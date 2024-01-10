<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class GamerResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $request->id,
            "username" => $request->username,
            "password" => $request->password,
            "email" => $request->email,
            "phone_number" => $request->phone_number,
            "dob" => $request->dob,
            "role" => $request->role
        ];
    }
}
