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
            $this->TaskDataSource = json_decode($this->TaskDataSource, true); // Should decode to an array of Task objects
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
        $this->setTaskId($this->getUniqueId());
        $this->setTaskName('New Task');
        $this->setDescription('New Description');
    }

    protected function getUniqueId() {
        // Assignment: Code to get new unique ID
        if (!empty($this->TaskDataSource)) {
            $highest = 0;
            foreach($this->TaskDataSource as $dataSource) {
                $highest = max($highest, $dataSource['TaskId']);
            }
            return ++$highest;
        }
        return 1; // Placeholder return for now
    }

    protected function LoadFromId($Id = null) {
        $Id = (int) $Id;
        if ($Id && !empty($this->TaskDataSource)) {
            foreach($this->TaskDataSource as $dataSource) {
                if ($Id == $dataSource['TaskId']) {
                    $this->setTaskId($dataSource['TaskId']);
                    $this->setTaskName($dataSource['TaskName']);
                    $this->setDescription($dataSource['TaskDescription']);

                    return true;
                }
            }
        }

        return null;
    }

    public function Save() {
        //Assignment: Code to save task here
        $key = $this->findArrayKey();
        if ($key === -1) {
            $currentMaxKey = max(array_keys($this->TaskDataSource));
            $key = $currentMaxKey == 0 ?: $currentMaxKey + 1;
        }
        $this->TaskDataSource[$key]  = [
            'TaskId'=>$this->getTaskId(),
            'TaskName' =>$this->getTaskName(),
            'TaskDescription' => $this->getDescription(),
        ];

        file_put_contents('Task_Data.txt', json_encode($this->TaskDataSource));
    }

    public function setTaskId($taskId) {
        $this->TaskId = $taskId;
    }

    public function setTaskName($taskName) {
        $this->TaskName = $taskName;
    }

    public function setDescription($description) {
        $this->TaskDescription = $description;
    }

    public function getTaskId() {
        return $this->TaskId;
    }

    public function getTaskName() {
        return $this->TaskName;
    }

    public function getDescription() {
        return $this->TaskDescription;
    }

    public function findArrayKey() {
        $taskKey = -1;
        if (!is_null($this->TaskId) && $this->TaskId > -1) {
            foreach ($this->TaskDataSource as $key=>$dataSource) {
                if ($this->TaskId == $dataSource['TaskId']) {
                    $taskKey = $key;
                    break;
                }
            }
        }
        return (int)$taskKey;
    }

    public function Delete() {
        //Assignment: Code to delete task here
        $deleted = false;
        $key = $this->findArrayKey();
        if ($key > -1) {
            unset($this->TaskDataSource[$key]);
            file_put_contents('Task_Data.txt', json_encode($this->TaskDataSource));
            $deleted = true;
        }
        return $deleted;
    }
}
?>