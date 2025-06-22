<?php

namespace App\Models\Game\Transaction;

use App\Models\Game\GameUser;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        "transaction_id",
        "currency_id",
        "sender_id",
        "receiver_id",
        "amount",
        "data",
    ];

    protected $casts = [
        "amount" => "decimal:10",
    ];

    public function sender()
    {
        return $this->belongsTo(GameUser::class, "sender_id", "id");
    }

    public function receiver()
    {
        return $this->belongsTo(GameUser::class, "receiver_id", "id");
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class, "currency_id", "id");
    }
}
