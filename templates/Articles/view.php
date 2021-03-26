<h1><?= h($article->title) ?></h1>
<?= $this->Text->autoParagraph(h($article->body)) ?>
<p><b>Tags: </b><?= h($article->tag_string); ?></p>
<p><small>作成日時: <?= $article->created->format(DATE_RFC850) ?></small></p>
<p><?= $this->Html->link('Edit', ['action'=>'edit', $article->slug]) ?></p>

