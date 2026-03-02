<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'amount',
        'date',
        'payer_id',
        'category_id',
        'colocation_id'
    ];

    public function payer(){
        return $this->belongsTo(User::class, 'payer_id');
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function colocation()
    {
        return $this->belongsTo(Colocation::class);
    }
}
