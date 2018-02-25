<?php
ini_set('display_errors',1); 
error_reporting(E_ALL);

include($_SERVER['DOCUMENT_ROOT']."/functions.php");
if (isset($_POST['delete_manga_title'])) {
	$path = "/mangas/".$_POST['delete_manga_title'];
	$path = $_SERVER['DOCUMENT_ROOT'].$path;
	deleteDirectory($path);
	echo "successfully deleted the manga: ".$_POST['delete_manga_title'];
}
if (isset($_POST['delete2_manga_title']) && isset($_POST['delete2_chapter_ID'])) {
	$chaptitle = getChapterTitle($_POST['delete2_manga_title'],$_POST['delete2_chapter_ID']);
		$path = "/mangas/".$_POST['delete2_manga_title']."/".$_POST['delete2_chapter_ID'];
	$path = $_SERVER['DOCUMENT_ROOT'].$path;
	deleteDirectory($path);
	echo "successfully deleted the chapter: \"".$chaptitle."\" from the manga: \"".$_POST['delete2_manga_title']."\"";
}


function deleteDirectory($dir) {
    if (!file_exists($dir)) {
        return true;
    }

    if (!is_dir($dir)) {
        return unlink($dir);
    }

    foreach (scandir($dir) as $item) {
        if ($item == '.' || $item == '..') {
            continue;
        }

        if (!deleteDirectory($dir . DIRECTORY_SEPARATOR . $item)) {
            return false;
        }

    }

    return rmdir($dir);
}
?>