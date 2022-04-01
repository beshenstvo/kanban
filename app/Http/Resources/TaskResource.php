<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'taskName' => $this->taskName,
            'description' => $this->description,
            'deadline' => $this->deadline,
            'user_id' => $this->user_id,
            'created_at' => $this->created_at
        ];
    }
}
