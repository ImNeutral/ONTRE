<?php

//require_once(LIB_PATH.DS."config.php");
require_once(LIB_PATH.DS."database.php");

class Thesis extends DatabaseObject {

	protected static $table_name="thesis";
	protected static $db_fields = array( 'id', 'adviser_id', 'date_posted', 'title', 'abstract',
											'filename', 'type', 'thesis_status', 'pdf_status' );
	
	public $id;
	public $adviser_id;
	public $date_posted;
	public $title;
	public $abstract;
	public $filename;
	public $type;
	public $thesis_status;
	public $pdf_status;

	public $max_file_size = 8388608;

	
	private $temp_path;
	protected $upload_dir="pdf";


	public $errors = array();
	
	function __construct() {
		
	}
 protected $upload_errors = array(
			UPLOAD_ERR_OK 				=> "No errors.",
			UPLOAD_ERR_INI_SIZE  	=> "Larger than upload_max_filesize.",
		  	UPLOAD_ERR_FORM_SIZE 	=> "Larger than form MAX_FILE_SIZE.",
		  	UPLOAD_ERR_PARTIAL 		=> "Partial upload.",
		  	UPLOAD_ERR_NO_FILE 		=> "No file.",
		  	UPLOAD_ERR_NO_TMP_DIR => "No temporary directory.",
		  	UPLOAD_ERR_CANT_WRITE => "Can't write to disk.",
		  	UPLOAD_ERR_EXTENSION 	=> "File upload stopped by extension."
		);

	public function attach_file($file) {
		
		if(!$file || empty($file) || !is_array($file)) {
			$this->error[] = "No file was uploaded";
			//echo "123456789";
			return false;
		} elseif($file['size'] > $this->max_file_size) {
			$this->errors[] = "The file size is too large.";
			return false;
		} elseif($file['error'] != 0) {
			$this->error[] = $this->upload_errors[$file['error']];
			//echo "123456789";
			return false; 
		} else {
			$this->temp_path	= $file['tmp_name'];
			$this->filename		= md5(basename($file['name'])) . date('dis');
			//$this->type			= $file['type'];
			//$this->size			= $file['size'];
			return true;
		}
	}

	//this method was overwritten frm the parent class. Because of error differences
	public function save() { 
		if(isset($this->id)) {
			$this->update();
		} else {
			if(!empty($this->errors)) { 
				return false; 
			}

			if(strlen($this->abstract) > 350) {
				$this->errors[] = "The abstract can only be 350 characters long.";
				return false;
			}

			if(empty($this->filename) || empty($this->temp_path)) {
				$this->errors[] = "The file location was not available." . $this->filename . $this->temp_path . "--" ;
				return false;
			}
			
			$target_path = SITE_ROOT.DS.'public'.DS.$this->upload_dir.DS.$this->filename; 
			if(file_exists($target_path)) {
				$this->errors[] = "The file {$this->filename} already exists.";
				return false;
			}

			if(move_uploaded_file($this->temp_path, $target_path)) {
				// Successs
				if($this->create()) {
					unset($this->temp_path);
					return true;
				}
			} else {
				$this->erros[] = "The file upload failed, possibly due to incorrect permissions on the upload folder.";
				return false;
			}

		}
		
	}

	public function save_new_pdf(){
		if(!empty($this->errors)) { 
				return false; 
		} 

		if(empty($this->filename) || empty($this->temp_path)) {
			$this->errors[] = "The file location was not available." . $this->filename . $this->temp_path . "--" ;
			return false;
		}
		
		$target_path = SITE_ROOT.DS.'public'.DS.$this->upload_dir.DS.$this->filename; 
		if(file_exists($target_path)) {
			$this->errors[] = "The file {$this->filename} already exists.";
			return false;
		}

		if(move_uploaded_file($this->temp_path, $target_path)) {
			// Successs
			unset($this->temp_path);
			return true;
		} else {
			$this->erros[] = "The file upload failed, possibly due to incorrect permissions on the upload folder.";
			return false;
		}
	
	}

	public function pdf_path() {
		return $this->upload_dir.'/'.$this->filename;
	}
	public function pdf_system_path() {
		return $this->upload_dir.DS.$this->filename;
	}

	public function size_as_text() {
		if($this->size < 1024) {
			return "{$this->size} bytes";
		} elseif($this->size < 1048576) {
			$size_kb = round($this->size / 1024);
			return "{$size_kb} KB";
		} else {
			$size_mb = round($this->size / 1048576, 1);
			return "{$size_mb} MB";
		}
	}

	public function comments() {
		return Comment::find_comments_on($this->id);
	}

	public function date_format(){
		return date_format(date_create($this->date_posted) ,"F d, Y. D");
	}	
	public function public_date_format(){
		return date_format(date_create($this->date_posted) ,"F d, Y");
	}

	public function destroy() {
		if($this->delete()) {
			$target_path = SITE_ROOT.DS.'public'.DS.$this->pdf_path();
			return unlink($target_path) ? true : false;		
		} else {
			
		}
	}

	public function destroy_pdf() {
		$target_path = SITE_ROOT.DS.'public'.DS.$this->pdf_system_path();
		return unlink($target_path) ? true : false ;
	}
 
	public static function find_by_college_id($college_id){
		global $database;
		$sql = "SELECT DISTINCT th.id, th.adviser_id, th.date_posted, th.title, th.abstract, th.filename, th.type, th.thesis_status, th.pdf_status ";
		$sql .= " FROM thesis th "; 
		$sql .= "inner join (";
		$sql .= "select ad.id as adviserId from adviser ad ";
		$sql .= "inner join department dept on ad.dept_id=dept.id where dept.college_id=" . $database->escape_value($college_id) . ") ad_dept ";
		$sql .= "WHERE th.adviser_id=ad_dept.adviserId ORDER BY th.date_posted DESC";

		$theses = Thesis::find_by_sql($sql);
		return $theses;
	}
	 
	
	public function editable(){
		$date_posted = date_create($this->date_posted);
		$date_now = date_create(date("Y-m-d H:i:s"));
		//2015-05-28 23:44:25
		//$date1=date_create("2013-01-01");
		//$date2=date_create("2013-02-10");
		
		$diff=date_diff($date_posted,$date_now); 
		
		
		//$date=date_create("2013-03-15 1:2:3");
		//echo date_format($date,"Y/m/d H:i:s");

		
		
		// %a outputs the total number of days
		return $diff->format("%a") >= 1 ? false : true;
		

	}
	
	public function get_all_keywords(){
		global $database;
		$sql = "SELECT k.keyword FROM keyword k ";
		$sql .= "inner join keyword_thesis kt on kt.keyword_id=k.id ";
		$sql .= "WHERE kt.thesis_id=" . $database->escape_value($this->id);
		$keyword_result = $database->query($sql);
		$keywords = array();
		while($keyword = mysql_fetch_array($keyword_result)){
			$keywords[] = $keyword['keyword'];
		}
		$keyword = implode(", " , $keywords);
		return $keyword;
	} 
	
	public function get_all_authors(){
		global $database;
		//SELECT a.id, a.fullname FROM author a 
		//inner join author_thesis at ON a.id=at.author_id WHERE at.thesis_id=2015015
		
		$sql = "SELECT a.id, a.fullname FROM author a ";
		$sql .= "inner join author_thesis at ON a.id=at.author_id ";
		$sql .= "WHERE at.thesis_id=" . $database->escape_value($this->id);
		$author_result = $database->query($sql);
		$authors = array();
		while($author = mysql_fetch_array($author_result)){
			$authors[] = $author['id'];
		}
		return $authors;
	}
	
	public function get_all_categories(){
		global $database;
		//SELECT c.id, c.name FROM category c 
		//inner join category_thesis ct ON c.id=ct.category_id WHERE ct.thesis_id=2015015
		$sql = "SELECT c.id, c.name FROM category c ";
		$sql .= "inner join category_thesis ct ON c.id=ct.category_id ";
		$sql .= "WHERE ct.thesis_id=" . $database->escape_value($this->id);
		
		$category_result = $database->query($sql);
		$categories = array();
		while($category = mysql_fetch_array($category_result)){
			$categories[] = $category['id'];
		}
		return $categories;
	}

	//common database methods
	
	public function update_thesis(){ 
		global $database;
		$sql = "UPDATE thesis ";
		$sql .= "SET abstract='" . $this->abstract;
		if($this->editable()){
			$sql .= "', title='" . $database->escape_value($this->title);
			$sql .= "', adviser_id='" . $database->escape_value($this->adviser_id); 
			$sql .= "', type='" . $database->escape_value($this->type);
		}
		$sql .= "', thesis_status='" . $database->escape_value($this->thesis_status);
		$sql .= "', pdf_status='" . $database->escape_value($this->pdf_status) ;
		$sql .= "' WHERE id=". $database->escape_value($this->id);
		
		$database->query($sql);
		return ($database->affected_rows() == 1) ? 1 : 0 ;
	}
	
	
	public static function search_thesis($search){
		global $database;
		$search_text = explode(" ",$database->escape_value($search));
		$text = "%";
		foreach($search_text as $t){
			if(strlen($t) > 0){
				$text .= trim($t) . "%";
			}
		} 
		$sql = "SELECT * FROM thesis ";
		$sql .= "WHERE title LIKE '" . $text . "' ORDER BY date_posted DESC";
		$theses = Thesis::find_by_sql($sql); 
		
		//SELECT th.id, th.adviser_id, th.date_posted, th.title, th.abstract, th.filename, th.type, th.thesis_status, th.pdf_status FROM thesis th inner join 
			//(SELECT ath.id, ath.author_id, ath.thesis_id FROM author_thesis ath INNER JOIN author a ON ath.author_id=a.id WHERE a.fullname LIKE "%sorronda%") 
				//ath on th.id=ath.thesis_id  
		
		//adviser search
			//SELECT th.id, th.adviser_id, th.date_posted, th.title, th.abstract, th.filename, th.type, th.thesis_status, th.pdf_status FROM thesis th 
			//	INNER JOIN adviser ad ON th.adviser_id=ad.id WHERE ad.fullname LIKE "%mudz%"
		$sql = "SELECT th.id, th.adviser_id, th.date_posted, th.title, th.abstract, th.filename, th.type, th.thesis_status, th.pdf_status ";
		$sql .= "FROM thesis th "; 
		$sql .= "INNER JOIN adviser ad ON th.adviser_id=ad.id ";
		$sql .= "WHERE ad.fullname LIKE '" . $text . "'";
		
		$thesis_set = Thesis::find_by_sql($sql);

		while($thesis_set){
			$theses[] = array_shift($thesis_set);
		}
		
		// author search
		$sql = "SELECT DISTINCT th.id, th.adviser_id, th.date_posted, th.title, th.abstract, th.filename, th.type, th.thesis_status, th.pdf_status ";
		$sql .= " FROM thesis th ";
		$sql .= "inner join (SELECT ath.id, ath.author_id, ath.thesis_id FROM author_thesis ath INNER JOIN author a ON ath.author_id=a.id WHERE a.fullname LIKE '" . $text . "') ath ";
		$sql .= "on th.id=ath.thesis_id "; 
		$thesis_set = Thesis::find_by_sql($sql);

		while($thesis_set){
			$theses[] = array_shift($thesis_set);
		}
		
		
		// keyword search
		$sql = "SELECT DISTINCT th.id, th.adviser_id, th.date_posted, th.title, th.abstract, th.filename, th.type, th.thesis_status, th.pdf_status ";
		$sql .= " FROM thesis th ";
		$sql .= "inner join (SELECT ath.id, ath.keyword_id, ath.thesis_id FROM keyword_thesis ath INNER JOIN keyword k ON ath.keyword_id=k.id WHERE k.keyword LIKE '" . $text . "') ath ";
		$sql .= "on th.id=ath.thesis_id "; 
		$thesis_set = Thesis::find_by_sql($sql);

		while($thesis_set){
			$theses[] = array_shift($thesis_set);
		}
		
		return $theses;
	}
	
	
	
	public static function find_by_category_id($cat_id){
		global $database;
		
		$sql = "SELECT th.id, th.adviser_id, th.date_posted, th.title, th.abstract, th.filename, th.type, th.thesis_status, th.pdf_status FROM thesis th ";
		$sql .= "INNER JOIN category_thesis cth ON th.id=cth.thesis_id ";
		$sql .= "WHERE cth.category_id=" . $database->escape_value($cat_id) . " AND th.thesis_status=1";
		
		$theses = Thesis::find_by_sql($sql); 
		
		return $theses;
		
	}
	
	
	public static function search_thesis_cleaned($search){
		global $database;
		$search_text = explode(" ",$database->escape_value($search));
		$text = "%";
		foreach($search_text as $t){
			if(strlen($t) > 0){
				$text .= trim($t) . "%";
			}
		} 
		$sql = "SELECT * FROM thesis ";
		$sql .= "WHERE title LIKE '" . $text . "' AND thesis_status=1 ORDER BY date_posted DESC";
		$theses = Thesis::find_by_sql($sql); 
		
		//SELECT th.id, th.adviser_id, th.date_posted, th.title, th.abstract, th.filename, th.type, th.thesis_status, th.pdf_status FROM thesis th inner join 
			//(SELECT ath.id, ath.author_id, ath.thesis_id FROM author_thesis ath INNER JOIN author a ON ath.author_id=a.id WHERE a.fullname LIKE "%sorronda%") 
				//ath on th.id=ath.thesis_id  
		
		//adviser search
			//SELECT th.id, th.adviser_id, th.date_posted, th.title, th.abstract, th.filename, th.type, th.thesis_status, th.pdf_status FROM thesis th 
			//	INNER JOIN adviser ad ON th.adviser_id=ad.id WHERE ad.fullname LIKE "%mudz%"
		$sql = "SELECT th.id, th.adviser_id, th.date_posted, th.title, th.abstract, th.filename, th.type, th.thesis_status, th.pdf_status ";
		$sql .= "FROM thesis th "; 
		$sql .= "INNER JOIN adviser ad ON th.adviser_id=ad.id ";
		$sql .= "WHERE ad.fullname LIKE '" . $text . "' AND th.thesis_status=1 ";
		foreach($theses as $thes){
			$sql .= " AND th.id!=" . $thes->id . " ";
		}
		$thesis_set = Thesis::find_by_sql($sql);

		while($thesis_set){
			$theses[] = array_shift($thesis_set);
		}
		
		// author search
		$sql = "SELECT DISTINCT th.id, th.adviser_id, th.date_posted, th.title, th.abstract, th.filename, th.type, th.thesis_status, th.pdf_status ";
		$sql .= " FROM thesis th ";
		$sql .= "inner join (SELECT ath.id, ath.author_id, ath.thesis_id FROM author_thesis ath INNER JOIN author a ON ath.author_id=a.id WHERE a.fullname LIKE '" . $text . "') ath ";
		$sql .= "on th.id=ath.thesis_id WHERE th.thesis_status=1 ";
		
		//$dummy_theses = $theses;
		/*if($d_theses = array_shift($dummy_theses)){
			$sql .= " WHERE th.id!= " . $d_theses->id;
		} */
		foreach($theses as $thes){
			$sql .= " AND th.id!=" . $thes->id . " ";
		}
		$thesis_set = Thesis::find_by_sql($sql);

		while($thesis_set){
			$theses[] = array_shift($thesis_set);
		}
		
		
		// keyword search
		$sql = "SELECT DISTINCT th.id, th.adviser_id, th.date_posted, th.title, th.abstract, th.filename, th.type, th.thesis_status, th.pdf_status ";
		$sql .= " FROM thesis th ";
		$sql .= "inner join (SELECT ath.id, ath.keyword_id, ath.thesis_id FROM keyword_thesis ath INNER JOIN keyword k ON ath.keyword_id=k.id WHERE k.keyword LIKE '" . $text . "') ath ";
		$sql .= "on th.id=ath.thesis_id WHERE th.thesis_status=1 ";
		
		/*$dummy_theses = $theses;
		if($d_theses = array_shift($dummy_theses)){
			$sql .= " WHERE th.id!= " . $d_theses->id;
		} */
		foreach($theses as $thes){
			$sql .= " AND th.id!=" . $thes->id . " ";
		} 
		$thesis_set = Thesis::find_by_sql($sql);

		while($thesis_set){
			$theses[] = array_shift($thesis_set);
		}
		
		return $theses;
	}
	
	
}
//SELECT * FROM thesis thes inner join 
//	(select ad.id as adviserId from adviser ad inner join department dept 
//		on ad.dept_id=dept.id where dept.college_id="5001") 
// 			ad_dept WHERE thes.adviser_id=ad_dept.adviserId

 


//SELECT * FROM thesis thes inner join 
//	(select ad.id from adviser ad inner join department dept 
//				on ad.dept_id=dept.id where dept.college_id="5001") 
//							ad_dept WHERE thes.adviser_id=ad_dept.id
if(isset($_SESSION['college_id'])){
	$theses = Thesis::find_by_college_id($_SESSION['college_id']);
}
?>  