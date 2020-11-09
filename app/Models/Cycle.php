<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cycle extends Model
{
    use SoftDeletes, HasFactory;

    /** @var array<string>  */
    protected $fillable = [
        'starts_at',
        'ends_at',
        'vegetable_id',
        'parcel_id'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function vegetable()
    {
        return $this->belongsTo(Vegetable::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parcel()
    {
        return $this->belongsTo(Parcel::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function times()
    {
        return $this->hasMany(Time::class);
    }
}
