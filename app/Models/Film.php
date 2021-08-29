<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Film extends Model
{
    use HasFactory;

    const VERY_POOR = 1;
    const POOR = 2;
    const AVERAGE = 3;
    const GOOD = 4;
    const EXCELLENT = 5;
    const NO_REVIEW = 0;

    const RATING = [
        self::NO_REVIEW => "Not rated yet!",
        self::VERY_POOR => "Very poor",
        self::POOR => "Poor",
        self::AVERAGE => "Average",
        self::GOOD => "Good",
        self::EXCELLENT => "Excellent",
    ];
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
        'release_date',
        'rating',
        'ticket_price',
        'country_id',
        'photo',
        'user_id',
    ];

    public function genres()
    {
        return $this->belongsToMany(Genre::class,'film_genre');
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function getRatingAttribute($value)
    {

        return self::RATING[$value];
    }

    public function getReleaseDateAttribute($value)
    {
        return Carbon::parse($value)->format('d-m-Y');
    }
}
