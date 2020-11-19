<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'email' =>  $this->email,
            'status' => $this->status,
            'role' => $this->role,
            'profile' => new ProfileResource($this->whenLoaded('profile')),
            'wallet' => new UserResource($this->whenLoaded('wallet')),
            'address' => new AddressResource($this->whenLoaded('address')),
            'events' => EventResource::collection($this->whenLoaded('events')),
            'created_at' => $this->dateformat($this->created_at),
            'updated_at' => $this->dateformat($this->updated_at),
            'deleted_at' => $this->dateformat($this->deleted_at)
        ];
    }

    public function dateformat ($date){
        if($date){
            return Carbon::parse($date)->format('Y-m-d H:i:s');
        }
    }
}
