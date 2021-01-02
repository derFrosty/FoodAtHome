<?php

namespace App\Observers;

use App\Models\Order;
use App\Models\User;

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
            case 'EC': { // caso seja um cook, vamos verificar se há encomendas onhold

                //há orders onhold?
                $ordersOnHold = Order::Where('status', 'H')->first();

                //se sim vamos tentar arranjar um cook
                if($ordersOnHold){
                    $cook = User::Where('type', 'EC')->Where('logged_at', '!=', 'null')->Where('available_at', '!=', 'null')->first();

                    if($cook){
                        $cook->available_at = null;
                        $cook->save();
                        $ordersOnHold->prepared_by = $cook->id;
                        $ordersOnHold->status = 'P';
                        $ordersOnHold->save();
                    }
                }

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
