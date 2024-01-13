<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransactionRequest extends FormRequest
{
    public function rules(): array
    {
        return [
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
        ];
    }

    public function authorize()
    {
        return true;
    }
}
