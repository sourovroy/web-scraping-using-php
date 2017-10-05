<?php
/*
|---------------------------------------
| Necessary functions will be here
|---------------------------------------
*/

// Define root path
define('ROOT_PATH', realpath(__DIR__.'/..'));

//We will use 80 page for test
define('SCRAP_URL', 'http://www.imdb.com/search/title?year=2017,2017&title_type=feature&explore=has');

require_once __DIR__ . '/PHPWebScraper.php';