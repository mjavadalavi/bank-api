<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransferRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'sender_card_number' => 'required|exists:debit_cards,card_number',
            'receiver_card_number' => 'required|exists:debit_cards,card_number',
            'amount' => 'required|numeric|between:10000,500000000',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
