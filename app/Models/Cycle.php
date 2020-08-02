<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cycle extends Model
{
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
}
