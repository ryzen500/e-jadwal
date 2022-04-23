<?php 
/**
 * Jadwal Page Controller
 * @category  Controller
 */
class JadwalController extends SecureController{
	function __construct(){
		parent::__construct();
		$this->tablename = "jadwal";
	}
	/**
     * List page records
     * @param $fieldname (filter record by a field) 
     * @param $fieldvalue (filter field value)
     * @return BaseView
     */
	function index($fieldname = null , $fieldvalue = null){
		$request = $this->request;
		$db = $this->GetModel();
		$tablename = $this->tablename;
		$fields = array("jadwal.id_jadwal", 
			"jadwal.tahun_ajaran", 
			"tahun_ajaran.tahun_ajaran AS tahun_ajaran_tahun_ajaran", 
			"jadwal.Hari", 
			"hari.nama_hari AS hari_nama_hari", 
			"jadwal.Waktu", 
			"waktu.waktu AS waktu_waktu", 
			"jadwal.Mapel", 
			"mapel.nama_mapel AS mapel_nama_mapel", 
			"jadwal.guru", 
			"guru.nama AS guru_nama");
		$pagination = $this->get_pagination(MAX_RECORD_COUNT); // get current pagination e.g array(page_number, page_limit)
		//search table record
		if(!empty($request->search)){
			$text = trim($request->search); 
			$search_condition = "(
				jadwal.id_jadwal LIKE ? OR 
				jadwal.tahun_ajaran LIKE ? OR 
				jadwal.Hari LIKE ? OR 
				jadwal.Waktu LIKE ? OR 
				jadwal.Mapel LIKE ? OR 
				jadwal.guru LIKE ?
			)";
			$search_params = array(
				"%$text%","%$text%","%$text%","%$text%","%$text%","%$text%"
			);
			//setting search conditions
			$db->where($search_condition, $search_params);
			 //template to use when ajax search
			$this->view->search_template = "jadwal/search.php";
		}
		$db->join("tahun_ajaran", "jadwal.tahun_ajaran = tahun_ajaran.id_tahun", "INNER");
		$db->join("hari", "jadwal.Hari = hari.id_hari", "INNER");
		$db->join("waktu", "jadwal.Waktu = waktu.id_waktu", "INNER");
		$db->join("mapel", "jadwal.Mapel = mapel.id_mapel", "INNER");
		$db->join("guru", "jadwal.guru = guru.kodeguru", "INNER");
		if(!empty($request->orderby)){
			$orderby = $request->orderby;
			$ordertype = (!empty($request->ordertype) ? $request->ordertype : ORDER_TYPE);
			$db->orderBy($orderby, $ordertype);
		}
		else{
			$db->orderBy("jadwal.id_jadwal", ORDER_TYPE);
		}
		if($fieldname){
			$db->where($fieldname , $fieldvalue); //filter by a single field name
		}
		$tc = $db->withTotalCount();
		$records = $db->get($tablename, $pagination, $fields);
		$records_count = count($records);
		$total_records = intval($tc->totalCount);
		$page_limit = $pagination[1];
		$total_pages = ceil($total_records / $page_limit);
		$data = new stdClass;
		$data->records = $records;
		$data->record_count = $records_count;
		$data->total_records = $total_records;
		$data->total_page = $total_pages;
		if($db->getLastError()){
			$this->set_page_error();
		}
		$page_title = $this->view->page_title = "Jadwal";
		$this->view->report_filename = date('Y-m-d') . '-' . $page_title;
		$this->view->report_title = $page_title;
		$this->view->report_layout = "report_layout.php";
		$this->view->report_paper_size = "A4";
		$this->view->report_orientation = "portrait";
		$this->render_view("jadwal/list.php", $data); //render the full page
	}
	/**
     * View record detail 
	 * @param $rec_id (select record by table primary key) 
     * @param $value value (select record by value of field name(rec_id))
     * @return BaseView
     */
	function view($rec_id = null, $value = null){
		$request = $this->request;
		$db = $this->GetModel();
		$rec_id = $this->rec_id = urldecode($rec_id);
		$tablename = $this->tablename;
		$fields = array("jadwal.id_jadwal", 
			"jadwal.tahun_ajaran", 
			"tahun_ajaran.tahun_ajaran AS tahun_ajaran_tahun_ajaran", 
			"jadwal.Hari", 
			"hari.nama_hari AS hari_nama_hari", 
			"jadwal.Waktu", 
			"waktu.waktu AS waktu_waktu", 
			"jadwal.Mapel", 
			"mapel.nama_mapel AS mapel_nama_mapel", 
			"jadwal.guru", 
			"guru.nama AS guru_nama");
		if($value){
			$db->where($rec_id, urldecode($value)); //select record based on field name
		}
		else{
			$db->where("jadwal.id_jadwal", $rec_id);; //select record based on primary key
		}
		$db->join("tahun_ajaran", "jadwal.tahun_ajaran = tahun_ajaran.id_tahun", "INNER");
		$db->join("hari", "jadwal.Hari = hari.id_hari", "INNER");
		$db->join("waktu", "jadwal.Waktu = waktu.id_waktu", "INNER");
		$db->join("mapel", "jadwal.Mapel = mapel.id_mapel", "INNER");
		$db->join("guru", "jadwal.guru = guru.kodeguru", "INNER");  
		$record = $db->getOne($tablename, $fields );
		if($record){
			$page_title = $this->view->page_title = "View  Jadwal";
		$this->view->report_filename = date('Y-m-d') . '-' . $page_title;
		$this->view->report_title = $page_title;
		$this->view->report_layout = "report_layout.php";
		$this->view->report_paper_size = "A4";
		$this->view->report_orientation = "portrait";
		}
		else{
			if($db->getLastError()){
				$this->set_page_error();
			}
			else{
				$this->set_page_error("No record found");
			}
		}
		return $this->render_view("jadwal/view.php", $record);
	}
	/**
     * Insert new record to the database table
	 * @param $formdata array() from $_POST
     * @return BaseView
     */
	function add($formdata = null){
		if($formdata){
			$db = $this->GetModel();
			$tablename = $this->tablename;
			$request = $this->request;
			//fillable fields
			$fields = $this->fields = array("tahun_ajaran","Hari","Waktu","Mapel","guru");
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'tahun_ajaran' => 'required',
				'Hari' => 'required',
				'Waktu' => 'required',
				'Mapel' => 'required',
				'guru' => 'required',
			);
			$this->sanitize_array = array(
				'tahun_ajaran' => 'sanitize_string',
				'Hari' => 'sanitize_string',
				'Waktu' => 'sanitize_string',
				'Mapel' => 'sanitize_string',
				'guru' => 'sanitize_string',
			);
			$this->filter_vals = true; //set whether to remove empty fields
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if($this->validated()){
				$rec_id = $this->rec_id = $db->insert($tablename, $modeldata);
				if($rec_id){
					$this->set_flash_msg("Record added successfully", "success");
					return	$this->redirect("jadwal");
				}
				else{
					$this->set_page_error();
				}
			}
		}
		$page_title = $this->view->page_title = "Add New Jadwal";
		$this->render_view("jadwal/add.php");
	}
	/**
     * Update table record with formdata
	 * @param $rec_id (select record by table primary key)
	 * @param $formdata array() from $_POST
     * @return array
     */
	function edit($rec_id = null, $formdata = null){
		$request = $this->request;
		$db = $this->GetModel();
		$this->rec_id = $rec_id;
		$tablename = $this->tablename;
		 //editable fields
		$fields = $this->fields = array("id_jadwal","tahun_ajaran","Hari","Waktu","Mapel","guru");
		if($formdata){
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'tahun_ajaran' => 'required',
				'Hari' => 'required',
				'Waktu' => 'required',
				'Mapel' => 'required',
				'guru' => 'required',
			);
			$this->sanitize_array = array(
				'tahun_ajaran' => 'sanitize_string',
				'Hari' => 'sanitize_string',
				'Waktu' => 'sanitize_string',
				'Mapel' => 'sanitize_string',
				'guru' => 'sanitize_string',
			);
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if($this->validated()){
				$db->where("jadwal.id_jadwal", $rec_id);;
				$bool = $db->update($tablename, $modeldata);
				$numRows = $db->getRowCount(); //number of affected rows. 0 = no record field updated
				if($bool && $numRows){
					$this->set_flash_msg("Record updated successfully", "success");
					return $this->redirect("jadwal");
				}
				else{
					if($db->getLastError()){
						$this->set_page_error();
					}
					elseif(!$numRows){
						//not an error, but no record was updated
						$page_error = "No record updated";
						$this->set_page_error($page_error);
						$this->set_flash_msg($page_error, "warning");
						return	$this->redirect("jadwal");
					}
				}
			}
		}
		$db->where("jadwal.id_jadwal", $rec_id);;
		$data = $db->getOne($tablename, $fields);
		$page_title = $this->view->page_title = "Edit  Jadwal";
		if(!$data){
			$this->set_page_error();
		}
		return $this->render_view("jadwal/edit.php", $data);
	}
	/**
     * Update single field
	 * @param $rec_id (select record by table primary key)
	 * @param $formdata array() from $_POST
     * @return array
     */
	function editfield($rec_id = null, $formdata = null){
		$db = $this->GetModel();
		$this->rec_id = $rec_id;
		$tablename = $this->tablename;
		//editable fields
		$fields = $this->fields = array("id_jadwal","tahun_ajaran","Hari","Waktu","Mapel","guru");
		$page_error = null;
		if($formdata){
			$postdata = array();
			$fieldname = $formdata['name'];
			$fieldvalue = $formdata['value'];
			$postdata[$fieldname] = $fieldvalue;
			$postdata = $this->format_request_data($postdata);
			$this->rules_array = array(
				'tahun_ajaran' => 'required',
				'Hari' => 'required',
				'Waktu' => 'required',
				'Mapel' => 'required',
				'guru' => 'required',
			);
			$this->sanitize_array = array(
				'tahun_ajaran' => 'sanitize_string',
				'Hari' => 'sanitize_string',
				'Waktu' => 'sanitize_string',
				'Mapel' => 'sanitize_string',
				'guru' => 'sanitize_string',
			);
			$this->filter_rules = true; //filter validation rules by excluding fields not in the formdata
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if($this->validated()){
				$db->where("jadwal.id_jadwal", $rec_id);;
				$bool = $db->update($tablename, $modeldata);
				$numRows = $db->getRowCount();
				if($bool && $numRows){
					return render_json(
						array(
							'num_rows' =>$numRows,
							'rec_id' =>$rec_id,
						)
					);
				}
				else{
					if($db->getLastError()){
						$page_error = $db->getLastError();
					}
					elseif(!$numRows){
						$page_error = "No record updated";
					}
					render_error($page_error);
				}
			}
			else{
				render_error($this->view->page_error);
			}
		}
		return null;
	}
	/**
     * Delete record from the database
	 * Support multi delete by separating record id by comma.
     * @return BaseView
     */
	function delete($rec_id = null){
		Csrf::cross_check();
		$request = $this->request;
		$db = $this->GetModel();
		$tablename = $this->tablename;
		$this->rec_id = $rec_id;
		//form multiple delete, split record id separated by comma into array
		$arr_rec_id = array_map('trim', explode(",", $rec_id));
		$db->where("jadwal.id_jadwal", $arr_rec_id, "in");
		$bool = $db->delete($tablename);
		if($bool){
			$this->set_flash_msg("Record deleted successfully", "success");
		}
		elseif($db->getLastError()){
			$page_error = $db->getLastError();
			$this->set_flash_msg($page_error, "danger");
		}
		return	$this->redirect("jadwal");
	}
}
