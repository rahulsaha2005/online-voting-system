<?php
// Include database connection
include('connect.php'); // Assume your database connection is in this file

// Fetch groups with role = 1 (parties)
$sql = "SELECT name, votes FROM user WHERE role = 1";
$result = mysqli_query($conn, $sql);

// Check if query executed successfully
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registered Groups</title>
    <link rel="stylesheet" href="styles.css"> <!-- Link to external CSS -->
    <style>
        /* General Reset and Box-Sizing */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: linear-gradient(90deg, #ff6347 0%, #ffd700 50%, #32cd32 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }

        /* Centering the content */
        .container {
            width: 80%;
            max-width: 900px;
            padding: 30px;
            background: rgba(255, 255, 255, 0.8);
            border-radius: 12px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(8px);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        /* Hover effects on container */
        .container:hover {
            transform: scale(1.05);
            box-shadow: 0 12px 48px rgba(0, 0, 0, 0.8);
        }

        h1 {
            text-align: center;
            color: #2ecc71;
            font-size: 36px;
            text-transform: uppercase;
            letter-spacing: 3px;
            margin-bottom: 20px;
        }

        /* Style for the table */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
            color: #333;
        }

        table th, table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        table th {
            background-color: #f39c12;
            color: white;
            font-size: 18px;
        }

        table tr:hover {
            background-color: #f0f0f0;
        }

        .scrollable-table {
            max-height: 300px;
            overflow-y: auto;
            padding-right: 10px;
            margin-top: 20px;
        }

        .back-btn {
            margin-top: 30px;
            display: inline-block;
            padding: 12px 20px;
            background-color: #2ecc71;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 18px;
            text-align: center;
        }

        .back-btn:hover {
            background-color: #27ae60;
        }

    </style>
</head>
<body>
    <div class="container">
        <h1>Registered Groups</h1>

        <?php if ($result): ?>
            <?php if (mysqli_num_rows($result) > 0): ?>
                <div class="scrollable-table">
                    <table>
                        <tr>
                            <th>Group Name</th>
                            <th>Votes</th>
                        </tr>
                        <?php while ($row = mysqli_fetch_assoc($result)): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['name']); ?></td>
                                <td><?php echo $row['votes']; ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </table>
                </div>
            <?php else: ?>
                <p>No registered parties found.</p>
            <?php endif; ?>
        <?php else: ?>
            <p>Error in query execution: <?php echo mysqli_error($conn); ?></p>
        <?php endif; ?>

    </div>
</body>
</html>

<?php mysqli_close($conn); ?>
