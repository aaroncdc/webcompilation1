<?php

/*
 *  connect.php
 *  Administrador automatizado de conexiones y consultas a bases de datos
 *  Por Aarón C.d.C
 *  10/02/2016
 */

//Archivo de configuración con los datos del servidor:

if(file_exists('config/.config.php'))
	require_once('config/.config.php');
else if(file_exists('../config/.config.php'))
	require_once('../config/.config.php');
else
	require_once('.config.php');

/*if(file_exists('config/.config.php'))
	require_once('config/.config.php');
else if(file_exists('.config.php'))
	require_once('.config.php');
else
	require_once('../config/.config.php');*/

/*
 * Clase mysqlmanager: Clase principal del administrador
 */
class mysqlmanager {
    //Objeto con los datos de la conexión actual.
    var $db_connection = NULL;
    //Bandera que indica si se está usando la clase sqli (true), o mysql estandard (false)
    var $using_sqli = false;
    //Bandera que indica si la conexión está activa
    var $connected = false;
    
    var $qresult = NULL;
    /*
     * Constructor mysqlmanager
     * $init: Bandera que especifica si se debe inicializar automáticamente la conexión.
     * Si $init es FALSE, la conexión deberá ser iniciada por separado.
     */
    function mysqlmanager($init = true){
        if($init)
        {
            $this->auto_connect_or_die();
        }else{return;}
    }
        
    /*
     * Conectar al servidor usando las isntrucciones mysql estandard
     * 
     * Retorna: TRUE si la conexión ha sido satisfactoria, o FALSE en caso contrario.
     */
    function mysql_connection() {
            global $db_connection;
            global $using_sqli;
            global $connected;
            if($db_connection = mysql_connect(constant('hostname'),constant('db_username'),constant('db_password')))
            {
                mysql_select_db(constant('db_name'), $db_connection);
                $using_sqli = false;
                $connected = true;
            }else{return false;}
    }

    /*
     * Conectar al servidor usando la nueva clase 'sqli'
     * 
     * Retorna: TRUE si la conexión ha sido satisfactoria, o FALSE en caso contrario.
     */
    function sqli_connection() {
        global $db_connection;
        global $using_sqli;
        global $connected;
		if(!function_exists('mysqli_connect'))
			return false;
        if(!$db_connection = mysqli_connect(constant('hostname'), constant('db_username'), constant('db_password'),constant('db_name')))
            return false;

        $using_sqli = true;
        $connected = true;
        return true;
    }

    /*
     * Conectar al servidor, usando mysql estandard, o sqli si la extensión está disponible
     */
    function auto_connect(){
        if(function_exists('mysqli_connect'))
        {
           if($this->sqli_connection())
               return true;
        }else{
            if($this->mysql_connection())
                return true;
        }
        return false;
    }
    
	function auto_connect_or_die(){
        if(function_exists('mysqli_connect'))
        {
           if($this->sqli_connection())
               return;
        }else{
            if($this->mysql_connection())
                return;
        }
		die ("<h1>Could not connect to the DB</h1>");
	}
	
    /*
     * Devuelve TRUE si hay una conexion activa, o FALSE en caso contrario
     */
    function is_connected(){
        global $connected;
        return $connected;
    }
    
    /*
     * Mandar consulta a la base de datos.
     * $qstring: String con la consulta a realizar.
     * 
     * Retorno: Resultado de la consulta, o NULL si la función falla.
     */
    function sqlquery($qstring) {
        global $db_connection;
        global $using_sqli;
        global $connected;
        global $qresult;
        if(!$connected)
            return NULL;
        if($db_connection){
            if($using_sqli){
                    if($qresult = mysqli_query($db_connection,$qstring)){
                        return $qresult;
                    }else{
                        return NULL;
                    }
            }else{
                $qresult = mysql_query($qstring);
                return $qresult;
            }
        }else{
            return NULL;
        }
    }
	
	function sqlquery_ns($qstring) {
        global $db_connection;
        global $using_sqli;
        global $connected;
        if(!$connected)
            return NULL;
        if($db_connection){
            if($using_sqli){
                    if($qresultx = mysqli_query($db_connection,$qstring)){
                        return $qresultx;
                    }else{
                        return NULL;
                    }
            }else{
                $qresultx = mysql_query($qstring);
                return $qresultx;
            }
        }else{
            return NULL;
        }
    }

    /*
     * Procesar todos los resultados de una consulta.
     * $queryresult: Resultado de una consulta.
     * $func: Nombre de la función a llamar.
     */
    function sqlfetcharray($func){
        global $using_sqli;
        global $connected;
        global $qresult;
        if(!$connected)
            return NULL;
        if($using_sqli)
        {
            while($res = mysqli_fetch_array($qresult))
            {
                $func($res);
            }
        }else{
            while($res = mysql_fetch_array($qresult))
            {
                 $func($res);
            }
        }
    }

    /*
     * Procesar los resultados de una consulta, y devolver la primera (o única) fila.
     * $queryresult: Resultado de una consulta.
     * 
     * Retorna: Fila con el resultado de la consulta, o NULL si falla la consulta.
     */
    function sqlfetchrow(){
        global $using_sqli;
        global $connected;
        global $qresult;
        if(!$connected)
            return NULL;
        $res = NULL;
        if($using_sqli)
        {
            $res = mysqli_fetch_row($qresult);
        }else{
            $res = mysql_fetch_row($qresult);
        }
        return $res;
    }
    
    function sqlfetchassoc(){
        global $using_sqli;
        global $connected;
        global $qresult;
        if(!$connected)
            return NULL;
        $res = NULL;
        if($using_sqli)
        {
            $res = mysqli_fetch_assoc($qresult);
        }else{
            $res = mysql_fetch_assoc($qresult);
        }
        return $res;
    }
	
	function sqlfetchassoc_ns($result){
        global $using_sqli;
        global $connected;
        global $qresult;
        if(!$connected)
            return NULL;
        $res = NULL;
        if($using_sqli)
        {
            $res = mysqli_fetch_assoc($result);
        }else{
            $res = mysql_fetch_assoc($result);
        }
        return $res;
    }
	
    /*
     * Retorna el número de filas en una consulta
     */
    function numrows(){
        global $using_sqli;
        global $qresult;
        if($using_sqli)
        {
            return mysqli_num_rows($qresult);
        }else{
            return mysql_num_rows($qresult);
        }
    }
    
    /*
     * Retorna el número de columnas en una consulta
     */
    function numfields(){
        global $using_sqli;
        global $qresult;
        if($using_sqli)
        {
            return mysqli_num_fields($qresult);
        }else{
            return mysql_num_fields($qresult);
        }
    }
    
	function numaffected(){
	    global $using_sqli;
        global $qresult;
		global $db_connection;
		if($using_sqli)
		{
			return mysqli_affected_rows($db_connection);
		}else{
			return mysql_affected_rows();
		}
	}
	
	function sqlinsertid(){
	    global $using_sqli;
        global $qresult;
		global $db_connection;
		if($using_sqli)
		{
			return mysqli_insert_id($db_connection);
		}else{
			return mysql_insert_id();
		}
	}
	
	function real_escape_string($toscape){
		global $using_sqli;
        global $qresult;
		global $db_connection;
		
		if($using_sqli)
		{
			return $db_connection->real_escape_string($toscape);
		}else{
			return mysql_real_escape_string($toscape);
		}
	}
	
    /*
     *  Retorna una cadena con la descripción del último error, si lo hay 
    */
    function sqlerror(){
        global $using_sqli;
        global $db_connection;
        if($using_sqli)
        {
            return mysqli_error($db_connection);
        }else{
            return mysql_error();
        }
    }

    /*
     * Cerrar la conexión con el servidor
     */
    function endconnection() {
            global $db_connection;
            global $using_sqli;
            global $connected;
                if(!$connected)
                    return NULL;
            if(!$db_connection){
                return;
            }
            if(!$using_sqli)
            {
                mysql_close($db_connection);
            }else{
                mysqli_close($db_connection);
            }
        }
        
        /*
         * Para depuración: muestra en pantalla los valores de la clase, y si hay
         * algún error.
         */
        function devdump() {
            global $db_connection;
            global $using_sqli;
            global $connected;
			global $qresult;
            var_dump($db_connection);
			echo("<pre>SQLI:</pre>");
            var_dump($using_sqli);
			echo("<pre>CONNECTED:</pre>");
            var_dump($connected);
			var_dump($qresult);
            echo $this->sqlerror();
        }
    }
	
	if(constant('autoconnect'))
		$mysqlman = new mysqlmanager();
?>