<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\TransactionRequest;
use App\Http\Resources\TransactionResource;
use App\Models\Transaction;
use App\Models\User;
use DB;

class TransactionController extends Controller
{
    public function index()
    {
        $users = User::withCount(['transactions' => function ($query) {
            $query->where('created_at', '>', now()->subMinutes(10));
        }])->orderByDesc('transactions_count')->take(3)->get();

        $latestTransactions = auth()->user()->transactions()->latest()->take(10)->get();

        return response()->json(compact('users', 'latestTransactions'));
    }

    public function store(TransactionRequest $request)
    {

        $request->validate([
            'debit_card_id' => 'required|exists:debit_cards,id',
            'amount' => [
                'required',
                'numeric',
                'between:1000,500000000',
                function ($attribute, $value, $fail) {
                    $debitCard = auth()->user()->debitCards()->findOrFail(request('debit_card_id'));
                    $currentBalance = $debitCard->transactions()->sum('amount');
                    $proposedBalance = $currentBalance + $value + 500;

                    if ($proposedBalance > 500000000) {
                        $fail('Insufficient balance for this transaction.');
                    }
                },
            ],
        ]);

        try {
            DB::beginTransaction();

            $debitCard = auth()->user()->debitCards()->findOrFail($request->input('debit_card_id'));

            $transaction = new Transaction([
                'amount' => $request->input('amount'),
                'verified' => false,
            ]);

            $debitCard->transactions()->save($transaction);

            // Dispatch the event after successfully saving the transaction
            event(new TransactionMade($transaction));

            DB::commit();

            return response()->json(['message' => 'Transaction initiated successfully']);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json(['error' => 'Transaction failed. ' . $e->getMessage()], 500);
        }
    }

    public function show(Transaction $transaction)
    {
        return new TransactionResource($transaction);
    }

    public function update(TransactionRequest $request, Transaction $transaction)
    {
        $transaction->update($request->validated());

        return new TransactionResource($transaction);
    }

    public function destroy(Transaction $transaction)
    {
        $transaction->delete();

        return response()->json();
    }
}
