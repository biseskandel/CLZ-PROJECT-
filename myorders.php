<?php 
include 'includes/header.php';
if(!isset($_SESSION['islogin'])) {
    $_SESSION['msg'] = "Please Login First";
    header('location: login.php');
}
$user_id = $_SESSION['userid'];
$qryorder = "SELECT * FROM orders WHERE user_id = $user_id";
include 'includes/dbconnection.php';
$resultorder = mysqli_query($conn, $qryorder);
?>

<h1 class="text-center font-bold text-4xl my-10">My <span class="text-red-500">Orders</span></h1>
<div class="p-5">
    <?php while($roworder = mysqli_fetch_assoc($resultorder)) {
        $qryprd = "SELECT * FROM products WHERE id=".$roworder['product_id'];
        $resultprd = mysqli_query($conn, $qryprd);
        $rowprd = mysqli_fetch_assoc($resultprd);
        ?>
        <div class="bg-gray-100 p-4 rounded-lg shadow flex justify-between">
            <img src="uploads/<?php echo $rowprd['photopath'];?>" alt="" class="h-40 w-40 object-cover">
            <div>
                <h1 class="text-2xl font-bold"><?php echo $rowprd['name'];?></h1>
                <p class="text-lg">Price: Rs. <?php echo $rowprd['price'];?>/-</p>
                <p class="text-lg">Quantity: <?php echo $roworder['quantity']; ?></p>
                <p class="text-lg">Total: Rs. <?php echo $rowprd['price'] * $roworder['quantity'];?></p>
            </div>
            <div class="flex flex-col">
                <a href="actionorder.php?deleteid=<?php echo $roworder['id'];?>" onclick="return confirm('Are you sure to delete this order?')" 
                   class="bg-red-500 text-white px-4 py-2 rounded-lg my-2">Remove</a>
                <form action="actionorder.php" method="POST">
                    <input type="hidden" name="cart_id" value="<?php echo $roworder['id']; ?>">
                    <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-lg my-2"><?php echo $roworder['status']; ?></button>
                </form>
            </div>
        </div>
    <?php } ?>
</div>

<?php 
include 'includes/closeconnection.php';
include 'includes/footer.php'; 
?>
