<?php

namespace App\Models\Game\Transaction;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    protected $fillable = [
        "name",
        "display_name",
        "decimal_places",
        "symbol",
        "symbol_display",
    ];

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
