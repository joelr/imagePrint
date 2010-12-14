<?php
//http://api.flickr.com/services/rest/?method=flickr.interestingness.getList&api_key=f1b43c996c476637ee434d7a013623e6

Class Flickr {
	
	function get_images($max = 10) {
		
		$data = file_get_contents("http://api.flickr.com/services/rest/?method=flickr.interestingness.getList&api_key=f1b43c996c476637ee434d7a013623e6");
		$xmlObj = simplexml_load_string($data);
		$arrXml = objectsIntoArray($xmlObj);
		$data = $arrXml["photos"];
		$images = array();
		$count = 0;
		foreach($data as $photo)
		{
			if (!is_null($photo[1])) {
				foreach($photo as $image) {
				 	$id = $image["@attributes"]["id"];
					$url = $this->get_image($id);
					if ($url) {
						$path = $id.".jpg";
						if (!file_exists('data/instagram/'.$path)) {
							$sourcecode=GetImageFromUrl($url);
							$savefile = fopen('data/instagram/'.$path, 'w');
							fwrite($savefile, $sourcecode);
							fclose($savefile);
						}
						array_push($images, $path);
						$max++;
						if ($count >= $max)
							return $images;
					}
				}
			}
			
		}
		return $images;
	}
	
	function get_image($id) {
		//http://api.flickr.com/services/rest/?method=flickr.photos.getSizes&api_key=f1b43c996c476637ee434d7a013623e6&photo_id=5258160961
		$data = file_get_contents("http://api.flickr.com/services/rest/?method=flickr.photos.getSizes&api_key=f1b43c996c476637ee434d7a013623e6&photo_id=".$id);
		$xmlObj = simplexml_load_string($data);
		$arrXml = objectsIntoArray($xmlObj);
		if (isset($arrXml["sizes"]["size"][4]["@attributes"]["source"]) && !is_null($arrXml["sizes"]["size"][4]["@attributes"]["source"]))	
			return $arrXml["sizes"]["size"][4]["@attributes"]["source"];
		else
			return false;
	}
	
	
}




?>