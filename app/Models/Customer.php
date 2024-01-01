<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;
use Laravel\Scout\Searchable;

class Customer extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'visibility'
    ];

    protected $dates = [
        'created_at',
    ];

    public function addedBy() : BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function toSearchableArray(): array
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'address' => $this->address,
        ];
    }

    protected static function booted(): void
    {

        static::addGlobalScope('addedBy', function(Builder $builder){

            if(isset(Auth::user()->is_admin)){
                if(Auth::user()->is_admin == 0){
                    $builder->where('user_id', Auth::id());
                }
            }
        });
        
    }
}
