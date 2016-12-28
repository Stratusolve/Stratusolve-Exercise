<?php
/**
 * This script is to be used to receive
 * a POST with the object information and then either updates,
 * creates or deletes the task object
 */
require('Task.class.php');
// Assignment: Implement this script
$tas = new Task();
if(isset($_POST['mysave'])){
    if($_POST['mysave']=="savetask"){
if(isset($_POST['TaskName'])||isset($_POST['TaskDescription'])){
    $tas->setTaskName($_POST['TaskName']);
    $tas->setTaskDescription($_POST['TaskDescription']);
    $tas->Save();
    echo $tas->getTaskName();
}
    }
}

if(isset($_POST['mydelete'])){
    if($_POST['mydelete']=="deletetask"){
if(isset($_POST['TaskName'])||isset($_POST['TaskDescription'])){
    $tas->setTaskName($_POST['TaskName']);
    $tas->setTaskDescription($_POST['TaskDescription']);
    $tas->Delete();
    echo $tas->getTaskName();
}
    }
}


?>