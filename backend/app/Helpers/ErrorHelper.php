<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\App;

class ErrorHelper
{
    /**
     * Handle exception reporting based on the environment.
     *
     * @param \Exception $exception The exception to be reported.
     * 
     * - In production environment: Sends the error to Sentry or another error tracking service.
     * - In non-production environment: Logs the error locally for debugging purposes.
     *
     * @return void
     */
    public static function reportError($exception)
    {
        if (App::environment('production')) {
            report($exception);
        } else {
            Log::error("Erro: " . $exception->getMessage());
        }
    }
}
