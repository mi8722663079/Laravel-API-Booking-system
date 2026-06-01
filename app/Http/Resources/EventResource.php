<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
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
            "Title" => $this->title,
            "Description" => $this->description,
            "Start Date" => $this->start_date,
            "Available Seats" => $this->avaliable_seats,
            "Location" => $this->location,
            "images" => $this->getMedia('events')->map(function($media){
                return $media->getUrl();
            }),
            "Category" => new CategoryResource($this->category)
        ];
    }
}
