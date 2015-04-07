<?php

include "database.class.php";
function query($sql){
	$result = Database::getInstance()->query($sql);
	return $result;
}


/*
*	similar to mysql_real_escape_string
*/
function textSafety($value)
{
	$search = array("\\",  "\x00", "\n",  "\r",  "'",  '"', "\x1a");
	$replace = array("\\\\","\\0","\\n", "\\r", "\'", '\"', "\\Z");
	return trim(str_replace($search, $replace, $value));
}

function passwordSafety($value)
{
	$search = array("\\",  "\x00", "\n",  "\r",  "'",  '"', "\x1a");
	$replace = array("\\\\","\\0","\\n", "\\r", "\'", '\"', "\\Z");
	return md5(str_replace($search, $replace, $value));
}

/*	
*	checking whether the browser is mobile browser or not
*/
function isMobile() 
{
	return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
}

function uploadImage($folder_name)
{
	$file_name = "";
	if ($_FILES["file"]["error"] > 0) 
	{
	  echo "Error: " . $_FILES["file"]["error"] . "<br>";
	}
	$allowedExts = array("gif", "jpeg", "jpg", "png");
	$temp = explode(".", $_FILES["file"]["name"]);
	$extension = end($temp);

	if ((($_FILES["file"]["type"] == "image/gif")
	|| ($_FILES["file"]["type"] == "image/jpeg")
	|| ($_FILES["file"]["type"] == "image/jpg")
	|| ($_FILES["file"]["type"] == "image/pjpeg")
	|| ($_FILES["file"]["type"] == "image/x-png")
	|| ($_FILES["file"]["type"] == "image/png"))
	&& ($_FILES["file"]["size"] < 200000000)
	&& in_array($extension, $allowedExts))
	{
		if ($_FILES["file"]["error"] > 0)
		{
			echo "Return Code: " . $_FILES["file"]["error"] . "<br>";
		} 
		else 
		{
			if (file_exists("../".$folder_name."/" . $_FILES["file"]["name"])) 
			{
				echo $_FILES["file"]["name"] . " already exists. ";
				//$file_name = $_FILES["file"]["name"];
			} 
			else 
			{
				move_uploaded_file($_FILES["file"]["tmp_name"],
				"../".$folder_name."/" . $_FILES["file"]["name"]);
				$file_name = $_FILES["file"]["name"];
			}
		}
	}
	return $file_name;
}
?>