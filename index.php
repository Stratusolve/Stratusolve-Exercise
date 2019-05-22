<?php
/**
 * Created by PhpStorm.
 * User: johangriesel
 * Date: 13052016
 * Time: 08:48
 * @package    ${NAMESPACE}
 * @subpackage ${NAME}
 * @author     johangriesel <info@stratusolve.com>
 */
?>
<!DOCTYPE html>
<html>
<head>
    <title>Basic Task Manager</title>
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
</head>
<body>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Modal title</h4>
            </div>
            <div class="modal-body">
                <form action="update_task.php" method="post">
                    <div class="row">
                        <div class="col-md-12" style="margin-bottom: 5px;;">
                            <input id="InputTaskName" type="text" placeholder="Task Name" class="form-control">
                        </div>
                        <div class="col-md-12">
                            <textarea id="InputTaskDescription" placeholder="Description" class="form-control"></textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button id="deleteTask" type="button" class="btn btn-danger">Delete Task</button>
                <button id="saveTask" type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>


<div class="container-fluid">
    <div class="row">
        <div class="col-md-3">

        </div>
        <div class="col-md-6">
            <h2 class="page-header">Task List</h2>
            <!-- Button trigger modal -->
            <button id="newTask" type="button" class="btn btn-primary btn-lg" style="width:100%;margin-bottom: 5px;" data-toggle="modal" data-target="#myModal">
                Add Task
            </button>
            <div id="TaskList" class="list-group">
                <!-- Assignment: These are simply dummy tasks to show how it should look and work. You need to dynamically update this list with actual tasks -->
            </div>
        </div>
        <div class="col-md-3">

        </div>
    </div>
</div>
</body>
<script type="text/javascript" src="assets/js/jquery-1.12.3.min.js"></script>
<script type="text/javascript" src="assets/js/bootstrap.min.js"></script>
<script type="text/javascript">
    var currentTaskId = -1;
    $('#myModal').on('show.bs.modal', function (event) {
        var triggerElement = $(event.relatedTarget); // Element that triggered the modal
        var modal = $(this);
        if (triggerElement.attr("id") == 'newTask') {
            modal.find('.modal-title').text('New Task');
            $('#deleteTask').hide();
            setFieldValues();
            currentTaskId = -1;
        } else {
            modal.find('.modal-title').text('Task details');
            $('#deleteTask').show();
            currentTaskId = triggerElement.attr("id");
            var taskNameElement = triggerElement.find('h4');
            var taskDescriptionElement = triggerElement.find('p');

            setFieldValues($(taskNameElement).text(), $(taskDescriptionElement).text());

            console.log('Task ID: '+triggerElement.attr("id"));
        }
    });

    var setFieldValues = function(taskName, taskDescription) {
        if (taskName === undefined) {
            taskName = "";
        }
        if (taskDescription === undefined) {
            taskDescription = "";
        }
        $("#InputTaskName").val(taskName);
        $("#InputTaskDescription").val(taskDescription);
    };

    var handleSubmission = function(path, data) {
        $.post(path, data, function (feedback) {
            var message = feedback.message;
            var messageClass = 'alert alert-danger';
            if (feedback.success) {
                messageClass = 'alert alert-success';
                updateTaskList();
            }

            var messageBox = $('<div id="feedback-message" class="' + messageClass + '">' + message + '</div>');

            $(".modal-body form").prepend(messageBox);
            setTimeout(function() {
                $("#feedback-message").remove();
                setFieldValues();
                $('#myModal').modal('hide');
            }, 3000);

        }, 'json');
    };

    $('#saveTask').click(function() {
        //Assignment: Implement this functionality
        //alert('Save... Id:'+currentTaskId);

        var taskName = $("#InputTaskName").val();
        var taskDescription = $("#InputTaskDescription").val();

        var data = {task_id:currentTaskId, task_name:taskName, task_description:taskDescription, action:'save'};
        handleSubmission('update_task.php', data)
    });

    $('#deleteTask').click(function() {
        //Assignment: Implement this functionality
        //alert('Delete... Id:'+currentTaskId);

        var data = {task_id:currentTaskId, action:'delete'};
        handleSubmission('update_task.php', data);
    });

    function updateTaskList() {
        $.post("list_tasks.php", function( data ) {
            $( "#TaskList" ).html( data );
        });
    }

    updateTaskList();
</script>
</html>