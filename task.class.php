<?php
/**
 * This class handles the modification of a task object
 */
class Task {
    //private fields
    private $TaskId;
    private $TaskName;
    private $TaskDescription;
    protected $TaskDataSource;
    //Constructor to provide default values
    public function __construct($Id = null) {
        $this->TaskDataSource = file_get_contents('Task_Data.txt');
        if (strlen($this->TaskDataSource) > 0)
            $this->TaskDataSource = json_decode($this->TaskDataSource); // Should decode to an array of Task objects
        else
            $this->TaskDataSource = array(); // If it does not, then the data source is assumed to be empty and we create an empty array

        if (!$this->TaskDataSource) 
            $this->TaskDataSource = array(); // If it does not, then the data source is assumed to be empty and we create an empty array
        if ($Id) {
            // This is an existing task
            $this->LoadFromId($Id);
        } else {
            // This is a new task
            $this->Create();
        }
    }
    protected function Create() {
        // This function needs to generate a new unique ID for the task
        $this->setTaskId();
        //$this->TaskName = 'New Task';
        //$this->TaskDescription = 'New Description';
        $this->setTaskName();
        $this->setTaskDescription();
    }
    //functions to get task properties(Data Encapsulation)
    public function getTaskName(){
        return $this->TaskName;
    }
    public function getTaskDescription(){
        return $this->TaskDescription;
    }
    public function getTaskId(){
        return $this->TaskId;
    }
    //functions to set tast properties(Data encapsulation)
    public function setTaskName($name = "New Task"){
        $this->TaskName = $name;
    }
    public function setTaskId(){
        $this->TaskId = $this->getUniqueId();
    }
    public function setTaskDescription($description = "New Description"){
        $this->TaskDescription = $description;
    }
    
    protected function getUniqueId() {
        // Assignment: Code to get new unique ID
            $arr_data = array();
            $file_data = file_get_contents("Task_Data.txt");
            $arr_data = json_decode($file_data,true);
            $arr_id = array();
            //Initialise counter variable
            $i = 0;
            //Put all ids in an array and assign new Id to the number next to the highest value in the array
            foreach($arr_data as $value){
                $arr_id[$i] = $value["TaskId"];
                $i++;
                }
                sort($arr_id);
                return ($arr_id[count($arr_id)-1]+1);
    }
    protected function LoadFromId($Id = null) {
        if ($Id) {
            // Assignment: Code to load details here...
            //Create an empty array
            $arr_data = array();
            //load all file contents
            $file_data = file_get_contents("Task_Data.txt");
            //Decode data and put it into associative array
            $arr_data = json_decode($file_data,true);
            foreach($arr_data as $value){
                if($Id==$value["TaskId"]){
                    $this->TaskId = $value["TaskId"];
                    $this->setTaskName($value["TaskName"]);
                    $this->setTaskDescription($value["TaskDescription"]);
                    }
            }       
        } else{
          return null;
        }
    }

    public function Save() {
        //Assignment: Code to save task here
        $my_data = array("TaskId"=>$this->getTaskId(),"TaskName"=>$this->getTaskName(),"TaskDescription"=>$this->getTaskDescription());
        //append data to the end of file data
        $this->TaskDataSource[] = $my_data;
        file_put_contents("Task_Data.txt",json_encode($this->TaskDataSource,JSON_PRETTY_PRINT));
    }
    public function Delete() {
        //Assignment: Code to delete task here
        //Create an empty array
        $arr_data = array();
       //Read all file contents
       $file_data = file_get_contents("Task_Data.txt");
       //Decode data and put it into associative array
       $arr_data = json_decode($file_data,true);
       //Declare and initialize a counter variable
       $i = 0;
       foreach($arr_data as $key=>$value){
          if(($this->TaskName==$value["TaskName"])&&($this->TaskDescription==$value["TaskDescription"])){
              unset($arr_data[$i]);
          }
          $i++;
        }
      $arr_data = array_values($arr_data);//re-index the array after deletion
      file_put_contents("Task_Data.txt",json_encode($arr_data,JSON_PRETTY_PRINT));
    }
}
?>