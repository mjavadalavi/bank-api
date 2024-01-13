<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transfer extends Model
{
    use HasFactory;

    protected $fillable = [
        'sender_debit_card_id',
        'receiver_debit_card_id',
        'amount',
    ];


    public function senderDebitCard(): BelongsTo
    {
        return $this->belongsTo(DebitCard::class, 'sender_debit_card_id');
    }

    public function receiverDebitCard(): BelongsTo
    {
        return $this->belongsTo(DebitCard::class, 'receiver_debit_card_id');
    }

}
