# Hkep
网龙集团统一支付接口

## Composer 安装

```dockerfile
composer require tuowt/Hkep
```

## Usage

### 服务端发起支付请求:

```php
use Hkep\Factory;

// $config = Configure::read('Hkep');
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
    'userName'       => '用户名',
    'userId'         => '1',
    'orderNO'        => 'O123456',
    'channel'        => 'wx_mini',
    // 支付的来源,如果不设置则会使用配置里的支付来源
    'paySource'      => '0',
    'subject'        => '标题',
    'body'           => '腾讯充值中心-QQ会员充值',
    'expireDateTime' => date('Y-m-d H:i:s', strtotime("+1 day")),
    'amount'         => 88,
    // 支付结果通知网址,如果不设置则会使用配置里的默认地址
    'notifyUrl'      => 'https://pay.weixin.qq.com/wxpay/pay.action',
]);
```

### 服务器异步通知：
> 闭包中返回true 回调响应 success，其他都返回 fail
```php
$app = Factory::payment($config);
// 业务处理
try {
    $response = $app->handlePaidNotify(function ($notify, $successful) use ($app) {
        if (!isset($notify['tradeNO']) || !isset($notify['tradeStatus'])) {
            return '订单错误';
        }
        // 查询订单接口，判断订单真实状态
        $wxOrder = $app->order->queryByTradeNo($notify['orderNO'], 'wx_pub_qr');
        if ($wxOrder['errorCode'] != 0 || strtoupper($wxOrder['msg']) != 'OK') {
            return '订单状态错误';
        }
        // 不考虑返回结果的多条，默认读取一条判断
        $orderInfo = json_decode($wxOrder['data']['OrderItems'], true);
        $orderInfo = array_shift($orderInfo);
        if(!in_array($orderInfo['TradeStatus'], [
            'TRADE_FINISHED',
            'TRADE_SUCCESS'
        ])) {
            return '订单状态错误';
        }

        return true;
    });

    // 直接返回回调处理后的结果
    return $response->send();
} catch (\Hkep\Kernel\Exceptions\Exception $e) {
    $this->log($e, LOG_DEBUG);
}
```

### 订单查询：
#### 根据订单号查询：
```php
// 订单号查询
$app->order->queryByTradeNo($tradeNo, $channel);
```

#### 订单查询：
```php
$params = [
    'orderNO'   => '',  // 必填
    'channel'   => '',  // 必填
    'username'  => '',  // 可选
];

$app->order->query($params);
```

### 订单取消：
```php
$params = [
    'orderNO'   => '',  // 必填
    'channel'   => '',  // 必填
    'username'  => '',  // 必填
];

$app->order->close($params);
```
