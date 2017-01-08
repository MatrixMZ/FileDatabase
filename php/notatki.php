<?php 
$line = file($this->database);
        $line = array_map('strtolower', $line);
        $columns = substr_count($this->database, ';') + 1;
        $z = 0;
        $out = '<div id="table" class="col-xs-12 col-sm-8">
        <table class="table">
        <thead>
        <tr bgcolor="#DDDDDD">
        <td>#</td>
        <td>Imie</td>
        <td>Nazwisko</td>
        <td colspan="2">Pesel</td>
        
        </tr>
        </thead>';
        
        if(!isset($this->search) OR $this->search == ''){
            $i = 0;
            $y = 0;
        foreach($this->db as $row)
        {
            
                $out .= '<tr row="'.$i.'">';
            $y = 0;
            foreach($this->db[$z] as $col)
            {
                $out .= '<td col="'.$y.'">'.$col.'</td>';
                $y++;
            }
            $out .='<td><span class="glyphicon glyphicon-trash"></span></td></tr>';

            $i++;
            $z++;
        }
        $out .= '</table></div>';
        echo $out;
            
        }else{
            $i = 0;
            foreach($this->db as $row)
            {
            if(@strstr($line[$z], $this->search) == true){
                $out .= '<tr row="'.$z.'>';
                foreach($this->db[$z] as $col)
                {
                    $out .= '<td>'.$col.'</td>';
                }
                $out .='</tr>';
            }
            $z++;
        }
        $out .= '</table></div>';
        echo $out;
        }
?>