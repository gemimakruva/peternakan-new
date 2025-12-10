<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response as STATUS;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->report(function (Throwable $e) {
            Log::error('Exception reported', ['class' => get_class($e), 'msg' => $e->getMessage()]);
        });

        $exceptions->render(function (Throwable $e, $request) {
            if ($e instanceof ValidationException) {
                /** @var ValidationException $e */
                $errors = $e->errors();

                Log::error('Validation failed', [
                    'class'  => get_class($e),
                    'msg'    => $e->getMessage(),
                    'errors' => $errors,
                ]);

                if ($request->expectsJson()) {
                    return response()->json([
                        'status'  => false,
                        'message' => 'Validation failed',
                        'data'    => ['errors' => $errors],
                    ], STATUS::HTTP_UNPROCESSABLE_ENTITY);
                }

                return redirect()->back()
                    ->withInput()
                    ->with('danger', 'Periksa kembali data yang Anda masukkan.')
                    ->withErrors($e->errors());
            }
        });
    })->create();
