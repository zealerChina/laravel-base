<?php

namespace App\Models;

/**
 * 配置模型
 */
class Config extends BaseModel
{
    /**
     * 值获取器
     *
     * @param string $value 
     * @return array
     */
    public function getValueAttribute($value)
    {
        if ($this->is_json == 1) {
            return json_decode($value, true);
        } else {
            return $value;
        }
    }

    /**
     * 值修改器
     *
     * @param array $value
     * @return void
     */
    public function setValueAttribute($value)
    {
        if (is_array($value)) {
            $this->attributes['value'] = json_encode($value, JSON_UNESCAPED_UNICODE);
            $this->attributes['is_json'] = 1;
        } else {
            $this->attributes['value'] = $value;
        }
    }
}
