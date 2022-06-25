<?php

namespace App\Models;

use App\Services\AdminUserService;
use Illuminate\Foundation\Auth\User;
use Illuminate\Notifications\Notifiable;

/**
 * 管理员模型
 */
class AdminUser extends User
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
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'mobile', 'password', 'status', 'avatar'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * 状态获取器
     *
     * @param string $value 
     * @return array
     */
    public function getStatusAttribute($value)
    {
        $genderData = AdminUserService::STATUS;

        return $genderData[$value] ?? '未知';
    }
}
