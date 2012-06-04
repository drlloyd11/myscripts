<?php
include_once('simple_html_dom.php');
include('config.php');
include('kittenconfig.php');
include("php-postlib.php");
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
	echo"exit \n";
	exit();
}
$subGroup = $argv[1];   
echo $subGroup;
  

$fullUserName = null;
$fullDate=null;
$fullPost =  null;
$fullForum = null;
$fullTopic = null;
$fullUrl = null;
$fullFileName = null;
$processed =0;
$forumToGet = $argv[2];
//	while (false !== ($entry = readdir($handle))) {
date_default_timezone_set("America/New_York");
$phpOld = "yuku";
try{
	echo "get topic\n";
	$topicsRawList =getTopicsWithForum($phpOld,0,-1,$forumToGet);
	$topicList = array();
	while($row = mysql_fetch_array(  $topicsRawList )){
		$topicTitle =   $row['topic_title'];
		$topicID =   $row['topic_id'];
		$topicList[$topicID] = $topicTitle;
	}
		foreach($topicList as $curTopicID  =>$curTopicName)  
		{
			$count =0;
			echo $curTopicID."==\n";
			$postsByTopic = getPostByTopic($phpOld ,$curTopicID);
		//	$postsTextByTopic = getPostTextByTopic($phpOld ,$curTopicID);
			while($row = mysql_fetch_array(  $postsByTopic )){
				//
				//
				$postText = getSinglePostText($phpOld,$row['post_id']);
	  		$queryString ="INSERT INTO phptrans.posts ( username, topic_title, postdate, post_index,post_text,notes)"; 
	  				$queryString =$queryString."VALUES (\"%s\",\"%s\",%s,\"%s\", \"%s\",\"%s\"  )";
	  		
	  		$query = sprintf($queryString,
	  				mysql_real_escape_string( $row['post_username']),mysql_real_escape_string($curTopicName), $row['post_time'],$count, mysql_real_escape_string ($postText['post_text']),$subGroup);
	  			//print $query."..\n\n";
	  		$result = mysql_query($query )
	  				or die(mysql_error());
	  		$count =  $count+1;
			}
		}
  		//print $hr->outerhtml."\n";
  		//print "\n post time $postTime\n";
}
catch (Exception $ex){
	echo $ex;
	echo $fullFileName."...\n";
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
	

	

