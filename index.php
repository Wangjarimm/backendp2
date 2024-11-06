<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Include database connection
include_once 'config/database.php';

// Autoloading classes for models
spl_autoload_register(function ($class_name) {
    // Convert the class name to the expected file path
    $file = 'models/' . $class_name . '.php';

    // Check if the file exists before including it
    if (file_exists($file)) {
        include $file;
    } else {
        // Optional: handle the error if the file does not exist
        echo "Error: Unable to load class '$class_name'. File '$file' not found.";
    }
});

// Include routes
include_once 'routes/api.php';

// Optionally, you can include other files or configurations here
// e.g., session_start(); for user authentication

?>
