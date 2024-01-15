<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Requests\TransactionRequest;
use App\Services\TransactionServices;
use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function index()
    {
        $users = User::select('users.*') ->selectSub(function ($query) {
                $query->select(DB::raw('COUNT(*)'))
                    ->from('transactions')
                    ->join('debit_cards', 'debit_cards.id', '=', 'transactions.debit_card_id')
                    ->join('bank_accounts', 'bank_accounts.id', '=', 'debit_cards.bank_account_id')
                    ->where('transactions.created_at', '>', Carbon::now()->subMinutes(10))
                    ->whereColumn('users.id', '=', 'bank_accounts.id');
            }, 'transaction_count')
            ->orderByDesc('transaction_count') // Order by transaction_count in descending order
            ->having('transaction_count', '>', 0)
            ->take(3)
            ->get();

        $latestTransactions = Transaction::latest()->take(10)->get();

        return response()->json(compact('users', 'latestTransactions'));
    }

    public function store(TransactionRequest $request)
    {
        $debitCard = auth()->user()->debitCards()->where('card_number', $request->input('card_number'))->firstOrFail();
        $currentBalance = $debitCard->transactions->sum('amount') + config('app.wage_amount');

        if ($currentBalance < $request->input('amount')) {
            return response()->json(['error' => 'Insufficient balance for this transaction.'], 422);
        }

        $transactionResponse = TransactionServices::transaction($debitCard, $request->input('amount'));

        if ($transactionResponse['status'])
            return response()->json($transactionResponse);

        return response()->json($transactionResponse, 500);
    }
}
