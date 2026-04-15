<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Symfony\Component\HttpKernel\Exception\HttpException;

class Handler extends ExceptionHandler
{
    protected $levels = [
        //
    ];

    protected $dontReport = [
        //
    ];

    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });

        // =========================
        // CUSTOM 403 HANDLER
        // =========================
        $this->renderable(function (HttpException $e, $request) {

            if ($e->getStatusCode() === 403) {
                return response()->view('errors.unauthorized', [], 403);
            }

            return null;
        });
    }
}