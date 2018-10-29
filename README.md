# Hkep
香港商务印刷馆相关接口

## Composer 安装

```dockerfile
composer require tuowt/mpms-hkep
```

## Usage

### 获取用户信息:

```php
use Hkep\Factory;

 $config = [
    'bearer'     => 'token', // OAuth2.0获取到的access_token
    'accessToken' => 'token',// OAuth2.0获取到的access_token
];

$app = Factory::auth($config);

// 获取用户信息
$result = $app->user->userinfo();
pr($result);
```
