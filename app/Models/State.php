<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Kyslik\ColumnSortable\Sortable;

class State extends Model
{
    use HasApiTokens, HasFactory, Notifiable, Sortable;
    protected $guarded = [];


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'status',
    ];

    public $sortable = [
        'id',
        'name',
        'created_at'
    ];

    public function state() {
        return $this->belongsTo(State::class, 'state_id');
    }
}
