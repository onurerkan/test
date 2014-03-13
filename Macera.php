<?php
/**
 * Macera Class
 */
error_reporting(0);
session_start();

class Macera{
	
	
	
	public function __construct(){
		mysql_connect("localhost","root","root") or die("Veritabanına bağlanamadım");
		mysql_select_db("macera") or die("Veritabanını seçemedim");
		mysql_query("SET NAMES 'utf8'");
		echo 'TEST';
	}
	
	public function userIsLogged()
	{
		if($_SESSION["uid"] == '')
		{
			$this->urlRedirect('login.php');
		}
	}
	
	public function userLogout(){
		$_SESSION = array();
		session_destroy();
		$this->urlRedirect('index.php');
	}
	
	
	public function getPagesAll(){
		
	 $q = mysql_query("SELECT * FROM pages");
	 $arr = array();
	 while($r = mysql_fetch_array($q))
	 {
	 	array_push($arr,$r);
	 }
	 return $arr;
	}
	
	public function getPagesByParent($page_id){
		(int)$page_id = $page_id;
		$q = mysql_query("SLEECT * FROM pages WHERE parent_id = '$page_id'");
		$arr = array();
		while($r = mysql_fetch_array($q))
		{
			array_push($arr,$r);
		}
		return $arr;
	}
	
	public function getPagesDetail($page_id){
		(int)$page_id = $page_id; 	
		$q = mysql_query("SELECT * FROM pages WHERE id = '$page_id'");
		$arr = mysql_fetch_array($q);
		return $arr;
	}
	
	public function addPages($siteID,$title,$keywords,$description,$content,$video,$seo,$parentID){
		
		$q = mysql_query("INSERT INTO pages(siteID,title,keywords,description,content,video,seo,parentID,isActive) VALUES('$siteID','$title','$keywords','$description','$content','$video','$seo','$parentID',1)");
		if(mysql_affected_rows() != -1)
		return true;
		else {
			return false;
		}
	}
	
	public function updatePages($siteID,$title,$keywords,$description,$content,$video,$seo,$parentID,$page_id){
		$q = mysql_query("UPDATE pages SET siteID = '$siteID',title='$title',keywords='$keywords',description='$description',content='$content',video='$video',seo='$seo',parentID='$parentID' WHERE id = '$page_id'");
		if(mysql_affected_rows() != -1)
		return true;
		else {
			return false;
		} 
	}
	public function deletePages($page_id){
		$q = mysql_query("UPDATE pages SET isActive = 0 WHERE id = '$page_id'");
		if(mysql_affected_rows() != -1)
		return true;
		else {
			return false;
		}
	}
	
	public function addPhotos($title,$image,$page_id){
		if (file_exists("img/" . $image["file"]["name"]))
      {
      //Bu isimde dosya var panpa diyor
      return 'false';
      }
    else
      {
      		
      $img_name =  uniqid();	
      move_uploaded_file($image["file"]["tmp_name"],"img/" . $img_name.'.'.$image["file"]["type"]);
      //echo "Stored in: " . "upload/" . $_FILES["file"]["name"];
      $dosya = $img_name.'.'.$image["file"]["type"];
	  $q = mysql_query("INSERT INTO photos(title,image,page_id,isActive) VALUES('$title','$dosya','$page_id',1) ");
	  if(mysql_affected_rows() != -1)
	  {
	  	return true;
	  }
		else {
				return false;
			}
	  }
	}
	
	public function getPhotos(){
		$q = mysql_query("SELECT * FROM photos");
		$arr = array();
		while($r = mysql_fetch_array($q)){
			array_push($arr,$r);
		}
		return $arr;
	}
	
	public function deletePhotos($photo_id){
		$q = mysql_query("UPDATE photos SET isActive = 0 WHERE id = '$photo_id'");
		if(mysql_affected_rows() != -1)
		{
			return true;
		}else{
			return false;
		}
	}
	
	public function urlRedirect($url){
		
		echo '	 	
 	
		<SCRIPT LANGUAGE="JavaScript">
		<!-- 
		window.location="'.$url.'";
		// -->
		</script>';
	}
}

?>
