<?php
use Hkep\Factory;

$config = [
    'bearer'     => 'YXFhNWtFSFN3RWNaQno0SlVaZzlFRFMwWkNpTTZGVnNpSVJwSUZJYXh5OD0=',
    'accessToken' => 'YXFhNWtFSFN3RWNaQno0SlVaZzlFRFMwWkNpTTZGVnNpSVJwSUZJYXh5OD0=',
    'log' => [
        'level' => 'debug',
        'file' => ROOT.DS.APP_DIR.'/tmp/logs/hkep.log',
    ],
];

$app = Factory::auth($config);

// 发起支付请求
$result = $app->user->userinfo();
pr($result);
exit;