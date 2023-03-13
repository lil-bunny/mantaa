<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Kyslik\ColumnSortable\Sortable;

class Notification extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, Sortable;
    //protected $guard = 'user';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'route',
        'object_id',
        'user_id',
        'type',
        'updated_at',
        'created_at',
    ];


    public $sortable = [
        'id',
        'title',
        'user_id',
        'is_read',
        'created_at'
    ];

    

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }
}
