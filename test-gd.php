<?php
require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php';
die;
$filePath = $_SERVER['DOCUMENT_ROOT'] . '/test/index.jpg';
if (file_exist($filePath)) {
	
	$fsize = filesize($filePath);
	$fdata = getimagesize($filePath);
	$fimage = '';
	switch($fdata['mime']) {
		case 'image/jpeg':
			$fimage = imagecreatefromjpeg($filePath);
		break;
		case 'image/gif':
			$fimage = imagecreatefromgif($filePath);
		break;
		case 'image/png':
			$fimage = imagecreatefrompng($filePath);
		break;
	}                      

	if($fimage) {
		$fquality = 80;
		if($fsize >= 1000000 && $fsize <= 2000000) $fquality = 50;
		if($fsize > 2000000 && $fsize <= 3000000) $fquality = 40;
		if($fsize > 3000000) $fquality = 30;

		$tdfile = $_SERVER['DOCUMENT_ROOT'] . '/upload/tmp_up/' . 'res_' . $tfile['name'];
		$tdfile = $_SERVER['DOCUMENT_ROOT'] . '/test/index-new.jpg';
		$tdfileList[] = $tdfile;
		if(imagejpeg($fimage, $tdfile, $fquality)) {
			// unlink($tnfile);
			//$cF = CFile::MakeFileArray($tdfile);
			//$tfile = $cF;

		}
	}
}