<?php
/*
Includes useful functions for the site
*/

//call to add new manga directory
function addNewManga($manga_title, $manga_description, $mega_download_link)
{
	$path = "/mangas/" . $manga_title;
	$path = $_SERVER['DOCUMENT_ROOT'].$path;
	if (!file_exists($path)) {
    	mkdir($path, 0755);
    	
	}
	$description = fopen($path . "/description.txt", "w") or die("Unable to open file!");
    $downloadurl = fopen($path . "/downloadurl.txt", "w") or die("Unable to open file!");
	fclose($description);
	fclose($downloadurl);
	//wipe the files first
	$description = fopen($path . "/description.txt", "w") or die("Unable to open file!");
    $downloadurl = fopen($path . "/downloadurl.txt", "w") or die("Unable to open file!");
    
	fwrite($description, $manga_description);
	fclose($description);
	fwrite($downloadurl, $mega_download_link);
	fclose($downloadurl);
	updateMangaPage($manga_title);

	if(file_exists($path."/thumbnail.png"))
	{
		unlink($path."/thumbnail.png");
	}
	$extension=array("png");
	$file_name=$_FILES["manga_image"]["name"];
    $file_tmp=$_FILES["manga_image"]["tmp_name"];
    $ext=pathinfo($file_name,PATHINFO_EXTENSION);
    if(in_array($ext,$extension)){
    	move_uploaded_file($file_tmp=$_FILES["manga_image"]["tmp_name"],$path."/thumbnail.png"); //move the images into the correct directory
        echo "Successfully uploaded and moved file.<br>";
    }
    else
    {
    	echo "Wrong file type. Has to be .png sry.<br>";
    }
}

function addNewChapter($chapter_ID, $manga_title, $chapter_title)
{
	$path = "/mangas/" . $manga_title . "/" . $chapter_ID;
	$path = $_SERVER['DOCUMENT_ROOT'].$path;
	if (!file_exists($path)) {
		mkdir($path, 0755);
		$index = fopen($path . "/index.php", "w") or die("Unable to open file!");
		$pathc = "/newestChapter.txt";
		$pathc = $_SERVER['DOCUMENT_ROOT'].$pathc;
		$newestChapFile = fopen($pathc, "w") or die("Unable to open file!");
		fclose($newestChapFile);
		$newestChapFile = fopen($pathc, "w") or die("Unable to open file!");
		fwrite($newestChapFile,$manga_title."~!@#".$chapter_ID."~!@#".date("M d, Y"));
		fclose($newestChapFile);
	}
	$titlefile = fopen($path . "/title.txt", "w") or die("Unable to open file!");
	fclose($titlefile);
	$titlefile = fopen($path . "/title.txt", "w") or die("Unable to open file!");
	fwrite($titlefile,$chapter_title);
	fclose($titlefile);

	replacePicturesForChapter($path);
	updateChapterPage($chapter_ID,$manga_title);
	updateMangaPage($manga_title);
}
function replacePicturesForChapter($path)
{
	$path = $path."/images";
	if (!file_exists($path)) { //creates images folder within the chapter folder if doesn't exist
		mkdir($path, 0755);
	}
	array_map('unlink', glob($path."/*")); //wipe the images folder to replace all images inside

    $extension=array("jpeg","jpg","png","gif","PNG","jpg-large");
    // Check $_FILES['upfile']['error'] value.
    
    foreach($_FILES["chapter_images"]["tmp_name"] as $key=>$tmp_name){ //for each images uploaded
    	echo 'file #'.$key;
    	echo " scanning file: ".$_FILES["chapter_images"]["name"][$key]."...<br>";
        $file_name=$_FILES["chapter_images"]["name"][$key];
        $file_tmp=$_FILES["chapter_images"]["tmp_name"][$key];
        $ext=pathinfo($file_name,PATHINFO_EXTENSION);
        if(in_array($ext,$extension)){ //if the file is of extention of .jpeg, .jpg, or .png
            if(!file_exists($path."/".$file_name)){
                move_uploaded_file($file_tmp=$_FILES["chapter_images"]["tmp_name"][$key],$path."/".$file_name); //move the images into the correct directory
                echo "Successfully uploaded and moved file.<br>";
            }
            else
            {
            	echo "file already exists";
            }
        }
        else{
        	echo "Wrong file type.<br>";
        }
    }

}

function getMangas()
{
	$path = "/mangas";
	$path = $_SERVER['DOCUMENT_ROOT'].$path;
	$mangas = scandir ( $path);
	$mangas_new = array();
	foreach($mangas as $manga)
	{
		if (!in_array($manga,array(".","..","index.php"))) 
		{
			array_push($mangas_new,$manga);
		}
	}
	return $mangas_new;
}
function getMangaImageUrl($manga_title)
{
	$path = "/mangas/".$manga_title."/thumbnail.png";
	//$path = $_SERVER['DOCUMENT_ROOT'].$path;
	return $path;
}
function getMangaUrl($manga_title)
{
	$path = "/mangas/".$manga_title;
	//$path = $_SERVER['DOCUMENT_ROOT'].$path;
	return $path;
}
function getMangaDescription($manga_title)
{
	$path = "/mangas/".$manga_title."/description.txt";
	$path = $_SERVER['DOCUMENT_ROOT'].$path;
	$description = file_get_contents($path);
	return $description;
}
function getMangaDownloadUrl($manga_title)
{
	$path = "/mangas/".$manga_title."/downloadurl.txt";
	$path = $_SERVER['DOCUMENT_ROOT'].$path;
	$downloadurl = file_get_contents($path);
	return $downloadurl;
}
function getChapters($manga_title)
{
	$path = "/mangas/".$manga_title;
	$path = $_SERVER['DOCUMENT_ROOT'].$path;
	$chapters = scandir ($path);
	$chapters_new = array();
	foreach($chapters as $chapter)
	{
		if (!in_array($chapter,array(".","..","description.txt","downloadurl.txt","index.html","thumbnail.jpg","thumbnail.png","index.php"))) 
		{
			array_push($chapters_new,$chapter);
		}
	}
	natsort($chapters_new);
	return array_reverse($chapters_new); //reverse to make new chapters go on top
}
function getChapterUrl($manga_title, $chapter_ID)
{
	$path = "/mangas/".$manga_title."/".$chapter_ID;
	return $path;
}
function getChapterImageUrls($manga_title, $chapter_ID)
{
	$path = "/mangas/".$manga_title."/".$chapter_ID."/images";
	$path = $_SERVER['DOCUMENT_ROOT'].$path;
	$images = scandir ($path);
	$image_urls = array();
	foreach($images as $image)
	{
		if (!in_array($image,array(".","..")))
		{
			array_push($image_urls,"/mangas/".$manga_title."/".$chapter_ID."/images/".$image);
		}
	}
	return $image_urls;
}
function chapterListString($manga_title)
{
	$chapterLi="";
	$chaps = getChapters($manga_title);
	foreach($chaps as $chap)
	{
		$chapterLi = $chapterLi. "<a href='".$chap."'><li>".getChapterTitle($manga_title,$chap)."</li></a>";
	}
	return $chapterLi;
}
function getChapterTitle($manga_title, $chapter_ID)
{
	$path = "/mangas/".$manga_title."/".$chapter_ID."/title.txt";
	$path = $_SERVER['DOCUMENT_ROOT'].$path;
	$title = file_get_contents($path);
	echo "<script>console.log('".$title."');</script>";
	return $title;
}
function updateMangaPage($manga_title)
{
	$path = "/mangas/" . $manga_title;
	$path = $_SERVER['DOCUMENT_ROOT'].$path;
	$index = fopen($path . "/index.php", "w") or die("Unable to open file!");
	fclose($index); //clear the page once and rewrite every update
	$index = fopen($path . "/index.php", "w") or die("Unable to open file!");
    	//$myfile = fopen("newfile.txt", "w") or die("Unable to open file!");

		$page = "
		
		<script>
		var helloworld;
		var description=\"".addslashes(getMangaDescription($manga_title))."\";
		var title=\"".addslashes($manga_title)."\";
		var chapString=\"".chapterListString($manga_title)."\";
		var downloadUrl=\"".addslashes(getMangaDownloadUrl($manga_title))."\";
		var imageUrl=\"".addslashes(getMangaImageUrl($manga_title))."\";
		</script>
		<?php
			\$path = \"/mangaPageTemplate.html\";
			\$path = \$_SERVER['DOCUMENT_ROOT'].\$path;
			echo file_get_contents(\$path);
		?>
		";
		fwrite($index, $page);
		fclose($index);
}

function updateChapterPage($chapter_ID,$manga_title)
{
	$path = "/mangas/" . $manga_title . "/" . $chapter_ID;
	$path = $_SERVER['DOCUMENT_ROOT'].$path;
	$index = fopen($path . "/index.php", "w") or die("Unable to open file!");
	fclose($index); //clear the page once and rewrite every update
	$index = fopen($path . "/index.php", "w") or die("Unable to open file!");
	$chapterImageUrls = getChapterImageUrls($manga_title, $chapter_ID);
	$imageUrlString="[";
	foreach($chapterImageUrls as $url)
	{
		$imageUrlString=$imageUrlString."\"".$url."\",";
	}
	$imageUrlString=$imageUrlString."]";
	$page = "
		<script>

		var imageUrls = ".$imageUrlString.";
		var title = \"".getChapterTitle($manga_title, $chapter_ID)."\";
		</script>
		<?php
			\$path = \"/chapterPageTemplate.html\";
			\$path = \$_SERVER['DOCUMENT_ROOT'].\$path;
			echo file_get_contents(\$path);
		?>
	";
	fwrite($index, $page);
	fclose($index);
}

function getNewestChapter()
{
	$path = "/newestChapter.txt";
	$path = $_SERVER['DOCUMENT_ROOT'].$path;
	$data = file_get_contents($path);
	$manga = preg_split("/~!@#/",$data)[0];
	$chapterID = preg_split("/~!@#/",$data)[1];
	$date = preg_split("/~!@#/",$data)[2];
	$newData = array(
		"manga" => $manga,
		"chapterID" => $chapterID,
		"date" => $date
	);
	return $newData;
}

?>