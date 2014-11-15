<?php
/** @author: utk
 */
include_once '../functions.php';
include_once 'SSE_Util.php';

function liveContestRanking($contestCode) {
	$query = "SELECT * FROM $contestCode LIMIT 10";
	$table = '<table class="table table-striped table-bordered table-condensed">' ;
	$result = DB::findAllFromQuery($query);
	foreach ($result as $row) {
		$table .= '<tr>';
		$table .= '<td>'.$row['rank'].'</td><td align="center">'.$row['teamname'].'</td><td>'.$row['score'].'</td>';
		$table .= '</tr>';
	}
	$table .= '</table>';
	return $table;
}

$contestCode = 'cqm5';
$printTable = liveContestRanking($contestCode);
//echo $printTable;
SSE_Util::sendMessageToClient($printTable);
