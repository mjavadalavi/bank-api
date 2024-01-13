<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Events\TransactionMade;
use App\Models\Transaction;
use App\Models\DebitCard;
use Exception;

class TransactionServices
{
    public static function transaction(DebitCard $debitCard, int $amount): array
    {
        try {
            DB::beginTransaction();

            $transaction = new Transaction([
                'amount' => $amount,
                'verified' => true,
            ]);

            $debitCard->transactions()->save($transaction);

            event(new TransactionMade($transaction));

            DB::commit();
            return ['message' => 'Transaction initiated successfully', "status" => true];
        } catch (Exception $e) {
            DB::rollBack();
            return ['message' => 'Transaction have some error: '. $e->getMessage(), "status" => false];
        }
    }
}
