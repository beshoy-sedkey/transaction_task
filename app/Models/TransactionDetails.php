<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TransactionDetails extends Model
{
    use HasFactory;

    protected $fillable = ['transaction_id', 'paid_amount', 'paid_on', 'details' , 'is_deducted'];

    /**
     * transaction
     * @return BelongsTo
     */
    public function transaction(): BelongsTo
    {
        return $this->belongsTo(Transaction::class, 'transaction_id');
    }
}
