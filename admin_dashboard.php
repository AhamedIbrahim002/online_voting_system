<?php
session_start();
include('config.php');

// Check if the user is logged in and is an admin
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header('Location: admin_login.php');
    exit();
}

// Handle candidate status update
if (isset($_GET['action']) && isset($_GET['candidate_id'])) {
    $action = $_GET['action'];
    $candidate_id = intval($_GET['candidate_id']);
    
    $status = 'pending';
    if ($action == 'accept') {
        $status = 'accepted';
    } elseif ($action == 'reject') {
        $status = 'rejected';
    }

    $sql_update = "UPDATE candidates SET status = ? WHERE id = ?";
    $stmt_update = $conn->prepare($sql_update);
    if ($stmt_update === false) {
        die("Error preparing statement: " . $conn->error);
    }
    $stmt_update->bind_param('si', $status, $candidate_id);

    if ($stmt_update->execute()) {
        echo "Candidate status updated successfully.";
    } else {
        echo "Error updating candidate status: " . $stmt_update->error;
    }
    $stmt_update->close();
}

// Fetch candidates and their vote counts
$sql_candidates = "
    SELECT c.id, c.name, c.description, c.status, COUNT(v.id) AS vote_count
    FROM candidates c
    LEFT JOIN votes v ON c.id = v.candidate_id
    GROUP BY c.id
";
$result_candidates = $conn->query($sql_candidates);

if ($result_candidates === false) {
    die("Error fetching candidates: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="css/styleadmin.css">

</head>
<body>
<div class="container">
    <h1>Admin Dashboard</h1>
    <p>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</p>

    <h2>Manage Candidates</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Description</th>
                <th>Status</th>
                <th>Votes</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result_candidates->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['id']); ?></td>
                <td><?php echo htmlspecialchars($row['name']); ?></td>
                <td><?php echo htmlspecialchars($row['description']); ?></td>
                <td><?php echo htmlspecialchars($row['status']); ?></td>
                <td><?php echo htmlspecialchars($row['vote_count']); ?></td>
                <td>
                    <?php if ($row['status'] === 'pending'): ?>
                        <a href="?action=accept&candidate_id=<?php echo htmlspecialchars($row['id']); ?>">Accept</a>
                        <a href="?action=reject&candidate_id=<?php echo htmlspecialchars($row['id']); ?>">Reject</a>
                    <?php else: ?>
                        <span>Reviewed</span>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <a href="admin_logout.php">Logout</a>
    <a href="index.html">Back to Home</a>
</div>
</body>
</html>
