<?php
/**
 * This script is to be used to receive a POST with the object information and then either updates, creates or deletes the task object
 */
require('task.class.php');
$task = new Task();
$task->TaskName = $_POST['InputTaskName'];
$task->TaskDescription = $_POST['InputTaskDescription'];
if(isset($_POST['InputTaskDescription'])&&isset($_POST['InputTaskName']))
        {
            if(empty($_POST['InputTaskName])||empty($_POST['InputTaskDescription']))
            {
                echo "Fields required";
            }
            else 
            {
                $task->Save();
            }
        }

?>