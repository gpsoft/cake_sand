<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.10.0
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 * @var \App\View\AppView $this
 */
use Cake\Cache\Cache;
use Cake\Core\Configure;
use Cake\Core\Plugin;
use Cake\Datasource\ConnectionManager;
use Cake\Error\Debugger;
use Cake\Http\Exception\NotFoundException;

$this->disableAutoLayout();

?>
<!DOCTYPE html>
<html lang="ja">
    <head>
        <?= $this->Html->charset() ?>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= $this->Html->meta('icon') ?>
        <link href="https://fonts.googleapis.com/css?family=Raleway:400,700" rel="stylesheet">
        <?= $this->Html->css(['normalize.min', 'milligram.min', 'cake', 'home']) ?>
        <?= $this->fetch('meta') ?>
        <?= $this->fetch('css') ?>
        <?= $this->fetch('script') ?>
        <title>Cake Sand</title>
    </head>
    <body>
        <header>
            <div class="container">
                <div class="header-content">
                    <div class="brand">
                        <a href="<?= $this->Url->build('/') ?>">Cake Sand</a>
                    </div>
                    <div class="user-info">
<?php
if ( $this->Identity->isLoggedIn() ) {
?>
                        <div>
                            <img class="avatar" th:src="${#authentication.principal.avatar} != '' ? ${#authentication.principal.avatar} : @{/img/default_avatar.jpg}" />
                            <span th:text="${#authentication.principal.username}">user</span>
                            <div class="logout">
                                <form th:action="@{/logout}" method="post">
                                    <input type="submit" value="Logout" />
                                </form>
                            </div>
                        </div>
<?php
} else {
?>
                        <div>
                            <?= $this->Html->link('Login', ['action' => 'login', 'controller'=>'auth'], ['class' => 'ope']) ?>
                        </div> 
<?php
}
?>
                    </div>
                </div>
            </div>
        </header>
        <main>
            <div class="container">
                <ul>
                    <li><?= $this->Html->link('Articles(from tutorial)', ['action' => 'index', 'controller'=>'Articles']) ?></li>
                    <li><?= $this->Html->link('Users(baked)', ['action' => 'index', 'controller'=>'Users']) ?></li>
                    <li><?= $this->Html->link('Tags(baked)', ['action' => 'index', 'controller'=>'Tags']) ?></li>
                </ul>
            </div>
        </main>
    </body>
</html>

