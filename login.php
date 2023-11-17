<?php

// Initialize a variable to track if the login attempt is invalid
$is_invalid = false;

// Check if the form has been submitted using POST method
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    // Require the database connection file
    $mysqli = require __DIR__ . "/database.php";
    
    // Create an SQL query to check if the provided email exists in the database
    $sql = sprintf("SELECT * FROM user
                    WHERE email = '%s'",
                   $mysqli->real_escape_string($_POST["email"]));
    
    // Execute the SQL query and store the result in $result
    $result = $mysqli->query($sql);
    
    // Fetch the user data as an associative array from the query result
    $user = $result->fetch_assoc();
    
    // Check if a user with the provided email exists
    if ($user) {
        
        // Verify the provided password against the hashed password stored in the database
        if (password_verify($_POST["password"], $user["password_hash"])) {
            
            // Start a new session for the user
            session_start();
            
            // Regenerate the session ID to enhance security
            session_regenerate_id();
            
            // Store the user ID in the session variable for later use
            $_SESSION["user_id"] = $user["id"];
            
            // Redirect the user to the index.php page after successful login
            header("Location: index.php");
            exit;
          
        } else {
            // Set the $is_invalid flag to true if the provided password is incorrect
            $is_invalid = true;
        }
    } else {
        // Set the $is_invalid flag to true if no user with the provided email is found
        $is_invalid = true;
    }
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    
    <h1 id="signup">Login</h1>
    
    <?php if ($is_invalid): ?>
        <!-- Display an error message if the login attempt is invalid -->
        <em>Invalid login</em>
    <?php endif; ?>
    
    <!-- Create a login form -->
    <form method="post">
        <label for="email">Email</label>
        <input type="email" name="email" id="email"
               value="<?= htmlspecialchars($_POST["email"] ?? "") ?>">
        
        <label for="password">Password</label>
        <input type="password" name="password" id="password">
        
        <button>Log in</button>
    </form>
    
</body>
</html>
