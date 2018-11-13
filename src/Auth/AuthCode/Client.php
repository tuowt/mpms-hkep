<?php

/*
 * This file is part of the tuowt/mpms-hkep.
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Hkep\Auth\AuthCode;

use Hkep\Auth\Kernel\BaseClient;

class Client extends BaseClient {

    /**
     * /groupid/submit
     * 客戶端向 MPMS 提交授權項目(Authority Group)
     */
    public function submit($items) {
        $params = [
            'items' => $items,
        ];

        return $this->httpPostJson('groupid/submit', $params);
    }

    /**
     * /groupid/disable
     * 使指定的授權項目(Authority Group)無法再被使用
     */
    public function disable($items) {
        $params = [
            'membercode' => $items,
        ];
        
        return $this->httpPostJson('groupid/disable', $params);
    }
}
