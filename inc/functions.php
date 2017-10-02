<?php
/*
|---------------------------------------
| Necessary functions will be here
|---------------------------------------
*/

//We will use 80 page for test
define('SCRAP_URL', 'http://www.imdb.com/search/title?country_of_origin=us&sort=user_rating,desc&view=advanced&page=80&ref_=adv_nxt');

require_once __DIR__ . '/PHPWebScraper.php';