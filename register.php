<?php
// Include the connection file
include("connect.php");

// Collect form data and sanitize inputs
$name = mysqli_real_escape_string($conn, $_POST['name']);
$mobile = mysqli_real_escape_string($conn, $_POST['mobile']);
$password = mysqli_real_escape_string($conn, $_POST['password']);
$cpassword = mysqli_real_escape_string($conn, $_POST['cpassword']);
$address = mysqli_real_escape_string($conn, $_POST['address']);
$role = mysqli_real_escape_string($conn, $_POST['role']);

// Handle file upload
$image = $_FILES['image']['name'];
$tmp_name = $_FILES['image']['tmp_name'];
$upload_dir = "uploads/"; // Directory to store uploaded files

// Check if password matches confirm password
if ($password == $cpassword) {
    // Check if file is uploaded successfully
    if (move_uploaded_file($tmp_name, $upload_dir . $image)) {
        // Insert user data into the database
        $insert = mysqli_query($conn, "
            INSERT INTO user (name, mobile, address, password, photo, role, status, votes) 
            VALUES ('$name', '$mobile', '$address', '$password', '$image', '$role', 0, 0)
        ");

        // Check if insertion is successful
        if ($insert) {
            echo '<script>
                alert("Registration successful.");
                window.location = "login.html"; // Redirect to login page
            </script>';
        } else {
            echo '<script>
                alert("Registration failed. Please try again.");
                window.location = "register.html"; // Redirect back to registration page
            </script>';
        }
    } else {
        echo '<script>
            alert("Failed to upload image. Please try again.");
            window.location = "register.html"; // Redirect back to registration page
        </script>';
    }
} else {
    echo '<script>
        alert("Password and Confirm Password do not match!");
        window.location = "register.html"; // Redirect back to registration page
    </script>';
}
?>
