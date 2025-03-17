<?php

#Conexion con la base de datos de playa cacao
    class Conexion{
        public function Conectar_Base_De_Datos(){
            define('HOST', '127.0.0.1');
            define('PORT',1521);
            define('NAME', 'XE');
            define('USER','PlayaCacaoDB');
            define('PASS','PlayaCacao12345#');
        
            $bd_settings ="
            (DESCRIPTION =
            (ADDRESS = (PROTOCOL = TCP)(HOST = ". HOST .")(PORT = ". PORT ."))
            (CONNECT_DATA =
            (SERVER = DEDICATED)
            (SERVICE_NAME = ". NAME .")
            )
        )
            ";
        
            try{
        
                $bd = new PDO('oci:dbname='.$bd_settings,USER,PASS);
                $bd->setAttribute(PDO::ATTR_CASE,PDO::CASE_LOWER);
                $bd->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
                return $bd;
        
            } catch (Exception $e) {
                echo "La cagaste menso: ".$e->getMessage();
            }
        }
    }
?>