<?php
class AjaxDataModifier
{
    public $option;
    public $row;
    public $dbfile;
    public $db;
    public $array;
    public $person;
    public function __set($atribute, $value)
    {
        $this->$atribute = $value;
    }
    
    public function run()
    {
        //odczyt z pliku
        $this->ReadFile($this->db);
        //modyfikacja danych
        @$this->UpdateArray($this->array);
        //selekcja funkcji
        if($this->option == 'delete'){
            $this->UserDelete($this->array, $this->row);
        }else if($this->option == 'add'){
            $this->UserAdd($this->array, $this->person);
        }else if($this->option == 'edit'){
            //$this->UserEdit();
        }
        //zapis do pliku
        @$this->SaveFile('test.csv', $this->array);
    }
    
    public function ReadFile(&$x)
    {
        $x = array();
        $file = fopen($this->dbfile,"r");
        while (($data = fgetcsv($file, 1000, ";")) !== FALSE)  {
          $x[] = $data;
        }
        fclose ($file);
        return $x;
    }
    public function UpdateArray(&$x)
    {
        $x = array();
        for($i=0;$i<=count($this->db)-1;$i++)
        {
            $max = count($this->db[$i])-1;
            for($j=0;$j<=count($this->db[$i])-1;$j++)
            {
               if($this->db[$i][$j] !== $this->db[$i][$max])
                {
                    $x[$i] .= $this->db[$i][$j].';';
                }
                else
                {
                    $x[$i] .= $this->db[$i][$j];
                }
            }
        }
    }
    public function UserAdd(&$data, $person)
    {
        $last = count($data);
        $data[$last] = $last.';'.$person[0].';'.$person[1].';'.$person[2];
        echo $data[$last];
    }
    public function UserDelete(&$data, $row)
    {
        $i=0;
        foreach($data as $key => $line)
        {
            if($row != $key)
            {
                $data[$i] = $line;
                echo $data[$i].'<br />';
                $i++;
            }
        }
    }
    public function UserEdit(&$data, $row)
    {
        
    }
    public function SaveFile($file, $data)
    {
        $fp = fopen($file, "w");
        $last = count($data) - 1;
        $i=0;
        foreach($data as $row)
        {
            if($data[$i] != $data[$last]){
            $write = fputs($fp, $row."\n");
            }else{
                $write = fputs($fp, $row);
            }
            $i++;
        }
        fclose($fp);
    }
}


$ajax = new AjaxDataModifier;
if(isset($_POST['option'])){
    $ajax->option = $_POST['option'];
}

if($_POST['option'] == 'delete')
{
    $ajax->row = $_POST['row'];
}
else if($_POST['option'] == 'add')
{
    $ajax->option = 'add';
    $ajax->person = array(ucfirst(strtolower($_POST['name'])),ucfirst(strtolower($_POST['lastname'])),$_POST['pesel']);
}
else if($_POST['option'] == 'edit')
{
    $ajax->row = $_POST['row'];
array(ucfirst(strtolower($_POST['name'])),ucfirst(strtolower($_POST['lastname'])),$_POST['pesel']);
}
else
{
    echo 'Błąd Krytyczny';
}
$ajax->dbfile = '../database.csv';
$ajax->run();
?>
