<?php
class WebApp
{
    public $search;
    public $database;
    public $db;
    public $dbline;
    public function __set($atribute, $value)
    {
        $this->$atribute = $value;
    }
    public function Show()
    {
        $this->ShowHead();
        $this->ShowContent();
        $this->SearchBar();
        $this->FileToArray($this->db);
        @$this->LineArray($this->dbline);
        $this->ShowTable();
        $this->ClosePage();
    }
    public function ShowHead()
    {
        echo '
        <!DOCTYPE html>
        <html><head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/bootstrap-theme.min.css">
        <link rel="stylesheet" href="css/style.css">
        </head><body><div class="container">
        ';
    }
    public function ShowContent()
    {
        if(isset($this->search))
        {
            echo 'Wartość wyszukiwana: '.$this->search;
        }
    }
    public function SearchBar()
    {
        echo '<div class="col-xs-12 col-sm-4">
                <h3 class="h3">Wyszukiwanie</h3>
                <form action="index.php" method="post">
                    <div class="input-group">
                       <input type="text" name="search" placeholder="Wpisz tekst..." class="form-control">
                       <span class="input-group-btn">
                            <button class="btn btn-default" type="submit"><span class="glyphicon glyphicon-search"></span></button>
                       </span>
                    </div>
                </form>
                <br /><br />
                <h3 class="h3">Dodaj użytkownika</h2>
                <div id="addform">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Imie</label>
                    <input type="text" class="form-control" id="name" placeholder="Wpisz tekst...">
                    <label for="exampleInputEmail1">Nazwisko</label>
                    <input type="text" class="form-control" id="lastname" placeholder="Wpisz tekst...">
                    <label for="exampleInputEmail1">Pesel</label>
                    <input type="text" class="form-control" id="pesel" placeholder="Wpisz tekst..."><br />
                    <button class="btn btn-primary" id="adduser">Dodaj osobę <span class="glyphicon glyphicon-plus"></span></button>
                  </div>
                </form>
                </div>
            </div>';
    }
    public function FileToArray(&$x)
    {
        ini_set('auto_detect_line_endings',TRUE);
        $handle = fopen($this->database,'r');
        //tworzenie tablicy dwuwymiarowej
        while (($data = fgetcsv($handle, 1000,';')) !== FALSE) {
            $x[] = $data;
        }
        ini_set('auto_detect_line_endings',FALSE);
    }
    public function LineArray(&$x)
    {
        $x = array();
        for($i=0;$i<=count($this->db)-1;$i++)
        {
            $max = count($this->db[$i])-1;
            for($j=0;$j<=$max;$j++)
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
    public function MakeTable($search)
    {
        $line = array_map('strtolower', $this->dbline);
        $out = '';
        if(isset($search) AND $search != '')
        {
            foreach($line as $key =>$row)
            {
                if(strstr($row, $search))
                {
                    $out .= '<tr row="'.$key.'">';
                    foreach($this->db[$key] as $y => $value)
                    {
                        $out .= '<td num="'.$y.'">'.$value.'</td>';
                    }
                    $out .= '<td><span class="glyphicon glyphicon-pencil"></span> <span class="glyphicon glyphicon-trash"></span></td></tr>';
                }
            }
            echo $out;
        }else{
            foreach($this->db as $x => $row){
                $out .= '<tr row="'.$x.'">';
                    foreach($this->db[$x] as $y => $value)
                    {
                        $out .= '<td num="'.$y.'">'.$value.'</td>';
                    }
                    $out .= '<td><span class="glyphicon glyphicon-pencil"></span> <span class="glyphicon glyphicon-trash"></span></td></tr>';
            }
            echo $out;
        }
    }
    public function ShowTable()
    {
        if($this->db == true)
        {
        $line = array_map('strtolower', $this->dbline);
        echo '<div id="table" class="col-xs-12 col-sm-8"><table class="table">
        <thead>
        <tr bgcolor="#DDDDDD">
        <td>#</td>
        <td>Imie</td>
        <td>Nazwisko</td>
        <td colspan="2">Pesel</td>
        </tr>
        </thead>';
        $this->MakeTable($this->search);
        echo '</table>';
        }
        else
        {
            echo "Plik z bazą danych nie istnieje!";
        }
    }
    public function ClosePage()
    {
        echo '
        </div>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        <script src="js/vendor/jquery-1.11.2.min.js"></script>
        <script src="js/vendor/bootstrap.min.js"></script>
        <script src="js/scripts.js"></script>
        </body>
        </html>';
    }
}
?>