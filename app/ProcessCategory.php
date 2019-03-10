<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProcessCategory extends Model
{
    protected $table = 'process_category';

    protected $casts = [
        'permission' => 'array'
    ];


    const PUBLIC_PERMISSION = 'public';
    const RESTRICTED_PERMISSION = 'restricted';

    protected $fillable = ['name', 'permission', 'visibility'];

    protected $dates = ['created_at'];

    public function getVisibilityTranslatedAttribute()
    {
        return ($this->visibility == 'public') ? 'Pública' : 'Restrita';
    }

    public function getVisibilityIconAttribute()
    {
        return ($this->visibility == 'public') ? "<i class='fas fa-lock-open'></i>" : "<i class='fas fa-lock'></i>";
    }

    public function groupHasPermission($group_id)
    {
        if (empty($this->permission['groups'])) {
            return false;
        }

        return in_array($group_id, $this->permission['groups']);
    }

    public function userHasPermission($user_id)
    {
        if (empty($this->permission['users'])) {
            return false;
        }

        return in_array($user_id, $this->permission['users']);
    }

    public function userSelectedHasPermission($user_id)
    {
        if (empty($this->permission['users_selected'])) {
            return false;
        }

        return in_array($user_id, $this->permission['users_selected']);
    }

    public static function getCategoriesAllowedToUser()
    {
        $user = auth()->user();
        //if the logged user is a member of committee or VIP, then bring all categories
        if ($user->isCommitteeMember() || $user->isVip()) {
            return self::all()->sortBy('name');
        }

        //bring all public categories + specified categories for user
        return self::all()->map(function ($category) {
            if ($category->visibility == self::PUBLIC_PERMISSION) {
                return $category;
            } else if (in_array(auth()->user()->id, $category->permission['users'])) {
                return $category;
            }
        })
            ->reject(function ($name) {
                return empty($name);
            });
    }
}
