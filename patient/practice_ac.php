<?php
// Assuming you are using POST method to submit the form
$q_score = isset($_POST['quality']) ? $_POST['quality'] : '';
$feedback_txt = isset($_POST['suggestion']) ? $_POST['suggestion'] : '';

// Validate and sanitize user inputs
$q_score = filter_var($q_score, FILTER_SANITIZE_NUMBER_INT);
$feedback_txt = filter_var($feedback_txt, FILTER_SANITIZE_STRING);

// Check if the inputs are not empty
if (!empty($q_score) && !empty($feedback_txt)) {
    // Create a connection to the database
    $conn = mysqli_connect("localhost", "root", "", "edoc");

    // Check the connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Use prepared statement to prevent SQL injection
    $query = "INSERT INTO practice (quality_score, feedback) VALUES (?, ?)";
    $stmt = mysqli_prepare($conn, $query);

    // Bind parameters
    mysqli_stmt_bind_param($stmt, "is", $q_score, $feedback_txt);

    // Execute the statement
    $result = mysqli_stmt_execute($stmt);

    // Check if the query was successful
    if ($result) {
        echo 'Thank you for your feedback. We appreciate it!';
    } else {
        echo 'Something went wrong. Please try again.';
    }

    // Close the statement and connection
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
} else {
    echo 'Invalid input. Please provide both quality and feedback.';
}
?>
