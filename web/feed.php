<?php

$master_config = parse_ini_file("../etc/master.ini");


header('Content-type: text/xml'); 
echo "<" . "?" . "xml version=\"1.0\" encoding=\"ISO-8859-1\"" . "?" . ">";


?>
<rss version="2.0"><channel>

<title>Recently Awesome at the Harvard Library</title>
<link>http://librarylab.law.harvard.edu/awesome</link>
<description>Keep up with the latest awesome items at the Harvard Library</description>

<language>en-gb</language>
<lastBuildDate>Mon, 27 Jun 05 13:37:16 GMT</lastBuildDate>
<copyright>The Harvard Library Innovation Lab</copyright>
<docs>http://librarylab.law.harvard.edu</docs>
<ttl>0</ttl>
        
        
<?php

$url = "http://librarylab.law.harvard.edu/awesome/api/item/recently-awesome";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$contents = curl_exec ($ch);
curl_close ($ch);

// Translate all of our data from json to PHP vars
$data = json_decode($contents, true);
$data = $data[docs];
//print_r($data);
		   
foreach($data as $item) {
	echo "<item><title>".$item['title']."</title>";
	echo "<link>".$master_config['CATALOG_URL'].$item['hollis_id']."</link>";
	if($item['poster']) {
	  echo "<description>&lt;img class=\"item-cover\" src=\"".$item['poster']."\" /&gt;&lt;p/&gt;".$item['title']." by ".$item['creator']."&lt;/p/&gt;</description>";
	}
	else {
    echo "<description>&lt;img src=\"http://covers.openlibrary.org/b/isbn/".$item['isbn']."-M.jpg\" /&gt;&lt;p/&gt;".$item['title']." by ".$item['creator']."&lt;/p/&gt;</description>";
  }
    
  echo "<pubDate></pubDate></item>";
}

?>

</channel>
</rss>
