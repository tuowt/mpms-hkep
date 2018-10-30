# Hkep
香港商务印刷馆相关接口

## Composer 安装

```dockerfile
composer require tuowt/mpms-hkep
```

## Usage

### 初始化Object对象
```php
use Hkep\Factory;

$config = [
    'bearer'     => 'token', // OAuth2.0获取到的access_token
    'accessToken' => 'token',// OAuth2.0获取到的access_token
];

$app = Factory::auth($config);
```

### 获取用户信息:

```php
// 获取用户信息 可选参数 $academicYear = 学年
$result = $app->user->userinfo($academicYear = null);
pr($result);
```

### 用户登出:

```php
// 必填参数$membercode = 會員代碼, 可选参数 $prodcode = HKEP 產品代碼
$result = $app->user->logout($membercode, $prodcode = null);
pr($result);
```
