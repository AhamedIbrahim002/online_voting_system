<?php
session_start();
include('config.php');

// Check if the user is logged in and is an admin
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header('Location: index.html');
    exit();
}

// Handle candidate status update
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_status'])) {
    $candidate_id = intval($_POST['candidate_id']);
    $status = $_POST['status'];

    $sql_update = "UPDATE candidates SET status = ? WHERE id = ?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param('si', $status, $candidate_id);

    if ($stmt_update->execute()) {
        echo "<p>Candidate status updated successfully!</p>";
    } else {
        echo "<p>Error updating status: " . $stmt_update->error . "</p>";
    }
    $stmt_update->close();
}

// Fetch all candidates
$sql_candidates = "SELECT * FROM candidates";
$result_candidates = $conn->query($sql_candidates);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Candidates</title>
    <link rel="stylesheet" href="css/style.css">

</head>
<body>
<div class="container">
    <h1>Manage Candidates</h1>

    <h2>Update Candidate Status</h2>
    <form method="POST" action="">
        <label for="candidate_id">Select Candidate:</label>
        <select name="candidate_id" id="candidate_id" required>
            <?php while ($row = $result_candidates->fetch_assoc()): ?>
                <option value="<?php echo htmlspecialchars($row['id']); ?>">
                    <?php echo htmlspecialchars($row['name']); ?>
                </option>
            <?php endwhile; ?>
        </select>
        <label for="status">Select Status:</label>
        <select name="status" id="status" required>
            <option value="pending">Pending</option>
            <option value="accepted">Accepted</option>
            <option value="rejected">Rejected</option>
        </select>
        <button type="submit" name="update_status">Update Status</button>
    </form>

    <a href="admin_dashboard.php">Back to Admin Dashboard</a>
</div>
</body>
</html>
