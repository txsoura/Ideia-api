<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
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
            'name' =>  $this->name,
            'cpf_cnpj' =>  $this->cpf_cnpj,
            'img' =>  $this->img,
            'birthdate' =>  $this->birthdate,
            'cellphone' =>  $this->cellphone,
            'sex' => $this->sex,
            'user_id' => $this->user_id,
            'user' => new UserResource($this->whenLoaded('user')),
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
