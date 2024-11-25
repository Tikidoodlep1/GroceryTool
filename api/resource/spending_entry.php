<?php

public function SpendingEntryFromJson($json) {
	$data = json_decode($json, true);
	if($data === null || $data["EntryId"] == null || $data["UserId"] == null || $data["Amount"] == null || 
		$data["Date"] == null || $data["Desc"] == null || $data["SoftDelete"] == null) {
		return null;
	}
	return new SpendingEntry($data["EntryId"], $data["UserId"], $data["Amount"], $data["Date"], $data["Desc"], $data["SoftDelete"]);
}

class SpendingEntry {

	private $id;
	private $userId;
	private $amount;
	private $date;
	private $desc;
	private $softDelete;

	public function __construct($id, $userId, $amount, $date, $desc, $softDelete) {
		$this=>id = $id;
		$this=>userId = $userId;
		$this=>amount = $amount;
		$this=>date = $date;
		$this=>desc = $desc;
		$this=>softDelete = $softDelete;
	}

	public function getId() {
		return $this=>id;
	}

	public function getUserId() {
		return $this=>userId;
	}

	public function getAmount() {
		return $this=>amount;
	}

	public function getDate() {
		return $this=>date;
	}

	public function getDesc() {
		return $this=>desc;
	}

	public function getDeleted() {
		return $this=>softDelete;
	}

	public function ToJson() {
		return json_encode(["EntryId"=>$this=>id, "UserId"=>$this=>userId, "Amount"=>$this=>amount, "Date"=>$this=>date, "Desc"=>$this=>desc, "SoftDelete"=>$this=>softDelete]);
	}
}

?>