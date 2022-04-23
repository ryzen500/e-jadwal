<?php 

/**
 * SharedController Controller
 * @category  Controller / Model
 */
class SharedController extends BaseController{
	
	/**
     * guru_user_role_id_option_list Model Action
     * @return array
     */
	function guru_user_role_id_option_list(){
		$db = $this->GetModel();
		$sqltext = "SELECT role_id AS value, role_name AS label FROM roles";
		$queryparams = null;
		$arr = $db->rawQuery($sqltext, $queryparams);
		return $arr;
	}

	/**
     * guru_email_value_exist Model Action
     * @return array
     */
	function guru_email_value_exist($val){
		$db = $this->GetModel();
		$db->where("email", $val);
		$exist = $db->has("guru");
		return $exist;
	}

	/**
     * guru_username_value_exist Model Action
     * @return array
     */
	function guru_username_value_exist($val){
		$db = $this->GetModel();
		$db->where("username", $val);
		$exist = $db->has("guru");
		return $exist;
	}

	/**
     * jadwal_tahun_ajaran_option_list Model Action
     * @return array
     */
	function jadwal_tahun_ajaran_option_list(){
		$db = $this->GetModel();
		$sqltext = "SELECT DISTINCT id_tahun AS value , id_tahun AS label FROM tahun_ajaran ORDER BY label ASC";
		$queryparams = null;
		$arr = $db->rawQuery($sqltext, $queryparams);
		return $arr;
	}

	/**
     * jadwal_Hari_option_list Model Action
     * @return array
     */
	function jadwal_Hari_option_list(){
		$db = $this->GetModel();
		$sqltext = "SELECT DISTINCT id_hari AS value , id_hari AS label FROM hari ORDER BY label ASC";
		$queryparams = null;
		$arr = $db->rawQuery($sqltext, $queryparams);
		return $arr;
	}

	/**
     * jadwal_Waktu_option_list Model Action
     * @return array
     */
	function jadwal_Waktu_option_list(){
		$db = $this->GetModel();
		$sqltext = "SELECT DISTINCT id_waktu AS value , id_waktu AS label FROM waktu ORDER BY label ASC";
		$queryparams = null;
		$arr = $db->rawQuery($sqltext, $queryparams);
		return $arr;
	}

	/**
     * jadwal_Mapel_option_list Model Action
     * @return array
     */
	function jadwal_Mapel_option_list(){
		$db = $this->GetModel();
		$sqltext = "SELECT DISTINCT id_mapel AS value , id_mapel AS label FROM mapel ORDER BY label ASC";
		$queryparams = null;
		$arr = $db->rawQuery($sqltext, $queryparams);
		return $arr;
	}

	/**
     * jadwal_guru_option_list Model Action
     * @return array
     */
	function jadwal_guru_option_list(){
		$db = $this->GetModel();
		$sqltext = "SELECT DISTINCT kodeguru AS value , username AS label FROM guru ORDER BY label ASC";
		$queryparams = null;
		$arr = $db->rawQuery($sqltext, $queryparams);
		return $arr;
	}

}
