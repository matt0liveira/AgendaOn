<?php

function redimensionar($file, $max_width, $max_height)
    {
        $orig_width = imagesx($file);
        $orig_height = imagesy($file);
        $width = $orig_width;
        $height = $orig_height;
        if ($height > $max_height) {
            $width = ($max_height / $height) * $width;
            $height = $max_height;
        }
        if ($width > $max_width) {
            $height = ($max_width / $width) * $height;
            $width = $max_width;
        }
        $image_p = imagecreatetruecolor($width, $height);
        $white = imagecolorallocate($image_p,  255, 255, 255);
        imagefilledrectangle($image_p, 0, 0, $width, $height, $white);
        imagecopyresampled($image_p, $file, 0, 0, 0, 0, $width, $height, $orig_width, $orig_height);
        return $image_p;
    }

    function converterImagem($originalImage, $outputImage, $quality, $larguramaxima, $alturamaxima)
    {
        $exploded = explode('.',$originalImage["name"]);
        $ext = $exploded[count($exploded) - 1]; 
        if (preg_match('/jpg|jpeg/i',$ext)){
            $imageTmp=imagecreatefromjpeg($originalImage["tmp_name"]);
        }
        else if (preg_match('/png/i',$ext)){
            $imageTmp=imagecreatefrompng($originalImage["tmp_name"]);
        }
        else if (preg_match('/gif/i',$ext)){
            $imageTmp=imagecreatefromgif($originalImage["tmp_name"]);
        }
        else if (preg_match('/bmp/i',$ext)){
            $imageTmp=imagecreatefrombmp($originalImage["tmp_name"]);
        }
        else{
            return 0;
        }    
        imagejpeg(redimensionar($imageTmp,$larguramaxima,$alturamaxima), $outputImage, $quality);
        imagedestroy($imageTmp);
        return 1;
    }
?>