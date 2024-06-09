<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class People extends Model
{
    use HasFactory;

    protected $fillable = [
        'dni',
        'name',
        'last_name',
        'phone',
        'address'
    ];

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime: d M Y h:m:s A',
            'updated_at' => 'datetime: d M Y h:m:s A'
        ];
    }
}
