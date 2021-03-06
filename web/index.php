<?php
    $master_config = parse_ini_file("../etc/master.ini");
?>

<!DOCTYPE html>

<html>
	
	<head>
		<title>Awesome at the Harvard Library</title>

		<meta charset="utf-8" />
		<meta name="description" content="Awesome at the Harvard Library" />

		<link rel="stylesheet" media="all" href="css/bootstrap.css" />
		<link rel="stylesheet" media="all" href="css/awesome.css" />
		<link href="images/favicon.ico" rel="shortcut icon">

		<script src="js/modernizr.custom.37797.js"></script> 
		<!-- Grab Google CDN's jQuery. fall back to local if necessary --> 
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script> 
		<script>!window.jQuery && document.write('<script src="/js/jquery-1.7.1.min.js"><\/script>')</script>
		<script src="js/jcarousellite.min.js"></script>
		<script src="js/jquery.dotdotdot-1.4.0-packed.js"></script>
		<script src="js/handlebars.js"></script>
        <script src="js/awesome.js"></script>
		<script src="http://use.typekit.com/vpi8egr.js"></script>
        <script >try{Typekit.load();}catch(e){}</script>
	</head>

	<body>

		<div id="wrapper">
			
			<header id="branding">
			  <span id="feeds">
			    <a href="feed.php" target="_blank">
            <img src="images/rss.png" class="rssIcon" alt="Awesome RSS" />
          </a> 
          <a href="http://twitter.com/#!/<?php echo $master_config["TWITTER_USERNAME"]; ?>" target="_blank">
            <img src="images/twitter.png" class="twitterIcon" alt="Follow <?php echo $master_config["TWITTER_USERNAME"]; ?> on Twitter" />
          </a>
        </span>
				<h1>Awesome at the Harvard Library</h1>
			</header>
			
			<nav id="primary">
				<ul>
					<li>
						<h1>Recently Awesome</h1>
						<a class="recently-awesome" href="#recently-awesome">View</a>
					</li>
					<li>
						<h1>Most Awesome</h1>
						<a class="most-awesome" href="#most-awesome">View</a>
					</li>
					<li>
						<h1>Search Awesome</h1>
						<a class="search" href="#search">View</a>
					</li>
					<li>
						<h1>About Awesome</h1>
						<a class="about" href="#about">View</a>
					</li>
				</ul>
			</nav>
			
			<div id="content">
				<article id="recently-awesome">
					<header>
						<h1>Recently Awesome</h1>
					</header>
          
          <div id="recent"></div>
					
					<nav class="next-prev">
					  <a class="newer" data-start="0" alt="Prev">Prev</a>
						<a class="older" data-start="9" alt="Next">Next</a>
						<!--<a class="next most-awesome" href="#most-awesome">Next</a>-->
					</nav>
					
					<nav class="filtering">
					  <span class="filter" data-filter="book"><i class="icon-book"></i></span>
					  <span class="filter" data-filter="videofilm"><i class="icon-videofilm"></i></span>
					  <span class="filter" data-filter="soundrecording"><i class="icon-soundrecording"></i></span>
					</nav>

				</article>
				
				<article id="most-awesome">
					<header>
						<h1>Most Awesome</h1>
					</header>
					
					<div id="most"></div>
					
					<nav class="next-prev">
						<!--<a class="prev recently-awesome" href="#recently-awesome">Prev</a>
						<a class="next search" href="#search">Next</a>-->
					</nav>
				</article>
				
				<article id="search">
					<header>
						<h1>Search Awesome</h1>
					</header>
					<p>Find something awesome at the Harvard Library.</p>
					<form id="search-awesome" class="form-inline">
            <input type="text" id="query" />
            <input class="btn btn-large" type="submit" value="GO" id="submit" />
          </form>
          <div id="search-results"></div>
					<nav class="next-prev">
						<!--<a class="prev most-awesome" href="#most-awesome">Prev</a>
						<a class="next about" href="#about">Next</a>-->
					</nav>
				</article>
				
				<article id="about">
					<header>
						<h1>About Awesome</h1>
					</header>
					<p>Returning something awesome to the Harvard Library?</p>
					<br />
					<p class="bold">Put it in the Awesome Box.</p>
					<br />
					<p>Funded by the <a href="http://osc.hul.harvard.edu/liblab">Library Lab</a>, the Awesome Box allows the community to see what others have found helpful, entertaining, or mind-blowing.</p>
					<br />
					<p class="small">Contact us at <a href="mailto:lil@law.harvard.edu">lil@law.harvard.edu</a>
					</p>
					<p class="small">Movie images provided by <a href="http://www.flixster.com/">Flixster</a></p>
					<nav class="next-prev">
						<!--<a class="prev search" href="#search">Prev</a>-->
					</nav>
				</article>
			</div>
			
			<!-- Parallax foreground -->
			<div id="parallax-bg3">
				<img id="bg3-1" src="images/awesome.png" width="529" height="757" alt="awesome"/>
				<img id="bg3-2" src="images/awesome2.png" width="377" height="789" alt="awesome"/>
				<img id="bg3-3" src="images/awesome3.png" width="600" height="745" alt="awesome"/>
				<img id="bg3-4" src="images/ground.png" width="1100" height="753" alt="awesome"/>
			</div>
			
			<!-- Parallax midground clouds -->
			<div id="parallax-bg2">
				<img id="bg2-1" src="images/blue-exclamation.png" alt="cloud"/>
				<img id="bg2-2" src="images/blue-exclamation.png" alt="cloud"/>
				<img id="bg2-3" src="images/blue-exclamation.png" alt="cloud"/>
				<img id="bg2-4" src="images/blue-exclamation.png" alt="cloud"/>
				<img id="bg2-5" src="images/blue-exclamation.png" alt="cloud"/>
			</div>
			
			<!-- Parallax background clouds -->
			<div id="parallax-bg1">
				<img id="bg1-1" src="images/green-exclamation.png" alt="cloud"/>
				<img id="bg1-2" src="images/green-exclamation.png" alt="cloud"/>
				<img id="bg1-3" src="images/green-exclamation.png" alt="cloud"/>
				<img id="bg1-4" src="images/green-exclamation.png" alt="cloud"/>
			</div>
		
		</div>
		<!--http://images.amazon.com/images/P/{{isbn}}.01.ZTZZZZZZ.jpg-->
		<!--http://covers.openlibrary.org/b/isbn/{{isbn}}-M.jpg-->
		<!--http://images.booksense.com/images/books/812/478/FC9780525478812.JPG-->
		<!--http://www.syndetics.com/index.aspx?isbn={{isbn}}/SC.gif-->
		<script id="search-template" type="text/x-handlebars-template">
		  <p class="num-found">{{num_found}} results</p>
		  <span class="left-right">
						<a class="left">Prev</a>
						<a class="right">Next</a>
				</span>
		  {{>items}}
		</script>
		<script id="items-template" type="text/x-handlebars-template">
      <ul> 
        {{#docs}}
          <li class="item">
            <a href="<?php echo $master_config["CATALOG_URL"];?>{{hollis_id}}" target="_blank" style="display:none;">{{title}}</a>
            {{#if poster}}
            <img class="item-cover" src="{{poster}}" alt="{{title}}" />
            {{else}}
            <img class="item-cover" src="http://covers.openlibrary.org/b/isbn/{{isbn}}-M.jpg" alt="{{title}}" />
            {{/if}}
            <div class="item-details">
              <span class="item-title">
                {{title}}
              </span>
              <span class="item-author">{{creator}}</span>
              <i class="icon-{{format}} item-format"></i>
            </div>
          </li>
        {{/docs}}
      </ul>
  </script>
  
    <script type="text/javascript">

        var _gaq  = _gaq || [];
        _gaq.push(['_setAccount', '<?php echo $master_config["GOOGLE_ANALYTICS"];?>']);
        _gaq.push(['_trackPageview']);

        (function() {
          var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
          ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
          var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
        })();

    </script>
	
	</body>
  
</html>