<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Kyslik\ColumnSortable\Sortable;

class SiteMerit extends Authenticatable
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
        'status',
        'created_by',
    ];


    public $sortable = [
        'id',
        'title',
        'status',
        'created_at'
    ];

    public function site_merit_values() {
        return $this->hasMany(SiteMeritValue::class, 'site_merit_id', 'id');
    }
}
