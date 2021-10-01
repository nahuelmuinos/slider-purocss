<?php
	for ($i=1; $i < 4; $i++) { 
		if (file_exists('slider/'.$i.'.webp')) {
			unlink('slider/'.$i.'.webp');
		}
	}
	function redimensionarImagen($imagen, $alto_final, $num){
		list($ancho_orig, $alto_orig, $nroTipo) = getimagesize($imagen);
		$exit = 0;
		switch ($nroTipo) {
			case 1: $img_original=imagecreatefromgif($imagen);break;
			case 2: $img_original=imagecreatefromjpeg($imagen);break;
			case 3: $img_original=imagecreatefrompng($imagen);break;
			case 6: $img_original=imagecreatefrombmp($imagen);break;
			case 15: $img_original=imagecreatefromwebp($imagen);break;
			case 16: $img_original=imagecreatefromxbm($imagen);break;
			default: echo 'Tipo de archivo incorrecto<br>'; $exit = 1; break;	
		}
		if ($exit == 0) {
			$aspecto = $ancho_orig / $alto_orig;
			$ancho_final = $alto_final*$aspecto;
			$nueva_img = imageCreateTrueColor($ancho_final, $alto_final);
			imagecopyresampled($nueva_img, $img_original, 0, 0, 0, 0, $ancho_final,
			$alto_final, $ancho_orig, $alto_orig);
			imagedestroy($img_original);
			$nombre_imagen = $num.'.webp';
			imagewebp($nueva_img, 'slider/'.$nombre_imagen , 70);
			return $nombre_imagen;
		}
	}
	move_uploaded_file($_FILES['archivo1']['tmp_name'], 'slider/'.$_FILES['archivo1']['name']);
	$nombre_imagen=redimensionarImagen('slider/'.$_FILES['archivo1']['name'], 580, 1);
	unlink('slider/'.$_FILES['archivo1']['name']);
	move_uploaded_file($_FILES['archivo2']['tmp_name'], 'slider/'.$_FILES['archivo2']['name']);
	$nombre_imagen=redimensionarImagen('slider/'.$_FILES['archivo2']['name'], 580, 2);
	unlink('slider/'.$_FILES['archivo2']['name']);
	move_uploaded_file($_FILES['archivo3']['tmp_name'], 'slider/'.$_FILES['archivo3']['name']);
	$nombre_imagen=redimensionarImagen('slider/'.$_FILES['archivo3']['name'], 580, 3);
	unlink('slider/'.$_FILES['archivo3']['name']);
	if (file_exists('slider/1.webp') && file_exists('slider/2.webp') && file_exists('slider/3.webp')) {
		header("Location: slider/");
    	die();
	}
	else {
		echo 'Los archivos no se subieron.';
	}
?>
