<h1><?= $title; ?></h1>

<hr />

<ul>
	<?php foreach($entries as $key => $entry) : ?>
	<li>
		<p><strong><?= $entry->title; ?></strong></p>
		<p><?= $entry->body; ?></p>
	</li>
	<?php endforeach; ?>
</ul>