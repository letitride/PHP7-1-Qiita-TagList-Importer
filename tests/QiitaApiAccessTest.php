<?php
require_once('vendor/autoload.php');
require_once('lib/QiitaApiAccess.php');

class QiitaApiAccessTest extends PHPUnit\Framework\TestCase{
    
    public function testSetMethod()
    {
        $qiitaApiAccessnew = new QiitaApiAccess();
        $qiitaApiAccessnew->setMethod("/api/v2/tags");
        $this->assertEquals("https://qiita.com/api/v2/tags", $qiitaApiAccessnew->makeUrl() );        
    }

    public function testSetMakeUrl1()
    {
        $qiitaApiAccessnew = new QiitaApiAccess();
        $qiitaApiAccessnew->setMethod("/api/v2/tags");
        $qiitaApiAccessnew->setPage(2);
        $qiitaApiAccessnew->setSort("count");        
        $this->assertEquals("https://qiita.com/api/v2/tags?page=2&sort=count", $qiitaApiAccessnew->makeUrl() );        
    }

    public function testSetMakeUrl2()
    {
        $qiitaApiAccessnew = new QiitaApiAccess();
        $qiitaApiAccessnew->setMethod("/api/v2/tags");
        $qiitaApiAccessnew->setPerpage(3);
        $this->assertEquals("https://qiita.com/api/v2/tags?per_page=3", $qiitaApiAccessnew->makeUrl() );        
    }

    public function testGetResource()
    {
        $qiitaApiAccessnew = new QiitaApiAccess();
        $qiitaApiAccessnew->setMethod("/api/v2/tags");
        $qiitaApiAccessnew->setPage(1);
        $qiitaApiAccessnew->setSort("count");
        $j1 = json_decode( $qiitaApiAccessnew->getResource(), true );
        $this->assertEquals( 20, count($j1) );

        $qiitaApiAccessnew->setPage(2);
        $j2 = json_decode( $qiitaApiAccessnew->getResource(), true );
        $this->assertNotEquals( $j1, $j2 );
    }
}