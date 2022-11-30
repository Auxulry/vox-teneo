<?php
namespace App\Traits\Http;

use Illuminate\Http\JsonResponse;

trait HasApiResponse
{
    /**
     * Set Response Json
     *
     * @param integer $code
     * @param string $status
     * @param array $data
     * @return JsonResponse
     */
    protected function setResponse(int $code, $data = [], $errors = []): JsonResponse
    {
        if (count($errors) == 0) {
            return response()->json([
                'code' => $code,
                'status' => $this->getHttpStatus($code),
                'data' => $data
            ])->setStatusCode($code);
        }
        return response()->json([
            'code' => $code,
            'status' => $this->getHttpStatus($code),
            'errors' => $errors
        ])->setStatusCode($code);
    }

    /**
     * Get HTTP Status
     *
     * @param integer $code
     * @return string
     */
    private function getHttpStatus(int $code): string
    {
        $status = '';

        switch ($code) {
            case 200:
                $status = 'OK';
                break;
            case 201:
                $status = 'CREATED';
                break;
            case 400:
                $status = 'BAD_REQUEST';
                break;
            case 401:
                $status = 'UNAUTHORIZED';
                break;
            case 403:
                $status = 'FORBIDDEN';
                break;
            case 404:
                $status = 'NOT_FOUND';
                break;
            case 405:
                $status = 'METHOD_NOT_ALLOWED';
                break;
            case 409:
                $status = 'CONFLICT';
                break;
            case 422:
                $status = 'UNPROCESSABLE_ENTITY';
                break;
            default:
                $status = 'INTERNAL_SERVER_ERROR';
                break;
        }

        return $status;
    }
}
