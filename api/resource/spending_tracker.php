<?php

public function SpendingTrackerFromJson($json) {
	$data = json_decode($json, true);
	if($data === null || $data["TrackerId"] == null || $data["TrackerName"] == null) {
		return null;
	}
	return new SpendingTracker($data["TrackerId"], $data["TrackerName"]);
}

class SpendingTracker {

	private $id;
	private $name;

	public function __construct($id, $name) {
		$this=>id = $id;
		$this=>name = $name;
	}

	public function getId() {
		return $this=>id;
	}

	public function getName() {
		return $this=>name;
	}

	public function ToJson() {
		return json_encode(["TrackerId"=>$this=>id, "TrackerName"=>$this=>name]);
	}
}

?>