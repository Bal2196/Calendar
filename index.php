<?php
require_once 'php_includes/CalendarController.php';
?>
<!DOCTYPE html>
<html>
<head>
  <title>Calendar</title>
  <meta charset="utf-8">
  <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
<div class="sticky">
<table>
  <tr>
    <td>
    <form method="post" action="php_includes/CalendarController.php">
      <input type="submit" name="prev" value="<?php $calendar->getLastMonth(); ?>">
    </form>
    </td>
    <td>
      <?php
      $calendar->getSelectedMonth();
      echo " " . $calendar->getYear($calendar->selectedDate);
      ?>
    </td>
    <td>
    <form method="post" action="php_includes/CalendarController.php">
      <input type="submit" name="next" value="<?php $calendar->getNextMonth(); ?>">
    </form>
    </td>
  </tr>
</table>
</div>
<div class="seperator"></div>
<table id="calendar">
  <?php for ($i = 1; $i <= $calendar->daysInMonth; $i++) { ?>
  <tr>
    <td>
      <?php echo $i; ?></td>
    <td>
      <?php
      // Store i (day number) with month and year appended to it
      // Which can be obtained from selectedDate without the day
      // e.g. 2019-03- + 13 = 2019-03-13
      $date = $calendar->getSelectedDateNoDay() . $i;
      
      // Check if date is missing a character as dates should be 10 characters long
      if (strlen($date) < 10) {
          // Insert a 0 before the last character of date
          // e.g. 2019-03-1 -> 2019-03-01
          $date = substr_replace($date, 0, 8, 0);
      }
      
      // Check whether there are any tasks
      if ($tasks->num_rows == 0) {
          // Check whether Date is greater than or equal to todayDate
          if ($date >= $calendar->todayDate) {
              // This means the date is not in the past
              // and therefore can include the following add todo button
              ?>
              <form method="post" action="php_includes/CalendarController.php">
                <input type="hidden" name="date" value="<?php echo $date; ?>">
                <input type="submit" name="add" value="Select to add to-dos">
              </form>
              <?php
          } else {
              // Otherwise the date is in the past
              // and therefore todos cannot be added
              ?><p class="small-font">
                <?php echo "Cannot add to-dos for dates in the past"; ?>
              </p><?php
          }
      }
      
      // Booleans used by the following loop
      $populated = false;
      $triggered = false;
      
      // Loop through the tasks array
      foreach ($tasks as $task) {
          // Store task date and truncate the date to just the day
          $task_day = substr($task['date'], 8);
          
          // Check whether i (day number) is equal to the task day number
          if ($i == $task_day) {
              // Echos task
              echo $task['task'];
              // Create edit and delete buttons
              ?>
              <form method="post" action="php_includes/CalendarController.php">
                <input type="hidden" name="id" value="<?php echo $task['id']; ?>">
                <input type="submit" name="edit" value="Edit">
                <input type="submit" name="delete" value="Delete">
              </form>
              <?php
              // Set to true
              $populated = true;
          }
          // Otherwise if not already populated and triggered
          else if (!$populated && !$triggered) {
              // Check whether Date is greater than or equal to todayDate
              if ($date >= $calendar->todayDate) {
                  // This means the date is not in the past
                  // and therefore can include the following add todo button
                  ?>
                  <form method="post" action="php_includes/CalendarController.php">
                    <input type="hidden" name="date" value="<?php echo $date; ?>">
                    <input type="submit" name="add" value="Select to add to-dos">
                  </form>
                  <?php
              } else {
                  // Otherwise the date is in the past
                  // and therefore todos cannot be added
                  ?><p class="small-font">
                    <?php echo "Cannot add to-dos for dates in the past"; ?>
                  </p><?php
              }
              // Set to true as this code block only needs to run once
              $triggered = true;
          }
      }
      ?>
    </td>
  </tr>
  <?php } ?>
</table>
</body>
</html>