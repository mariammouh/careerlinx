<?php
// Start session to access stored verification code
session_start();

// Check if verification code is stored in session
if (!isset($_SESSION['verification_code'])) {
    // Redirect user back to forgot password page if verification code is not set
    header("Location: forgot_password.php");
    exit;
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve user input verification code
    $enteredCode = $_POST['verification_code'];
    
    // Retrieve stored verification code from session
    $storedCode = $_SESSION['verification_code'];

    // Compare entered code with stored code
    if ($enteredCode == $storedCode) {
        // Verification successful, redirect user to password reset page
        header("Location: reset_password.php");
        exit;
    } else {
        // Verification failed, display error message
        $verificationError = "Invalid verification code. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Verification</title>
</head>
<body>

<h2>Verification</h2>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <label for="verification_code">Verification Code:</label><br>
    <input type="text" id="verification_code" name="verification_code" required><br><br>
    <input type="submit" value="Verify">
</form>

<?php
// Display verification error message if verification fails
if (isset($verificationError)) {
    echo '<p style="color: red;">' . $verificationError . '</p>';
}
?>

</body>
</html>
