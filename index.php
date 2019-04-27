<?php include "inc/header.php" ?>
<?php
 include "lib/config.php";
 include "lib/database.php";

 $db = new Database();


  ?>

  <div class="myform">
    <?php
      if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $permitted = array('jpg','jpeg','png','gif' );
        $file_name = $_FILES['image']['name'];
        $file_size = $_FILES['image']['size'];
        $file_tmp = $_FILES['image']['tmp_name'];

        //To generate unique file name
        $div = explode('.',$file_name);
        $file_ext = strtolower(end($div));
        $unique_file_name = substr(md5(time()),0,10).'.'.$file_ext;
        $uploaded_image = "uploads/".$unique_file_name;

      //end


        if(empty($file_name)){
          echo "<span class='error'>Please Select Any Image.</span>";
        }elseif ($file_size > 5242880) {
          echo "<span class='error'>File Size should be less than 5 Mb !</span>";
        }elseif(in_array($file_ext,$permitted) === false){
          echo "<span class='error'>You can upload only:-".implode(',',$permitted)."</span>";
        }else {

          move_uploaded_file($file_tmp,$uploaded_image);

          $query = "INSERT INTO tbl_img(image) VALUES('$uploaded_image') ";
          $inserted_rows = $db->insert($query);
          if ($inserted_rows) {
            echo "<span class='success'>Image Uploaded Successfully.</span>";
          }else {
            echo "<span class='error'>Failed To Upload.</span>";
          }
        }



      }
     ?>
    <form class="" action="" method="post" enctype="multipart/form-data">
      <table>
        <tr>
          <td>Select Image</td>
          <td> <input type="file" name="image" value=""> </td>
        </tr>
        <tr>
          <td></td>
          <td> <input type="submit" name="submit" value="Upload"> </td>
        </tr>
      </table>
    </form>
  </div>

<table>
  <tr>
    <th>No.</th>
    <th>Image</th>
    <th>Action</th>
  </tr>
<?php
  //Data Delete query
  if (isset($_GET['delete'])) {
    $the_id = $_GET['delete'];

    //code for delete pic from folder
    $Getquery = "SELECT * FROM tbl_img where id = '$the_id' ";
    $getImg = $db->select($Getquery);

    if ($getImg) {
      while($imageData = $getImg->fetch_assoc()){
        $del_img = $imageData['image'];
        unlink($del_img);
      }
    }


    //code for delete pic from database
  $query = "DELETE FROM tbl_img where id = '$the_id' ";
  $delImage = $db->delete($query);
  if ($delImage) {
    echo "<span class='success'>Deleted</span>";
  }else {
    echo "<span class='error'>Failed to delete.</span>";
  }
  header("Location: index.php");
  }

 ?>
  <?php
    $query = "SELECT * FROM tbl_img";
    $get_image = $db->select($query);
    if ($get_image) {
      $i = 0;
      while($result = $get_image->fetch_assoc()){
        $i++;
        ?>
          <tr>
            <td><?php echo $i; ?></td>
            <td><img src="<?php echo $result['image']; ?>" height="40px" width="50px" alt=""></td>
            <td><a href="?delete=<?php echo $result['id']; ?>">Delete</a> </td>
          </tr>
        <?php
      }
    }
   ?>

</table>
<?php include "inc/footer.php" ?>
