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


$processed =0;
//if ($handle = opendir($dirName)) {
//	while (false !== ($entry = readdir($handle))) {
date_default_timezone_set("America/New_York");
foreach(glob($dirName."*.htm") as $entry){
	//echo ">>".$entry."\n";
	$fullFileName =  $entry;
	if ($entry != "." && $entry != ".." && is_file($fullFileName)) {
 	if (strstr($fullFileName,"intro")!= false){
 		continue;
 	}
 	if (strstr($fullFileName,"shadow")== false){
 		continue;
 	}
		//echo "filename ".$fullFileName."\n";
		// get DOM from URL or file
		$html = file_get_html($fullFileName);  
		echo "fn:".$fullFileName."\n";
		try{
		$titlePrime = $html->find('center');
		$topic = $titlePrime[0]->plaintext;
		//echo $title."\n";
		$table = $html->find('table');
		if($table == null){
			echo "bad file".$fullFileName."\n";
			continue ;
		}
		
	
	
	$columnsTmp =$table[0]->find('tr');
	$length = sizeof($columnsTmp);	
	$count =0;
	for ($i = 1; $i < $length 	-1; $i+=1) {
		//print_r($rows);
		//get subject from first tow
	
		$columns = $columnsTmp[$i]->find('td');
		//echo $columns[1];
		$nameColumn = $columns[1];
		$bodyColumn= $columns[2];
		$userName = $nameColumn->plaintext;
		$body = $bodyColumn;
		$datePrm = strpos($bodyColumn,"posted");
		$datePrmPrm = strpos($bodyColumn,"(",$datePrm);
		$date = substr($bodyColumn,$datePrm, $datePrmPrm - $datePrm);
		list($buffer,$month,$day,$year,$hour,$tz) = sscanf($date,"%s %d-%d-%d %s %s");
		
		 $postTime= strtotime("$day-$month-$year $hour" );
		 //echo "xxxx".$postTime."--";
		//echo "\n date:". $date."\n";
		//echo "\n name:". $name."<--\n";
		//echo "\nbody ".$bodyColumn."\n";
		//$leftColumnP = $leftColumn->find('b');
		
		
		
		
  	
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
	 if (($processed %255)==1){
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
  		//print $query."..\n\n";
  		$result = mysql_query($query )
  				or die(" ".$count." ".$query);
  			
  		$count = $count+1;
	}
	unset($table);
	unset($columnsTmp);
	
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
	

	

