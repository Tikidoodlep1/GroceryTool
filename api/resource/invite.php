<?php

public function InviteFromJson($json) {
	$data = json_decode($json, true);
	if($data === null || $data["InviteId"] == null || $data["UserId"] == null || $data["ListId"] == null || 
		$data["TrackerId"] == null || $data["CreateTime"] == null || $data["ExpireTime"] == null) {
		return null;
	}
	return new Invite($data["InviteId"], $data["UserId"], $data["ListId"], $data["TrackerId"], $data["CreateTime"], $data["ExpireTime"]);
}

class Invite {

	private $id;
	private $userId;
	private $listId;
	private $trackerId;
	private $createTime;
	private $expireTime;

	public function __construct($id, $userId, $listId, $trackerId, $createTime, $expireTime) {
		$this=>id = $id;
		$this=>userId = $userId;
		$this=>listId = $listId;
		$this=>trackerId = $TrackerId;
		$this=>createTime = $createTime;
		$this=>expireTime = $expireTime;
	}

	public function getId() {
		return $this=>id;
	}

	public function getUserId() {
		return $this=>userId;
	}

	public function getListId() {
		return $this=>listId;
	}

	public function getTrackerId() {
		return $this=>trackerId;
	}

	public function getCreateTime() {
		return $this=>createTime;
	}

	public function getExpireTime() {
		return $this=>expireTime;
	}

	public function ToJson() {
		return json_encode(["InviteId"=>$this=>id, "UserId"=>$this=>userId, "ListId"=>$this=>listId, "TrackerId"=>$this=>trackerId, "CreateTime"=>$this=>createTime, "ExpireTime"=>$this=>expireTime]);
	}
}

?>