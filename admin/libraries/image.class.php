<?php
class Image
{

	function create_image( $dir, $file, $new_file, $width, $height, $proportional=true, $use_linux_command=false )
	{		
		if ( $height <= 0 && $width <= 0 ) {
			return false;
		}
		
		$info = getimagesize($dir.$file);
		$image = '';
		
		$final_width = 0;
		$final_height = 0;
		list($width_old, $height_old) = $info;
		
		if ($proportional) {
				
			$proportion = $width_old / $height_old;
		  
			if ( $width > $height && $height != 0) {
				$final_height = $height;
				$final_width = $final_height * $proportion;
			}
			elseif ( $width < $height && $width != 0) {
				$final_width = $width;
				$final_height = $final_width / $proportion;
			}
			elseif ( $width == 0 ) {
				$final_height = $height;
				$final_width = $final_height * $proportion;          
			}
			elseif ( $height == 0) {
				$final_width = $width;
				$final_height = $final_width / $proportion;          
			}
			else {
				$final_width = $width;
				$final_height = $height;
			}
		}
		else {
			$final_width = ( $width <= 0 ) ? $width_old : $width;
			$final_height = ( $height <= 0 ) ? $height_old : $height;
		}
	
		switch ( $info['mime'] ) {
			case "image/jpeg":
				$image = imagecreatefromjpeg($dir.$file);	
			break;
			case "image/gif":
				$image = imagecreatefromgif($dir.$file);
			break;
			case "image/png":
				$image = imagecreatefrompng($dir.$file);
			break;	
			default:
				return false;
		}
		
		$image_resized = imagecreatetruecolor( $final_width, $final_height );
		imagecolortransparent($image_resized, imagecolorallocate($image_resized, 0, 0, 0) );
		imagealphablending($image_resized, false);
		imagesavealpha($image_resized, true);
		
		imagecopyresampled($image_resized, $image, 0, 0, 0, 0, $final_width, $final_height, $width_old, $height_old);
		
	/*	if ( $use_linux_command )
			exec('rm '.$file);
		else
			@unlink($dir.$file);
	*/	
	
		switch ( $info['mime'] ) {
			case "image/gif":
				imagegif($image_resized, $dir.$new_file);
			break;
			case "image/jpeg":
				imagejpeg($image_resized, $dir.$new_file);
			break;
			case "image/png":
				imagepng($image_resized, $dir.$new_file);
			break;
			default:
				return false;
		}
		
		return true;
	}
	

	function open_image($file) 
	{
		# JPEG:
		$img = @imagecreatefromjpeg($file);
		if ($img != 0) { return $img; }
	
		# GIF:
		$img = @imagecreatefromgif($file);
		if ($img != 0) { return $img; }
	
		# PNG:
		$img = @imagecreatefrompng($file);
		if ($img != 0) { return $img; }
	
		# GD File:
		$img = @imagecreatefromgd($file);
		if ($img != 0) { return $img; }
	
		# GD2 File:
		$img = @imagecreatefromgd2($file);
		if ($img != 0) { return $img; }
	
		# WBMP:
		$img = @imagecreatefromwbmp($file);
		if ($img != 0) { return $img; }
	
		# XBM:
		$img = @imagecreatefromxbm($file);
		if ($img != 0) { return $img; }
	
		# XPM:
		$img = @imagecreatefromxpm($file);
		if ($img != 0) { return $img; }
	
		# Try and load from string:
		$img = @imagecreatefromstring(file_get_contents($file));
		if ($img != 0) { return $img; }
	
		return false;
	}

}
?>