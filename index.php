<?php

// Start the session to access session variables
session_start();

// Check if the "user_id" session variable is set, indicating that the user is logged in
if (isset($_SESSION["user_id"])) {
    
    // Require the database connection file
    $mysqli = require __DIR__ . "/database.php";
    
    // SQL query to retrieve user data based on the user ID stored in the session
    $sql = "SELECT * FROM user
            WHERE id = {$_SESSION["user_id"]}";
            
    // Execute the SQL query and store the result in $result
    $result = $mysqli->query($sql);
    
    // Fetch the user data as an associative array from the query result
    $user = $result->fetch_assoc();
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Home</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
</head>
<body>
    
    <h1>Home</h1>
    
    <?php if (isset($user)): ?>
        <!-- If the user is logged in, display a personalized greeting -->
        <p>Hello <?= htmlspecialchars($user["name"]) ?></p>
        
        <!-- Provide a link to log out (logout.php) -->
        <p><a href="logout.php">Log out</a></p>
        
    <?php else: ?>
        <!-- If the user is not logged in, provide options to log in or sign up -->
        <p><a href="login.php">Log in</a> or <a href="sign_up.html">sign up</a></p>
        
    <?php endif; ?>
    
</body>
</html>
