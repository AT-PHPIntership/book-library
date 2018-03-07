<?php
namespace App\Exceptions;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Illuminate\Validation\ValidationException;
class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];
    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];
    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param \Exception $exception Exception
     *
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }
    /**
     * Render an exception into an HTTP response.
     *
     * @param \Illuminate\Http\Request $request   Request HTTP
     * @param \Exception               $exception Exception
     *
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        $message = "";
        $code = 0;
        if ($request->route() != null) {
            if ($request->route()->getPrefix() === 'api') {
                //error 400
                if ($exception instanceof ValidationException) {
                    $code = Response::HTTP_BAD_REQUEST;
                    $message = $exception->errors();
                    return $this->showMessageAndCode($code, $message);
                }

                //error 405
                if ($exception instanceof MethodNotAllowedHttpException) {
                    $code = Response::HTTP_BAD_METHOD;
                    $message = config('define.messages.405_method_failure');
                    return $this->showMessageAndCode($code, $message);
                }
                // error 404
                if ($exception instanceof ModelNotFoundException) {
                    $code = Response::HTTP_NOT_FOUND;
                    $message = config('define.messages.404_not_found');
                    return $this->showMessageAndCode($code, $message);
                }
                // error server exxception
                if ($exception instanceof ServerException) {
                    $code = Response::HTTP_INTERNAL_SERVER_ERROR;
                    $message = config('define.messages.500_server_error');
                    return $this->showMessageAndCode($code, $message);
                }
                // error the rest of exception
                if ($exception instanceof \Exception) {
                    $code = Response::HTTP_INTERNAL_SERVER_ERROR;
                    $message = config('define.messages.500_server_error');
                    return $this->showMessageAndCode($code, $message);
                }
            }
        }
        return parent::render($request, $exception);
    }
    /**
     * Return json.
     *
     * @param int    $code    number return
     * @param String $message message
     *
     * @return void
     */
    public function showMessageAndCode($code, $message)
    {
        return response()->json([
            'meta' => [
                'code' => $code,
                'message' => $message
            ],
        ], $code);
    }
}
