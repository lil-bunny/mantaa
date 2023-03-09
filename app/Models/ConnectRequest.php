<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Kyslik\ColumnSortable\Sortable;
use App\Models\User;

class ConnectRequest extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, Sortable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

     protected $fillable = [
        'user_id',
        'area_id',
        'updated_at',
        'created_at',
    ];

    public $sortable = [
        'id',
        'area_id',
        'user_id',
        'created_at'
    ];


    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function area() {
        return $this->belongsTo(Area::class, 'area_id');
    }
}
