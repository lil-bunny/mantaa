<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Kyslik\ColumnSortable\Sortable;

class SiteMeritValue extends Authenticatable
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
        'score',
        'site_merit_id',
        'created_at'
    ];

    public function site_merit() {
        return $this->belongsTo(SiteMerit::class, 'site_merit_id', 'id');
    }

    public function areas() {
        return $this->belongsToMany(Area::class, 'area_site_merit_value')->setEagerLoads([]);
    }
}
