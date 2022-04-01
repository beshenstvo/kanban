<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class InProcessResource extends JsonResource
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
            'responsible' => $this->responsible,
            'task_id' => $this->task_id
        ];
    }
}
