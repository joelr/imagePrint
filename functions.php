<?php


function GetImageFromUrl($link) 
{ 
$ch = curl_init(); 
curl_setopt($ch, CURLOPT_POST, 0); 
curl_setopt($ch,CURLOPT_URL,$link); 
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
$result=curl_exec($ch); 
curl_close($ch); 
return $result; 
}




function imagebmp(&$im, $filename = "")
{
if (!$im) return false;
$w = imagesx($im);
$h = imagesy($im);
$result = '';

if (!imageistruecolor($im)) {
$tmp = imagecreatetruecolor($w, $h);
imagecopy($tmp, $im, 0, 0, 0, 0, $w, $h);
imagedestroy($im);
$im = & $tmp;
}

$biBPLine = $w * 3;
$biStride = ($biBPLine + 3) & ~3;
$biSizeImage = $biStride * $h;
$bfOffBits = 54;
$bfSize = $bfOffBits + $biSizeImage;

$result .= substr('BM', 0, 2);
$result .= pack ('VvvV', $bfSize, 0, 0, $bfOffBits);
$result .= pack ('VVVvvVVVVVV', 40, $w, $h, 1, 24, 0, $biSizeImage, 0, 0, 0, 0);

$numpad = $biStride - $biBPLine;
for ($y = $h - 1; $y >= 0; --$y) {
for ($x = 0; $x < $w; ++$x) {
$col = imagecolorat ($im, $x, $y);
$result .= substr(pack ('V', $col), 0, 3);
}
for ($i = 0; $i < $numpad; ++$i)
$result .= pack ('C', 0);
}

if($filename==""){
echo $result;
}
else
{
$file = fopen($filename, "wb");
fwrite($file, $result);
fclose($file);
}
return true;
}






?>