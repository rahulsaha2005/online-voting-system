<?php
session_start();
include('connect.php');

if (!isset($_SESSION['userdata'])) {
    header("Location: login.php");
    exit();
}

$userdata = $_SESSION['userdata']; // Get updated user data from session
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(to bottom, #FF9933, #ffffff 33%, #138808 66%);
            height: 100vh; /* Full viewport height */
            color: black;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .container {
            width: 80%;
            max-width: 900px;
            background: rgba(255, 255, 255, 0.9);
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
            backdrop-filter: blur(5px);
            text-align: center;
            animation: fadeIn 1s ease-in-out;
        }

        .profile-header {
            margin-bottom: 20px;
        }

        .profile-header img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            border: 5px solid #fff;
            transition: transform 0.3s ease;
        }

        .profile-header img:hover {
            transform: scale(1.1);
        }

        .profile-header h2 {
            margin: 15px 0;
            font-size: 2em;
            color: #333;
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.2);
        }

        .profile-header p {
            font-size: 1.1em;
            color: #555;
        }

        .profile-info {
            margin: 20px 0;
            font-size: 1.2em;
        }

        .profile-info p {
            margin: 10px 0;
        }

        .profile-info p strong {
            color: #0072ff;
        }

        .back-btn {
            padding: 12px 20px;
            background: linear-gradient(45deg, #4CAF50, #45a049);
            color: white;
            text-decoration: none;
            border-radius: 25px;
            font-size: 1.1em;
            transition: background 0.3s ease;
            margin-top: 20px;
        }

        .back-btn:hover {
            background: linear-gradient(45deg, #45a049, #4CAF50);
        }

        @keyframes fadeIn {
            0% {
                opacity: 0;
                transform: translateY(20px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="profile-header">
            <img src="uploads/<?php echo htmlspecialchars($userdata['photo']); ?>" alt="Profile Picture">
            <h2><?php echo htmlspecialchars($userdata['name']); ?></h2>
        </div>

        <div class="profile-info">
            <p><strong>Mobile:</strong> <?php echo htmlspecialchars($userdata['mobile']); ?></p>
            <p><strong>Address:</strong> <?php echo htmlspecialchars($userdata['address']); ?></p>
            <p><strong>Status:</strong> 
                <?php 
                echo $userdata['status'] == 1 ? 'Voted' : 'Not Voted'; 
                ?>
            </p>
            <p><strong>Role:</strong> <?php echo $userdata['role'] == 0 ? 'Voter' : 'Group'; ?></p>
        </div>

        <a href="page.php" class="back-btn">Back to Main Page</a>
    </div>
</
