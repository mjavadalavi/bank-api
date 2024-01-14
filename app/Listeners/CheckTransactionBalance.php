<?php

namespace App\Listeners;

use App\Events\TransactionMade;

class CheckTransactionBalance
{
    /**
     * Create the event listener.
     */
    public function __construct(){

    }

    /**
     * Handle the event.
     */
    public function handle(TransactionMade $event): void
    {

        if ($event->transaction->amount < 0){
            $debitCard = $event->transaction->debitCard()->create([
                'amount' => (config('app.wage_amount') * -1)
            ]);

            $debitCard->save();
        }
    }
}
