<?php
	if(!isset($_COOKIE["username"]))
		header("Location: login.php");
	$email = $_COOKIE["email"];
	
	if(isset($_POST["submit"])){
	if($_FILES["file"]["error"] > 0)
	{
		echo "Error: " .$_FILES["file"]["error"]."<br/>";
	}
	else
	{
		$description = $_POST["description"];
	
		$file_name = $_FILES["file"]["name"];
		$str1 = strchr($file_name,".");
		if($str1){
			$file_name = trim($file_name,$str1);/*used to obtain the file name without the postfix*/}
		move_uploaded_file($_FILES["file"]["tmp_name"],"uploadVideos/" . $_FILES["file"]["name"]);
		$db = mysql_connect("sdmysql.comp.polyu.edu.hk","18012633x","sqgqcbvd");
		if(!$db)
		{
			die('Could not connect: ' .mysql_error());
		}
		
		mysql_select_db("18012633x",$db);
		$sql = "INSERT INTO vocabulary(submitter,approver,status,vocabName,description,videoSource,checkTotal,addTotal)
						VALUES( '$email','1767182376@qq.com' ,'unapproved','$file_name','$description','upload/','0','0')";
		
		if(!mysql_query($sql,$db)){
			die('Error: '.mysql_error());
		}
		
		echo "1 video added";
		mysql_close($db);
		
		
	}
	}
									  
									 
	
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Sign Language Station</title>
<link rel="stylesheet" type="text/css" href="top_bottom_list.css"/>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
$(document).ready(function(){
	$(".dropDown").click(function(){
    	$(".dropDownContent").slideToggle("slow");
    });
})
</script>
</head>
<body>
	<?php require('header.php');?>
	
	<div class="mainFrame">
		Please upload your video:
		<form action="upload.php" method = "post" enctype="multipart/form-data">
        <label for = "file">Filename:</label>
        <input type = "file" name = "file" id = "file"/>
        <br/>
        Please use words to explain the meaning of this word:
        <input type = "text" name = "description"/>
        <br/>
        <input type = "submit" name = "submit" value="Submit"/>
        </form>
	
		
	</div>
	
	<?php require('footer.php');?>
</body>
</html>
