<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\DatabaseMessage;
use App\Models\Transaction;

class OrderStatusNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $transaction;
    public $status;

    public function __construct(Transaction $transaction, $status)
    {
        $this->transaction = $transaction;
        $this->status = $status;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'transaction_id' => $this->transaction->id,
            'status' => $this->status,
            'updated_at' => now(),
        ];
    }
}
