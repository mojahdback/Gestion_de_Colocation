<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Colocation extends Model
{
    use HasFactory;

    protected $fillable = ['name','status'];

    public function users()
    {
        return $this->belongsToMany(User::class, 'memberships')
                    ->withPivot('role' , 'joined_at', 'left_at')
                    ->withTimestamps();  
    }

    public function activeMembers(){
        return $this->users()->wherePivotNull('left_at');
    }



    public function owner(){
        return $this->users()
              ->wherePivot('role','owner')
              ->first();
    }

    public function categories()
    {
         return $this->hasMany(Category::class);
    }

    public function expenses()
    {
    return $this->hasMany(Expense::class);
    }


}
