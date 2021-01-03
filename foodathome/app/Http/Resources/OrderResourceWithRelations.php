<?php

namespace App\Http\Resources;

use App\Models\Order_Item;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResourceWithRelations extends JsonResource
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
            'status' => $this->status_func($this->status),
            'customer' => $this->customer,
            'customer_details' => $this->customer->customer,
            'notes' => $this->notes_func($this->notes),
            'total_price' => $this->totalPrice_func($this->total_price),
            'date' => $this->date,
            'prepared_by' => $this->cook,
            'opened_at' => $this->opened_at,
            'current_status_at' => $this->current_status_at,
            'time_elapsed_since_status' => Carbon::parse($this->current_status_at)->diffInMinutes(Carbon::now(), false),
            'closed_at' => $this->closed_at,
            'preparation_time' => $this->preparation_time,
            'delivery_time' => $this->delivery_time,
            'total_time' => $this->total_time,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'order_items' => Order_ItemResource::collection($this->order_items)
        ];
    }


    public function status_func($status){
        switch ($status) {
            case "H" : return "Holding";
            case "P" : return "Preparing";
            case "R" : return "Ready";
            case "T" : return "In transit";
            case "D" : return "Delivered";
            case "C" : return "Cancelled";
            default : return "Other";
        }
    }

    public function notes_func($notes){
        return ($notes == null ? "No notes" : $notes);
    }

    public function totalPrice_func($totalPrice){
        return $totalPrice . "€";
    }
}
