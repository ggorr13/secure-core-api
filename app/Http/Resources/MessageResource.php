<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MessageResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'status'  => 'success',
            'message' => $this->resource, // The string passed to the constructor
        ];
    }
}
