<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Kyslik\ColumnSortable\Sortable;

class Area extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, Sortable;
    //protected $guard = 'user';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'full_name',
        'email',
        'mobile',
        'image',
        'password',
        'role_id',
        'status',
        'created_by',
    ];


    public $sortable = [
        'id',
        'title',
        'state_id',
        'city_id',
        'site_location',
        'created_at'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function state() {
        return $this->belongsTo(State::class, 'state_id');
    }

    public function city() {
        return $this->belongsTo(City::class, 'city_id');
    }
}
