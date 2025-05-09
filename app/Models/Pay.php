<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pay extends Model
{
    use HasFactory;
    protected $fillable = [
        'nom',
        'alpha2',
        'numerique',
        'iso31662_code'
    ];
    
}
