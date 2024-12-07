<?php
		error_reporting(E_ALL);
		ini_set("display_errors", 1);
	
		// servername => localhost now rds endpoint
		// username => root now your db username 
		// password => empty now your oen password
		// database name => Your database name
		$conn = mysqli_connect('localhost', 'root', 'root', 'bow_hotel');
		
		// Check connection
		if($conn === false){
			die("ERROR: Could not connect. "
				. mysqli_connect_error());
		}
		
		// Taking all 5 values from the form data(input)
    // Ensure the form is submitted via POST
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Get input data from the form
        $name = $_POST['name'];
        $email = $_POST['email'];
        $subject = $_POST['subject'];
        $message = $_POST['message'];

        // Basic validation (you can expand on this as needed)
        if (empty($name) || empty($email) || empty($subject) || empty($message)) {
            echo "All fields are required.";
            exit;
        }

        // Validate email format
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "Invalid email format.";
            exit;
        }

        // Prepared statement to insert user data into the database
        $stmt = $conn->prepare("INSERT INTO contact (cname, cemail, csubject, cmessage) VALUES (?, ?, ?, ?)");
        
        // Bind the parameters ('ssss' means four strings)
        $stmt->bind_param('ssss', $name, $email, $subject, $message);

        // Execute the query
        if ($stmt->execute()) {
            echo "<h3>Data stored in the Bow hotel database successfully.</h3>";
            echo nl2br("\n$name\n$email\n$subject\n$message");
        } else {
            echo "ERROR: Could not execute query: " . $stmt->error;
        }

        // Close statement and connection
        $stmt->close();
        mysqli_close($conn);
    }
?>