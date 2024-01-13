<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransactionRequest extends FormRequest
{
    public function rules()
    {
        return [
            'id' => ['required', 'integer'],
            'from_user_id' => ['required', 'integer'],
            'to_user_id' => ['required', 'integer'],
            'from_user_balance' => ['required', 'decimal:10,2'],
            'to_user_balance' => ['required', 'decimal:10,2'],
            'amount' => ['required', 'decimal:10,2']
        ];
    }

    public function authorize()
    {
        return true;
    }
}
