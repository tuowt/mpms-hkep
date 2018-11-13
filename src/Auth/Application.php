<?php

/*
 * This file is part of the tuowt/mpms-hkep.
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Hkep\Auth;

use Closure;
use Hkep\Kernel\ServiceContainer;
use Hkep\Kernel\Support;

/**
 * Class Application.
 *
 * @property \Hkep\Auth\User\Client           $user      用户(包括老师学生通用操作)
 * @property \Hkep\Auth\Teacher\Client        $teacher   老师
 * @property \Hkep\Auth\AuthCode\Client       $authCode  授权码
 */
class Application extends ServiceContainer
{
    /**
     * @var array
     */
    protected $providers = [
        User\ServiceProvider::class,
        Teacher\ServiceProvider::class,
        AuthCode\ServiceProvider::class,
    ];

    /**
     * @var array
     */
    protected $defaultConfig = [
        'http' => [
            'base_uri' => 'https://dev.hkep.com/mpmsapi/',
        ],
    ];

    /**
     * @param string|null $endpoint
     *
     * @return string
     */
    public function getKey($endpoint = null)
    {
        return $this['config']->key;
    }
}
