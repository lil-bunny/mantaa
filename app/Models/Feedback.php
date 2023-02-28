<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Kyslik\ColumnSortable\Sortable;
use App\Models\User;

class Feedback extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, Sortable;
    
    protected $table = 'feedbacks';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

     protected $fillable = [
        'user_id',
        'area_id',
        'feedback',
        'status',
    ];


    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }
}
