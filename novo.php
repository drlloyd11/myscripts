<?php
include_once('simple_html_dom.php');
include('config.php');
include('kittenconfig.php');
$dbms = 'mysqli';
$dbhost = 'localhost';
$dbport = '3306';
$dbname = 'mydb';
$dbuser = 'root';
$dbpasswd = 'root';
$table_prefix = 'phpbb_';
$tableIs = 'netherData'; 
echo $argv[1]."-\n";
$con = mysql_connect($dbhost, $dbuser,$dbpasswd);
mysql_select_db("phptrans");
if ($argc <3){
	exit();
}
$dirName = $argv[1];   
echo $dirName;
try{ 
	//$conHandle= dbAccess();
}
catch (Exception $x){
	echo $ex."\n	";
}


$fullUserName = null;
$fullDate=null;
$fullPost =  null;
$fullForum = null;
$fullTopic = null;
$fullUrl = null;
$fullFileName = null;
$processed =0;
//if ($handle = opendir($dirName)) {
//	while (false !== ($entry = readdir($handle))) {
date_default_timezone_set("America/New_York");
foreach(glob($dirName."*.html") as $entry){
	//echo ">>".$entry."\n";
	$fullFileName =  $entry;
	if ($entry != "." && $entry != ".." && is_file($fullFileName)) {

		//echo "filename ".$fullFileName."\n";
		// get DOM from URL or file
		$html = file_get_html($fullFileName);
		echo "fn:".$fullFileName."\n";
		try{
		$table = $html->find('table');
		if($table == null){
			echo "bad file".$fullFileName."\n";
			continue ;
		}
		
	/*	$subject = $html->find('tr');
		
		$length = count($subject);
		$title = $subject[0]->find('b');
		$topic = $title[0]->plaintext;*/
	
	// $html->find('text');

	//print_r($table);
// echo "\n==========---\n";
	//($table);
	$rows = $table[0]->find('tr');
	//echo "rows ".sizeof($rows);
	//print_r($rows);
	//get subject from first tow
	$columnsTmp = $rows[0]->find('td');
	//echo $columns[1];
	$postSubjectHTML = $columnsTmp[1]->find('b');//;->plaintext;
	$postSubject =  $postSubjectHTML[0]->plaintext."\n";		
	//echo "\n topic: ".$postSubject."\n";
	$topic = $postSubject;
	if (strpbrk($fullFileName,"-")==FALSE){	 
		//print "odd\n";
		$startVal = 1;
		$strIdx =1;
		$strBoundry=0;
	} 
	else{
		//print "even\n";
		$startVal = 1;
		$strIdx =1;
		$strBoundry=0;
	} 
	$length = sizeof($rows);	
	for ($i = $startVal; $i < $length -$strBoundry	; $i+=$strIdx) {
		$columns = $rows[$i]->find('td');
		$leftColumn = $columns[0];
		$rightColumn= $columns[1];
		$leftColumnP = $leftColumn->find('b');
		
		//print_r($leftColumn);
		//echo "--".sizeof($columns)."\n";
		$userName = $leftColumnP[0];
		//echo "\n--".
		//list($un,$two) = sscanf($userName,"<a name=%d>%s");
		$un = $userName->find('a[name]');
		//print "a find:".$un[0]."\n";
		list($one,$two) = sscanf($un[0],"<a name=%d>%s");
		$count = $one;
		$userName= $userName->plaintext;
	//	echo "\n user".$userName."..".$count."\n";
		$fonts = $rightColumn->find('font font');
		$postDateP =  $fonts[0]->plaintext;
		list($dates,$month,$day,$year,$hour) = sscanf($postDateP,"%s %s %d,%d %s %d:%d");
	   // echo "---".sizeof($fonts)."\n";
		$postTime= strtotime("$day $month $year $hour" );
		//echo $postTime."--\n";
		$numFonts = sizeof($fonts);
		//echo "sz".$numFonts."\n";
		$totalText = $fonts[1];
		for ($j = 2; $j < $numFonts -1	; $j+=1) {
			$totalText = $totalText. $fonts[$j];
			
		}
		//echo "\nxxx",$totalText."-----\n";
	$body = $totalText;
	
	
	

  	
/*
 * 
 * +-------------+-------------+------+-----+---------+----------------+ 
| Field       | Type        | Null | Key | Default | Extra          |
+-------------+-------------+------+-----+---------+----------------+
| phpid       | int(11)     | NO   | PRI | NULL    | auto_increment |
| username    | varchar(45) | YES  |     | NULL    |                |
| topic_title | varchar(45) | YES  |     | NULL    |                |
| postdate    | int(11)     | YES  |     | NULL    |                |
| post_index  | varchar(45) | NO   | PRI | NULL    |                |
| post_text   | mediumtext  | YES  |     | NULL    |                |
| notes       | varchar(45) | YES  |     | NULL    |                |
+-------------+-------------+------+-----+---------+----------------+
7 rows in set (0.00 sec)

 
 */
	 if (($processed %255)==0){
		echo $processed."\n";
	}
	$processed= $processed + 1;
  		$queryString ="INSERT INTO phptrans.posts ( username, topic_title, postdate, post_index,post_text,notes)"; 
  				$queryString =$queryString."VALUES (\"%s\",\"%s\",%s,\"%s\", \"%s\",\"%s\"  )";
  		
  		$query = sprintf($queryString,
  				mysql_real_escape_string( $userName),mysql_real_escape_string($topic), $postTime,$count, mysql_real_escape_string ($body),$argv[2]);
  		//,mysql_real_escape_string($fullFileName), mysql_real_escape_string ($body),mysql_real_escape_string ($body),"Novogate",1,"2",);
  	//	$query ="INSERT INTO posts (index, topic_title, user_name, postdate,origin,file_name,post_text) " ;
  		
  	//	$query = $query."VALUES (".$count.", mysql_real_escape_string($title),$userName, $postTime,Novogate,mysql_real_escape_string($fullFileName), mysql_real_escape_string ($body))";
  		print $query."..\n\n";
  		$result = mysql_query($query )
  				or die(mysql_error());
	}
  		//print $hr->outerhtml."\n";
  		//print "\n post time $postTime\n";
}
catch (Exception $ex){
	echo $ex;
	echo $fullFileName."...\n";
}
	}
}
echo "exit\n";
exit();
	//	foreach($subject as $name){
		//	echo $name."-------------\n";
		//}
		
// get subject
//
//<A name=2>
/*
$subject = $html->find('title');
echo $subject[0]."-------------\n";
		
		$first = 1;
		foreach( $html->find('A[name^=name') as $entry){ //every other one
			if ($first == 1){
				$first = 0;
				continue;	
			}   
			echo $entry."\n";
		
			}
			*/
	

	

