<?php
//Include constants page
include('../config/constants.php');

if (isset($_GET['id']) && isset($_GET['image_name'])) {
    //Process to delete
    
    //1. Get id and image name
    $id = $_GET['id'];
    $image_name = $_GET['image_name'];
    
    //2. Remove the image if available
    //Check the image is available or not and delete only available
    if ($image_name != "") {
        //Have image and need to remove
        //Get the path
        $path= "../images/food/".$image_name;
        
        //Remove image file from folder
        $remove = unlink($path);
        
        //Check whether the image is removed or not
        if ($remove == FALSE) {
            //Failed to remove image
            $_SESSION['upload'] = "<div class='error'>Failed to Remove Image File.</div>";
            //Redirect to manage food page
            header('location:'.SITEURL.'admin/manage-food.php');
            //Stop the process
            die();
        }
    }
    
    //3. Delete food from database
    $sql = "DELETE FROM tbl_food WHERE id='$id'";
    //Execute the query
    $res = mysqli_query($conn, $sql);
    
    //Check the query is executed or not and set the session message
    //4. Redirect to manage food page with message
    if ($res == TRUE) {
        //Success
        $_SESSION['delete'] = "<div class='success'>Food Deleted Successfully.</div>";
        header('location:'.SITEURL.'admin/manage-food.php');
    }
    else {
        //Failed
        $_SESSION['delete'] = "<div class='error'>Failed to Delete Food.</div>";
        header('location:'.SITEURL.'admin/manage-food.php');
    }
}
else {
    //Redirect to manage food page
    $_SESSION['unauthorize'] = "<div class='error'>Unauthorized Access.</div>";
    header('location:'.SITEURL.'admin/manage-food.php');
}

?>