<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Group;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'is_process_committee_member' => 'boolean',
    ];

    public function isCommitteeMember()
    {
        return $this->is_process_committee_member;
    }

    public function isVIP()
    {
        return in_array($this->group_id, Group::VIP);
    }

    public function group()
    {
        return $this->belongsTo('App\Group');
    }

    public function scopeVip($query)
    {
        return $query->where('group_id', Group::VIP);
    }

    public function scopeCommittee($query)
    {
        return $query->where('is_process_committee_member', 1);
    }
}
