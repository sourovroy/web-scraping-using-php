<?php foreach($movies as $movie): ?>
<div class="card">
	<?php $image = self::getLargeImage($movie['image']); ?>
	<img src="<?= $image; ?>" alt="<?= $movie['title']; ?>">
	<div class="card-block">
		<h4 class="card-title"><?= $movie['title']; ?></h4>
		<p class="card-text"><?= $movie['description']; ?></p>
		<p class="card-text">
			<?php if(!empty($movie['year'])): ?>Year: <?php echo $movie['year']; endif; ?>
			<?php if(!empty($movie['runtime'])): ?> | Runtime: <?php echo $movie['runtime']; endif; ?>
			<?php if(!empty($movie['genre'])): ?> | Genre: <?php echo $movie['genre']; endif; ?>
			<?php if(!empty($movie['certificate'])): ?> | Certificate: <?php echo $movie['certificate']; endif; ?>
		</p>
	</div>
</div>
<?php endforeach; ?>