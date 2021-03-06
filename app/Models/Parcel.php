<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Parcel extends Model
{
    use SoftDeletes, HasFactory;

    /** @var array<string>  */
    protected $fillable = [
        'name'
    ];
}
