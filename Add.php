 <?php

require_once "connection.php";

if(isset($_REQUEST['btn_insert']))
{
 try
 {
  $name = $_REQUEST['txt_name']; //textbox name "txt_name"
   
  $image_file = $_FILES["txt_file"]["name"];
  $type  = $_FILES["txt_file"]["type"]; //file name "txt_file" 
  $size  = $_FILES["txt_file"]["size"];
  $temp  = $_FILES["txt_file"]["tmp_name"];
  
  $path="upload/".$image_file; //set upload folder path
  
  if(empty($name)){
   $errorMsg="Please Enter Name";
  }
  else if(empty($image_file)){
   $errorMsg="Please Select Image";
  }
  else if($type=="image/jpg" || $type=='image/jpeg' || $type=='image/png' || $type=='image/gif') //check file extension
  { 
   if(!file_exists($path)) //check file not exist in your upload folder path
   {
    if($size < 5000000) //check file size 5MB
    {
     move_uploaded_file($temp, "upload/" .$image_file); //move upload file temperory directory to your upload folder
    }
    else
    {
     $errorMsg="Your File To large Please Upload 5MB Size"; //error message file size not large than 5MB
    }
   }
   else
   { 
    $errorMsg="File Already Exists...Check Upload Folder"; //error message file not exists your upload folder path
   }
  }
  else
  {
   $errorMsg="Upload JPG , JPEG , PNG & GIF File Formate.....CHECK FILE EXTENSION"; //error message file extension
  }
  
  if(!isset($errorMsg))
  {
   $insert_stmt=$db->prepare('INSERT INTO tbl_file(name,image) VALUES(:fname,:fimage)'); //sql insert query     
   $insert_stmt->bindParam(':fname',$name); 
   $insert_stmt->bindParam(':fimage',$image_file);   //bind all parameter 
  
   if($insert_stmt->execute())
   {
    echo $insertMsg="File Upload Successfully........"; //execute query success message
    header("refresh:3;index1.php"); //refresh 3 second and redirect to index.php page
   }
  }
  else{
	  echo $errorMsg;
  }
 }
 catch(PDOException $e)
 {
  echo $e->getMessage();
 }
}

?>







<form method="post" class="form-horizontal" enctype="multipart/form-data">
     
 <div class="form-group">
 <label class="col-sm-3 control-label">Name</label>
 <div class="col-sm-6">
 <input type="text" name="txt_name" class="form-control" placeholder="enter name" />
 </div>
 </div>
         
 <div class="form-group">
 <label class="col-sm-3 control-label">File</label>
 <div class="col-sm-6">
 <input type="file" name="txt_file" class="form-control" />
 </div>
 </div>
         
 <div class="form-group">
 <div class="col-sm-offset-3 col-sm-9 m-t-15">
 <input type="submit"  name="btn_insert" class="btn btn-success " value="Insert">
 <a href="index.php" class="btn btn-danger">Cancel</a>
 </div>
 </div>
     
</form>