<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Requests\TransactionRequest;
use App\Services\TransactionServices;
use App\Http\Controllers\Controller;
use App\Models\User;

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
        $debitCard = auth()->user()->debitCards()->where('card_number', $request->input('card_number'))->firstOrFail();

        $transactionResponse = TransactionServices::transaction($debitCard, $request->input('amount'));

        if ($transactionResponse['status'])
            return response()->json($transactionResponse);
        return response()->json($transactionResponse, 500);

    }
}
