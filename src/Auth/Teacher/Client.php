<?php

/*
 * This file is part of the tuowt/mpms-hkep.
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Hkep\Auth\Teacher;

use Hkep\Kernel\Support;
use Hkep\Auth\Kernel\BaseClient;

class Client extends BaseClient {

    /**
     * /auth/getclassesbymember
     * 取得使用者身份為教師的任教班別及科目
     */
    public function getclasses($membercode, $academicYear = null) {
        $params = [
            'access_token' => $this->app['config']->accessToken,
            'membercode' => $membercode,
        ];

        if($academicYear) {
            $params['academic_year'] = $academicYear;
        }

        return $this->httpPost($this->wrap('auth/getclassesbymember'), $params);
    }

    /**
     * /auth/getgroupsbymember
     * 取得使用者身份為教師所創建的所有組別
     * 
     */
    public function getgroups($membercode, $academicYear = null) {
        $params = [
            'access_token' => $this->app['config']->accessToken,
            'membercode' => $membercode,
        ];

        if($academicYear) {
            $params['academic_year'] = $academicYear;
        }

        return $this->httpPost($this->wrap('auth/getgroupsbymember'), $params);
    }
}
