<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transactions extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',   
        'description',
        'value',
        'registerType',
        'category',
    ];


    protected $casts = [
        'value' => 'float',
    ];

    public function scopeOfType($query, $type)
    {
        return $query->where('registerType', $type);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
