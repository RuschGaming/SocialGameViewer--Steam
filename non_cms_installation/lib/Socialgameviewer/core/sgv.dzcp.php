<?php

class Sgv_dzcp extends Sgv {

    public function load_players() {
	    global $sql_prefix;
		$prefix = $sql_prefix;
	    $ples = array();
		$qry = db('SELECT t1.comid, t1.userid, t2.id, t2.steamid, t1.steamid bakid, t2.level FROM '.$prefix.'socialgameviewer_users t1 RIGHT JOIN '.$prefix.'users t2 ON (t2.id = t1.userid)');
		while ($user = mysqli_fetch_assoc($qry)) {
			if ($user['comid'] == NULL & $user['level'] > 2) {
				if ($comid = $this->get_steam64_id($user['steamid'])) {
					db ('INSERT INTO '.$prefix."socialgameviewer_users (comid, userid, steamid) VALUES ('".$comid."', '".$user['id']."', '".$user['steamid']."');");
				}
			}
			if ($user['comid'] != NULL & $user['level'] > 2) {
				$ples[] = $user['comid'];
			}
			if ($user['bakid'] != $user['steamid']) {
				 db('delete FROM '.$prefix.'socialgameviewer_users WHERE userid = '.$user['userid']);
			}
		}
		$this->load_player_informations($ples);
    }
}