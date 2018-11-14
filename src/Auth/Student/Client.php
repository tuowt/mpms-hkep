<?php

/*
 * This file is part of the tuowt/mpms-hkep.
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Hkep\Auth\Student;

use Hkep\Kernel\Support;
use Hkep\Auth\Kernel\BaseClient;

class Client extends BaseClient {

    /**
     * /auth/getmembersbyclassgroup
     * 取得班別的學生及同班的老師的信息
     */
    public function getStudentsByClass($classid) {
        $params = [
            'access_token' => $this->app['config']->accessToken,
            'unittype' => 'class',
            'unitcode' => $classid,
        ];

        return $this->httpPost($this->wrap('auth/getmembersbyclassgroup'), $params);
    }
}
