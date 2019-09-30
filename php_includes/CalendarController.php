<?php
require_once 'db_connect.php';
require_once 'Calendar.php';

// Create Calendar object
$calendar = new Calendar;

// Store selectedDate without the day
// and append the % wildcard used for the following query
// e.g. 2019-03-%
$tmp = $calendar->getSelectedDateNoDay() . "%";

// Get all tasks from the database with the currently presented month
$query = "SELECT * FROM tasks WHERE date LIKE '$tmp' ORDER BY date";
// Store the results in the tasks array
$tasks = mysqli_query($db_connect, $query);

// Create task
function add_task($conn, $task) {
    // Insert new task into the database
    $query = "INSERT INTO tasks VALUES(NULL, '$task', '$_SESSION[date]')";
    $result = mysqli_query($conn, $query);
    
    // Return to the homepage
    header("location: ../index.php");
}

// Update task
function edit_task($conn) {
    // Update the task with the corresponding id
    $query = "UPDATE tasks SET task='$_POST[task]' WHERE id='$_SESSION[id]'";
    $result = mysqli_query($conn, $query);
    
    // Return to the homepage
    header("location: ../index.php");
}

// Delete task
function remove_task($conn) {
    // Delete the task with the corresponding id
    $query = "DELETE FROM tasks WHERE id='$_POST[id]'";
    $result = mysqli_query($conn, $query);
    
    // Return to the homepage
    header("location: ../index.php");
}

// Upon selecting prev
if (isset($_POST['prev'])) {
    // Subtracts a month
    $calendar->setSelectedDate("-1 month");
    
    // Return to the homepage
    header("location: ../index.php");
}

// Upon selecting next
if (isset($_POST['next'])) {
    // Adds a month
    $calendar->setSelectedDate("+1 month");
    
    // Return to the homepage
    header("location: ../index.php");
}

// Upon selecting add
if (isset($_POST['add'])) {
    // Retain date as required for the add form
    $_SESSION['date'] = $_POST['date'];
    // Send to add page
    header("location: ../task/add.php");
}

// Upon selecting edit
if (isset($_POST['edit'])) {
    // Get the task with the corresponding id of the task to be edited
    $query = "SELECT * FROM tasks WHERE id='$_POST[id]'";
    $result = mysqli_query($db_connect, $query);
    $row = mysqli_fetch_array($result);
    
    // Retain the task as required for the edit form
    $_SESSION['id'] = $row['id'];
    $_SESSION['task'] = $row['task'];
    $_SESSION['date'] = $row['date'];
    
    // Send to edit page
    header("location: ../task/edit.php");
}

// Upon selecting delete
if (isset($_POST['delete'])) {
    remove_task($db_connect);
}

// Upon submitting the add form
if (isset($_POST['add_task'])) {
    add_task($db_connect, $_POST['task']);
}

// Upon submitting the edit form
if (isset($_POST['edit_task'])) {
    edit_task($db_connect, $_POST['task']);
}

// Upon selecting cancel
if (isset($_POST['cancel'])) {
    // Return to the homepage
    header("location: ../index.php");
}
