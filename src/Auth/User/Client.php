<?php

/*
 * This file is part of the tuowt/mpms-hkep.
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Hkep\Auth\User;

use Hkep\Kernel\Support;
use Hkep\Auth\Kernel\BaseClient;

class Client extends BaseClient {

    /**
     * oa/userinfo 取得使用者資訊
     * 
     */
    public function userinfo($academicYear = null) {
        $params = [
            'access_token' => $this->app['config']->accessToken,
        ];

        if($academicYear) {
            $params['academic_year'] = $academicYear;
        }

        return $this->request($this->wrap('oa/userinfo'), $params, 'post');
    }

    /**
     *  /auth/logout
     * 登出使用者
     * 
     */
    public function logout($membercode, $prodcode = null) {
        $params = [
            'access_token' => $this->app['config']->accessToken,
            'membercode' => $membercode,
        ];

        if($prodcode) {
            $params['prodcode'] = $prodcode;
        }

        return $this->requestRaw($this->wrap('auth/logout'), $params);
    }
}
