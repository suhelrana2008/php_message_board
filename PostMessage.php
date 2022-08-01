<!-- Chapter 6 exercise -->
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="message_styles.css" />
	<title>Post Message</title>
</head>	
<body>
	<?php 
		if(isset($_POST['submit'])) {
			$Subject = stripslashes($_POST["subject"]);
			$Name = stripslashes($_POST["name"]);
			$Message = stripslashes($_POST["message"]);

			// Replace any '~' characters with '-' characters
			$Subject = str_replace("~", "-", $Subject);
			$Name = str_replace("~", "-", $Name);
			$Message = str_replace("~", "-", $Message);

			// Create a string out of all the values from the $_POST array
			$MessageRecord = "$Subject~$Name~$Message\n";

			// Start working with file data
			$MessageFile = fopen("MessageBoard/messages.txt", "a");

			// Check to see if the $MessgaeFile is valid
			if($MessageFile == FALSE) {
				echo "<p>There was an error in saving your message!</p>";
			} else {
				fwrite($MessageFile, $MessageRecord);
				fclose($MessageFile);
				echo "<p>Your message has been saved!</p>";
			}
		}
	?>
	<h1>Post New Message</h1>
	<hr />

	<form action="PostMessage.php" method="POST">

		<label style="font-weight: bold" for="sub";>Subject</label>
		<input type="text" name="subject" id="sub" />

		<label style="font-weight: bold" for="nam";>Name: </label>
		<input type="text" name="name" id="nam" />
		<br />
		<br />
		<textarea name="message" rows="6" cols="80"></textarea>
		<br />
		<br />
		<input type="submit" name="submit" value="Post Message" />
		<input type="reset" name="reset" value="Reset Form" />

	</form>
	<br />
	<hr />
	<p><a href="MessageBoard.php">View Messages</a></p>
</body>

</html>