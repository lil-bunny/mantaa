<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Kyslik\ColumnSortable\Sortable;

class City extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, Sortable;
    //protected $guard = 'user';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'data',
        'updated_at',
        'created_at'
    ];


    public $sortable = [
        'id',
        'name',
        'updated_at',
        'created_at'
    ];
}
