<?php
class Dao {

    static protected $_db;
    protected $_stmt = null;
    private $_preQuery = "";
    
    /**
     * postgresql接続
     */
    public function connect(){
        
        if( self::$_db !== null ){            
            return;
        }
        try{
            self::$_db = new PDO("pgsql:dbname=*** host=*** port=***", "***", "***");
            self::$_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }catch(PDOException $e){
            print $e->getMessage();
            exit;
        }catch(Exception $e){
            print $e->getMessage();
            exit;
        }
    }

    /**
     * ステートメント保持中のクエリは再prepareを行わない
     */
    protected function prepare( $sql ){
        if( $this->_preQuery != $sql ){
            $this->_stmt = self::$_db->prepare( $sql );
            $this->_preQuery = $sql;
        }
    }

    protected function parseInsertPrams( $data ){

        $columns = array();
        $values  = array();
        $binds   = array();

        foreach( $data as $column => $value ){
            $columns[] = $column;
            $values[]  = $value;
        }

        foreach( $data as $column => $value ){
            $binds[":".$column] = $value;
        }

        return array( join($columns, ","), ":".join($columns, ",:"), $binds );
    }

    protected function parseUpdatePrams( $data ){

        $sets  = array();  
        $binds = array();
        
        foreach( $data as $column => $value ){
            $sets[] = $column . " = :".$column;
            $binds[":".$column] = $value; 
        }
        return array( join($sets, ","), $binds );

    }
}
