<?php 
/*
|---------------------------------------
| Core scraper class
|---------------------------------------
*/
class PHPWebScraper
{
	/**
	 * Show the output
	 */
	public static function showList()
	{
		if(isset($_GET['reload']) && $_GET['reload'] == 'data'){
			// Get data through http request
			$requestReturn = self::sendHTTPRequest();
			
			// Parse respond data
			$parsedData = self::parseHTMLString($requestReturn);
			header("Location: index.php");
			exit;
		}

		// Generate the html
		self::generateHtml();
	}// End of showList

	/**
	 * Send HTTP request
	 */
	private static function sendHTTPRequest()
	{
        $ch = curl_init(); 
        curl_setopt($ch, CURLOPT_URL, SCRAP_URL); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
        $output = curl_exec($ch); 

        if($output === false){
        	die(curl_error($ch));
        }

        curl_close($ch); 

        return $output;
	}// End of sendHTTPRequest

	/**
	 * Parse the html string
	 */
	private static function parseHTMLString($fullHtml)
	{
		$titleArray = self::getMoviesTitle($fullHtml);

		$yearArray = self::getMoviesYear($fullHtml);

		$imageArray = self::getMoviesImage($fullHtml);

		$runtimeGenreArray = self::getCertificateRuntimeGenre($fullHtml);

		$descriptionArray = self::getDescription($fullHtml);
		
		$fullArray = self::mixAllTogather([
			'title' => $titleArray,
			'year' => $yearArray,
			'image' => $imageArray,
			'runtime_genre' => $runtimeGenreArray,
			'description' => $descriptionArray,
		]);

		$data = serialize($fullArray);
		file_put_contents(ROOT_PATH.'/database/database.txt', $data);
		
		return $fullArray;
	}// End of parseHTMLString

	/**
	 * Parse the movie title
	 */
	private static function getMoviesTitle($htmlString)
	{
		$patern = '/<a href="\/title\/.*?\/\?ref_=adv_li_tt"\n>(.*?)<\/a>/';
		preg_match_all($patern, $htmlString, $matches);
		return isset($matches[1]) ? $matches[1] : [];
	}// End of getMoviesTitle

	/**
	 * Get Movies year
	 */
	private static function getMoviesYear($htmlString)
	{
		$patern = '/<span class="lister-item-year text-muted unbold">.*?\((\d{4}).*?\).*?<\/span>/';
		preg_match_all($patern, $htmlString, $matches);
		return isset($matches[1]) ? $matches[1] : [];
	}//End of getMoviesYear

	/**
	 * Get image URL
	 */
	private static function getMoviesImage($htmlString)
	{
		$pattern = '/loadlate="(.*?)"/';
		preg_match_all($pattern, $htmlString, $matches);
		return isset($matches[1]) ? $matches[1] : [];
	}//End of getMoviesImage

	/**
	 * Get certificate, runtime, genre
	 */
	private static function getCertificateRuntimeGenre($htmlString)
	{
		$pattern = '/<p class="text-muted\s">(.*?)<\/p>/is';
		preg_match_all($pattern, $htmlString, $blockMatches);
		// print_r($blockMatches[1]);
		$certificate = [];
		$runtime = [];
		$genre = [];
		foreach($blockMatches[1] as $index => $blockMatch){
			// Certificate
			$pattern = '/<span class="certificate">(.*?)<\/span>/';
			if(preg_match($pattern, $blockMatch, $match)){
				$certificate[] = $match[1];
			}else{
				$certificate[] = '';
			}

			// Runtime
			$pattern = '/<span class="runtime">(.*?)<\/span>/';
			if(preg_match($pattern, $blockMatch, $match)){
				$runtime[] = $match[1];
			}else{
				$runtime[] = '';
			}

			// Genre
			$pattern = '/<span class="genre">\n(.*?)\s*?<\/span>/';
			if(preg_match($pattern, $blockMatch, $match)){
				$genre[] = $match[1];
			}else{
				$genre[] = '';
			}

		}//End foreach

		return [
			'certificate' => $certificate,
			'runtime' => $runtime,
			'genre' => $genre
		];
	}//End of getCertificateRuntimeGenre

	/**
	 * Get movie short description
	 */
	private static function getDescription($htmlString)
	{
		$pattern = '/\n<p class="text-muted">(.*?)<\/p>\n\s*<p class="">/is';
		preg_match_all($pattern, $htmlString, $matches);
		$data = array_map('trim', $matches[1]);
		$data = str_replace("\n", '', $data);
		return $data;
	}// End of getDescription

	/**
	 * Mix all indivisule array togather
	 */
	private static function mixAllTogather($allArray)
	{
		$counts = count($allArray, 1);
		if($counts == 358){
			$finalArray = [];
			foreach($allArray['title'] as $index => $title){
				$finalArray[] = [
					'title' => $title,
					'year' => $allArray['year'][$index],
					'image' => $allArray['image'][$index],
					'runtime' => $allArray['runtime_genre']['runtime'][$index],
					'genre' => $allArray['runtime_genre']['genre'][$index],
					'certificate' => $allArray['runtime_genre']['certificate'][$index],
					'description' => $allArray['description'][$index],
				];
			}
			return $finalArray;
		}else{
			die('Sorry!. Unable to get all data properly.');
		}
	}//End of mixAllTogather

	/**
	 * Genarate output html
	 */
	private static function generateHtml()
	{
		$movies = file_get_contents(ROOT_PATH.'/database/database.txt');
		$movies = unserialize($movies);
		include __DIR__ . '/html-output.php';
	}// End of generateHtml

	/**
	 * Get large image from small image
	 */
	public static function getLargeImage($imageUrl)
	{
		$image = str_replace(",98", ",370", $imageUrl);
		$image = str_replace("UY98", "UY370", $image);
		$image = str_replace(",67", ",255", $image);
		$image = str_replace("UX67", "UX255", $image);
		return $image;
	}//End of largeImage

}//End of class
