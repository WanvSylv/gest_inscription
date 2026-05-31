<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\Mail;

try {
    Mail::raw('Test email HOREB ACADEMY - configuration SMTP OK', function ($message) {
        $message->to('adjibako123@gmail.com')
                ->subject('Test SMTP - HOREB ACADEMY');
    });
    echo "✅ Email envoyé avec succès !\n";
} catch (\Exception $e) {
    echo "❌ Erreur : " . $e->getMessage() . "\n";
}
