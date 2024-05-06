<?php include('partials/menu.php');?>

<?php 

//Check whether id is set or not
if(isset($_GET['id'])) {
    //Get all the details
    $id = $_GET['id'];
    
    //SQL query to get the selected food details
    $sql2 = "SELECT * FROM tbl_food WHERE id='$id'";
    //Execute the query
    $res2 = mysqli_query($conn, $sql2);
    
    //Get the value based on query executed
    $row2 = mysqli_fetch_assoc($res2);
    
    //Get the individual values
    $title = $row2['title'];
    $description = $row2['description'];
    $price = $row2['price'];
    $current_image = $row2['image_name'];
    $current_category = $row2['category_id'];
    $featured = $row2['featured'];
    $active = $row2['active'];
}
else {
    //Redirect to manage food page
    header('location:'.SITEURL.'admin/manage-food.php');
}

?>

<div class="main-content">
	<div class="wrapper">
		<h1>Update Food</h1>
		
		<br><br>
		
		<form action="" method="POST" enctype="multipart/form-data">
			<table class="tbl-30">
				<tr>
					<td>Title: </td>
					<td>
						<input type="text" name="title" value="<?php echo $title;?>">
					</td>
				</tr>
				<tr>
					 <td>Description: </td>
					 <td>
					 	<textarea name="description" cols="30" rows="5"><?php echo $description;?></textarea>
					 </td>
				</tr>
				<tr>
					<td>Price: </td>
					<td>
						<input type="number" name="price" value="<?php echo $price;?>">
					</td>
				</tr>
				<tr>
					<td>Current Image: </td>
					<td>
						<?php 
						if($current_image == "") {
						    //Image not available
						    echo "<div class='error'>Image not Available.</div>";
						}
						else {
						    //Image available
						    ?>
						    <img src="<?php echo SITEURL;?>images/food/<?php echo $current_image;?>" alt="" width="150px">
						    <?php
						}
						?>
					</td>
				</tr>
				<tr>
					<td>Select New Image: </td>
					<td>
						<input type="file" name="image">
					</td>
				</tr>
				<tr>
					<td>Category: </td>
					<td>
						<select name="category">
							<?php 
							//Create PHP code to display categories from database
							//1. Create SQL to get all active categories from database
							$sql = "SELECT * FROM tbl_category WHERE active='YES'";
							
							$res = mysqli_query($conn, $sql);
							
							//Count rows to check whether we have categories or not
							$count = mysqli_num_rows($res);
							
							//If count greater than zero, we have categories else we don't have categories
							if ($count > 0) {
							    //We have categories
							    while ($row = mysqli_fetch_assoc($res)) {
							        //Get the details of categories
							        $category_id = $row['id'];
							        $category_title = $row['title'];
							        
							        //echo "<option value='$category_id'>$category_title</option>";
							        ?>
							        
							        <option <?php if($current_category==$category_id) {echo "selected='selected'";}?> value="<?php echo $category_id;?>"><?php echo $category_title;?></option>
							        
							        <?php
							    }
							}
							else {
							    //We don't have categories
							    ?>
							    
							    <option value="0"> No Category Found</option>
							    
							    <?php
							}
							
							//2. Display on Dropdown
							?>
						</select>
					</td>
				</tr>
				<tr>
					<td>Featured: </td>
					<td>
						<input <?php if($featured=="Yes") {echo "checked";}?> type="radio" name="featured" value="Yes"> Yes
						<input <?php if($featured=="No") {echo "checked";}?> type="radio" name="featured" value="No"> No
					</td>
				</tr>
				<tr>
					<td>Active: </td>
					<td>
						<input <?php if($active=="Yes") {echo "checked";}?> type="radio" name="active" value="Yes"> Yes
						<input <?php if($active=="No") {echo "checked";}?> type="radio" name="active" value="No"> No
					</td>
				</tr>
				
				
				<tr>
					<td colspan="2">
						<input type="hidden" name="id" value="<?php echo $id;?>">
						<input type="hidden" name="current_image" value="<?php echo $current_image;?>">
						
						<input type="submit" name="submit" value="Update Food" class="btn-secondary">
					</td>
				</tr>
			</table>
		</form>
		
		<?php 
		
		if(isset($_POST['submit'])) {
		    //1. Get all the details from the form
		    $id = $_POST['id'];
		    $title = $_POST['title'];
		    $description = $_POST['description'];
		    $price = $_POST['price'];
		    $current_image = $_POST['current_image'];
		    $category = $_POST['category'];
		    
		    $featured = $_POST['featured'];
		    $active = $_POST['active'];
		    
		    //2. Upload the image if selected
		    
		    //Check whether upload button is clicked or not
		    if (isset($_FILES['image']['name'])) {
		        //Upload button clicked
		        $image_name = $_FILES['image']['name']; //New image name
		        
		        //Check whether the file is available or not
		        if($image_name != "") {
		            //Available
		            //A. Uploading new image
		            //Rename the image
		            $ext = end(explode('.', $image_name));
		            
		            //Create new name for image
		            $image_name = "Food-Name-".rand(0000,9999).".".$ext; //New image name may be "Food-Name-1234.jpg"
		            
		            //Get the src path and destination path
		            $src_path = $_FILES['image']['tmp_name']; //Source Path
		            $dest_path = "../images/food/".$image_name; //Destination Path
		            
		            //Finally upload the food image
		            $upload = move_uploaded_file($src_path, $dest_path);
		            
		            //Check whether image uploaded or not
		            if ($upload == FALSE) {
		                //Failed to upload the image
		                $_SESSION['upload'] = "<div class='error'>Failed to Upload Image.</div>";
		                //Redirect to add food page with error message
		                header('location:'.SITEURL.'admin/add-food.php');
		                //Stop the process
		                die();
		            }
		            
		            //3. Remove the image if new image is uploaded
		            //B. Remove current image if available
		            if ($current_image != "") {
		                //Current image is available
		                //Remove the image
		                $remove_path = "../images/food/".$current_image;
		                
		                $remove = unlink($remove_path);
		                
		                //Check image is removed or not
		                if ($remove == FALSE) {
		                    //Fail
		                    $_SESSION['remove-failed'] = "<div class='error'>Failed to Remove Current Image.</div>";
		                    //Redirect to manage food
		                    header('location:'.SITEURL.'admin/manage-food.php');
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
		    
		    //4. Update the food in database
		    $sql3 = "UPDATE tbl_food SET
                title = '$title',
                description = '$description',
                price = '$price',
                image_name = '$image_name',
                category_id = '$category',
                featured = '$featured',
                active = '$active'
                WHERE id = '$id'
            ";
		    
		    //Execute the query
		    $res3 = mysqli_query($conn, $sql3);
		    
		    //Check whether the query is executed or not
		    //Redirect to manage food page with message
		    if ($res3 == TRUE) {
		        //Updated successfully
		        $_SESSION['update'] = "<div class='success'>Food Updated Successfully.</div>";
		        header('location:'.SITEURL.'admin/manage-food.php');
		    }
		    else {
		        //Fail to update
		        $_SESSION['update'] = "<div class='success'>Failed to Update Food.</div>";
		        header('location:'.SITEURL.'admin/manage-food.php');
		    }
		}
		
		?>
	</div>
</div>

<?php include('partials/footer.php'); ?>