<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Foundation\Inspiring;

// Comando Artisan padrão
Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Carregar o Kernel manualmente (se necessário)
app()->singleton(
    Illuminate\Contracts\Console\Kernel::class,
    App\Console\Kernel::class
);