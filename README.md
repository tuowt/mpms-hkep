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

### 取得登入使用者授權項目

```php
// 可选参数 $lite = 0,简化模式;1,一般模式，默认简化模式
$result = $app->user->permission($lite = 0);
pr($result);
```

### 取得班別的學生及同班的老師的信息

```php
// 必填参数$classid = 班级编号
$result = $app->student->getStudentsByClass($classid);
pr($result);
```
