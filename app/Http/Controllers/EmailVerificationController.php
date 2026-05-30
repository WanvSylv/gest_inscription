<?php

namespace App\Http\Controllers;

use App\Mail\OtpVerificationEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class EmailVerificationController extends Controller
{
    // Affiche la page de saisie d'email
    public function showEmailForm()
    {
        return view('preinscription.verify-email');
    }

    // Envoie le code OTP
    public function sendOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ], [
            'email.required' => 'L\'adresse email est obligatoire.',
            'email.email'    => 'Veuillez saisir une adresse email valide.',
        ]);

        $email = strtolower(trim($request->email));

        // Supprimer les anciens codes pour cet email
        DB::table('email_verifications')->where('email', $email)->delete();

        // Générer code à 6 chiffres
        $code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        // Sauvegarder en base
        DB::table('email_verifications')->insert([
            'email'      => $email,
            'code'       => $code,
            'verified'   => false,
            'expires_at' => Carbon::now()->addMinutes(10),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Envoyer l'email
        try {
            Mail::to($email)->send(new OtpVerificationEmail($email, $code));
        } catch (\Exception $e) {
            return back()->with('error', 'Impossible d\'envoyer l\'email. Vérifiez votre adresse et réessayez.');
        }

        return redirect()->route('preinscription.verify-otp-form', ['email' => $email])
            ->with('success', 'Un code à 6 chiffres a été envoyé à ' . $email);
    }

    // Affiche le formulaire de saisie du code OTP
    public function showOtpForm(Request $request)
    {
        $email = $request->get('email');
        if (!$email) {
            return redirect()->route('preinscription.verify-email');
        }
        return view('preinscription.verify-otp', compact('email'));
    }

    // Vérifie le code OTP
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'code'  => 'required|string|size:6',
        ]);

        $email = strtolower(trim($request->email));
        $code  = trim($request->code);

        $record = DB::table('email_verifications')
            ->where('email', $email)
            ->where('code', $code)
            ->where('verified', false)
            ->where('expires_at', '>', now())
            ->first();

        if (!$record) {
            return back()->with('error', 'Code invalide ou expiré. Veuillez réessayer.')->withInput();
        }

        // Marquer comme vérifié
        DB::table('email_verifications')
            ->where('id', $record->id)
            ->update(['verified' => true, 'updated_at' => now()]);

        // Stocker en session que cet email est vérifié
        session(['email_verifie' => $email]);

        return redirect()->route('preinscription.create')
            ->with('success', 'Email vérifié ! Vous pouvez maintenant compléter votre inscription.');
    }

    // Renvoyer un nouveau code
    public function resendOtp(Request $request)
    {
        $email = strtolower(trim($request->get('email')));
        if (!$email) {
            return redirect()->route('preinscription.verify-email');
        }

        DB::table('email_verifications')->where('email', $email)->delete();

        $code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        DB::table('email_verifications')->insert([
            'email'      => $email,
            'code'       => $code,
            'verified'   => false,
            'expires_at' => Carbon::now()->addMinutes(10),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        try {
            Mail::to($email)->send(new OtpVerificationEmail($email, $code));
        } catch (\Exception $e) {
            return back()->with('error', 'Impossible d\'envoyer l\'email.');
        }

        return redirect()->route('preinscription.verify-otp-form', ['email' => $email])
            ->with('success', 'Nouveau code envoyé à ' . $email);
    }
}
