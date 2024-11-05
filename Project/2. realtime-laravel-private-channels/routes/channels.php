<?php

use Illuminate\Support\Facades\Broadcast;
use App\Models\User;

Broadcast::channel('users.{id}', function (User $user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('orders.{orderId}', function (User $user, $orderId) {

    if($user->id !== \App\Models\Order::findOrNew($orderId)->user_id){
        return false;
    }

    return true;
});


//Broadcast::channel('chat.room.{roomId}', function (User $user, $roomId) {
//    if (!$user->canAccessRoom($roomId)) {
//        return false;
//    }
//
//    return true;
//});
