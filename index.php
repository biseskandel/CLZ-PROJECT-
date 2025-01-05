<?php include 'includes/header.php'; $qry = "SELECT * FROM products ORDER BY product_date ";
$qryall = "SELECT* FROM products ORDER BY RAND()";
include 'includes/dbconnection.php';
$result = mysqli_query($conn, $qry);
$resultall = mysqli_query($conn, $qryall);
include 'includes/closeconnection.php';

?>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<div class="bg-[url('https://png.pngtree.com/thumb_back/fh260/20170803/pngtree-Food-Menu-Fare-Meal-background-photo-869492.jpg')] m-2 h-96 w-full bg-no-repeat bg-cover p-2"><br><br><br><br>
    
<!-- Our menu color color status -->
<h1 class="text-center font-bold text-4xl  text-white my-10 ">Our<span class="text-yellow-500 "> Menu  </span></h1><br><br><br><br><br><br><br><br>

<div class="grid grid-cols-4 gap-10 px-20">
    
        <?php while($row = mysqli_fetch_assoc($result))
        { ?>

        <a href="viewproduct.php?id=<?php echo $row['id'];?>" class="hover:-translate-y-2 duration-300 hover:shadow-lg">
        <div class="bg-gray-100 rounded shadow">
            <img src="uploads/<?php echo $row ['photopath']; ?>" class="w-full h-60 object-cover rounded">
            <div class="p-4">
                <h2 class="text-lg font-bold">
                    <?php echo $row['name']; ?> </h2>
                    <p class="text-sm text-gray-600">Rs. <?php echo $row ['price']; ?> </p>
                    
            </div> 
        </div>
        </a>
        
    <?php } ?>
        
    </div>
<?php include 'includes/footer.php';?>