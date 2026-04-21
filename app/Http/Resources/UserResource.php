<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'identificador' => $this->id,
            'nom' => $this->name,
            'llinatge' => $this->lastname,
            'dni' => $this->dni,
            'email' => $this->email,
            'phone' => $this->phone
        ];
    }
}
