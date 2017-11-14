<?php namespace App\Classes;

class GettyImage {
	
	private $_output;
	
	/**
	 * Create a gettyImage object
	 *
	 * @param string $embedCode The html code copied from Getty Website
	 * @param integer $version The version of the embedded code
	*/
	public function __construct($embedCode, $version = 1)
	{
		if ($embedCode != "") {
			
			// Get image ID
			$imageid = substr($embedCode, strpos($embedCode, "/embed/") + 7);
			$imageid = substr($imageid, 0, strpos($imageid, "?"));
			
			
			// Containing DIV
			$container = substr($embedCode, 0, strpos($embedCode, "><div ") + 1);
			
			
			// Iframe Sector
			$beforeIframe = substr($embedCode, 0, strpos($embedCode, "<iframe"));
			$iframe = substr($embedCode, strpos($embedCode, "<iframe"));
			$iframe = substr($iframe, 0, strpos($iframe, "</iframe>") + 9);
			$iframeContainer = substr($beforeIframe, strrpos($beforeIframe, "<div"));
			$iframeSector = $iframeContainer . $iframe . '</div>';
	
			
			if (config('app.livemedia')){
				if ($version == 0) {		// Original Image
					$this->_output = $embedCode;
				}
				elseif ($version == 1) {	// Text Links at Bottom
					$linkSector = '<div style="padding:0;margin:0 0 0 10px;text-align:left;"><a href="http://www.gettyimages.com/detail/' . $imageid . '" target="_blank" style="color:#a7a7a7;text-decoration:none;font-weight:normal !important;border:none;display:inline-block;">View image</a> | <a href="http://www.gettyimages.com" target="_blank" style="color:#a7a7a7;text-decoration:none;font-weight:normal !important;border:none;display:inline-block;">gettyimages.com</a></div>';
					$this->_output = $container . $iframeSector . '<p style="margin:0;"></p>' . $linkSector . '</div>';
				}
				elseif ($version == 2) {	// Text Link at Top
					$linkSector = '<div style="padding:0;margin:0;text-align:left;"><a href="http://www.gettyimages.com/detail/' . $imageid . '" target="_blank" style="color:#a7a7a7;text-decoration:none;font-weight:normal !important;border:none;display:inline-block;">Embed from Getty Images</a></div>';
					$this->_output = $container . $linkSector . $iframeSector . '<p style="margin:0;"></p></div>';
				}
			}
			else {
				$this->_output = '<div class="getty localGetty"><img src="/storage/getty/' . $imageid . '.jpg" /></div>';
			}
		}
		else {
			$this->_output = '';
		}
	}
	
	/**
	 * Output the image
	 * 
	*/
	public function outputImage()
	{
		return $this->_output;
	}
	
}

?>