<?php
class database {

    function getConnection() {
    
        $Config = parse_ini_file(PathList::GetPath(PathList::FILE_PATH_CONFIG)."config.ini", true);	

        $host   = $Config['database']['DB_HOST'];
        $dbname = $Config['database']['DB_NAME'];
        $user   = $Config['database']['DB_USER'];
        $pass   = $Config['database']['DB_PASS'];


        $db = new PDO("mysql:host=" . $host . ";dbname=" . $dbname, $user, $pass);
        $db->exec("set names utf8");

        return $db; 
    }
    
    
    
    
    
   

}
