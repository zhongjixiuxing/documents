<?php	
	require_once 'MongoDBUtil.php';
	require_once 'config.php';
	$method = $_REQUEST['method'];
   	$m = MongoDBUtil::_getIntance();
   	$db = $m->$db_name;
   	$collection = $db->createCollection("$table_name");

   	if($method === 'getInfo'){
   		$result = MongoDBUtil::getAllRecordJsonStr_Dynamic($collection);
   		echo $result;
   	}elseif	($method === 'delete'){
   		$json = $_POST['json'];
   		$jsonObjs = json_decode($json,true);
   		$ids = MongoDBUtil::deleteRow($jsonObjs,$collection);
   		$res = json_encode($ids);
   		echo $res;
   	}elseif ($method === 'add'){
   		$json = $_POST['json'];
   		$jsonObjs = json_decode($json, true);
		$result = json_encode(MongoDBUtil::addRows($jsonObjs, $collection));
		echo "jsosn : ".$json."\n";
   		//echo $result;
   	}elseif ($method === 'update'){
   		$json = $_POST['json'];
   		$jsonObjs = json_decode($json, true);
   		MongoDBUtil::updateRows($jsonObjs, $collection);
   		echo "update ok!";
   	}elseif ($method === 'test'){
   		test();
   		
   	}
   	
   	function test($jsonObjs){
   		$m = MongoDBUtil::_getIntance();
   		$db = $m->user;
   		$collection = $db->createCollection("mycol");
   		$json = MongoDBUtil::addRows($jsonObjs, $collection);
		return $json;
   	}
   
?>