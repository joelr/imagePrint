<?php
set_time_limit(1000);

include "functions.php";
include "plugins/instagram.php";
$instagram = new Instagram();
$images = $instagram->get_images();

$image_p = imagecreatetruecolor(1748, 1181);
$im = 0;
for ($x = 0; $x < 3; $x++) {
	for ($y = 0; $y < 2; $y++) {
		
		$image = imagecreatefromjpeg("data/instagram/".$images[$im]);
		imagecopyresampled($image_p, $image, ($x * 583), ($y * 591), 0, 0, 583, 591, 612, 612);
		$im++;
}
}

$file = "data/prints/images/".time().".jpg";

imagejpeg($image_p, $file, 100);
imagebmp($image_p, "print.bmp");

echo "<img src='".$file."' />";





?>