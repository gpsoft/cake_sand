<section>
<h1>Articles tagged with <?= $this->Text->toList(h($tags), 'or') ?></h1>

<?php foreach ( $articles as $article ): ?>
    <article>
        <h2>
<?=
$this->Html->link($article->title,
    ['controller'=>'Articles', 'action'=>'view', $article->slug]);
?>
        </h2>
        <span><?= h($article->created) ?></span>
    </article>
<?php endforeach; ?>
</section>
