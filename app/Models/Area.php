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

    // Cast attributes JSON to array
    protected $casts = [
        'gridTrends' => 'array'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'site_location',
        'priority',
        'income_group',
        'road_name',
        'pin_code',
        'lat',
        'lng',
        'state_id',
        'city_id',
        'city_tag',
        'face_traffic_from',
        'place_type',
        'media_formats',
        'orientation',
        'media_tags',
        'height',
        'width',
        'illumination',
        'ad_spot_per_second',
        'total_ad_spot_perday',
        'total_advertiser',
        'display_charge_pm',
        'production_cost',
        'installation_cost',
        'media_partner_name',
        'media_partner_email',
        'area_pic1',
        'area_pic2',
        'area_video',
        'nearby_places',
        'gridTrends',
        'site_count',
        'error_response',
        'status',
        'created_by',
        'updated_at',
        'created_at',
    ];


    public $sortable = [
        'id',
        'title',
        'state_id',
        'city_id',
        'site_location',
        'created_at'
    ];

    public function state() {
        return $this->belongsTo(State::class, 'state_id');
    }

    public function city() {
        return $this->belongsTo(City::class, 'city_id');
    }

    // public function user() {
    //     return $this->belongsTo(User::class, 'user_id');
    // }

    public function site_marit_values() {
        return $this->belongsToMany(SiteMeritValue::class, 'area_site_merit_value')->setEagerLoads([]);
    }
}
