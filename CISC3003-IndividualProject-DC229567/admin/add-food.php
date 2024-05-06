<?php include('partials/menu.php');?>

<div class="main-content">
	<div class="wrapper">
		<h1>Add Food</h1>
		
		<br><br>
		
		<?php 
		if(isset($_SESSION['upload'])) {
		    echo $_SESSION['upload'];
		    unset($_SESSION['upload']);
		}
		?>
		
		<form action="" method="POST" enctype="multipart/form-data">
			<table class="tbl-30">
				<tr>
					<td>Title: </td>
					<td>
						<input type="text" name="title" placeholder="Title of the Food">
					</td>
				</tr>
				<tr>
					 <td>Description: </td>
					 <td>
					 	<textarea name="description" cols="30" rows="5" placeholder="Description of the Food"></textarea>
					 </td>
				</tr>
				<tr>
					<td>Price: </td>
					<td>
						<input type="number" name="price">
					</td>
				</tr>
				<tr>
					<td>Select Image: </td>
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
							        $id = $row['id'];
							        $title = $row['title'];
							        ?>
							        
							        <option value="<?php echo $id;?>"><?php echo $title;?></option>
							        
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
						<input type="radio" name="featured" value="Yes"> Yes
						<input type="radio" name="featured" value="No"> No
					</td>
				</tr>
				<tr>
					<td>Active: </td>
					<td>
						<input type="radio" name="active" value="Yes"> Yes
						<input type="radio" name="active" value="No"> No
					</td>
				</tr>
				
				
				<tr>
					<td colspan="2">
						<input type="submit" name="submit" value="Add Food" class="btn-secondary">
					</td>
				</tr>
			</table>
		</form>
		
		<?php 
		
		if(isset($_POST['submit'])) {
		    //Add the food in database
		    //echo "Button Clicked";
		    
		    //1. Get the data from form
		    $title = $_POST['title'];
		    $description = $_POST['description'];
		    $price = $_POST['price'];
		    $category = $_POST['category'];
		    
		    //Check whether radio button for featured and active are checked or not
		    if (isset($_POST['featured'])) {
		        $featured = $_POST['featured'];
		    }
		    else {
		        $featured = 'No';
		    }
		    
		    if (isset($_POST['active'])) {
		        $active = $_POST['active'];
		    }
		    else {
		        $active = 'No';
		    }
		    
		    //2. Upload the image if selected
		    //Check select image or not
		    if (isset($_FILES['image']['name'])) {
		        //Get details of the selected image
		        $image_name = $_FILES['image']['name'];
		        
		        //Check whether the image is selected or not
		        if ($image_name != "") {
		            //Image is selected
		            //A. Rename the image
		            //Get the extenion of selected image (.jpg, .png, .gif, etc)
		            $ext = end(explode('.', $image_name));
		            
		            //Create new name for image
		            $image_name = "Food-Name-".rand(0000,9999).".".$ext; //New image name may be "Food-Name-1234.jpg"
		            
		            //B. Upload the image
		            //Get the src path and destination path
		            
		            //Source path is the current location
		            $src = $_FILES['image']['tmp_name'];
		            
		            //Destination path for the image to be uploaded
		            $dst = "../images/food/".$image_name;
		            
		            //Finally upload the food image
		            $upload = move_uploaded_file($src, $dst);
		            
		            //Check whether image uploaded or not
		            if ($upload == FALSE) {
		                //Failed to upload the image
		                //Redirect to add food page with error message
		                $_SESSION['upload'] = "<div class='error'>Failed to Upload Image.</div>";
		                header('location:'.SITEURL.'admin/add-food.php');
		                //Stop the process
		                die();
		            }
		        }
		    }
		    else {
		        $image_name = ""; //Setting default value as blank
		    }
		    
		    //3. Insert into database
		    
		    //Create a SQL query to save or add food
		    $sql2 = "INSERT INTO tbl_food SET
                title = '$title',
                description = '$description',
                price = '$price',
                image_name = '$image_name',
                category_id = '$category',
                featured = '$featured',
                active = '$active'
            ";
		        
            //Execute the query
            $res2 = mysqli_query($conn, $sql2);
            
            //4. Redirect with message to manage food page
            //Check the data is inserted or not
            if ($res2 == TRUE) {
                //Data inserted successfully
                $_SESSION['add'] = "<div class='success'>Added Food Successfully.</div>";
                header('location:'.SITEURL.'admin/manage-food.php');
            }
            else {
                $_SESSION['add'] = "<div class='error'>Failed to Add Food.</div>";
                header('location:'.SITEURL.'admin/manage-food.php');
            }
		}
		
		?>
	</div>
</div>

<?php include('partials/footer.php');?>