<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransactionRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'card_number' => 'required|exists:debit_cards,card_number',
            'amount' => [
                'required',
                'numeric',
                'between:1000,500000000',
                function ($attribute, $value, $fail) {
                    $debitCard = auth()->user()->debitCards()->where('card_number', request('card_number'))->firstOrFail();
                    if (($debitCard->balance + config('app.wage_amount')) < $value) {
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
