<?php

namespace App\Observers;

use App\Mail\EmailNotification;
use App\Models\Order;
use Illuminate\Support\Facades\Mail;

class OrderObserver
{
    /**
     * Handle the Order "created" event.
     */
    public function created(Order $order): void
    {
        //
    }

    /**
     * Handle the Order "updated" event.
     */
    public function updated(Order $order): void
    {
        if ($order->isDirty('status') && $order->status == "approved") {

            $data = [
                "subject" => "New Order",
                "to" => $order->order_descriptions[0]->product->vendor->name,
                "message" => "You have a new order from". $order->user->name. ". The order id is $order->id.",
            ];

            foreach ($order->order_descriptions as $orderDescription) {
                $orderDescription->product->vendor->balance += $orderDescription->amount - $orderDescription->amount * $orderDescription->product->category->commission / 100;
                $orderDescription->product->vendor->update();
            }

            Mail::to($order->order_descriptions[0]->product->vendor->email)->send(new EmailNotification($data));


        }
    }

    /**
     * Handle the Order "deleted" event.
     */
    public function deleted(Order $order): void
    {
        //
    }

    /**
     * Handle the Order "restored" event.
     */
    public function restored(Order $order): void
    {
        //
    }

    /**
     * Handle the Order "force deleted" event.
     */
    public function forceDeleted(Order $order): void
    {
        //
    }
}
