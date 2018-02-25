<?php
include($_SERVER['DOCUMENT_ROOT']."/functions.php");
?>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="main.css">
	<link rel="shortcut icon" type="image/png" href="###favicon url###">
	<title>
		###Site Title###
	</title>
	<!--Google Analytics -->
	<!--###copy and paste google analytics JavaScript tracking snippet found here: https://developers.google.com/analytics/devguides/collection/analyticsjs/###-->
	<!--End Google Analytics-->
</head>
<body>
	<div class='index-header'>
		<a href='###Home Page Url###' style='text-decoration: none; color: black;'>
			<img src='###Home Page Image Url###'></img>
		</a>
		<a href='###Home Page Url###' style='text-decoration: none; color: black;'>
			<span>###Site Title###</span>
		</a>
	</div>
	<div class="newest-chapter">

		<?php

		$data = getNewestChapter();
		$manga = $data["manga"];
		$chapterID = $data["chapterID"];
		$chapter = getChapterTitle($manga, $chapterID);
		$url = getChapterUrl($manga,$chapterID);
		$date = $data["date"];
		echo "<div>Latest Chapter: ".$date."</div>";
		echo "<a href=\"".$url."\" target=\"_blank\"><span>".$manga." ".$chapter."</span></a>";

		?>
	</div>
	<div class='index-mangas'>
		<?php


		
		$mangas = getMangas();
		foreach($mangas as $manga)
		{
			echo "<div class='index-manga-container'><a href=\"".getMangaUrl($manga)."\"><div class='index-manga'><div class='index-img-container'><img src=\"".getMangaImageUrl($manga)."\"></img></div><div class='index-manga-title'>".$manga."</div></div></a></div>";
		}
		?>
	</div>
	<div class='comments'>
		<div id='disqus_thread'></div>
	</div>
	<div class='footer'>
		Contact us via email at ###contact info###.
	</div>
<!--###Copy and paste code generated from Disqus. Should look like below###-->
	<!--
	<script>

			/**
			*  RECOMMENDED CONFIGURATION VARIABLES: EDIT AND UNCOMMENT THE SECTION BELOW TO INSERT DYNAMIC VALUES FROM YOUR PLATFORM OR CMS.
			*  LEARN WHY DEFINING THESE VARIABLES IS IMPORTANT: https://disqus.com/admin/universalcode/#configuration-variables*/
			/*
			var disqus_config = function () {
			this.page.url = $path;  // Replace PAGE_URL with your page's canonical URL variable
			this.page.identifier = $path; // Replace PAGE_IDENTIFIER with your page's unique identifier variable
			};
			*/
			(function() { // DON'T EDIT BELOW THIS LINE
				var d = document, s = d.createElement('script');
				s.src = 'https://example.com/embed.js';
				s.setAttribute('data-timestamp', +new Date());
				(d.head || d.body).appendChild(s);
			})();
			</script>
			<noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
		-->
		</body>
		</html>