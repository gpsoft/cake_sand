# Cake sand

## 概要

CakePHPフレームワークの実験プロジェクト。

## 環境

- php 7.4
- composer
- apache httpd
- mysql

## 実験内容

- クイックスタート(公式サイト)
- チュートリアル(公式サイト)

## 公式チュートリアル - CMS

### serverコマンド

```
$ bin/cake server
$ bin/cake server --host 0.0.0.0 --port 8080 --document_root webroot/
```

### bakeコマンド

```
$ bin/cake bake model hoges
$ bin/cake bake controller hoges
$ bin/cake bake template hoges

$ bin/cake bake all fugas

$ bin/cake bake policy --type entity Piyo
```


### Authentication

```php
// AppController.php
$this->loadComponent('Authentication.Authentication');
```

`loadComponent('Hoge.Fuga')`は、「`Hoge`プラグインの`Fuga`コンポーネントをロードする」の意味。コントローラ内では、`$this->Fuga`でコンポーネントを参照可能。

```php
// AuthenticationService object
$service = $this->request->getAttribute('authentication');

// Authentication\Controller\Component\AuthenticationComponent object
$component = $this->Authentication;

// Authentication\Identity object
$identity = $this->Authentication->getIdentity();
$identity = $this->request->getAttribute('identity');
$identity->getIdentifier(); // user_id
$identity['email'];
$identity->get('email');
$identity->email;

// Authentication\Authenticator\Result object
$result = $this->Authentication->getResult();
$result = $this->request->getAttribute('authentication')->getResult();
$result->isValid();
$result->getStatus();   // 'SUCCESS', 'FAILURE_IDENTITY_NOT_FOUND', ...
$result->getErrors();   // array of what?

// logout
$service->logout();
```

### Authorization

```php
// Authorization\Controller\Component\AuthorizationComponent object
$component = $this->Authorization;

// authorize all
$component->skipAuthorization();

// authorize by policy
$component->authorize($article);
```

## トラブルシュート

### DebugKitパネルが小さい?

ルーティングエラーが起きている。

```
Missing Route
Cake\Routing\Exception\MissingRouteException
A route matching "array ( 'controller' => 'users', 'action' => 'login',
  'plugin' => 'DebugKit', '_ext' => NULL, )" could not be found.
```

- `fallbacks()`の下に`DebugKit`用のrouteを追加
- https://www.m-kobayashi.org/working_log/2020/06/04_01.html
- https://discourse.cakephp.org/t/debugkit-not-showing-due-to-missing-route/7419

```php
$builder->fallbacks();

if ( Configure::read('debug') ) {
    $builder->connect('/:controller/:action/*', ['plugin' => 'DebugKit']);
}
```

