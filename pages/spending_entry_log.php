<?php
	$fakeTrackerName = "Target";

	$fakeSpendingLog = [];
	$fakeSpendingLog[] = array("user"=>"Jared", "date"=>"11/4/24", "desc"=>"Grabbed Milk, Creamer, Coffee", "amount"=>18.64);
	$fakeSpendingLog[] = array("user"=>"Ana", "date"=>"10/6/24", "desc"=>"Pizza, Bananas, Grapes, Coconut milk, Curry paste, Garbanzo beans, Poptarts, Chili Beans.", "amount"=>134.64);
	$fakeSpendingLog[] = array("user"=>"Angela", "date"=>"3/8/24", "desc"=>"Found some cute pants", "amount"=>45.61);
	$fakeSpendingLog[] = array("user"=>"Kevin", "date"=>"9/3/23", "desc"=>"", "amount"=>16.12);
	$fakeSpendingLog[] = array("user"=>"Angela", "date"=>"8/6/23", "desc"=>"New coffee maker", "amount"=>168.14);
	$fakeSpendingLog[] = array("user"=>"Jared", "date"=>"8/4/23", "desc"=>"Small grocery shopping trip", "amount"=>64.93);




	//ECHO TABLE STRUCTURE
	function getSpendingEntryLog($n = 0) {
		global $fakeSpendingLog;

		$table = "
		<ul id='spending-entry-header'>
			<li>Date</li>
			<li>Username</li>
			<li>Description</li>
			<li>Amount</li>
		</ul>
		";
		for($i = 0; $i < ($n === 0 ? count($fakeSpendingLog) : $n); $i++) {
			$table .= "
			<ul class='spending-entry'>
				<li>" . trim($fakeSpendingLog[$i]['date']) . "</li>
				<li>" . trim($fakeSpendingLog[$i]['user']) . "</li>
				<li>" . trim($fakeSpendingLog[$i]['desc']) . "</li>
				<li>" . trim($fakeSpendingLog[$i]['amount']) . "</li>
			</ul>
			";
		}

		return $table;
	}

?>