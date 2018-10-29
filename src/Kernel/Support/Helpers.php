<?php

/*
 * This file is part of the tuowt/mpms-hkep.
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Hkep\Kernel\Support;

/*
 * helpers.
 */

function sign_sort($endpoint = null) {
    $config = [
        'create.ashx'         => [
            'appId'      => '0',
            'paySource'  => '1',
            'userName'   => '2',
            'userId'     => '3',
            'orderNO'    => '4',
            'channel'    => '5',
            'amount'     => '6',
            'clientIp'   => '7',
            'currency'   => '8',
            'subject'    => '9',
            'notifyUrl'  => '10',
            'extra'      => '11',
            'timeExpire' => '12',
            'remark'     => '13',
            'Key'        => '14'
        ],
        'query.ashx'          => [
            'appId'    => '0',
            'userName' => '1',
            'orderNO'  => '2',
            'channel'  => '3',
            'Key'      => '4'
        ],
        'refund.ashx'         => [
            'appId'     => '0',
            'userName'  => '1',
            'orderNO'   => '2',
            'channel'   => '3',
            'clientIp'  => '4',
            'notifyUrl' => '5',
            'Key'       => '6'
        ],
        'fundtranstoacc.ashx' => [
            'appId'         => '0',
            'bizNo'         => '1',
            'clientIp'      => '2',
            'payeeType'     => '3',
            'payeeAccount'  => '4',
            'payeeRealName' => '5',
            'amount'        => '6',
            'remark'        => '7',
            'Key'           => '8'
        ],
        'closeorder.ashx'     => [
            'appId'    => '0',
            'userName' => '1',
            'orderNO'  => '2',
            'channel'  => '3',
            'clientIp' => '4',
            'Key'      => '5'
        ],
        'Hkep\Payment\Notify\Paid' => [
            'tradeStatus' => '0',
            'tradeNO'     => '1',
            'createTime'  => '2',
            'paymentTime' => '3',
            'notifyTime'  => '4',
            'appId'       => '5',
            'paySource'   => '6',
            'username'    => '7',
            'userId'      => '8',
            'orderNO'     => '9',
            'channel'     => '10',
            'amount'      => '11',
            'clientIp'    => '12',
            'currency'    => '13',
            'subject'     => '14',
            'Key'         => '15'
        ]
    ];

    if (isset($config[$endpoint])) {
        return $config[$endpoint];
    }
    return [];
}

function params_sort($endpoint, $attributes) {
    $sortConfig = sign_sort($endpoint);

    $attributes = array_intersect_key($attributes, $sortConfig);

    uksort($attributes, function ($first, $second) use ($sortConfig) {
        if ($sortConfig[$first] == $sortConfig[$second]) {
            return 0;
        }

        return $sortConfig[$first] > $sortConfig[$second] ? 1 : -1;
    });

    return $attributes;
}

/**
 * Generate a signature.
 *
 * @param array $attributes
 * @param string $key
 * @param string $encryptMethod
 *
 * @return string
 */
function generate_sign($attributes, $key, $encryptMethod = 'md5') {
    $attributes['Key'] = $key;
    return call_user_func_array($encryptMethod, [implode('', $attributes)]);
}

/**
 * Get client ip.
 *
 * @return string
 */
function get_client_ip() {
    if (!empty($_SERVER['REMOTE_ADDR'])) {
        $ip = $_SERVER['REMOTE_ADDR'];
    } else {
        // for php-cli(phpunit etc.)
        $ip = defined('PHPUNIT_RUNNING') ? '127.0.0.1' : gethostbyname(gethostname());
    }

    return filter_var($ip, FILTER_VALIDATE_IP) ?: '127.0.0.1';
}

/**
 * Get current server ip.
 *
 * @return string
 */
function get_server_ip() {
    if (!empty($_SERVER['SERVER_ADDR'])) {
        $ip = $_SERVER['SERVER_ADDR'];
    } elseif (!empty($_SERVER['SERVER_NAME'])) {
        $ip = gethostbyname($_SERVER['SERVER_NAME']);
    } else {
        // for php-cli(phpunit etc.)
        $ip = defined('PHPUNIT_RUNNING') ? '127.0.0.1' : gethostbyname(gethostname());
    }

    return filter_var($ip, FILTER_VALIDATE_IP) ?: '127.0.0.1';
}

/**
 * Return current url.
 *
 * @return string
 */
function current_url() {
    $protocol = 'http://';

    if ((!empty($_SERVER['HTTPS']) && 'off' !== $_SERVER['HTTPS']) || ($_SERVER['HTTP_X_FORWARDED_PROTO'] ? $_SERVER['HTTP_X_FORWARDED_PROTO'] : 'http') === 'https') {
        $protocol = 'https://';
    }

    return $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
}

/**
 * Return random string.
 *
 * @param string $length
 *
 * @return string
 */
function str_random($length) {
    return Str::random($length);
}

/**
 * @param string $content
 * @param string $publicKey
 *
 * @return string
 */
function rsa_public_encrypt($content, $publicKey) {
    $encrypted = '';
    openssl_public_encrypt($content, $encrypted, openssl_pkey_get_public($publicKey), OPENSSL_PKCS1_OAEP_PADDING);

    return base64_encode($encrypted);
}
