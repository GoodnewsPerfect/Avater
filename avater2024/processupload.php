<?php
$data = $_POST['image'];


list($type, $data) = explode(';', $data);
list(, $data)      = explode(',', $data);


$data = base64_decode($data);
$imageName = 'dummyippc2020' . time() . '.png';
file_put_contents('NYM_images/' . $imageName, $data);



$filename = createimageinstantly('avater.png', $imageName);

function createimageinstantly($img1, $imageName)
{
	$x = $y = 900;
	header('Content-Type: image/png');
	$targetFolder = 'NYM_images/';
	//$targetPath = $_SERVER['DOCUMENT_ROOT'] . $targetFolder;
	$targetPath = $_SERVER['DOCUMENT_ROOT'] . preg_replace('@/+$@', '', dirname($_SERVER['SCRIPT_NAME'])) . '/' . $targetFolder;

	$img1 = $targetPath . $img1;
	$img3 = $targetPath . $imageName;

	$outputImage = imagecreatetruecolor(900, 900);

	// set background to white
	$white = imagecolorallocate($outputImage, 255, 255, 255);
	imagefill($outputImage, 0, 0, $white);

	//$first = imagecreatefromjpeg($img1);
	$first = imagecreatefrompng($img1);
	$third = imagecreatefrompng($img3);

	//imagecopyresized ( resource $dst_image , resource $src_image , int $dst_x , int $dst_y , int $src_x , int $src_y , int $dst_w , int $dst_h , int $src_w , int $src_h )
	imagecopyresized($outputImage, $third, 240, 400, 13, 0, 510, 510, 310, 310);//1 //126 //first no is horizontal, second no is vertical.
	imagecopyresized($outputImage, $first, 0, 0, 0, 0, $x, $y, $x, $y);

	$newimageName = 'avater' . round(microtime(true)) . '.png';

	$filename = $targetPath . $newimageName;
	imagepng($outputImage, $filename);

	// To compress the image.
	imagejpeg($outputImage, $filename, 60);


	imagedestroy($outputImage);
	//imagedestroy($imageName);

	// To delete the dummyimage (uploaded image)
	unlink($img3);

	return $newimageName;
}


$final_image = "NYM_images/$filename";
header('Content-type:application/json');
echo json_encode(array('img' => $final_image));
exit;
