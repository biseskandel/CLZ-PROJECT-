<?php
include 'includes/header.php'; 
include 'includes/dbconnection.php'; 

if(isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = md5($_POST['password']); // Encrypt password
    $qry = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";
    $result = mysqli_query($conn, $qry);

    if(mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION['username'] = $row['fullname'];
        $_SESSION['userid'] = $row['id'];
        $_SESSION['islogin'] = 'yes';
        $_SESSION['role'] = $row['role'];

        echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';

        if ($row['role'] == 'user') {
            echo '<script type="text/javascript">';
            echo 'Swal.fire({';
            echo 'title: "User Login Successfully",';
            echo 'icon: "success",';
            echo 'showConfirmButton: false,';
            echo 'timer: 1500,';
            echo 'willClose: () => { window.location.href = "index.php"; }';
            echo '});';
            echo '</script>';
        } elseif ($row['role'] == 'Admin') {
            echo '<script type="text/javascript">';
            echo 'Swal.fire({';
            echo 'title: "Admin Login Successfully",';
            echo 'icon: "success",';
            echo 'showConfirmButton: false,';
            echo 'timer: 1500,';
            echo 'willClose: () => { window.location.href = "admin/dashboard.php"; }';
            echo '});';
            echo '</script>';
        } else {
            echo '<script type="text/javascript">';
            echo 'Swal.fire({';
            echo 'title: "Invalid Role",';
            echo 'icon: "error",';
            echo 'showConfirmButton: true';
            echo '});';
            echo '</script>';
        }
    } else {
        echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
        echo '<script type="text/javascript">';
        echo 'Swal.fire({';
        echo 'title: "Invalid Email or Password",';
        echo 'icon: "error",';
        echo 'showConfirmButton: true';
        echo '});';
        echo '</script>';
    }
}

include 'includes/closeconnection.php'; 
?>

<div class="flex justify-center items-center my-10">
    <form action="" method="POST" class="bg-gray-100 p-10 rounded shadow">
        <h1 class="text-center font-bold text-4xl my-10">Login</h1>
        <input type="text" class="w-full p-2 my-5 border-2 border-gray-300" name="email" placeholder="Email">
        <input type="password" class="w-full p-2 my-5 border-2 border-gray-300" name="password" placeholder="Password">
        <button type="submit" name="login" class="w-full p-2 my-5 bg-orange-500 text-white font-bold hover:bg-blue-400">Login</button>
        <div class="my-5">
            <p class="text-center text-orange-500 text-15px"> Don't have an account? <br>
            <a href="register.php" class="text-blue-500">Register Now</a></p>
        </div>
    </form>
</div>

<?php include 'includes/footer.php'; ?>
