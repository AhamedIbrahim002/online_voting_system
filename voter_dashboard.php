<?php
session_start();
include('config.php');

// Check if the user is logged in and is a voter
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'voter') {
    header('Location: index.html');
    exit();
}

// Handle voting
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $candidate_id = intval($_POST['candidate_id']);
    $user_id = $_SESSION['user_id'];

    // Check if the user has already voted
    $sql_check = "SELECT * FROM votes WHERE user_id = ?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param('i', $user_id);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();
    
    if ($result_check->num_rows > 0) {
        echo "<p>You have already voted.</p>";
    } else {
        // Record the vote
        $sql_vote = "INSERT INTO votes (user_id, candidate_id) VALUES (?, ?)";
        $stmt_vote = $conn->prepare($sql_vote);
        $stmt_vote->bind_param('ii', $user_id, $candidate_id);

        if ($stmt_vote->execute()) {
            header('Location: thank_you.php');
            exit();
        } else {
            echo "<p>Error voting: " . $stmt_vote->error . "</p>";
        }
        $stmt_vote->close();
    }
    $stmt_check->close();
}

// Fetch all candidates
$sql_candidates = "SELECT * FROM candidates WHERE status = 'accepted'";
$result_candidates = $conn->query($sql_candidates);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voter Dashboard</title>
    <link rel="stylesheet" href="css/style.css">

</head>
<body>
<div class="container">
    <h1>Voter Dashboard</h1>
    <p>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</p>

    <h2>Vote Now</h2>
    <form method="POST" action="">
        <label for="candidate_id">Select Candidate:</label>
        <select name="candidate_id" id="candidate_id" required>
            <?php while ($row = $result_candidates->fetch_assoc()): ?>
                <option value="<?php echo htmlspecialchars($row['id']); ?>">
                    <?php echo htmlspecialchars($row['name']); ?>
                </option>
            <?php endwhile; ?>
        </select>
        <button type="submit">Submit Vote</button>
    </form>

    <a href="index.html">Back to Home</a>
</div>
</body>
</html>
