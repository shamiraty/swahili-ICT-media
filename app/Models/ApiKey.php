<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class ApiKey extends Model
{
    protected $fillable = [
        'username',
        'password',
        'api_key',
        'end_date',
        'phone_number',
        'email',
        'category',
        'last_used', // Ongeza last_used
        'number_of_requests', // Ongeza number_of_requests
        'status', // Ongeza status
        'access_history', // Ongeza access_history
    ];

    protected $casts = [
        'end_date' => 'date',
        'last_used' => 'datetime', // Itawezesha Laravel kutibu kama tarehe na saa
        'status' => 'boolean',    // Itawezesha Laravel kutibu kama boolean
        'access_history' => 'array', // Itawezesha Laravel kutibu kama array (itabadilishwa kwenda/kutoka JSON kiatomati)
    ];

    /**
     * Get the number of days remaining until the API key expires.
     *
     * @return int|null
     */
    public function getDaysRemainingAttribute()
    {
        if ($this->end_date) {
            return Carbon::parse($this->end_date)->diffInDays(Carbon::now());
        }
        return null;
    }
}