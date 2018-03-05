<?php
/**
 * This class handles the modification of a task object
 */
class Task {
    public $TaskId;
    public $TaskName;
    public $TaskDescription;
    protected $TaskDataSource;
    public function __construct($Id = null) {
        $this->TaskDataSource = file_get_contents('Task_Data.txt');
        if (strlen($this->TaskDataSource) > 0)
            $this->TaskDataSource = json_decode($this->TaskDataSource); // Should decode to an array of Task objects
        else
            $this->TaskDataSource = array(); // If it does not, then the data source is assumed to be empty and we create an empty array

        if (!$this->TaskDataSource)
            $this->TaskDataSource = array(); // If it does not, then the data source is assumed to be empty and we create an empty array
        if (!$this->LoadFromId($Id))
            $this->Create();
    }
    protected function Create() {
        // This function needs to generate a new unique ID for the task
        // Assignment: Generate unique id for the new task
        $this->TaskId = $this->getUniqueId();
        $this->TaskName = 'New Task';
        $this->TaskDescription = 'New Description';
    }
    protected function getUniqueId() {

        // Assignment: Code to get new unique ID
        $taskList = $this->getTaskList();
        $taskListIds = array_column( $taskList, 'TaskId' );
        $uniqueId = $taskListIds[ count( $taskListIds ) - 1 ] + 1;
        return $uniqueId;
    }
    protected function LoadFromId($Id = null) {
        if ($Id) {
            // Assignment: Code to load details here...
        } else
            return null;
    }

    public function Save( $task, $description, $id = -1 ) {

        //Assignment: Code to save task here
        $taskList = $this->getTaskList();

        if ( $id == -1 )
        {
            $newTask = [
                "TaskId"=> $this->getUniqueId(),
                "TaskName" => $task,
                "TaskDescription" => $description
            ];
            array_push( $taskList, $newTask );
        }
        else
        {
            $taskListIds = array_column( $taskList, 'TaskId' );
            $search = array_search( $id, $taskListIds );
            $taskList[ $search ] = [
                "TaskId"=> $id,
                "TaskName" => $task,
                "TaskDescription" => $description
            ];
        }

        $newTaskList = json_encode( array_values( $taskList ) );

        file_put_contents( 'Task_Data.txt', $newTaskList );
    }
    public function Delete( $id ) {

        //Assignment: Code to delete task here
        $taskList = $this->getTaskList();
        $taskListIds = array_column( $taskList, 'TaskId' );
        $search = array_search( $id, $taskListIds );
        unset( $taskList[ $search ] );
        $newTaskList = json_encode( array_values( $taskList ) );
        file_put_contents( 'Task_Data.txt', $newTaskList );
    }

    // private function get task list
    private function getTaskList() {
        $taskList = file_get_contents('Task_Data.txt');
        return json_decode( $taskList, true );
    }
}
?>