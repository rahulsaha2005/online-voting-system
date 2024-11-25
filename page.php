<?php
session_start();
include('connect.php');

if (!isset($_SESSION['userdata'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="page.css">
    <style>
        /* Style for the button */
        .vote-btn {
            display: inline-block;
            padding: 15px 25px;
            background-color: #4CAF50;
            color: white;
            font-size: 18px;
            border-radius: 8px;
            text-decoration: none;
            text-align: center;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .vote-btn:hover {
            background-color: #45a049;
            transform: scale(1.05);
        }

        .vote-btn:active {
            background-color: #388e3c;
        }
    </style>
</head>
<body>

    <!-- Topbar with Logout Button -->
    <div class="topbar">
        <center class="title">छोड़ो अपने सारे काम,पहले चलो करें मतदान।</center>
    </div>
    <button class="logout-btn" onclick="logout()">Logout</button>

    <!-- Sidebar Toggle Button -->
    <span class="sidebar-btn" onclick="openSidebar()">☰</span>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <button class="close-btn" onclick="closeSidebar()">X</button>
        <div class="profile-history-dropdown" onclick="toggleDropdown()">
            <span>Profile History</span>
        </div>
        <div class="profile-dropdown-content">
            <a href="profile.php">Profile</a> <!-- Link to Profile Page -->
            <a href="vote.php">Vote Party</a>
            <a href="group.php" >Parties</a> <!-- Link to group.php for voting -->

        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <h1>Welcome to the Dashboard</h1>
        <p>Your details and voting options are shown here.</p>
    </div>

    <script>
        // Function to log the user out
        function logout() {
            alert('You have logged out.');
            window.location.href = 'login.html';
        }

        // Function to open/close the sidebar
        function openSidebar() {
            document.getElementById('sidebar').style.left = '0';
        }

        function closeSidebar() {
            document.getElementById('sidebar').style.left = '-250px';
        }

        // Function to toggle the profile history dropdown
        function toggleDropdown() {
            const dropdownContent = document.querySelector('.profile-dropdown-content');
            const profileHistoryDropdown = document.querySelector('.profile-history-dropdown');
            profileHistoryDropdown.classList.toggle('active');
        }
    </script>

</body>
</html>
