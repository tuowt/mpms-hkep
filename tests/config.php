<?php
use Hkep\Factory;

// bearer = access_token 通过OAuth2.0请求服务器获取
$config = [
    'bearer'     => 'YXFhNWtFSFN3RWNaQno0SlVaZzlFRFMwWkNpTTZGVnNpSVJwSUZJYXh5OD0=',
    'accessToken' => 'YXFhNWtFSFN3RWNaQno0SlVaZzlFRFMwWkNpTTZGVnNpSVJwSUZJYXh5OD0=',
    'log' => [
        'level' => 'debug',
        'file' => ROOT.DS.APP_DIR.'/tmp/logs/hkep.log',
    ],
];

$app = Factory::auth($config);

// 获取用户信息
$result = $app->user->userinfo();
pr($result);
exit;