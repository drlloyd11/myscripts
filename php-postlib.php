<?php


function getTopics($phpSrcx,$topicStart,$topicStop){
	include('config.php');
	include('kittenconfig.php');
	$con = mysql_connect($dbhost, $dbuser,$dbpasswd);
	mysql_select_db($phpSrcx);
	if ($topicStop <0){
		$queryTail = ";";
	}
	else{
		$queryTail = "and topic_id <$topicStop";
	}
	$query = "SELECT * FROM ".$phpSrcx.".phpbb_topics where topic_id >=$topicStart".$queryTail;
	$result = mysql_query($query )
	or die(mysql_error());
	return $result;
}
function getTopicsWithForum($phpSrcx,$topicStart,$topicStop,$forumId){
	include('config.php');
	include('kittenconfig.php');
	$con = mysql_connect($dbhost, $dbuser,$dbpasswd);
	mysql_select_db($phpSrcx);
	if ($topicStop <0){
		$queryTail = ";";
	}
	else{
		$queryTail = "and topic_id <$topicStop";
	}
	$query = "SELECT * FROM ".$phpSrcx.".phpbb_topics where forum_id=".$forumId." and topic_id >=$topicStart".$queryTail;
	$result = mysql_query($query )
	or die(mysql_error());
	return $result;
}
function getUserByName($phpSrcx,$userName){
	include('config.php');
	include('kittenconfig.php');
	$con = mysql_connect($dbhost, $dbuser,$dbpasswd);
	mysql_select_db($phpSrc);
	$query = "SELECT * FROM ".$phpSrcx.".phpbb_users where username like \"".$userName."\"";
	$result = mysql_query($query )
	or die(mysql_error());
	$row = mysql_fetch_array(  $result );
	return $row;
}
function getSinglePostText($phpSrcx,$postId){
	include('config.php');
	include('kittenconfig.php');
	$con = mysql_connect($dbhost, $dbuser,$dbpasswd);
	mysql_select_db($phpSrc);
	$query = "SELECT * FROM ".$phpSrcx.".phpbb_posts_text where post_id =$postId";
	$result = mysql_query($query )
	or die(mysql_error());
	$row = mysql_fetch_array(  $result );
	return $row;
}
function getSinglePost($phpSrcx,$postId){
	include('config.php');
	include('kittenconfig.php');
	$con = mysql_connect($dbhost, $dbuser,$dbpasswd);
	mysql_select_db($phpSrc);
	$query = "SELECT * FROM ".$phpSrcx.".phpbb_posts where post_id =$postId";
	$result = mysql_query($query )
	or die(mysql_error());
	$row = mysql_fetch_array(  $result );
	return $row;
}
function getPosts($phpSrcx,$postId,$postStop){
	include('config.php'); 
	include('kittenconfig.php');
	$con = mysql_connect($dbhost, $dbuser,$dbpasswd);
	mysql_select_db($phpTarget);
	$query = "SELECT * FROM ".$phpSrcx.".phpbb_posts where post_id >=$postId and post_id < $postStop";
	$result = mysql_query($query )
	or die(mysql_error());
	$row = mysql_fetch_array(  $result );
	return $row;
}
function getPostByTopic($phpSrcx,$topicId){
	include('config.php');
	include('kittenconfig.php');
	$con = mysql_connect($dbhost, $dbuser,$dbpasswd);
	mysql_select_db($phpTarget);
	$query = "SELECT * FROM ".$phpSrcx.".phpbb_posts where topic_id =\"".mysql_real_escape_string($topicId)."\" ;";
	$result = mysql_query($query )
	or die(mysql_error());
	//$row = mysql_fetch_array(  $result );
	return $result;
}
function getPostTextByTopic($phpSrcx,$topicId){
	include('config.php');
	include('kittenconfig.php');
	$con = mysql_connect($dbhost, $dbuser,$dbpasswd);
	mysql_select_db($phpTarget);
	$query = "SELECT * FROM ".$phpSrcx.".phpbb_posts_text where topic_id =\"".mysql_real_escape_string($topicId)."\" ;";
	$result = mysql_query($query )
	or die(mysql_error());
	$row = mysql_fetch_array(  $result );
	return $row;
}
function getSinglePostTest($phpSrcx,$postId){
	include('config.php');
	include('kittenconfig.php');
	$con = mysql_connect($dbhost, $dbuser,$dbpasswd);
	mysql_select_db($phpSrc);
	$query = "SELECT * FROM ".$phpSrcx.".phpbb_posts_text where post_id =$postId";
	$result = mysql_query($query )
	or die(mysql_error());
	$row = mysql_fetch_array(  $result );
	return $row;
}
