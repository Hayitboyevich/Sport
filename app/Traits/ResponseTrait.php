<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Casts\Json;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;


trait ResponseTrait
{
    /**
     * Success response.
     *
     * @param array|object $data
     * @param string $message
     *
     * @return JsonResponse
     */
    public function responseSuccess($data = [], $message = "Successful", $meta = []): JsonResponse
    {
        return response()->json([
            'status' => true,
            'message' => $message,
            'code' => 200,
            'data' => $data,
            'meta' => $meta,
            'errors' => null
        ]);
    }

    /**
     * Error response.
     *
     * @param array|object $errors
     * @param string $message
     *
     * @return JsonResponse
     */


    public function responseErrorWithCode($code, string $message = null) : JsonResponse
    {
        if($message)
        {
            $error_code = $message;
        }
        else
        {
            $error_code = $this->errorCode($code);
        }

        return response()->json([
            'status' => false,
            'message' => $error_code,
            'code' => $code,
            'data' => [],
            'errors' => null
        ], $code);
    }



    public function errorCode($code){
        switch ($code) {
            case 400:
                $message = 'Неверный запрос (Bad Request).';
                break;
            case 401:
                $message = 'Неавторизован (Unauthorized).';
                break;
            case 403:
                $message = 'Доступ запрещен (Forbidden).';
                break;
            case 404:
                $message = 'Страница не найдена (Not Found).';
                break;
            case 405:
                $message = 'Метод не поддерживается (Method Not Allowed).';
                break;
            case 409:
                $message = 'Конфликт (Conflict).';
                break;
            case 422:
                $message = 'Неверные данные (Unprocessable Entity).';
                break;
            case 500:
                $message = 'Внутренняя ошибка сервера (Internal Server Error).';
                break;
            case 502:
                $message = 'Ошибка шлюза (Bad Gateway).';
                break;
            case 503:
                $message = 'Сервис временно недоступен (Service Unavailable).';
                break;
            default:
                $message = 'Неизвестная ошибка.';
                break;
        }
        return $message;
    }






}
