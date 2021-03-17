<h1>記事の追加/編集</h1>
<?php
    echo $this->Form->create($article);
    echo $this->Form->control('user_id', ['type'=>'hidden']);
    echo $this->Form->control('title', ['label'=>'タイトル']);
    echo $this->Form->control('body', ['label'=>'本文', 'rows'=>'3']);
    echo $this->Form->button('保存');
    echo $this->Form->end();
?>
