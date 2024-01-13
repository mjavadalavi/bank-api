<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'from_user_id',
        'to_user_id',
        'from_user_balance',
        'to_user_balance',
        'amount',
    ];


    public function debitCard(): BelongsTo
    {
        return $this->belongsTo(DebitCard::class);
    }
}
