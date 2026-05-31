<?php

return [
    // Clé publique Fedapay (live)
    'public_key' => env('FEDAPAY_PUBLIC_KEY'),

    // Clé secrète Fedapay (live)
    'secret_key' => env('FEDAPAY_SECRET_KEY'),

    // URL de callback Fedapay (webhook)
    'callback_url' => env('FEDAPAY_CALLBACK_URL'),

    // Environnement – true = sandbox, false = live (déduit de la présence du préfixe "live" dans les clés)
    'sandbox' => env('FEDAPAY_SANDBOX', false),
];
