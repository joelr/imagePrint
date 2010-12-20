<?php
set_time_limit(1000);

include "functions.php";
include "plugins/instagram.php";
$instagram = new Instagram();
$images = $instagram->get_images();




$images_x = 3;
$images_y = 2;

$image_width = 1748;
$image_height = 1181;

$image_p = imagecreatetruecolor($image_width, $image_height);
$im = 0;
for ($x = 0; $x < $images_x; $x++) {
	for ($y = 0; $y < $images_y; $y++) {
		
		$image = imagecreatefromjpeg("data/instagram/".$images[$im]);
		$im_w = round($image_width / $images_x);
		$im_h = round($image_height / $images_y);
		imagecopyresampled($image_p, $image, round($x * $im_w), round($y * $im_h), 0, 0, $im_w, $im_h, 612, 612);
		$im++;
}
}

$file = "data/prints/images/".time().".jpg";

imagejpeg($image_p, $file, 100);
imagebmp($image_p, "print.bmp");



echo "<img src='".$file."' />";

// enter the printer name here.....
//comment out all of this to stop the printing
$handle = printer_open("Canon SELPHY CP730");
printer_start_doc($handle, "My Document");
printer_start_page($handle);

printer_draw_bmp($handle, "print.bmp", 1, 1);

printer_end_page($handle);
printer_end_doc($handle);
printer_close($handle);



?>