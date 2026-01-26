<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VendorStatusResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'vendor_id' => $this->id,
            'vendor_name' => $this->name, 
            'vendor_logo' => $this->logo ? asset('storage/' . $this->logo) : asset('default-logo.png'),
            'stories' => StatusResource::collection($this->whenLoaded('statuses')),
        ];
    }
}
