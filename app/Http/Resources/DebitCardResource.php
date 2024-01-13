<?php

namespace App\Http\Resources;

use App\Models\DebitCard;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin DebitCard */
class DebitCardResource extends JsonResource
{
    public function toArray(Request $request)
    {
        return [
            'id'=> $this->id,
            'user_id' => $this->user_id,
            'credit_number'=> $this->credit_number,
            'expired_at' => $this->expired_at,
            'cvv2' => $this->cvv2,
            'balance' => $this->balance,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
