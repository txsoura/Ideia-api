<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class TicketResource extends JsonResource
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
            'status' => $this->status,
            'price' => $this->price,
            'event_id' => $this->event_id,
            'event' => new EventResource($this->whenLoaded('event')),
            'customer_id' => $this->customer_id,
            'created_at' => $this->dateformat($this->created_at),
            'updated_at' => $this->dateformat($this->updated_at),
            'deleted_at' => $this->dateformat($this->deleted_at)
        ];
    }

    public function dateformat($date)
    {
        if ($date) {
            return Carbon::parse($date)->format('Y-m-d H:i:s');
        }
    }
}
