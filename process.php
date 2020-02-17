<?php

if (is_uploaded_file($_FILES['cropImage']['tmp_name'])) {
	$targetPath = "uploads/" . $_FILES['cropImage']['name'];
	if (move_uploaded_file($_FILES['cropImage']['tmp_name'], $targetPath)) {
		$uploadedImagePath = $targetPath;
	}
}

$image = imagecreatefromjpeg($uploadedImagePath);
$filename = 'images/cropped_whatever.jpg';

$thumb_width = 200;
$thumb_height = 150;

$width = imagesx($image);
$height = imagesy($image);

$original_aspect = $width / $height;
$thumb_aspect = $thumb_width / $thumb_height;

if ( $original_aspect >= $thumb_aspect ) {
	// If image is wider than thumbnail (in aspect ratio sense)
	$new_height = $thumb_height;
	$new_width = $width / ($height / $thumb_height);
} else {
	// If the thumbnail is wider than the image
	$new_width = $thumb_width;
	$new_height = $height / ($width / $thumb_width);
}

$thumb = imagecreatetruecolor( $thumb_width, $thumb_height );

// Resize and crop
imagecopyresampled($thumb, $image, 
	0 - ($new_width - $thumb_width) / 2, // Center the image horizontally
  0 - ($new_height - $thumb_height) / 2, // Center the image vertically
  0, 0,
  $new_width, $new_height,
	$width, $height);
	
imagejpeg($thumb, $filename, 80);
?>

<!doctype html>
<html lang="en">
<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

	<title>Hello, world!</title>
</head>
<body>
	<div class="container">
		<h1>Result(Image cropped)</h1>
		<div class="row">
			<div class="col">
				<h2> Original Image</h2>
				<img src="<?php echo $uploadedImagePath?>" />
			</div>
			<div class="col">
				<h2> Cropped Image</h2>
				<img src="<?php echo $filename?>" />
			</div>
		</div>
	</div>
</body>
</html>