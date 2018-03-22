<?php

namespace Jwwb681232\WongApi\Models;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Foundation\Auth\User as Authenticatable;

class WongApi extends Authenticatable implements JWTSubject
{

    /**
     * 获取主键
     * @return string
     */
    final public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * 返回一个键值数组，其中包含要添加到JWT的任何自定义声明。
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
