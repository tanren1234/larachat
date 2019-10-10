<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    //
    protected $fillable = ['name','creator','qrcode','notice'];

    protected $table = 'im_groups';

    public function users()
    {
        return $this->hasMany(GroupUser::class, 'group_id');
    }
}
