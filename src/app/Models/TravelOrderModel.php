<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class TravelOrderModel extends Model
{
    /** @use HasFactory<\Database\Factories\TravelOrderModelFactory> */
    use HasFactory, Notifiable;

    protected $table = 'travel_orders';

    protected $fillable = [
        'order_id',
        'user_id',
        'applicant_name',
        'destination',
        'departure_date',
        'return_date',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(UserModel::class, 'user_id', 'id');
    }
}
