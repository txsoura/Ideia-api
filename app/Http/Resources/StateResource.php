<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class StateResource extends JsonResource
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
            'code' => $this->code,
            'country_id' => $this->country_id,
            'country' => new CountryResource($this->whenLoaded('country')),
            'created_at' => $this->dateformat($this->created_at),
            'updated_at' => $this->dateformat($this->updated_at),
        ];
    }

    public function dateformat ($date){
        if($date){
            return Carbon::parse($date)->format('Y-m-d H:i:s');
        }
    }
}
