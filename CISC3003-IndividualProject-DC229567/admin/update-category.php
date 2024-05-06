<?php include('partials/menu.php')?>

<div class="main-content">
	<div class="wrapper">
		<h1>Update Category</h1>
		
		<br><br>
		
		<?php 
		//Checking whether the Session is Set or Not
		if(isset($_SESSION['update'])) {
		    echo $_SESSION['update'];
		    unset($_SESSION['update']);
		}
		?>
		
		<?php 
    	//Check whether the id is set or not
		if (isset($_GET['id'])) {
		    //Get the id and all other details
		    //echo "Getting the Data";
		    $id = $_GET['id'];
		    //Create SQL query to get all other details
		    $sql = "SELECT * FROM tbl_category WHERE id=$id";
		    
		    //Execute the query
		    $res = mysqli_query($conn, $sql);
		    
		    //Count the rows to check whether the id is valid or not
		    $count = mysqli_num_rows($res);
		    
		    if ($count == 1) {
		        //Get all the data
		        $row = mysqli_fetch_assoc($res);
		        $title = $row['title'];
		        $current_image = $row['image_name'];
		        $featured = $row['featured'];
		        $active = $row['active'];
		    }
		    else {
		        //Redirect to manage category page with session message
		        $_SESSION['no-category-found'] = "<div class='error'>Category not Found.</div>";
		        header('location:'.SITEURL.'admin/manage-category.php');
		    }
		}
		else {
		    //Redirect to manage category page
		    header('location:'.SITEURL.'admin/manage-category.php');
		}
		?>
		
		<form action="" method="POST" enctype="multipart/form-data">
    		<table class="tbl-30">
    			<tr>
    				<td>Title: </td>
    				<td>
    					<input type="text" name="title" value="<?php echo $title;?>">
    				</td>
    			</tr>
    			<tr>
    				 <td>Current Image:</td>
    				 <td>
    				 	<?php 
    				 	if ($current_image != "") {
    				 	    //Display the image
    				 	    ?>
    				 	    <img src="<?php echo SITEURL;?>images/category/<?php echo $current_image;?>" alt="" width="150px">
    				 	    <?php
    				 	}
    				 	else {
    				 	    //Display Message
    				 	    echo "<div class='error'>Image not Added.</div>";
    				 	}
    				 	?>
    				 </td>
    			</tr>
    			<tr>
    				 <td>New Image:</td>
    				 <td>
    				 	<input type="file" name="image">
    				 </td>
    			</tr>
    			<tr>
    				<td>Featured: </td>
    				<td>
    					<input <?php if($featured=="Yes"){echo "checked";}?> type="radio" name="featured" value="Yes"> Yes
    					<input <?php if($featured=="No"){echo "checked";}?> type="radio" name="featured" value="No"> No
    				</td>
    			</tr>
    			<tr>
    				<td>Active: </td>
    				<td>
    					<input <?php if($active=="Yes"){echo "checked";}?> type="radio" name="active" value="Yes"> Yes
    					<input <?php if($active=="No"){echo "checked";}?> type="radio" name="active" value="No"> No
    				</td>
    			</tr>
    			
    			<tr>
    				<td colspan="2">
    					<input type="hidden" name="id" value=<?php echo $id;?>>
    					<input type="hidden" name="current_image" value=<?php echo $current_image;?>>
    					<input type="submit" name="submit" value="Update Category" class="btn-secondary">
    				</td>
    			</tr>
    		</table>
		</form>
		
		<?php
		
		//Check the submit button is clicked
		if (isset($_POST['submit'])) {
		    //echo "Button Clicked";
		    //1. Get all the values from form
		    $id = $_POST['id'];
		    $title = $_POST['title'];
		    $current_image = $_POST['current_image'];
		    $featured = $_POST['featured'];
		    $active = $_POST['active'];
		    
		    //2. Updateing new image if selected
		    //Check whether the image is selected or not
		    if(isset($_FILES['image']['name'])) {
		        //Get the image details
		        $image_name = $_FILES['image']['name'];
		        
		        //Check whether the image is available or not
		        if ($image_name != "") {
		            //Image available
		            
		            //A. Upload the new image
		            
		            //Auto rename the image
		            //Get the extension of our image (jpg, png, gif, etc) e.g. "special.food1.jpg"
		            $ext = end(explode('.', $image_name));
		            
		            //Rename the image
		            $image_name = "Food_Category_".rand(000, 999).'.'.$ext; //e.g. Food_Category_123.jpg
		            
		            $source_path = $_FILES['image']['tmp_name'];
		            
		            $destination_path = "../images/category/".$image_name;
		            
		            //Finally upload the image
		            $upload = move_uploaded_file($source_path, $destination_path);
		            
		            //Check whether the image is uploaded or not
		            //And if the image is not uploaded then we will stop the process and redirect with error message
                    if ($upload == FALSE) {
                        //Set message
                        $_SESSION['upload'] = "<div class='error'>Failed to Upload Image.</div>";
                        //Redirect to add category page
                        header('location:'.SITEURL.'admin/manage-category.php');
                        //Stop the process
                        die();
		            }
		            
		            //B. Remove current image
		            if ($current_image != "") {
		                $remove_path = "../images/category/".$current_image;
		                
		                $remove = unlink($remove_path);
		                
		                //Check whether the image is removed or not
		                //If failed to remove then display message and stop the process
		                if ($remove == false) {
		                    //Failed to remove image
		                    $_SESSION['failed-remove'] = "<div class='error'>Failed to Remove Current Image</div>";
		                    //redirect to manage category page
		                    header('location:'.SITEURL.'admin/manage-category.php');
		                    //Stop the process
		                    die();
		                }
		            }
		        }
		        else {
		            $image_name = $current_image;
		        }
		    }
		    else {
		        $image_name = $current_image;
		    }
		    
		    //3. Update the database
		    $sql2 = "UPDATE tbl_category SET
                title = '$title',
                image_name = '$image_name',
                featured = '$featured',
                active = '$active'
                WHERE id = '$id'
            ";
		    
		    //Execute the query
		    $res2 = mysqli_query($conn, $sql2);
		    
		    //4. Redirect to manage category page with message
		    //Check whether executed or not
		    if ($res2 == true) {
		        //Category updated
		        $_SESSION['update'] = "<div class='success'>Category Updated Successfully.</div>";
		        header('location:'.SITEURL.'admin/manage-category.php');
		    }
		    else {
		        //Failed to update category
		        $_SESSION['update'] = "<div class='error'>Failed to Update Category.</div>";
		        header('location:'.SITEURL.'admin/manage-category.php');
		    }
		}
		
		?>
		
	</div>
</div>

<?php include('partials/footer.php')?>