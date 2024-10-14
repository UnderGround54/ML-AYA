<?php


namespace App\Service;

use Symfony\Component\HttpFoundation\JsonResponse;

class ResponseService
{
    public function createResponse(string $status, int $statusCode, string $message = null, $results = null, array $errors = []): JsonResponse
    {
        $responseData = [
            'status' => $status,
            'code' => $statusCode,
        ];

        if ($message !== null) {
            $responseData['message'] = $message;
        }

        if (isset($results['data'])) {
            $responseData['data'] = $results['data'];
        }

        if (isset($results['meta'])) {
            $responseData['meta'] = $results['meta'];
        }

        if (!empty($errors)) {
            $responseData['errors'] = $errors;
        }

        return new JsonResponse($responseData, $statusCode);
    }
}
