<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'id'   => $this->id,
            'status' => $this->status,
            'customer_id' => $this->customer_id,
            'notes' => $this->notes,
            'total_price' => $this->total_price,
            'date' => $this->date,
            'prepared_by' => $this->prepared_by,
            'delivered_by' => $this->delivered_by,
            'opened_at' => $this->opened_at,
            'current_status_at' => $this->current_status_at,
            'closed_at' => $this->closed_at,
            'preparation_time' => $this->preparation_time,
            'delivery_time' => $this->delivery_time,
            'total_time' => $this->total_time,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
