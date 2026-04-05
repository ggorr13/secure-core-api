<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LoginResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'user' => new UserResource($this['user']),
            'auth' => [
                'token' => $this['token'],
                'type'  => 'Bearer',
            ],
        ];
    }

    public function withResponse($request, $response): void
    {
        // Only set 201 if it's a POST request (Registration/Login usually)
        if ($request->isMethod('post')) {
            $response->setStatusCode(201);
        }
    }
}
