<?php
/**
 * This script is to be used to receive a POST with the object information and then either updates, creates or deletes the task object
 */
require('task.class.php');
$task = new Task();
$task->TaskName = $_POST['name'];
$task->TaskDescription = $_POST['description'];
$task->Save();
?>