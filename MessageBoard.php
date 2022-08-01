<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="message_styles.css" />
	<title>Message Board</title>
</head>
<body>
	<h1>Message Board</h1>
	<?php
		if(isset($_GET['action'])) {
			if((file_exists("MessageBoard/messages.txt")) && (filesize("MessageBoard/messages.txt") != 0)) {
				// the file exists and it's not empty
				$MessageArray = file("MessageBoard/messages.txt");
				switch ($_GET['action']) {
					case 'Delete First':
						array_shift($MessageArray);
						break;
					case 'Delete Last':
						array_pop($MessageArray);
						break;	
					case 'Delete Message':
						if (isset($_GET['message'])) {
							array_splice($MessageArray, $_GET['message'], 1);						
						}
						break;
					case 'Remove Duplicates':
						$MessageArray = array_unique($MessageArray);
						$MessageArray = array_values($MessageArray);
						break;	
					case 'Sort Ascending':
						sort($MessageArray);
						break;	
					case 'Sort Descending':
						rsort($MessageArray);
						break;	
						
				}// end of switch statement
				if (count($MessageArray) > 0) {
					$NewMessages = implode($MessageArray);
					$MessageStore = fopen("MessageBoard/messages.txt", "w");
					if ($MessageStore === FALSE) {
						echo "<p>There was an error updating the message file!</p>\n";		
					} else {
						fwrite($MessageStore, $NewMessages);
						fclose($MessageStore);
					}
				} else {	
					unlink("MessageBoard/messages.txt");
				} // end of else					
			}
		}
		// this code displays the message board on the page
		if((!file_exists("MessageBoard/messages.txt")) || (filesize("MessageBoard/messages.txt") == 0)) {
			echo "<p>There are no messages posted!</p>\n";
		} else {

			$MessageArray = file("MessageBoard/messages.txt");
			echo "<table style='background-color: lightgray' border='1' width='100%' />\n";
			$count = count($MessageArray);
			for ($i=0; $i < $count; $i++) { 
				$CurrMsg =  explode("~", $MessageArray[$i]);
				echo "<tr>\n";
				echo "<th width='5%'>" . ($i + 1) .   "</th>\n";
				echo "<td width='85%'><span style='font-weight: bold'>Subject:</span> " . htmlentities($CurrMsg[0]) . "<br />\n";
				echo "<span style='font-weight: bold'>Name:</span> " . htmlentities($CurrMsg[1]) . "<br />\n";
				echo "<span style='text-decoration:underline; font-weight:bold;'>Message</span><br />\n" . htmlentities($CurrMsg[2]) . "</td>\n";
				echo "<td width='10%' style='text-align: center'><a class='delete' href='MessageBoard.php?action=Delete%20Message&message=$i'>Delete This Message</a></td>\n";
				echo "</tr>\n";
			} // end of for loop
			echo "</table>\n";
		}
	?>
	<p><a href="PostMessage.php">Post New Messsage</a></p>
	<p><a href="MessageBoard.php?action=Sort%20Ascending">Sort Subjects A-Z</a></p>
	<p><a href="MessageBoard.php?action=Sort%20Descending">Sort Subjects Z-A</a></p>
	<p><a href="MessageBoard.php?action=Remove%20Duplicates">Remove Duplicate Messages</a></p>
	<p><a href="MessageBoard.php?action=Delete%20First">Delete First Message</a></p> <!--here ? will append date/link with action as variable will do delete but can't have space so %20 will fill the gap in the URL but we could write like DeleteFirst in switch statement too -->
	<p><a href="MessageBoard.php?action=Delete%20Last">Delete Last Massage</a></p>

</body>
</html>