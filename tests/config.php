<?php

use Hkep\Factory;

$config = [
    // 必要配置
    'appId'     => 'xxxx',
    // APP key 密钥
    'key'       => '',
    // 支付的来源 默认其他（0-其他；1-iOS；2-android；3-PC；4-xxx）
    'paySource' => '0',
    // 三位 ISO 货币代码
    'currency'  => 'CNY',
    // 你也可以在下单时单独设置来想覆盖它
    'notifyUrl' => '默认的订单回调地址',
];

$app = Factory::payment($config);

// 发起支付请求
$result = $app->order->unify([
    'userName'       => '学生一',
    'userId'         => '1',
    'orderNO'        => '',
    'channel'        => 'wx_mini',
    'subject'        => '标题',
    'body'           => '腾讯充值中心-QQ会员充值',
    'expireDateTime' => date('Y-m-d H:i:s', strtotime("+1 day")),
    'amount'         => 88,
    // 支付结果通知网址，如果不设置则会使用配置里的默认地址
    'notifyUrl'      => 'https://pay.weixin.qq.com/wxpay/pay.action',
]);
