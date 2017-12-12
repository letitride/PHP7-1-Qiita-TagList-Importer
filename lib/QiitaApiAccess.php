<?php
class QiitaApiAccess {

    const QIITA_API_DOMAIN = "https://qiita.com%s";
    private $_method;    
    private $_page;
    private $_perPage;
    private $_sort;

    public function getResource( $method = null ){
        
        if( $method !== null ){
            $this->setMethod( $method );           
        }
        if( $this->_method === null ){

        }

        $url = $this->makeUrl();
        $json = file_get_contents( $url );
        return $json;
    }

    public function setMethod( $method ){
        $this->_method = $method;
    }
    public function setPage( $page ){
        $this->_page = $page;
    }
    public function setPerpage( $perPage ){
        $this->_perPage = $perPage;
    }
    public function setSort( $sort ){
        $this->_sort = $sort;
    }

    private function makeUrl(){

        $url = sprintf( self::QIITA_API_DOMAIN, $this->_method );
        $params = array();
        if( $this->_page !== null ){
            $params["page"] = $this->_page;
        }
        if( $this->_perPage !== null ){
            $params["per_page"] = $this->_perPage;
        }
        if( $this->_sort !== null ){
            $params["sort"] = $this->_sort;
        }
        $queryString = http_build_query($params);
        if( $queryString != "" ){
            $url = $url . "?" . $queryString;
        }
        return $url;
    }
}

