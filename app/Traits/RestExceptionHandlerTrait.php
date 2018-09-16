<?php
namespace App\Traits;

use App\Exceptions\AppException;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use App\Exceptions\ImageValidationException;
use App\Exceptions\VideoValidationException;
use App\Exceptions\AudioValidationException;
use App\Exceptions\PermissionException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\Exceptions\BlackListException;



trait RestExceptionHandlerTrait{

    /**
     * Creates a new JSON response based on exception type.
     *
     * @param Request $request
     * @param Exception $e
     * @return \Illuminate\Http\JsonResponse
     */
    protected function getJsonResponseForException(Request $request, Exception $e)
    {
        switch(true) {
            case $this->isAppException($e):
                $retval = $this->appException($e);
                break;
            case $this->isNotFoundException($e):
                $retval = $this->notFound($e);
                break;
            case $this->isModelNotFoundException($e):
                $retval = $this->modelNotFound();
                break;
            case $this->isValidationException($e):
                $retval = $this->validation($e);
                break;
            default:
                $retval = $this->badRequest($e);
        }

        return $retval;
    }

    /**
     * Returns json response for generic bad request.
     *
     * @param string $message
     * @param int $statusCode
     * @return \Illuminate\Http\JsonResponse
     */




    /**
     * Returns json response for Eloquent model not found exception.
     *
     * @param string $message
     * @param int $statusCode
     * @return \Illuminate\Http\JsonResponse
     */
    protected function appException(Exception $e, $message='Bad request', $statusCode=400){
        return $this->jsonResponse(['error' => 'error' ,'error_text'=>$e->getMessage()], $statusCode);
    }
    protected function notFound($message='Current url route not found', $statusCode=404){
        return $this->jsonResponse(['error' => 'not_found', 'error_text'=>'Current url route not found'], $statusCode);
    }
    protected function modelNotFound($message='Not found', $statusCode=404){
        return $this->jsonResponse(['error' => 'not_found', 'error_text'=>$message], $statusCode);
    }
    protected function validation($e){
        return $this->jsonResponse([
            'error' => 'validation',
            'error_text'=>'Validation error',
            'validation'=>$e->validator->messages()
        ], 400);
    }

    protected function badRequest(Exception $e, $message='Something when wrong', $statusCode=400){
        return $this->jsonResponse(['error' => 'error' ,'error_text'=>(config('app.debug')) ? $e->getMessage() : $message], $statusCode);
    }


    /**
     * Returns json response.
     *
     * @param array|null $payload
     * @param int $statusCode
     * @return \Illuminate\Http\JsonResponse
     */
    protected function jsonResponse(array $payload=null, $statusCode=404){
        $payload = $payload ?: [];

        return response()->json($payload, $statusCode);
    }

    /**
     * Determines if the given exception is an Eloquent model not found.
     *
     * @param Exception $e
     * @return bool
     */
    protected function isAppException(Exception $e){
        // dd($e);
        return $e instanceof AppException;
    }
    protected function isNotFoundException(Exception $e){
       // dd($e);
        return $e instanceof NotFoundHttpException;
    }
    protected function isModelNotFoundException(Exception $e){
        return $e instanceof ModelNotFoundException;
    }

    protected function isValidationException(Exception $e){
        return $e instanceof ValidationException;
    }
}