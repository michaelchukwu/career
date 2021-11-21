<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    use HasFactory;

    protected $fillable = [
        "image",
        "title",
        "status"
    ];

    public function accounts(){
        return $this->hasMany(Account::class);
    }
}
