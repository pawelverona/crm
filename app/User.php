<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name','last_name','username','last_login','password_date','user_type_id','department_info_id',
        'start_work','end_work','status_work','phone','desc','student','ck','agency_id','guid','login_phone','rate','priv_phone',
        'salary','add_to_salary',
        'email', 'password','id_manager','documents','dating_type',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function department_info() {
        return $this->belongsTo('App\Department_info');
    }

    public function user_type() {
        return $this->belongsTo('App\User_types', 'user_type_id');
    }

    public function agencies() {
        return $this->belongsTo('App\Agencies', 'agency_id');
    }

    public function schedule() {
        return $this->hasMany('App\Schedule', 'id_user');
    }

    public function penalty_bonuses() {
        return $this->hasMany('App\PenaltyBonus', 'id_user');
    }

    public function work_hours() {
        return $this->hasMany('App\Work_hour', 'id_user');
    }

    public function dkj() {
        return $this->hasMany('App\Dkj', 'id_user');
    }

    public function privilages() {
        return $this->belongsToMany('App\User', 'privilage_relation', 'user_type_id', '1');
    }
}
