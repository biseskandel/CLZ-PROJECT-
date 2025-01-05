<?php include 'includes/header.php' ;?>
<!-- Register -->

<div class="flex justify-center items-center my-10">
    <form action="" method="POST" class="bg-gray-100 w-5/12 p-10 rounded shadow" name="sign-up" onsubmit="return validateForm()">
        <h1 class="text-center font-bold text-4xl my-10">Register</h1>
        <input type="text"class="w-full p-2 my-5 border-2 border-gray-300" name="fullname" placeholder="Full Name" pattern="[a-zA-Z\s]+" title="Enter only letters and spaces" required>
        <input type="email"class="w-full p-2 my-5 border-2 border-gray-300" name="email" placeholder="Email" required>
        <input type="text"  class="w-full p-2 my-5 border-2 border-gray-300" name="phone" placeholder="phone" required minlength="10" maxlength="15">
        <input type="text"class="w-full p-2 my-5 border-2 border-gray-300" name="address" placeholder="address" required>
        <input type="password"class="w-full p-2 my-5 border-2 border-gray-300" name="password" placeholder="Password" required>
        <input type="password"class="w-full p-2 my-5 border-2 border-gray-300" name="cpassword" placeholder="Confirm Password" required>
        <button type="submit" name="register" class="w-full p-2 my-5 bg-orange-500 text-white font-bold hover:bg-blue-400">Register</button>

        <div class="my-5">
                <p class="text-center">Already have an account? <a href="login.php" class="text-blue-500">Login now</a></p>

            </div>
    </form>

</div>
<?php include 'includes/footer.php' ;?>

<?php
if(isset($_POST['register'])){
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];

    if (!preg_match('/^[a-zA-Z0-9._%+-]+@gmail.com$/', $email)) {
        echo "<script>alert('Please enter a valid Gmail address')</script>";
        exit; // Stop execution if email is not in Gmail format
    }
 		


        if($password == $cpassword){
            $password = md5($password);
            $qry = "INSERT INTO users (fullname, email, password, phone, address) VALUES ('$fullname','$email', '$password', '$phone', '$address')";
            include 'includes/dbconnection.php';
            $result = mysqli_query($conn, $qry);
            include 'includes/closeconnection.php';
            if($result){
                echo "<script>alert('User Register Successfully');
                window.location.href = 'login.php';
                </script>";
            }else{
                echo "<script> alert('User Register Failed')</script>";
            }
        }else{
            echo "<script>alert('password and confirm password do not match')</script>";
        }
    }
?>

<script>
    function validateForm() {
        var name = document.forms["sign-up"]["fullname"].value;
        var email = document.forms["sign-up"]["email"].value;
        var password = document.forms["sign-up"]["password"].value;
        var cpassword = document.forms["sign-up"]["cpassword"].value;

        // Name validation
        var nameRegex = /^[a-zA-Z\s]+$/;
        if (!nameRegex.test(name)) {
            alert("Please enter a valid name (letters and spaces only)");
            return false;
        }

        // Email validation
        var emailRegex = /^[^\d\s][\w\.-]+@[a-zA-Z\d\.-]+\.[a-zA-Z]{2,}$/;
        if (!emailRegex.test(email)) {
            alert("Please enter a valid email address");
            return false;
        }

        // Password validation
        var passwordRegex = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*]).{6,}$/;
        if (!passwordRegex.test(password)) {
            alert("Password must be at least 6 characters long and contain at least one uppercase letter, one lowercase letter, one number, and one special character");
            return false;
        }

        // Password validation
        var passwordRegex = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*]).{6,}$/;
        if (!passwordRegex.test(cpassword)) {
            alert("Password must be at least 6 characters long and contain at least one uppercase letter, one lowercase letter, one number, and one special character");
            return false;
        }


        return true;
    }
</script>

