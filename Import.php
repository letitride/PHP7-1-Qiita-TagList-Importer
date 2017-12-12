<?php
require "lib/QiitaApiAccess.php";
require "model/QiitaTagsDao.php";

$date = new DateTime();
$date->setTimeZone( new DateTimeZone('Asia/Tokyo'));
$currentTime = $date->format('Y-m-d H:i:s'); 

$qiitaTagsDao = new QiitaTagsDao();
$qiitaTagsDao->connect();

$qiitaApiAccess = new QiitaApiAccess();
$qiitaApiAccess->setPerpage(100);
$qiitaApiAccess->setSort("count");

for($i=1;;$i++)
{


    $qiitaApiAccess->setPage($i);    
    $json = $qiitaApiAccess->getResource("/api/v2/tags");
    $tagList = json_decode( $json, true );
    if(count($tagList) == 0){
        break;
    }

    //データの更新・投入
    foreach( $tagList as $idx => $record )
    {
        $data = array();
        $data["updated_at"] = $currentTime;
        foreach($record as $column => $value){
            if( $column == "id" ){
                $data["name"] = $value;
                continue;
            }
            $data[$column] = $value;
        }
        //レコード更新
        $count = $qiitaTagsDao->updateRecordByName($data, $record["id"]);
        //更新行がなければ登録
        if( $count == 0 ){
            $qiitaTagsDao->insertRecord($data);
        }
    }
    
    sleep(3);

    //投稿数が100未満のものは取り込み対象外
    if($tagList[99]["items_count"] < 100 ){
        break;
    }

}
