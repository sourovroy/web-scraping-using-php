<?php require_once __DIR__ . '/inc/functions.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>PHP Web Scraper</title>

	<link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>
	
	<section class="main-section">
		<div class="container">
			<div class="row justify-content-md-center">
				<div class="col col-md-8">
					<?php PHPWebScraper::showList(); ?>
				</div>
			</div>
		</div>
	</section>
	
</body>
</html>