<?php require_once __DIR__ . '/inc/functions.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>PHP Web Scraper</title>

	<link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>
	
	<section class="main-section album text-muted">
		<div class="container text-center">
			<h2>Most Popular 50 movies of 2017</h2>
		</div>
	
		<div class="container mt-5">
			<div class="row ">
				<?php PHPWebScraper::showList(); ?>
			</div>
			<div class="row">
				<div class="col mt-3">
					<a href="?reload=data" class="btn btn-primary">Re-store database</a>
				</div>
			</div>
		</div>
	</section>
	
</body>
</html>