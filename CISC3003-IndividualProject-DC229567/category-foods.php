<?php include('partials-front/menu.php');?>

<?php 

//Check id is passed or not
if(isset($_GET['category_id'])) {
    //Category id is set
    $category_id = $_GET['category_id'];
    //Get the title based on category id
    $sql = "SELECT title FROM tbl_category WHERE id='$category_id'";
    
    //Execute the query
    $res = mysqli_query($conn, $sql);
    
    //Get the value from database
    $row = mysqli_fetch_assoc($res);
    //Get the title
    $category_title = $row['title'];
}
else {
    //Category not passed
    //Redirect to home page
    header('location:'.SITEURL);
}

?>

    <!-- fOOD sEARCH Section Starts Here -->
    <section class="food-search text-center">
        <div class="container">
            
            <h2>Foods on <a href="#" class="text-white">"<?php echo $category_title;?>"</a></h2>

        </div>
    </section>
    <!-- fOOD sEARCH Section Ends Here -->



    <!-- fOOD MEnu Section Starts Here -->
    <section class="food-menu">
        <div class="container">
            <h2 class="text-center">Food Menu</h2>
            
            <?php 
            
            //Get foods from database that are active and featured
            //SQL query
            $sql2 = "SELECT * FROM tbl_food WHERE category_id='$category_id' AND active='Yes'";
            
            //Execute the query
            $res2 = mysqli_query($conn, $sql2);
            
            //Count rows
            $count2 = mysqli_num_rows($res2);
            
            //Check whether food available or not
            if ($count2 > 0) {
                //Available
                while($row2 = mysqli_fetch_assoc($res2)) {
                    //Get all values
                    $id = $row2['id'];
                    $title = $row2['title'];
                    $price = $row2['price'];
                    $description = $row2['description'];
                    $image_name = $row2['image_name'];
                    ?>
                    
                    <div class="food-menu-box">
                        <div class="food-menu-img">
                            <?php 
                            	//Check image is available or not
                            	if ($image_name == "") {
                            	    //Not available
                            	    //Display message
                            	    echo "<div class='error'>Image not Available.</div>";
                            	}
                            	else {
                            	    //Image available
                            	    ?>
                            	    
                            	    <img src="<?php echo SITEURL;?>images/food/<?php echo $image_name;?>" alt="<?php echo $title;?>" class="img-responsive img-curve">
                            	    
                            	    <?php
                            	}
                            	?>
                        </div>
        
                        <div class="food-menu-desc">
                            <h4><?php echo $title;?></h4>
                            <p class="food-price">$<?php echo $price;?></p>
                            <p class="food-detail">
                                <?php echo $description;?>
                            </p>
                            <br>
        
                            <a href="<?php echo SITEURL;?>order.php?food_id=<?php echo $id;?>" class="btn btn-primary">Order Now</a>
                        </div>
                    </div>
                    
                    <?php
                }
            }
            else {
                //Not available
                echo "<div class='error'>Food not Found.</div>";
            }
            
            ?>

            <div class="clearfix"></div>

            

        </div>

    </section>
    <!-- fOOD Menu Section Ends Here -->

<?php include('partials-front/footer.php');?>