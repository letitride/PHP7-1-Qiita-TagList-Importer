<?php
require "model/Dao.php";

class QiitaTagsDao extends Dao {

    public function insertRecord( $data  )
    {

        list($columns, $values, $binds) = parent::parseInsertPrams( $data );
        $sql = sprintf( 
            "insert into qiita_tags ( %s ) values ( %s )", 
            $columns,
            $values
        );
        
        try{
            parent::prepare( $sql );            
            $this->_stmt->execute($binds);
        }catch(PDOException $e){
            print $e->getMessage();
            exit;
        }catch(Exception $e){
            print $e->getMessage();
            exit;
        }
    }

    public function updateRecordByName( $data, $name )
    {
        list($sets, $binds) = parent::parseUpdatePrams( $data );        
        $sql = sprintf(
            " update qiita_tags set %s, prev_items_count = items_count where name = :name",
            $sets
        );
        try{
            parent::prepare( $sql );
            $this->_stmt->execute($binds);
        }catch(PDOException $e){
            print $e->getMessage();
            exit;
        }catch(Exception $e){
            print $e->getMessage();
            exit;
        }
        return $this->_stmt->rowCount();
    }
}
