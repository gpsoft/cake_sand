<?php
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
        <?= $this->Html->css(['normalize.min', 'milligram.min', 'cake', 'common']) ?>
        <?= $this->fetch('meta') ?>
        <?= $this->fetch('css') ?>
        <?= $this->fetch('script') ?>
        <title>Cake Sand</title>
    </head>
    <body>
        <header>
            <div class="container clearfix mt-16 mb-16">
                <h1 class="float-left mb-0">
                    <strong><small><a href="<?= $this->Url->build('/') ?>">Cake Sand</a></small></strong>
                </h1>
                <div class="float-right">
<?php
if ( $this->Identity->isLoggedIn() ) {
?>
                    <div class="row">
                            <img class="avatar" />
                            <span>User name</span>
<?php
    echo $this->Form->create();
    echo $this->Form->button('Logout');
    echo $this->Form->end();
?>
                    </div>
<?php
} else {
?>
                    <div>
<?php
    echo $this->Html->link('Login',
        ['action' => 'login', 'controller'=>'auth'],
        ['class' => 'button']);
?>
                    </div> 
<?php
}
?>
                    </div>
            </div>
        </header>
        <main>
            <div class="container">
                <h1><small>Menu</small></h1>
                <ul class="ml-16">
                    <li><?= $this->Html->link('Articles(from tutorial)', ['action' => 'index', 'controller'=>'Articles']) ?></li>
                    <li><?= $this->Html->link('Users(baked)', ['action' => 'index', 'controller'=>'Users']) ?></li>
                    <li><?= $this->Html->link('Tags(baked)', ['action' => 'index', 'controller'=>'Tags']) ?></li>
                </ul>
            </div>
        </main>
    </body>
</html>

