<?php
/**
 * This script is to be used to receive a POST with the object information and then either updates, creates or deletes the task object
 */
require( 'task.class.php' );
// Assignment: Implement this script

if ( isset( $_POST[ 'action' ] ) )
{

    $action = $_POST[ 'action' ];

    $task = new Task();

    if ( $action == "save" )
    {
        $task->Save( $_POST[ 'name' ], $_POST[ 'description' ], ( int ) $_POST[ 'taskId' ]  );
    }
    else if ( $action == "delete" )
    {
        $task->Delete( $_POST[ 'id' ] );
    }
    else
    {
        throw new Exception( "Could not perform the requested operation." );
    }
}
else
{
    throw new Exception( "Invalid server request." );
}
