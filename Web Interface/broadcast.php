<?php
    require 'config.php';
    $query = "select * from broadcast where deleted=0 and createdOn >= '".date('Y-m-d H:i:s', $_SESSION['team']['time'])."'";
    $result = DB::findAllFromQuery($query);
    $msg = "{\"broadcast\":[";
    $i = 0;
    foreach($result as $row){
        if($i != 0)
            $msg .= ",";
        $i++;
        $row['msg'] = preg_replace("/\r\n|\r|\n/",'<br/>',$row['msg']);
        $msg .= "{'title':'$row[title]', 'msg':'$row[msg]'}";
    }
    if(isset($_SESSION['loggedin']) && $_SESSION['team']['status'] == "Admin"){
    	//fixed bug in case of multiple clarification
    	//included more info on clarification notification
        $query = "select * from clar where reply is NULL and access='public' and time > ".$_SESSION['team']['time'];
        $result = DB::findAllFromQuery($query);
        
        foreach($result as $row) {
        	if($i != 0)
        		$msg .= ",";
        	$i++;
        	$row['query'] = preg_replace("/\r\n|\r|\n/",'<br/>',$row['query']);
        	$problemName = DB::findOneFromQuery("SELECT name FROM problems WHERE pid = ".$row['pid']);
        	$msg .= "{'title':'Clarification for <i>$problemName[name]</i>', 'msg':'$row[query]'}";
        }
    }
    $msg .= "]}";
    if(isset($_GET['updatetime'])){
        echo "done";
        $_SESSION['team']['time'] = time();
    }
    echo $msg;
?>
