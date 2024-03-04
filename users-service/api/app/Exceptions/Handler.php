<?php

namespace Api\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $e)
    {
        $response = [
            'errors' => 'Sorry, something went wrong.'
        ];

        // If the app is in debug mode
        if (config('app.debug')) {
            $response['exception'] = get_class($e);
            $response['message'] = $e->getMessage();
            $response['trace'] = $e->getTrace();
        }

        $status = 400;

        if ($this->isHttpException($e)) {
            $status = $e->getStatusCode();
        }

        return response()->json($response, $status);
    }
}
