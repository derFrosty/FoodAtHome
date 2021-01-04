<?php

namespace App\Http\Resources;

use App\Models\Order_Item;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class WorkersResource extends JsonResource
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
            'name' => $this->name,
            'email' => $this->email,
            'type' => $this->type,
            'photo_url' => $this->photo_url,
            'logged_at' => $this->logged_at,
            'available_at' => $this->available_at,
            'currently' => $this->doing($this->type, $this->logged_at, $this->available_at)
        ];
    }

    private function doing($type, $logged_at, $available_at)
    {
        if(!$logged_at){
            return "Offline";
        }

        if($available_at){
            return "Available";
        }

        switch ($type){
            case "EC": return "preparing";
            case "ED": return "delivering";
        }

        return "Unknown";

    }

}
