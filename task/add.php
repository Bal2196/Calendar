<?php
require_once '../php_includes/CalendarController.php';
?>
<!DOCTYPE html>
<html>
<head>
  <title>Calendar</title>
  <meta charset="utf-8">
  <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
<form method="post" action="add.php">
  <input type="date" name="date" value="<?php echo $_SESSION['date']; ?>" disabled>
  <br><br>
  <textarea  rows="4" cols="50" name="task" placeholder="Enter to-do..."></textarea>
  <br><br>
  <input type="submit" name="add_task" value="Create">
  &nbsp;
  <input type="submit" name="cancel" value="Cancel">
</form>
</body>
</html>