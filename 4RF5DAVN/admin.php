<?php
ini_set('display_errors',1); 
error_reporting(E_ALL);


include($_SERVER['DOCUMENT_ROOT']."/functions.php");
if (isset($_POST['manga_title'])) {
	addNewManga($_POST["manga_title"],$_POST["manga_description"],$_POST["mega_download_url"]);

	echo "successfully added new manga to directory.<br>";
}
if (isset($_POST['chapter_ID']) && isset($_POST['chapter_manga_title'])) {
	addNewChapter($_POST["chapter_ID"], $_POST["chapter_manga_title"], $_POST["chapter_title"]);
	echo "successfully added new chapter to directory.<br>";
}

if(isset($_POST['update1_manga_title']))
{
	updateMangaPage($_POST['update1_manga_title']);
}
if(isset($_POST['update2_manga_title']))
{
	updateMangaPage($_POST['update2_manga_title']);
	updateChapterPage($_POST['update2_chapter_ID'],$_POST['update2_manga_title']);
}
?>