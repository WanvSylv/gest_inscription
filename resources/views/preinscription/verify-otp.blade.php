@extends('layouts.public')
@section('title', 'Code de vérification')

@push('head')
<style>
    .otp-input { width:3rem; height:3.5rem; text-align:center; font-size:1.5rem; font-weight:900; border:2px solid #e5e7eb; border-radius:12px; transition:all 0.15s; color:#111827; }
    .otp-input:focus { outline:none; border-color:#1a56db; box-shadow:0 0 0 3px rgba(26,86,219,0.1); }
</style>
@endpush

@section('content')

<div style="background:linear-gradient(135deg,#0f172a 0%,#1e3a8a 50%,#1a56db 100%);" class="py-12">
    <div class="max-w-6xl mx-auto px-6 text-center">
        <p class="text-blue-200/70 text-xs font-semibold uppercase tracking-widest mb-2">Étape préliminaire</p>
        <h1 class="text-3xl font-black text-white mb-2">Entrez votre code</h1>
        <p class="text-blue-100/60 text-sm">Un code à 6 chiffres a été envoyé à <strong class="text-white">{{ $email }}</strong></p>
    </div>
</div>

<div class="flex items-center justify-center px-6 py-12">
    <div class="w-full max-w-md">

        @if(session('success'))
        <div class="mb-5 flex items-center gap-3 bg-green-50 border border-green-200 text-green-700 px-4 py-3.5 rounded-2xl text-sm">
            <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
            {{ session('success') }}
        </div>
        @endif

        @if(session('error'))
        <div class="mb-5 flex items-center gap-3 bg-red-50 border border-red-200 text-red-700 px-4 py-3.5 rounded-2xl text-sm">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            {{ session('error') }}
        </div>
        @endif

        <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="p-8">
                <div class="w-14 h-14 bg-green-50 rounded-2xl flex items-center justify-center mb-6">
                    <svg class="w-7 h-7 text-green-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"/></svg>
                </div>
                <h2 class="text-xl font-black text-gray-900 mb-1">Vérification du code</h2>
                <p class="text-sm text-gray-400 mb-8">Saisissez le code à 6 chiffres reçu par email. Il expire dans <strong class="text-gray-600">10 minutes</strong>.</p>

                <form action="{{ route('preinscription.verify-otp') }}" method="POST" id="otpForm">
                    @csrf
                    <input type="hidden" name="email" value="{{ $email }}">
                    <input type="hidden" name="code" id="codeHidden">

                    <div class="flex justify-center gap-2 mb-8" id="otpInputs">
                        @for($i = 0; $i < 6; $i++)
                        <input type="text" maxlength="1" inputmode="numeric" pattern="[0-9]"
                               class="otp-input" data-index="{{ $i }}" autocomplete="off">
                        @endfor
                    </div>

                    @error('code')
                    <p class="text-xs text-red-500 text-center mb-4">{{ $message }}</p>
                    @enderror

                    <button type="submit"
                            class="w-full flex items-center justify-center gap-2 bg-sigan-blue text-white font-bold text-sm py-3.5 rounded-xl hover:bg-blue-700 transition-all shadow-sm active:scale-95">
                        Vérifier mon email
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </button>
                </form>
            </div>
            <div class="px-8 py-4 bg-gray-50 border-t border-gray-100 flex items-center justify-between">
                <p class="text-xs text-gray-400">Vous n'avez pas reçu le code ?</p>
                <form action="{{ route('preinscription.resend-otp') }}" method="POST">
                    @csrf
                    <input type="hidden" name="email" value="{{ $email }}">
                    <button type="submit" class="text-xs text-sigan-blue font-semibold hover:underline">Renvoyer le code</button>
                </form>
            </div>
        </div>

    </div>
</div>

@push('scripts')
<script>
    const inputs = document.querySelectorAll('.otp-input');
    const hidden = document.getElementById('codeHidden');
    inputs.forEach((input, index) => {
        input.addEventListener('input', (e) => {
            e.target.value = e.target.value.replace(/\D/g, '');
            if (e.target.value && index < 5) inputs[index + 1].focus();
            updateHidden();
        });
        input.addEventListener('keydown', (e) => {
            if (e.key === 'Backspace' && !e.target.value && index > 0) inputs[index - 1].focus();
        });
        input.addEventListener('paste', (e) => {
            e.preventDefault();
            const pasted = (e.clipboardData || window.clipboardData).getData('text').replace(/\D/g,'').slice(0,6);
            pasted.split('').forEach((char, i) => { if (inputs[i]) inputs[i].value = char; });
            inputs[Math.min(pasted.length, 5)].focus();
            updateHidden();
        });
    });
    function updateHidden() { hidden.value = Array.from(inputs).map(i => i.value).join(''); }
    document.getElementById('otpForm').addEventListener('submit', (e) => {
        updateHidden();
        if (hidden.value.length !== 6) { e.preventDefault(); alert('Veuillez saisir les 6 chiffres du code.'); }
    });
</script>
@endpush

@endsection
