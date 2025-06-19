<?php
session_start();
include('config.php');

// Handle form submission for candidate registration
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $aadhar_id = $_POST['aadhar_id'];
    $college_reg_no = $_POST['college_reg_no'];
    $student_id = $_POST['student_id'];

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert into `users` table
    $sql_user = "INSERT INTO users (username, password, role, aadhar_id, college_reg_no, student_id) VALUES (?, ?, 'candidate', ?, ?, ?)";
    $stmt_user = $conn->prepare($sql_user);
    $stmt_user->bind_param('sssss', $username, $hashed_password, $aadhar_id, $college_reg_no, $student_id);

    if ($stmt_user->execute()) {
        $user_id = $stmt_user->insert_id;

        // Insert into `candidates` table
        $sql_candidate = "INSERT INTO candidates (id, name, aadhar_id, college_reg_no) VALUES (?, ?, ?, ?)";
        $stmt_candidate = $conn->prepare($sql_candidate);
        $stmt_candidate->bind_param('isss', $user_id, $username, $aadhar_id, $college_reg_no);

        if ($stmt_candidate->execute()) {
            echo "Candidate registered successfully!";
        } else {
            echo "Error: " . $stmt_candidate->error;
        }
        $stmt_candidate->close();
    } else {
        echo "Error: " . $stmt_user->error;
    }
    $stmt_user->close();
}

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register as Candidate</title>
    <link rel="stylesheet" href="css/style.css">

</head>
<body>
<div class="container">
    <h1>Register as Candidate</h1>
    <form method="POST" action="">
        <label for="username">Username:</label>
        <input type="text" name="username" id="username" required>
        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required>
        <label for="aadhar_id">Aadhar ID:</label>
        <input type="text" name="aadhar_id" id="aadhar_id" required>
        <label for="college_reg_no">College Registration Number:</label>
        <input type="text" name="college_reg_no" id="college_reg_no" required>
        <label for="student_id">Student ID:</label>
        <input type="text" name="student_id" id="student_id" required>
        <button type="submit">Register</button>
    </form>
    <a href="index.html">Back to Home</a>
</div>
</body>
</html>
