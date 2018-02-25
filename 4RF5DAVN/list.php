<?php
ini_set('display_errors',1); 
error_reporting(E_ALL);


include($_SERVER['DOCUMENT_ROOT']."/functions.php");
if (isset($_POST['list_manga_title'])) {
	$chapters = getChapters($_POST['list_manga_title']);
	echo "Searched Manga Title: ".$_POST['list_manga_title']."<br><br>";
	foreach($chapters as $chapter_ID)
	{
		echo "Chapter Title: \"".getChapterTitle($_POST['list_manga_title'], $chapter_ID)."\" Chapter ID: ".$chapter_ID."<br>";
	}
}
?>