<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Booking extends Model
{
    use SoftDeletes;
    #[Scope]
    protected function confirmed(Builder $builder)
    {
        $builder->where("status", "confirmed");
    }

    protected $fillable = [
        'user_id',
        'event_id',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
