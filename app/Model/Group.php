<?php

namespace App\Model;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    //
    protected $fillable = ['name','creator','qrcode','notice'];

    protected $table = 'im_groups';

    public function users()
    {
        return $this->belongsToMany(User::class,GroupUser::class, 'group_id','user_id');
    }
}
