<?php
session_start();
include('connect.php');

if (!isset($_SESSION['userdata'])) {
    header("Location: login.php");
    exit();
}

// Fetch groups (parties) from the database
$query = "SELECT * FROM user WHERE role = 1"; // Role = 1 means group
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Error fetching groups: " . mysqli_error($conn));
}

$groups = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Check if the user has already voted
$hasVoted = $_SESSION['userdata']['status'] == 1;

// Handle voting
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['user_id'])) {
    if ($hasVoted) {
        // If already voted, prevent voting
        die("You have already voted and cannot vote again.");
    }

    $user_id = intval($_POST['user_id']); // The group being voted for
    $voter_id = $_SESSION['userdata']['id']; // Logged-in voter ID

    // Update voter's status and increment group's votes
    $conn->begin_transaction();
    try {
        // Mark voter as "voted"
        $updateVoterQuery = "UPDATE user SET status = 1 WHERE id = ?";
        $stmt = $conn->prepare($updateVoterQuery);
        $stmt->bind_param("i", $voter_id);
        $stmt->execute();

        // Increment vote count for the group
        $updateGroupQuery = "UPDATE user SET votes = votes + 1 WHERE id = ?";
        $stmt = $conn->prepare($updateGroupQuery);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();

        // Fetch updated voter data and refresh session
        $query = "SELECT * FROM user WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $voter_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $_SESSION['userdata'] = $result->fetch_assoc();

        $conn->commit();
        header("Location: profile.php"); // Redirect to profile after successful vote
        exit();
    } catch (Exception $e) {
        $conn->rollback();
        die("Error during voting: " . $e->getMessage());
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vote for a Party</title>
    <style>
        /* Add your CSS styles here */
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(to bottom, #FF9933, #ffffff 33%, #138808 66%);
            height: 100vh;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .main-content {
            width: 90%;
            max-width: 800px;
            padding: 20px;
            background: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
            text-align: center;
        }

        h1 {
            margin-bottom: 20px;
            color: #333;
        }

        ul {
            list-style-type: none;
            padding: 0;
        }

        li {
            margin: 15px 0;
            padding: 15px;
            background: #e9e9e9;
            border-radius: 8px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        li:hover {
            background: #f7f7f7;
        }

        form {
            display: inline-block;
        }

        button {
            padding: 10px 15px;
            font-size: 1em;
            color: white;
            background: #007bff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s;
        }

        button:hover {
            background: #0056b3;
        }

        button:disabled {
            background: #999;
            cursor: not-allowed;
        }

        .no-groups {
            font-size: 1.2em;
            color: #666;
            margin: 20px 0;
        }

        .back-btn {
            display: inline-block;
            margin-top: 20px;
            padding: 12px 20px;
            background: linear-gradient(45deg, #4CAF50, #45a049);
            color: white;
            text-decoration: none;
            border-radius: 25px;
            font-size: 1.1em;
            transition: background 0.3s ease;
        }

        .back-btn:hover {
            background: linear-gradient(45deg, #45a049, #4CAF50);
        }
    </style>
</head>
<body>
    <div class="main-content">
        <h1>Vote for a Party</h1>
        <?php if ($hasVoted): ?>
            <p class="no-groups">You have already voted. Thank you for participating!</p>
        <?php elseif (!empty($groups)): ?>
            <ul>
                <?php foreach ($groups as $group): ?>
                    <li>
                        <span><strong><?php echo htmlspecialchars($group['name']); ?></strong> - Votes: <?php echo $group['votes']; ?></span>
                        <form method="POST" action="">
                            <input type="hidden" name="user_id" value="<?php echo $group['id']; ?>">
                            <button type="submit">Vote</button>
                        </form>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p class="no-groups">No groups available to vote for.</p>
        <?php endif; ?>
        <a href="page.php" class="back-btn">Back to Main page</a>
    </div>
</body>
</html>
