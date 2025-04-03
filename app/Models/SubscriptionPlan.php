<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class SubscriptionPlan extends Model
{
    use HasUuids, HasFactory;

    protected $fillable = [
        'name',
        'website',
        'monthly_price',
        'yearly_price',
        'logo'
    ];
}
