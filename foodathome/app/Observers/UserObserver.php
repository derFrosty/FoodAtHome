<?php

namespace App\Observers;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class UserObserver
{
    /**
     * Handle the User "created" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function created(User $user)
    {
        //
    }

    /**
     * Handle the User "updated" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function updated(User $user) // pode também ocorrer quando é feito um update do user por isso vamos à mesma verificar se existe mesmo um cook available
    {
        switch ($user->type){

            case 'EC': {

                $hasOrder = Order::Where('prepared_by', $user->id)->Where('status', 'P')->first();

                if(!$hasOrder){
                    $user->available_at = Carbon::now();

                }else{
                    $user->available_at = null;
                }

                $user->saveQuietly();

                if($user->available_at){
                    $order = Order::orderBy('id', 'ASC')->Where('status', 'H')->first();

                    if($order){
                        $user->available_at = null;
                        $user->saveQuietly();
                        $order->status = 'P';
                        $order->prepared_by = $user->id;
                        $order->save();
                    }
                }


                break;
            }
            case 'ED': {
                $order = Order::Where('prepared_by', $user->id)->Where('status', 'T')->count();
                if($order > 0){
                    $user->available_at = null;
                }else{
                    $user->available_at = Carbon::now();
                }

                $user->saveQuietly();

                break;
            }
        }
    }

    /**
     * Handle the User "deleted" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function deleted(User $user)
    {
        //
    }

    /**
     * Handle the User "restored" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function restored(User $user)
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function forceDeleted(User $user)
    {
        //
    }
}
