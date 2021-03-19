<div class="users form">
	<?= $this->Flash->render() ?>
	<h1>Login</h1>
	<?= $this->Form->create() ?>
	<fieldset>
		<legend>ログインしてください。</legend>
		<?= $this->Form->control('email', ['required' => true]) ?>
		<?= $this->Form->control('password', ['required' => true]) ?>
	</fieldset>
	<?= $this->Form->submit('ログイン'); ?>
	<?= $this->Form->end() ?>

	<?= $this->Html->link("Add User", ['action' => 'add']) ?>
</div>
