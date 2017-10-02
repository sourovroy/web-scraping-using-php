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
		// print_r(htmlentities($request_return));
		$parsedData = self::parseHTMLString($request_return);
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

	}// End of parseHTMLString

	/**
	 * Parse the movie title
	 */
	public static function getMoviesTitle($htmlString)
	{
		$patern = "";
		preg_match_all($patern, $htmlString, $matches);
		print_r($matches[1]);
	}// End of getMoviesTitle

}//End of class
