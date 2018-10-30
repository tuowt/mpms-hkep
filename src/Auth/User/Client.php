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
     * /auth/user_permission
     * 取得登入使用者授權項目 (Authority Group) ，此功能僅以請求當時的授權情況為準。
     * 
     * 本功能有兩個模式:「簡易模式」及「一般模式」，
     * 於簡易模式中，使用者的授權項 目 ID 將會以字串形式列出，並不會附加其他資訊。
     * 於一般模式中，使用者的授權項目 會以物件形式列出，當中除了授權項目的 ID 外，還會附加授權項目的屬性。
     * 
     */
    public function permission($lite = 0) {
        $params = [
            'access_token' => $this->app['config']->accessToken,
            'lite' => $lite,
        ];

        return $this->request($this->wrap('auth/user_permission'), $params, 'post');
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

        return $this->request($this->wrap('auth/logout'), $params, 'post');
    }
}
