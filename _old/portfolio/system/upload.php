<?
	include "setup.php";

	$my_pass=$_GET['pass'];
	$my_code=$_GET['code'];
	$photo_max_width=$_GET['maxW'];

	if($my_pass==$admin_pass){
		// FILE UPLOAD
		$uploadfile="../_photo/".$my_code.".jpg";
		move_uploaded_file($_FILES['Filedata']['tmp_name'],$uploadfile);
		// RESIZE
		$rsrc_img=imagecreatefromjpeg($uploadfile);
		list($tW,$tH)=getImageSize($uploadfile);
		$rtW=$tW;
		$rtH=$tH;
		if($tW>$photo_max_width||$tH>$photo_max_width){
			if($tW>$tH){
				$scale=$photo_max_width/$tW;
				$rtW=$photo_max_width;
				$rtH=$rtH*$scale;
			}else{
				$scale=$photo_max_width/$tH;
				$rtW=$tW*$scale;
				$rtH=$photo_max_width;
			}
			$rimg=imageCreateTrueColor($rtW,$rtH);
			imagecopyresampled($rimg,$rsrc_img,0,0,0,0,($rtW),($rtH),$tW,$tH);
			imagejpeg($rimg,$uploadfile,90);
		}
		ImageDestroy($rimg);
		ImageDestroy($rsrc_img);
		exec("chmod 666 ".$uploadfile);
		// MAKE THUMBNAIL
		$photo_max_width=64;
		$src_img=imagecreatefromjpeg($uploadfile);
		list($tW,$tH)=getImageSize($uploadfile);
		$rtW=$tW;
		$rtH=$tH;
		if($tW>$tH){
			$scale=$photo_max_width/$tH;
			$rtW=$tW*$scale;
			$rtH=$photo_max_width;
			$cropX=($rtW-64)/2;
			$cropY=0;
		}else{
			$scale=$photo_max_width/$tW;
			$rtW=$photo_max_width;
			$rtH=$rtH*$scale;
			$cropX=0;
			$cropY=($rtH-64)/2;
		}
		$img=imageCreateTrueColor(64,64);
		imagecopyresampled($img,$src_img,-$cropX,-$cropY,0,0,$rtW,$rtH,$tW,$tH);
		$t_name=str_replace(".jpg","_thumb.jpg",$uploadfile);
		imagejpeg($img,$t_name,90);
		ImageDestroy($img);
		ImageDestroy($src_img);
		exec("chmod 666 ".$t_name);
	}else{
		echo("FALSE");
	}
?>