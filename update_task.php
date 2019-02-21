<?php
/**
 * This script is to be used to receive a POST with the object information and then either updates, creates or deletes the task object
 */
require('Task.class.php');
// Assignment: Implement this script

$message = 'You either tried accessing this directly or submitted an invalid action. Please trying saving the form again';
$success = false;

if (isset($_POST)) {

    $action = filter_input(INPUT_POST, 'action', FILTER_SANITIZE_STRING);
    $taskId = filter_input(INPUT_POST, 'task_id', FILTER_SANITIZE_NUMBER_INT);
    $taskClass = new Task($taskId);

    if ($action == 'save') {
        $taskName = filter_input(INPUT_POST, 'task_name', FILTER_SANITIZE_STRING);
        $taskDescription = filter_input(INPUT_POST, 'task_description', FILTER_SANITIZE_STRING);

        $taskClass->setTaskName($taskName);
        $taskClass->setDescription($taskDescription);
        $taskClass->Save();
        $success = true;
        $message = 'Task has been successfully created/updated';
    }

    if ($action == 'delete') {
        $deleted = $taskClass->Delete();
        $message = "Something went wrong, couldn't delete task";
        if ($deleted) {
            $success = true;
            $message = "Task has been successfully deleted";
        }
    }
}

echo json_encode(['message' => $message, 'success' => $success]);
exit;
?>