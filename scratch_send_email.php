<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Mail;

try {
    Mail::raw('Bonjour, ceci est un email de test de HOREB ACADEMY pour valider le bon fonctionnement de la messagerie SMTP.', function($message) {
        $message->to('adjibako123@gmail.com')->subject('Validation SMTP - HOREB ACADEMY');
    });
    echo "EMAIL_SENT_SUCCESSFULLY\n";
} catch (\Exception $e) {
    echo "EMAIL_SENDING_FAILED: " . $e->getMessage() . "\n";
}
