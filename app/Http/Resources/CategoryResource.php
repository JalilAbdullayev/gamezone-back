<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\JsonResponse;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'status' => $this->status,
            'order' => $this->order
        ];
    }

    public function with($request): array
    {
        return [
            'status' => 200
        ];
    }

    public function withResponse(Request $request, JsonResponse $response): JsonResponse
    {
        return $response->header('Accept', 'application/json');
    }
}
