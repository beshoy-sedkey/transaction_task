<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    use HasFactory;

    public $timestamps = true;
    protected $fillable = ['amount', 'payer', 'due_on', 'vat', 'is_vat_inclusive', 'payment_status', 'created_at', 'updated_at'];

    /**
     * payer
     * @return BelongsTo
     */
    public function payer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'payer');
    }
    /**
     * setAmountAttribute
     * @param float $value
     *
     * @return [type]
     */
    public function setAmountAttribute($value)
    {
        $vat = (float)request()->get('vat');
        $isVatInclusive = request()->get('is_vat_inclusive');
        if (!empty($vat) && $isVatInclusive) {
            $value -= ($value * ($vat / 100));
        } elseif (!$isVatInclusive) {
            $this->attributes['amount'] = $value;
        }
        $this->attributes['amount'] = $value;
    }
    /**
     * transactionDetails
     * @return [type]
     */
    public function transactionDetails()
    {
        return $this->hasMany(TransactionDetails::class);
    }
}
