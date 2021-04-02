# Cake sand

## 概要

CakePHPフレームワークの実験プロジェクト。

## 環境

- php 7.4
- composer
- apache httpd
- mysql, postgres

## 実験内容

- クイックスタート(公式サイト)
- チュートリアル(公式サイト)

## インストール

```
$ php composer.phar create-project --prefer-dist cakephp/app:4.* .
```

`composer.json`に以下の記述があるので、`src/Console/Installer.php`が自動実行される。

```php
"scripts": {
    "post-install-cmd": "App\\Console\\Installer::postInstall",
    "post-create-project-cmd": "App\\Console\\Installer::postInstall",
    ...
```

ここで、`config/app_local.php`を生成したり、SALTを初期化してくれたりする。

## コンフィグ

- 環境変数
  - `DEBUG`
  - `APP_DEFAULT_LOCALE`
  - `APP_DEFAULT_TIMEZONE`
  - `SECURITY_SALT`
  - `DATABASE_URL`
  - `DATABASE_TEST_URL`
- `config/app_local.php`
- `config/app.php`

```php
<?php
// app_local.php for development
return [
    'debug' => true,
    'Security' => [
        'salt' => '25f.....',
    ],
    'App' => [
        'defaultLocale' => 'ja_JP',
        'defaultTimezone' => 'Asia/Tokyo',
    ],
    'Datasources' => [
        'default' => [
            'host' => 'db',
            //'port' => 'non_standard_port_number',
            'username' => 'root',
            'password' => 'mysql',
            'database' => 'cake_sand',
        ],
        'test' => [
            'host' => 'localhost',
            //'port' => 'non_standard_port_number',
            'username' => 'root',
            'password' => 'mysql',
            'database' => 'cake_sand_test',
        ],
    ],
];
```

`config/bootstrap.php`で、`.env`をロードするようにしておけば、`config/.env`で環境変数を定義可能。

```php
if (!env('APP_NAME') && file_exists(CONFIG . '.env')) {
    $dotenv = new \josegonzalez\Dotenv\Loader([CONFIG . '.env']);
    $dotenv->parse()
        ->putenv()
        ->toEnv()
        ->toServer();
}
```

`APP_NAME`が未定義の場合のみロードするようになってるので注意。

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

$ bin/cake bake migration_snapshot Initial
$ bin/cake bake migration WhatToDo ...
$ bin/cake bake migration CreateHoges name:string place:text count:integer created modified
$ bin/cake bake seed Hoges
$ bin/cake bake seed --data Hoges
```

### Migration

`bake`したマイグレーションファイル名のタイムスタンプがUTCになるのは、一意性を考えるとしかたないのかな。

- `CreateHoges`, `DropHoges`, `AlterHoge`,
- `AddFugaToHoges`, `RemoveFugaFromHoges`, `AlterFugaOnHoges`

```
$ bin/cake migrations status
$ bin/cake migrations migrate
$ bin/cake migrations rollback

$ bin/cake migrations seed
$ bin/cake migrations seed --seed HogesSeed
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

`fallbacks()`の下に`DebugKit`用のrouteを追加すれば解消する。

```php
$builder->fallbacks();

if ( Configure::read('debug') ) {
    $builder->connect('/:controller/:action/*', ['plugin' => 'DebugKit']);
}
```

参考記事:

- https://www.m-kobayashi.org/working_log/2020/06/04_01.html
- https://discourse.cakephp.org/t/debugkit-not-showing-due-to-missing-route/7419

## 本番(Heroku)

GitリポジトリごとHerokuへプッシュするスタイル。環境変数経由でコンフィグする。`DATABASE_URL`は、Herokuが定義してくれる。それ以外は、`heroku config:add`で設定。

```
$ heroku login
$ heroku apps:create cake-sand
$ heroku config:add APP_DEFAULT_LOCALE="ja_JP" APP_DEFAULT_TIMEZONE="Asia/Tokyo" SECURITY_SALT=""
$ heroku addons:create heroku-postgresql:hobby-dev
```

DBへつないでテーブルを生成。

```
$ heroku pg:info
$ heroku pg:credentials:url
$ heroku run bash
# psql "postgres://ymxhuuhkf....."
```

本番用のSALTは、`openssl_random_pseudo_bytes()`とかで作ればいいんじゃないかな。

```php
echo bin2hex(openssl_random_pseudo_bytes(32));
```

デプロイ。

```
$ git push heroku master
```

migrationsコマンド。

```
$ heroku run bin/cake migrations migrate
```

問題が1つ。

Herokuへデプロイすると、`composer install`が実行され、`config/app_local.php`が生成されるが、この`app_local.php`をHerokuで使うのは少々不自由なので、Heroku専用の`app_heroku.php`を使いたい。

そこで、`config/bootstrap.php`に手を入れる。

```php
if (isset($_ENV['DYNO'])) {
    Configure::load('app_heroku', 'default');
} else if (file_exists(CONFIG . 'app_local.php')) {
    Configure::load('app_local', 'default');
}
```

## DDL

### MySQL

```sql
CREATE TABLE `articles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(191) NOT NULL,
  `body` text,
  `published` tinyint(1) DEFAULT '0',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `articles_tags` (
  `article_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL,
  PRIMARY KEY (`article_id`,`tag_id`),
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

CREATE TABLE `tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(191) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `title` (`title`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
```

### PostgreSQL

```sql
CREATE TABLE articles (
  id serial,
  user_id integer NOT NULL,
  title varchar(255) NOT NULL,
  slug varchar(191) NOT NULL,
  body text,
  published smallint DEFAULT '0',
  created timestamp DEFAULT NULL,
  modified timestamp DEFAULT NULL,
  PRIMARY KEY (id),
  UNIQUE (slug)
);

CREATE TABLE articles_tags (
  article_id integer NOT NULL,
  tag_id integer NOT NULL,
  PRIMARY KEY (article_id,tag_id)
);

CREATE TABLE tags (
  id serial,
  title varchar(191) DEFAULT NULL,
  created timestamp DEFAULT NULL,
  modified timestamp DEFAULT NULL,
  PRIMARY KEY (id),
  UNIQUE (title)
);

CREATE TABLE users (
  id serial,
  email varchar(255) NOT NULL,
  password varchar(255) NOT NULL,
  created timestamp DEFAULT NULL,
  modified timestamp DEFAULT NULL,
  PRIMARY KEY (id)
);
```

