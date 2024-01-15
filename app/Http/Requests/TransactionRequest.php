<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransactionRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'card_number' => 'required|exists:debit_cards,card_number',
            'amount' => 'required|numeric|between:-500000000,500000000'
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
