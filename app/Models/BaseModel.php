<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * 基础模型类
 */
class BaseModel extends Model
{
    use HasFactory;
    
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
}
