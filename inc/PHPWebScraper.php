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
		$requestReturn = self::sendHTTPRequest();
		// print_r(htmlentities($requestReturn));
		// echo $requestReturn;
		$parsedData = self::parseHTMLString($requestReturn);
	}// End of showList

	/**
	 * Send HTTP request
	 */
	public static function sendHTTPRequest()
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
	public static function parseHTMLString($fullHtml)
	{
		$titleArray = self::getMoviesTitle($fullHtml);

		$yearArray = self::getMoviesYear($fullHtml);

		$imageArray = self::getMoviesImage($fullHtml);

		$runtimeGenreArray = self::getCertificateRuntimeGenre($fullHtml);

		$descriptionArray = self::getDescription($fullHtml);
		
		// print_r($runtimeGenreArray);
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
	public static function getCertificateRuntimeGenre($htmlString)
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
	public static function getDescription($htmlString)
	{
		$pattern = '/<div class="ratings-bar">.*?<\/div>\n<p class="text-muted">(.*?)<\/p>/is';
		preg_match_all($pattern, $htmlString, $matches);
		print_r(array_map('trim', $matches[1]));
	}// End of getDescription

}//End of class
