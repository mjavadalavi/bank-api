<?php

namespace App\Listeners;

use App\Events\TransactionMade;
use App\Models\Transaction;

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
            Transaction::create([
                    'debit_card_id' => $event->transaction->debit_card_id,
                    'amount' => (config('app.wage_amount') * -1)
                ]
            );
        }
    }
}
