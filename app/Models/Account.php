<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;

    protected $fillable=[
        "name",
        "key",
        "ip",
        "wallet_id"
    ];

    public function wallet(){
        return $this->belongsTo(Wallet::class);
    }
}
