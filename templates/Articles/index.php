<h1>記事一覧</h1>
<?= $this->Html->link('記事の追加', ['action'=>'add']) ?>
<table>
	<tr>
		<th>タイトル</th>
		<th>作成日時</th>
<?php
if ( $this->Identity->isLoggedIn() ) {
?>
		<th>操作</th>
<?php
}
?>
	</tr>
	<?php foreach ($articles as $article): ?>
	<tr>
		<td>
			<?= $this->Html->link($article->title, ['action'=>'view', $article->slug]) ?>
		</td>
		<td>
			<?= $article->created->format(DATE_RFC850) ?>
		</td>
<?php
if ( $this->Identity->isLoggedIn() ) {
?>
		<td>
<?php
    if ( $this->Identity->is($article->user_id) ) {
?>
			<?= $this->Html->link('編集', ['action'=>'edit', $article->slug]) ?>
			<?= $this->Form->postLink('削除',
			['action'=>'delete', $article->slug],
			['confirm'=>'削除するよ?']) ?>
<?php
}
?>
		</td>
<?php
}
?>
	</tr>
	<?php endforeach; ?>
</table>
