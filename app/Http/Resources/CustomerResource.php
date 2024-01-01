<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class CustomerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {   
        if(Auth::user()->is_admin == 1){

            return [
                'id' => $this->id,
                'name' => $this->name,
                'email' => $this->email,
                'phone' => $this->phone,
                'address' => $this->address,
                'visibility' => $this->visibility,
                'added' => $this->created_at->format('d-m-Y'),
                'added_by' => new UserResource($this->addedBy)
            ];
            
        }

        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'address' => $this->address,
            'visibility' => $this->visibility,
            'added' => $this->created_at->format('d-m-Y')
        ];
    }
}
