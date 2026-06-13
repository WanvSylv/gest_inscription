<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\PasswordChangeController;
use App\Http\Controllers\PreinscriptionController;
use Illuminate\Support\Facades\Auth;

// Page d'accueil publique
Route::get('/', function () {
    return view('home');
})->name('home');

// Vérification email OTP (avant inscription)
use App\Http\Controllers\EmailVerificationController;

Route::get('/inscription/verifier-email', [EmailVerificationController::class, 'showEmailForm'])->name('preinscription.verify-email');
Route::post('/inscription/envoyer-otp', [EmailVerificationController::class, 'sendOtp'])->name('preinscription.send-otp');
Route::get('/inscription/code', [EmailVerificationController::class, 'showOtpForm'])->name('preinscription.verify-otp-form');
Route::post('/inscription/verifier-code', [EmailVerificationController::class, 'verifyOtp'])->name('preinscription.verify-otp');
Route::post('/inscription/renvoyer-code', [EmailVerificationController::class, 'resendOtp'])->name('preinscription.resend-otp');

// Routes publiques de pré-inscription
Route::get('/inscription', [PreinscriptionController::class, 'create'])->name('preinscription.create');
Route::post('/inscription', [PreinscriptionController::class, 'store'])->name('preinscription.store');
Route::get('/inscription/succes', [PreinscriptionController::class, 'success'])->name('preinscription.success');

use App\Http\Controllers\PaiementController;

// Routes publiques de paiement
Route::get('/paiement/{token}', [PaiementController::class, 'show'])->name('paiement.show');
Route::post('/paiement/{token}/payer', [PaiementController::class, 'payer'])->name('paiement.payer');
Route::get('/paiement/confirmation/{token}', [PaiementController::class, 'success'])->name('paiement.success');

// Webhook FedaPay
Route::post('/webhook/fedapay', [PaiementController::class, 'webhook'])->name('webhook.fedapay');

Route::get('/dashboard', function () {
    if (Auth::user()->hasRole('etudiant')) {
        return redirect()->route('etudiant.dashboard');
    }
    return view('dashboard');
})->middleware(['auth', 'verified', 'force.password'])->name('dashboard');

// Espace étudiant
use App\Http\Controllers\Etudiant\DashboardController as EtudiantDashboardController;

Route::middleware(['auth', 'force.password', 'role:etudiant'])
    ->prefix('mon-espace')
    ->name('etudiant.')
    ->group(function () {
        Route::get('/', [EtudiantDashboardController::class, 'index'])->name('dashboard');
    });

Route::middleware(['auth', 'force.password'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/change-password', [PasswordChangeController::class, 'create'])->name('password.change');
    Route::post('/change-password', [PasswordChangeController::class, 'store'])->name('password.change.store');
});

use App\Http\Controllers\Academique\InscriptionController as AcademiqueInscriptionController;
use App\Http\Controllers\Academique\FiliereController as AcademiqueFiliereController;

// Routes Académique (directeur académique + admin)
Route::middleware(['auth', 'force.password', 'role:academique|admin'])
    ->prefix('academique')
    ->name('academique.')
    ->group(function () {
        Route::get('/inscriptions', [AcademiqueInscriptionController::class, 'index'])->name('inscriptions.index');
        Route::get('/inscriptions/{inscription}', [AcademiqueInscriptionController::class, 'show'])->name('inscriptions.show');
        Route::patch('/inscriptions/{inscription}/valider', [AcademiqueInscriptionController::class, 'valider'])->name('inscriptions.valider');
        Route::patch('/inscriptions/{inscription}/rejeter', [AcademiqueInscriptionController::class, 'rejeter'])->name('inscriptions.rejeter');
        
        // Gestion des Filières
        Route::resource('filieres', AcademiqueFiliereController::class)->except(['show']);
    });

use App\Http\Controllers\Comptable\PaiementController as ComptablePaiementController;

// Routes Comptabilité (comptable + admin)
Route::middleware(['auth', 'force.password', 'role:comptable|admin'])
    ->prefix('comptabilite')
    ->name('comptable.')
    ->group(function () {
        Route::get('/paiements', [ComptablePaiementController::class, 'index'])->name('paiements.index');
        Route::get('/paiements/{paiement}', [ComptablePaiementController::class, 'show'])->name('paiements.show');
        Route::get('/paiements/{paiement}/recu', [ComptablePaiementController::class, 'telechargerRecu'])->name('paiements.recu');
    });

require __DIR__.'/auth.php';
