<?php 
//Include constants file
include('../config/constants.php');

//ehco "Delete Page";
//Check whether the id and image_name value is set or not
if (isset($_GET['id']) && isset($_GET['image_name'])) {
    //Get the value and delete
    //echo "Get Value and Delete";
    $id = $_GET['id'];
    $image_name = $_GET['image_name'];
    
    //Remove the physical image file is available
    if($image_name != "") {
        //Image is available. So remove it
        $path = "../images/category/".$image_name;
        //Remove the image
        $remove = unlink($path);
        
        //If failed to remove image then add an error message and stop the process
        if ($remove == FALSE) {
            //Set the session message
            $_SESSION['remove'] = "<div class='error'>Failed to Remove Category Image</div>";
            //redirect to manage category page
            header('location:'.SITEURL.'admin/manage-category.php');
            //Stop the process
            die();
        }
    }
    
    //Delete data from database
    //SQL query to delete data form database
    $sql = "DELETE FROM tbl_category WHERE id=$id";
    
    //Execute the query
    $res = mysqli_query($conn, $sql);
    
    //Check whether th edata is delete from database or not
    if ($res == TRUE) {
        //Set success message and redirect
        $_SESSION['delete'] = "<div class='success'>Category Deleted Successfully.</div>";
        //Redirect to manage category page
        header('location:'.SITEURL.'admin/manage-category.php');
    }
    else {
        //Set fail message and redirect
        $_SESSION['delete'] = "<div class='success'>Failed to Delete Category.</div>";
        //Redirect to manage category page
        header('location:'.SITEURL.'admin/manage-category.php');
    }
}
else {
    //redirect to manage category page
    header('location:'.SITEURL.'admin/manage-category.php');
}
?>