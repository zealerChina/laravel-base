<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * 用户模型
 */
class User extends Authenticatable
{
    use Notifiable;
    
    /**
    * 类型转换
    *
    * @var array
    */
   protected $casts = [
       'created_at' => 'datetime:Y-m-d H:i:s',
       'updated_at' => 'datetime:Y-m-d H:i:s',
   ];
    
    /**
     * 黑名单
     */
    protected $guarded = [];

    /**
     * 和被邀请人一对多的关系
     *
     * @return void
     */
    public function inviters()
    {
        return $this->hasMany('App\Models\User', 'invite_id');
    }

    /**
     * 与邀请人一对一的关系
     *
     * @return void
     */
    public function invitedBy()
    {
        return $this->belongsTo('App\Models\User', 'invite_id');
    }
    
    /**
     * 与消息多对多的关系
     *
     * @return void
     */
    public function messages()
    {
        return $this->belongsToMany(Message::class, 'user_message', 'user_id', 'message_id');
    }

    /**
     * 与房子多对多的关系
     *
     * @return void
     */
    public function houses()
    {
        return $this->belongsToMany(House::class, 'user_house', 'user_id', 'house_id');
    }

    /**
     * 与房子一对一的关系
     *
     * @return void
     */
    public function house()
    {
        return $this->hasOne(House::class);
    }

    /**
     * 与用户关注的人多对多的关系
     *
     * @return void
     */
    public function follows()
    {

    }

    /**
     * 与关注用户者多对多的关系
     *
     * @return void
     */
    public function FollowedBys()
    {

    }
}
