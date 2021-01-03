<?php

namespace App\Observers;

use App\Models\Order;
use App\Models\User;
use Carbon\Carbon;

class OrderObserver
{
    /**
     * Handle the Order "created" event.
     *
     * @param  \App\Models\Order  $order
     * @return void
     */
    public function created(Order $order)
    {
        //find available cook.
        $cook = User::Where('type', 'EC')->Where('logged_at', '!=', 'null')->Where('available_at', '!=', 'null')->first();

        //if there is an available cook, assign it, change from H (hold) to P (preparing)
        if($cook){
            $cook->available_at = null;
            $cook->save();
            $order->prepared_by = $cook->id;
            $order->status = 'P';
            $order->current_status_at = Carbon::now()->toDateTimeString();
            $order->save();
        }

        //else stay on hold (solved on update)


    }

    /**
     * Handle the Order "updated" event.
     *
     * @param  \App\Models\Order  $order
     * @return void
     */
    public function updated(Order $order)
    {


        //switch estava a dar erro mudou-se para ifs ...
        //dd($order->status == 'T');
        //switch ($order->status){
            if($order->status == 'R') { //se houver uma order updated a ready
                //o cook passa a estar available
                $cook = User::Where('id', $order->prepared_by)->first();
                $cook->available_at = Carbon::now();
                $cook->save();
                $order->preparation_time = Carbon::parse($order->current_status_at)->diffInSeconds(Carbon::now(), false);

            }
            if($order->status== "T"){
                $delivery_man = User::Where('id', $order->delivered_by)->first();
                $delivery_man->available_at = null;
                $delivery_man->save();
            }

            if($order->status== "D") { //se houver uma order updated para delivered, tudo correu bem e o delivery_man está agora available.
                $delivery_man = User::Where('id', $order->delivered_by)->first();
                $delivery_man->available_at = Carbon::now();
                $delivery_man->save();
                $order->delivery_time = Carbon::parse($order->current_status_at)->diffInSeconds(Carbon::now(), false);
                $order->total_time = Carbon::parse($order->opened_at)->diffInSeconds(Carbon::now(), false);
            }

            if($order->status== "C") { //se houver uma order updated para canceled, o delivery_man ou cook está agora ativos
                $delivery_man = User::Where('id', $order->delivered_by)->first();
                if($delivery_man){
                    $delivery_man->available_at = Carbon::now();
                    $delivery_man->save();
                }

                $cook = User::Where('id', $order->prepared_by)->first();
                if($cook){
                    $cook->available_at = Carbon::now();
                    $cook->save();
                }
            }
        //}


        $order->current_status_at = Carbon::now();
        $order->saveQuietly();


        //Acabado é sempre libertado ou um deliveryman ou um cook...
        //há orders onhold?
        $ordersOnHold = Order::Where('status', 'H')->first();

        //se sim vamos tentar arranjar um cook (o mesmo é feito no update do user quando um cook fica online)
        if($ordersOnHold){
            $cook = User::Where('type', 'EC')->Where('logged_at', '!=', 'null')->Where('available_at', '!=', 'null')->first();

            if($cook){
                $cook->available_at = null;
                $cook->save();
                $ordersOnHold->prepared_by = $cook->id;
                $ordersOnHold->status = 'P';
                $ordersOnHold->current_status_at = Carbon::now()->toDateTimeString();
                $ordersOnHold->save();
            }
        }


    }

    /**
     * Handle the Order "deleted" event.
     *
     * @param  \App\Models\Order  $order
     * @return void
     */
    public function deleted(Order $order)
    {
        //
    }

    /**
     * Handle the Order "restored" event.
     *
     * @param  \App\Models\Order  $order
     * @return void
     */
    public function restored(Order $order)
    {
        //
    }

    /**
     * Handle the Order "force deleted" event.
     *
     * @param  \App\Models\Order  $order
     * @return void
     */
    public function forceDeleted(Order $order)
    {
        //
    }
}
