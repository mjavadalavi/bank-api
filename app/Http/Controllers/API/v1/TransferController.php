<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Requests\TransferRequest;
use App\Services\TransactionServices;
use App\Exceptions\TransferException;
use App\Http\Controllers\Controller;
use App\Models\DebitCard;
use App\Models\Transfer;
use DB;

class TransferController extends Controller
{

    public function store(TransferRequest $request)
    {
        // Start a database transaction
        DB::beginTransaction();

        try {
            $senderDebitCard = auth()->user()->debitCards()->where('card_number', $request->input('sender_card_number'))->firstOrFail();
            $receiverDebitCard = DebitCard::where('card_number', $request->input('receiver_card_number'))->firstOrFail();
            $currentBalance = $senderDebitCard->transactions()->sum('amount');

            if ($currentBalance < $request->input('amount')) {
                throw new TransferException('Insufficient balance for this transfer.');
            }

            // Perform the transfer
            $transfer = Transfer::create([
                'sender_debit_card_id' => $senderDebitCard->id,
                'receiver_debit_card_id' => $receiverDebitCard->id,
                'amount' => $request->input('amount'),
            ]);

            //transactions for sender to sub from balance
            $senderTransactionResponse = TransactionServices::transaction($senderDebitCard, $request->input('amount') * -1);

            if (!$senderTransactionResponse['status'])
                throw new TransferException("sender: ".$senderTransactionResponse['message']);

            //transactions for receiver to add balance
            $receiverTransactionResponse = TransactionServices::transaction($receiverDebitCard, $request->input('amount'));

            if (!$receiverTransactionResponse['status'])
                throw new TransferException("receiver: ".$receiverTransactionResponse['message']);

            // Commit the transaction if all steps are successful
            DB::commit();

            return response()->json(['message' => 'Transfer successful']);
        } catch (TransferException $e) {
            // Rollback the transaction in case of an exception
            DB::rollBack();

            return response()->json(['error' => $e->getMessage()], 422);
        }
    }
}
