<?php
session_start();
include("connect.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize inputs
    $mobile = mysqli_real_escape_string($conn, $_POST['mobile']);
    $password = mysqli_real_escape_string($conn, $_POST['pass']);
    $role = mysqli_real_escape_string($conn, $_POST['role']); // This will be '0' or '1'

    // Query to verify user credentials
    $query = "SELECT * FROM user WHERE mobile='$mobile' AND password='$password' AND role='$role'";
    $check = mysqli_query($conn, $query) or die("Query Error: " . mysqli_error($conn));

    if (mysqli_num_rows($check) > 0) {
        // Fetch user data
        $userdata = mysqli_fetch_array($check, MYSQLI_ASSOC);

        // If role is '1' (Group), fetch all group data
        if ($role == '1') {
            $groups = mysqli_query($conn, "SELECT * FROM user WHERE role=1");
            $groupdata = mysqli_fetch_all($groups, MYSQLI_ASSOC);
        }

        // Store user data in session
        $_SESSION['userdata'] = $userdata;
        if (isset($groupdata)) {
            $_SESSION['groupsdata'] = $groupdata;
        }

        // Redirect to dashboard
        echo '<script>
            alert("Login successful.");
            window.location = "page.php";
        </script>';
    } else {
        // For debugging, display received values (remove in production)
        echo "Mobile: $mobile, Password: $password, Role: $role<br>";

        // Invalid credentials
        echo '<script>
            alert("Invalid credentials. Please try again.");
            window.location = "login.html";
        </script>';
    }
} else {
    echo '<script>
        alert("Invalid request.");
        window.location = "login.html";
    </script>';
}
?>
