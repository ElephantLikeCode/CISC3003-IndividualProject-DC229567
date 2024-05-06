<?php include('partials/menu.php')?>

<div class="main-content">
	<div class="wrapper">
		<h1>Manage Food</h1>
		
		<br><br>
		
		<!-- Button to Add Food -->
		<a href="<?php echo SITEURL;?>admin/add-food.php" class="btn-primary">Add Food</a>
		
		<br><br><br>
		
		<?php 
		if(isset($_SESSION['add'])) {
		    echo $_SESSION['add'];
		    unset($_SESSION['add']);
		}
		if(isset($_SESSION['delete'])) {
		    echo $_SESSION['delete'];
		    unset($_SESSION['delete']);
		}
		if(isset($_SESSION['upload'])) {
		    echo $_SESSION['upload'];
		    unset($_SESSION['upload']);
		}
		if(isset($_SESSION['unauthorize'])) {
		    echo $_SESSION['unauthorize'];
		    unset($_SESSION['unauthorize']);
		}
		if(isset($_SESSION['update'])) {
		    echo $_SESSION['update'];
		    unset($_SESSION['update']);
		}
		?>
		
		<table class="tbl-full">
			<tr>
				<th>S.N.</th>
				<th>Title</th>
				<th>Price</th>
				<th>Image</th>
				<th>Featured</th>
				<th>Active</th>
				<th>Action</th>
			</tr>
			
			<?php 
			//Create a SQL query to get all the food
			$sql = "SELECT * FROM tbl_food";
			
			//Execute the query
			$res = mysqli_query($conn, $sql);
			
			//Count rows to check have food or not
			$count = mysqli_num_rows($res);
			
			//Create serial number variable and set default value as 1
			$sn = 1;
			
			if ($count > 0) {
			    //Have food
			    //Get and display the foods from database
			    while($rows = mysqli_fetch_assoc($res)) {
			        //Get the values from individual columns
			        $id = $rows['id'];
			        $title = $rows['title'];
			        $price = $rows['price'];
			        $image_name = $rows['image_name'];
			        $featured = $rows['featured'];
			        $active = $rows['active'];
			        ?>
			        
			        <tr>
            			<td><?php echo $sn++?>. </td>
            			<td><?php echo $title;?></td>
            			<td>$<?php echo $price;?></td>
            			<td>
            				<?php 
            				//Check have image or not
            				if ($image_name == "") {
            				    //No image
            				    echo "<div class='error'>Image not Added.</div>";
            				}
            				else {
            				    //Have image, display image
            				    ?>
            				    
            				    <img src='<?php echo SITEURL;?>images/food/<?php echo $image_name;?>' alt='' width='100px'>
            				    
            				    <?php
            				}
            				?>
            			</td>
            			<td><?php echo $featured;?></td>
            			<td><?php echo $active;?></td>
            			<td>
            				<a href="<?php echo SITEURL;?>admin/update-food.php?id=<?php echo $id?>" class="btn-secondary">Update Food</a>
            				<a href="<?php echo SITEURL;?>admin/delete-food.php?id=<?php echo $id?>&image_name=<?php echo $image_name;?>" class="btn-danger">Delete Food</a>
            			</td>
            		</tr>
			        
			        <?php
			    }
			}
			else {
			    //No food
			    echo "<tr><td colspan='7' class='error'>No Food Added.</td></tr>";
			}
			?>
		</table>
	</div>
	
</div>

<?php include('partials/footer.php')?>