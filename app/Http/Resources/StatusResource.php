<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StatusResource extends JsonResource
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
            'type' => $this->type,
            'content' => $this->content, 
            'bg_color' => $this->background_color,
            'created_at_human' => $this->created_at->diffForHumans(),
            'is_video' => $this->type === 'video',
        ];
    }
}
