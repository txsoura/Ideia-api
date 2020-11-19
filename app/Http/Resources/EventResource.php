<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
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
            'name' => $this->name,
            'description' => $this->description,
            'tags_id' => $this->tags_id,
            'start' => $this->start,
            'price' => $this->price,
            'access' => $this->access,
            'type' => $this->type,
            'restriction' => $this->restriction,
            'available' => $this->available,
            'ticket' => $this->ticket,
            'owner_id' => $this->owner_id,
            'address_id' => $this->address_id,
            'owner' =>  new UserResource($this->whenLoaded('user')),
            'tags' =>  TagResource::collection($this->whenLoaded('tags')),
            'tickets' =>  TicketResource::collection($this->whenLoaded('tickets')),
            'address' => new AddressResource($this->whenLoaded('address')),
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
