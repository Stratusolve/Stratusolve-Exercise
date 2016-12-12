<?php
/**
 * This class handles the modification of a task object
 */
class Task {
    public $TaskId;
    public $TaskName;
    public $TaskDescription;
    public  $fileName = "testTask.txt";
    public function __construct($Id = null) {
        if ($Id) {
            // This is an existing task
            $this->LoadFromId($Id);
        } else {
            // This is a new task
            $this->Create();
        }
    }
    protected function Create() {
        $this->TaskId = uniqid();
        $this->TaskName = '';
        $this->TaskDescription = '';
    }
    protected function LoadFromId($Id = null) {
        if ($Id) {
            // Assignment: Code to load details here...
            //Load file data
            $fileData = file_get_contents($this->fileName);
            //put file data into array
            $jsonData = json_decode($fileData,true);
            foreach($jsonData as $value)
            {
                if(!is_array($value))
                {
                    
                }
                else
                {
                    foreach($value as $val)
                    {
                        if($Id == $value["id"])
                        {
                        $this->TaskName = $value["name"];
                        $this->TaskDescription = $value["description"];
                        }
                    }
                }
            }
            
        } else
            return null;
    }

    public function Save()
    {
                $data = array('id'=>$this->TaskId,'name'=>$this->TaskName,'description'=>$this->TaskDescription);
                $arr_data = array();
                $file_data = file_get_contents($this->fileName);
                $arr_data = json_decode($file_data,true);
                $arr_data[] = $data;
                $jsonMobiles = json_encode($arr_data,JSON_PRETTY_PRINT);
                if(file_put_contents($this->fileName,$jsonMobiles))
                {
                    echo "Success";
                }
                else
                {
                    echo "Error";
                }
    }
    public function Delete()
    {
        //Load file data
            $fileData = file_get_contents($this->fileName);
            //put file data into array
            $jsonData = json_decode($fileData,true);
            foreach($jsonData as $value)
            {
                if(!is_array($value))
                {
                    
                }
                else
                {
                    foreach($value as &$val)
                    {
                        if($this->TaskName == $value["name"])
                        {
                        unset($val);
                        $jsonEncode = json_encode($jsonData,JSON_PRETTY_PRINT);
                        file_put_contents($this->fileName,$jsonEncode);
                        }
                    }
                }
            }
            
    }
}
?>