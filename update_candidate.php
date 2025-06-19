<?php
session_start();
include('config.php');

// Check if the user is logged in and is a candidate
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'candidate') {
    header('Location: index.html');
    exit();
}

// Handle candidate information update
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];

    $sql_update = "UPDATE candidates SET name = ?, description = ? WHERE aadhar_id = ?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param('sss', $name, $description, $_SESSION['aadhar_id']);

    if ($stmt_update->execute()) {
        echo "<p>Candidate information updated successfully!</p>";
    } else {
        echo "<p>Error updating information: " . $stmt_update->error . "</p>";
    }
    $stmt_update->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Candidate</title>
    <link rel="stylesheet" href="css/style.css">

</head>
<body>
<div class="container">
    <h1>Update Your Information</h1>
    <form method="POST" action="">
        <label for="name">Name:</label>
        <input type="text" name="name" id="name" required>
        <label for="description">Description:</label>
        <textarea name="description" id="description" required></textarea>
        <button type="submit">Update Information</button>
    </form>
    <a href="candidate_dashboard.php">Back to Candidate Dashboard</a>
</div>
</body>
</html>
