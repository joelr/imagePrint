<?php



Class Instagram {


	function get_images() {
		$data = file_get_contents('http://instagr.am/api/v1/feed/popular');
		$data = json_decode($data);
		$images = array();
		for ($i =0; $i < 32; $i++) 
		{
			$url = $data->items[$i]->image_versions[2]->url;
			$parts = explode("/",$url);
			$path = $parts[count($parts) - 1];
			if (!file_exists('data/instagram/'.$path)) {
				$sourcecode=GetImageFromUrl($url);
			
				$savefile = fopen('data/instagram/'.$path, 'w');
				fwrite($savefile, $sourcecode);
				fclose($savefile);
			}
			array_push($images, $path);
		}
		shuffle($images);	
		return $images;
	}





}

?>