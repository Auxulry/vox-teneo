<?php
namespace App\Traits\Http;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

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
        if (!$errors) {
            return response()->json([
                'code' => $code,
                'status' => Response::$statusTexts[$code],
                'data' => $data
            ])->setStatusCode($code);
        }
        return response()->json([
            'code' => $code,
            'status' => Response::$statusTexts[$code],
            'errors' => $errors
        ])->setStatusCode($code);
    }
}
