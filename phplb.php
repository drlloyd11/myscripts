<?php


ini_set('error_reporting', E_ALL);
ini_set('display_errors', 'On');


// The default phpBB inclusion protection - required
define('IN_PHPBB', true);
$phpbb_root_path = '';
$phpEx = substr(strrchr(__FILE__, '.'), 1);


include($phpbb_root_path . 'common.' . $phpEx);
include($phpbb_root_path . 'includes/functions_admin.' . $phpEx);
include($phpbb_root_path . 'includes/functions_posting.' . $phpEx);
include($phpbb_root_path . 'phpBBFunctions.php');




$user->session_begin();
$auth->acl($user->data);
$user->setup();

//echo "---;";

// Backup the details of the logged in user
$backup = array(
  'user'   => $user,
  'auth'   => $auth,
);

// The ID of the parent category / forum
$forumParentID = 15;

// The forum to copy permissions from
$forumPpermFrom = 2;

// The type of forum to create. FORUM_CAT for category and FORUM_POST for regular forum and FORUM_LINK for a link forum (?)
$forumType = FORUM_POST;
  

$forumDesc = "Automatically created by Iains new function Script as if by magic!";

// Check that user (System) has permissions to create forums. Taken from includes/acp/acp_forums.php around line 71
// Error trigger taken out and replaced with simple echo. The error shouldnevr happen but it's just in case..
//if (!$auth->acl_get('a_forumadd'))
//{
  //echo "ERROR! Problem with forum creation permissions for user";
//}

//$newForumID = createCategoryForum($forumParentID,$forumPpermFrom,$forumType,$forumName,$forumDesc);

//echo "Forum created with ID of $newForumID";

$forumtoPost = 7; 
 
$msgSubject = "This is a new thread";
//$msgSubject = "The new Cliche Thread3";
$msgText = "--Here is an automatic post from my new function code";

$newPostID = createPost ($forumtoPost,"Brand new",$msgText,"xita","post",0,891239402);

$newPostID = createPost ($forumtoPost,$msgSubject,$msgText,"drlloyd11","reply",-1,0);

echo "post id is now  $newPostID" . 
// Restore the original backed up logged in user data
extract($backup);


?>