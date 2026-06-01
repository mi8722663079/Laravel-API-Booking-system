<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        return [
            "ID" => $this->id,
            "Status" => $this->status,
            "Event" => new EventResource($this->event),
            "User" => new UserResource($this->user)
        ];
    }
}
