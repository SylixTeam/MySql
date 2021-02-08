<?php
#Developed by Sylix Team
#Version : 1.0.0
class MySQL
{
    private $DB_Host;
    private $DB_Username;
    private $DB_Password;
    private $conn;
    private $live;
    public $errors;
    public $error;
    public $id;
    public function __construct($hostname, $username, $password)
    {
        $this->DB_Host = $hostname; $this->DB_Username = $username; $this->DB_Password = $password;
        $this->conn = new mysqli($hostname, $username, $password);
        if($this->conn->connect_error)
        {
            $this->error("*Database(error) : [ Connection Failed ] -> [ " . $this->conn->connect_error . " ]");
            die("*Database(error) : [ Connection Failed ] -> [ " . $this->conn->connect_error . " ]");
        }
        else
        {
            return true;
        }
    }
    public function get_dbs()
    {
        $result = $this->conn->query("SHOW DATABASES");
        if ($result->num_rows > 0)
        {
            $RSL = [];
            while($SQ = $result->fetch_assoc())
            {
                array_push($RSL, $SQ);
            }
            return $RSL;
        }
        else
        {
            $this->error("*Database(error) : [ Not Found Any Database ]");
            return false;
        }
    }
    public function get_tables($DB)
    {
        if($this->exists_db($DB))
        {
            $result = $this->conn->query("SHOW TABLES FROM $DB");
            if ($result->num_rows > 0)
            {
                $RSL = [];
                while ($SQ = $result->fetch_assoc())
                {
                    array_push($RSL, $SQ);
                }
                return $RSL;
            }
            else
            {
                $this->error("*Database(error) : [ Not Found Any Table In $DB ]");
                return false;
            }
        }
        else
        {
            $this->error("*Database(error) : [ Failed To Get ($DB Not Found) ]");
            return false;
        }
    }
    public function get($DB, $Table, $Data)
    {
        if(count($Data) == 1)
        {
            foreach ($Data as $key=>$value)
            {
                if(is_array($value)
                {
                    ####################################################################################################
                    if ($this->exists_db($DB))
                    {
                        if ($this->exists_table($DB, $Table))
                        {
                            $this->live = new mysqli($this->DB_Host, $this->DB_Username, $this->DB_Password, $DB);
                            if (!$this->live->connect_error)
                            {
                                ####################################################################################################
                                $Search = $this->Tool_3($value);
                                if(empty($Search))
                                {
                                    $this->error("*Database(error) : [ Failed To Get ] -> [ Bad Syntax ]");
                                    return false;
                                }
                                $sql = "SELECT $Search FROM $Table";
                                echo $sql;
                                $result = $this->live->query($sql);
                                if ($result->num_rows > 0)
                                {
                                    $RSL = [];
                                    while($SQ = $result->fetch_assoc())
                                    {
                                        array_push($RSL, $SQ);
                                    }
                                    return $RSL;
                                }
                                else
                                {
                                    $this->error("*Database(error) : [ Failed To Get ] -> [ Empty Result ]");
                                    return false;
                                }
                                ####################################################################################################
                            }
                            else
                            {
                                $this->error("*Database(error) : [ Failed To Get ] -> [ " . $this->live->connect_error . " ]");
                                return false;
                            }
                        }
                        else
                        {
                            $this->error("*Database(error) : [ Failed To Get ($Table Not Found) ] -> [ " . $this->conn->error . " ]");
                            return false;
                        }
                    }
                    else
                    {
                        $this->error("*Database(error) : [ Failed To Get ($DB Not Found) ]");
                        return false;
                    }
                    ####################################################################################################
                }
                else
                {
                    $this->error("*Database(error) : [ Failed To Get ] -> [ Bad Syntax ]");
                    return false;
                }
            }
        }
        elseif(count($Data) == 2)
        {
            if ($this->exists_db($DB))
            {
                if ($this->exists_table($DB, $Table))
                {
                    $this->live = new mysqli($this->DB_Host, $this->DB_Username, $this->DB_Password, $DB);
                    if (!$this->live->connect_error)
                    {
                        ####################################################################################################
                        foreach($Data as $key=>$value)
                        {
                            if (is_array($value)
                            {
                                $Targets = $this->Tool_3($Data[$key]);
                            }
                            else
                            {
                                $Search = "$key='" . str_replace("'", "\\'", $value) . "'";
                            }
                        }
                        if(empty($Search) || empty($Targets))
                        {
                            $this->error("*Database(error) : [ Failed To Get ] -> [ Bad Syntax ]");
                            return false;
                        }
                        $sql = "SELECT $Targets FROM $Table WHERE $Search";
                        echo $sql;
                        $result = $this->live->query($sql);
                        if ($result->num_rows > 0)
                        {
                            return $result->fetch_assoc();
                        }
                        else
                        {
                            $this->error("*Database(error) : [ Failed To Get ] -> [ Empty Result ]");
                            return false;
                        }
                        ####################################################################################################
                    }
                    else
                    {
                        $this->error("*Database(error) : [ Failed To Get ] -> [ " . $this->live->connect_error . " ]");
                        return false;
                    }
                }
                else
                {
                    $this->error("*Database(error) : [ Failed To Get ($Table Not Found) ] -> [ " . $this->conn->error . " ]");
                    return false;
                }
            }
            else
            {
                $this->error("*Database(error) : [ Failed To Get ($DB Not Found) ]");
                return false;
            }
        }
        else
        {
            $this->error("*Database(error) : [ Failed To Get ] -> [ Incorrect Array in the \$Data section ]");
            return false;
        }
    }
    public function put($DB, $Table, $Data)
    {
        if($this->exists_db($DB))
        {
            if($this->exists_table($DB, $Table)) {
                $this->live = new mysqli($this->DB_Host, $this->DB_Username, $this->DB_Password, $DB);
                if(!$this->live->connect_error)
                {
                    ####################################################################################################
                    $Data = $this->Tool_1($Data);
                    $sql = "INSERT INTO $Table ({$Data[0]}) VALUES ({$Data[1]})";
                    if($this->live->query($sql) === TRUE)
                    {
                        $this->id = $this->live->insert_id;
                        return true;
                    }
                    else
                    {
                        $this->error("*Database(error) : [ Failed To Insert ] -> [ " . $this->live->error . " ]");
                        return false;
                    }
                    ####################################################################################################
                }
                else
                {
                    $this->error("*Database(error) : [ Failed To Insert ] -> [ " . $this->live->connect_error . " ]");
                    return false;
                }
            }
            else
            {
                $this->error("*Database(error) : [ Failed To Insert ($Table Not Found) ] -> [ " . $this->conn->error . " ]");
                return false;
            }
        }
        else
        {
            $this->error("*Database(error) : [ Failed To Insert ($DB Not Found) ]");
            return false;
        }
    }
    public function update($DB, $Table , $Data)
    {
        if(count($Data) == 2) {
            if ($this->exists_db($DB)) {
                if ($this->exists_table($DB, $Table)) {
                    $this->live = new mysqli($this->DB_Host, $this->DB_Username, $this->DB_Password, $DB);
                    if (!$this->live->connect_error) {
                        ####################################################################################################
                        foreach($Data as $key=>$value)
                        {
                            if(is_array($value))
                            {
                                $Updates = $this->Tool_2($Data[$key]);
                            }
                            else
                            {
                                $Search = "$key='" . str_replace("'","\\'",$value) . "'";
                            }
                        }
                        $sql = "UPDATE $Table SET $Updates WHERE $Search";
                        if ($this->live->query($sql) === TRUE) {
                            return true;
                        }
                        else
                        {
                            $this->error("*Database(error) : [ Failed To Update ] -> [ " . $this->live->error . " ]");
                            return false;
                        }
                        ####################################################################################################
                    }
                    else
                    {
                        $this->error("*Database(error) : [ Failed To Update ] -> [ " . $this->live->connect_error . " ]");
                        return false;
                    }
                }
                else
                {
                    $this->error("*Database(error) : [ Failed To Update ($Table Not Found) ] -> [ " . $this->conn->error . " ]");
                    return false;
                }
            }
            else
            {
                $this->error("*Database(error) : [ Failed To Update ($DB Not Found) ]");
                return false;
            }
        }
        else
        {
            $this->error("*Database(error) : [ Failed To Update ] -> [ Incorrect Array in the \$Data section ]");
            return false;
        }
    }
    public function delete($DB, $Table, $Data)
    {
        if ($this->exists_db($DB)) {
            if ($this->exists_table($DB, $Table)) {
                $this->live = new mysqli($this->DB_Host, $this->DB_Username, $this->DB_Password, $DB);
                if (!$this->live->connect_error) {
                    ####################################################################################################
                    $is = 0;
                    foreach($Data as $key=>$value)
                    {
                        $sql = "DELETE FROM $Table WHERE $key='" . str_replace("'", "\\'", $value) . "'";
                        if($this->live->query($sql) === TRUE)
                        {
                            $is += 1;
                        }
                    }
                    return $is;
                    ####################################################################################################
                }
                else
                {
                    $this->error("*Database(error) : [ Failed To Delet ] -> [ " . $this->live->connect_error . " ]");
                    return false;
                }
            }
            else
            {
                $this->error("*Database(error) : [ Failed To Delet ($Table Not Found) ] -> [ " . $this->conn->error . " ]");
                return false;
            }
        }
        else
        {
            $this->error("*Database(error) : [ Failed To Delet ($DB Not Found) ]");
            return false;
        }
    }
    public function new_db($DB)
    {
        if(!$this->exists_db($DB)) {
            if ($this->conn->query("CREATE DATABASE $DB")) {
                return true;
            }
            else
            {
                $this->error("*Database(error) : [ Failed To Create DB ] -> [ " . $this->conn->error . " ]");
                return false;
            }
        }
        else
        {
            $this->error("*Database(error) : [ Failed To Create DB (Already Exists!)] -> [ " . $this->conn->error . " ]");
            return false;
        }
    }
    public function new_table($DB, $Name, $Table)
    {
        if($this->exists_db($DB))
        {
            if(!$this->exists_table($DB, $Name)){
                $this->live = new mysqli($this->DB_Host, $this->DB_Username, $this->DB_Password, $DB);
                if(!$this->live->connect_error)
                {
                    $q = "CREATE TABLE $Name";
                    $tb = '';
                    $i = 1;
                    foreach($Table as $k=>$v)
                    {
                        if(empty($v[0]))
                        {
                            $key = "DB_$i";
                        }
                        else
                        {
                            $key = $v[0];
                        }
                        if(empty($v[1]))
                        {
                            if($v[0] == 'id')
                            {
                                $option = "INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY";
                            }
                            else
                            {
                                $option = "VARCHAR(500)";
                            }
                        }
                        else
                        {
                            $option = $v[1];
                        }
                        $tb .= "$key $option, ";
                        $i += 1;
                    }
                    $tb = preg_replace('/(, )$/', '', $tb);
                    $sql = $q . ' (' . $tb . ')';
                    if ($this->live->query($sql) === TRUE) {
                        //$conn->error;
                        return true;
                    }
                    else
                    {
                        $this->error("*Database(error) : [ Filed To Create Table ] -> [ " . $this->live->error . " ]");
                        return false;
                    }
                }
                else
                {
                    $this->error("*Database(error) : [ Filed To Create Table ]");
                return false;
                }
            }
            else
            {
                $this->error("*Database(error) : [ The Table Has Already Been Created ]");
                return false;
            }
        }
        else
        {
            $this->error("*Database(error) : [ DB Not Exists ]");
            return false;
        }
    }
    public function remove_db($DB)
    {
        if($this->exists_db($DB))
        {
            if($this->conn->query("DROP DATABASE $DB;"))
            {
                return true;
            }
            else
            {
                $this->error("*Database(error) : [ Failed To Remove DB] -> [ " . $this->conn->error . " ]");
                return false;
            }
        }
        else
        {
            $this->error("*Database(error) : [ Failed To Remove DB ($DB Not Found) ]");
            return false;
        }
    }
    public function remove_table($DB, $Table)
    {
        if($this->exists_db($DB))
        {
            if($this->exists_table($DB, $Table)) {
                $this->live = new mysqli($this->DB_Host, $this->DB_Username, $this->DB_Password, $DB);
                if(!$this->live->connect_error)
                {
                    if ($this->live->query("DROP TABLE $Table;")) {
                        return true;
                    }
                    else
                    {
                        $this->error("*Database(error) : [ Failed To Remove Table ] -> [ " . $this->live->error . " ]");
                        return false;
                    }
                }
                else
                {
                    $this->error("*Database(error) : [ Failed To Remove Table ] -> [ " . $this->live->connect_error . " ]");
                    return false;
                }
            }
            else
            {
                $this->error("*Database(error) : [ Failed To Remove Table ($Table Not Found) ] -> [ " . $this->conn->error . " ]");
                return false;
            }
        }
        else
        {
            $this->error("*Database(error) : [ Failed To Remove Table ($DB Not Found) ]");
            return false;
        }
    }
    public function exists_db($DB)
    {
        if ($this->conn->select_db($DB)) {
            return true;
        }
        else
        {
            return false;
        }
    }
    public function exists_table($DB, $Table)
    {
        if($this->conn->query("SELECT table_name FROM information_schema.tables WHERE table_schema = '$DB' AND table_name = '$Table';")->num_rows == 0)
        {
            return false;
        }
        else
        {
            return true;
        }
    }
    private function error($error)
    {
        $this->errors .= $error . "\n\n";
        $this->error = $error;
        return;
    }
    private function Tool_1($Array)
    {
        $s1 = '';
        $s2 = '';
        foreach($Array as $key=>$value)
        {
            $s1 .= "$key, ";
            $value = str_replace("'","\\'", $value);
            $s2 .= "'$value', ";
        }
        $s1 = preg_replace('/(, )$/', '', $s1);
        $s2 = preg_replace('/(, )$/', '', $s2);
        return [$s1, $s2];
    }
    private function Tool_2($Array)
    {
        $s = '';
        foreach($Array as $key=>$value)
        {
            $s .= "$key='".str_replace("'","\\'", $value)."', ";
        }
        return preg_replace('/(, )$/', '', $s);
    }
    private function Tool_3($Array)
    {
        $s = '';
        foreach($Array as $key=>$value)
        {
            if($value == "*" || $value == "ALL_DATA")
            {
                return "*";
            }
            else
            {
                $value = str_replace("'", "\\'", $value);
                $s .= "$value, ";
            }
        }
        $s = preg_replace('/(, )$/', '', $s);
        return $s;
    }
}
# Developers@Sylix.ir
# Https://Sylix.ir
# Https://github.com/SylixTeam/MySql
# Https://T.me/Sylix_Team
