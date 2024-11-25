<?php
	$fakeSpendingUserLog = [];
	$fakeSpendingUserLog[] = array("user"=>"Jared", "date"=>"3/18/20", "total"=>83.57);
	$fakeSpendingUserLog[] = array("user"=>"Ana", "date"=>"6/7/21", "total"=>134.64);
	$fakeSpendingUserLog[] = array("user"=>"Angela", "date"=>"9/28/20", "total"=>213.75);
	$fakeSpendingUserLog[] = array("user"=>"Kevin", "date"=>"11/5/20", "total"=>16.12);




	//ECHO TABLE STRUCTURE
	function getSpendingUserLog($n = 0) {
		global $fakeSpendingUserLog;

		$table = "
		<ul id='spending-user-header'>
			<li>Date Added</li>
			<li>Username</li>
			<li>Total Spent</li>
		</ul>
		";
		for($i = 0; $i < ($n === 0 ? count($fakeSpendingUserLog) : $n); $i++) {
			$table .= "
			<ul class='spending-user'>
				<li>" . trim($fakeSpendingUserLog[$i]['date']) . "</li>
				<li>" . trim($fakeSpendingUserLog[$i]['user']) . "</li>
				<li>" . trim($fakeSpendingUserLog[$i]['total']) . "</li>
			</ul>
			";
		}
		return $table;
	}
	
?>
