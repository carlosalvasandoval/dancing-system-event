<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Datatables
{
	private $table;
	private $key_table;
	private $select;
	private $join = [];
	private $where = [];
	private $like = [];
	private $order_by = "";
	private $group_by = "";

	public function setFrom($table){
		$this->table = $table;
	}

	public function setSelect($str){
		$this->select = $str;
	}

	public function setJoin($table, $condicion, $type="INNER"){
		$this->join[] = [$table, $condicion, $type];
	}
    
    public function setLeftJoin($table, $condicion, $type="LEFT"){
		$this->join[] = [$table, $condicion, $type];
	}

	public function setWhere($column, $val = ""){
		$this->where[] = [$column, $val];
	}
    public function setLike($column, $val){
		$this->like[] = [$column, $val];
	}

	public function setOrderBy($text){
		$this->order_by = $text;
	}

	public function setGroupBy($text){
		$this->group_by = $text;
	}


	public function getData()
	{
		// Loads CodeIgniter's Database Configuration
		$CI =& get_instance();
		$CI->load->database();

		$aColumns = explode(", ", $this->select);
		$searchColumns = $aColumns;
		$sTable = $this->table;

		//id table
		$idColumn = $aColumns[count($aColumns)-1];
		$idColumn = explode(".", $idColumn);
		if(count($idColumn)>1){
			$idColumn = $idColumn[1];
		}else{
			$idColumn = $idColumn[0];
		}

		//column ordenar al final
		for ($i=0; $i < count($aColumns) ; $i++) {
			$result = explode(" AS ", $aColumns[$i]);
			if(count($result)>1){
				$aColumns[$i] = trim($result[1]);
			}
		}

		//columnas para buscar
		for ($i=0; $i < count($searchColumns) ; $i++) {
			$result = explode(" AS ", $searchColumns[$i]);
			if(count($result)>1){
				$searchColumns[$i] = trim($result[0]);
			}
		}

		// Paging
		$limit = "";
		if(isset($_GET['iDisplayStart']) && $_GET['iDisplayLength'] != '-1')
		{		
			if((int)$_GET['iDisplayStart']!=0){
				$limit .= " LIMIT ".(int)$_GET['iDisplayLength']." OFFSET ".(int)$_GET['iDisplayStart']." ";
			}else{
				$limit .= " LIMIT ".(int)$_GET['iDisplayLength'];
			}
		}
        
		// Ordering
		$text_order_by_datatable = "";
		if(isset($_GET['iSortCol_0']))
		{
			for($i=0; $i<intval($_GET['iSortingCols']); $i++)
			{
				$coma = ($i<intval($_GET['iSortingCols'])-1)?", ":"";
				if($_GET['bSortable_'.intval($_GET['iSortCol_'.$i])] == 'true')
				{
					$text_order_by_datatable.=" ".$searchColumns[(int)$_GET['iSortCol_'.$i]]." ".strtoupper($_GET['sSortDir_'.$i]).$coma;
				}
			}
		}

		$text_order_by = "";
		if( !empty($text_order_by_datatable) && !empty($this->order_by) )
		{
			$text_order_by_datatable .= ", ";
		}

		$text_order_by_datatable = ($this->order_by!="")?$text_order_by_datatable.$this->order_by:$text_order_by_datatable;
		$text_order_by .= (!empty($text_order_by_datatable)) ? " ORDER BY ".$text_order_by_datatable : " ";
		/* Multi column filtering */
		$where = "";
		$text_where_datatable = "";
		for ( $i = 0 ; $i < count($searchColumns) ; $i++ )
		{
			if ( ( isset($_GET['bSearchable_'.$i]) && $_GET['bSearchable_'.$i] == "true" ) && $_GET['sSearch'] != '' )
			{
				if($i==0){ $type=""; }else{ $type=" OR ";  }
				$text_where_datatable .= $type.$searchColumns[$i]." LIKE '%".$_GET['sSearch']."%' ";
			}
		}
		if($text_where_datatable!=""){
			$text_where_datatable =" (".$text_where_datatable.") ";
		}

		//where
		for ($i=0; $i < count($this->where); $i++) {
			if($i==0 && $text_where_datatable!=""){ $type=" AND "; }elseif($i==0 && $where==""){ $type=""; }else{ $type=" AND "; }
			$operador = " ";
			if( !empty($this->where[$i][1]) )
			{
				if(!strpos($this->where[$i][0], "=")){
					$operador = " = ";
				}
				if(!is_numeric($this->where[$i][1]) && strlen($this->where[$i][1])==1){
					$this->where[$i][1] = "'".$this->where[$i][1]."'";
				}
			}
			$text_where_datatable.=$type.$this->where[$i][0].$operador.$this->where[$i][1]." ";
		}
		$where = ($text_where_datatable!="")?" WHERE ".$text_where_datatable : "";
		
        $like = '';
        $text_like_datatable = '';
        for ($i=0; $i < count($this->like); $i++) {
			if($i==0 && $text_like_datatable!=""){ $type=" AND "; }elseif($i==0 && $like==""){ $type=""; }else{ $type=" AND "; }
			$operador = " ";
			if(!strpos($this->like[$i][0], "=")){
				$operador = " like ";
			}
			if(!is_numeric($this->like[$i][1]) && strlen($this->like[$i][1])==1){
				$this->like[$i][1] = "'".$this->like[$i][1]."'";
			}
			$text_like_datatable.=$type.$this->like[$i][0].$operador.$this->like[$i][1]." ";
		}
        if($where!='')
        {
          $like = ($text_like_datatable!="")?" AND ".$text_like_datatable : "";
        }else{
          $like = ($text_like_datatable!="")?" WHERE ".$text_like_datatable : "";
        }

       //group by
        $text_group_by = ( !empty($this->group_by) ) ? " GROUP BY ".$this->group_by." " : $this->group_by;
        
        
		//join
		$join = "";
		for ($i=0; $i < count($this->join); $i++) {
			if(!isset($this->join[$i][2])){ $type_join="INNER"; }else{ $type_join=$this->join[$i][2]; }
			$join.=" ".$type_join." JOIN ".$this->join[$i][0]." ON ".$this->join[$i][1]." ";
		}



		$sql = "SELECT ".$this->select." FROM ".$sTable.$join.$where.$like.$text_group_by.$text_order_by.$limit;
		//echo $sql;die;
		$rResult = $CI->db->query($sql);

		// Total data set length
		$iTotal = count($rResult->result());

		// Data set length after filtering
		$new_query = $CI->db->query("SELECT COUNT(*) AS found_rows FROM ".$sTable.$join.$where.$limit);
		if(count($new_query->row())>0){
			$iFilteredTotal = $new_query->row()->found_rows;
		}else{
			$iFilteredTotal = $iTotal;
		}

		// Output
		$output = array(
			'sEcho' => intval($_GET['sEcho']),
			'iTotalRecords' => $iTotal,
			'iTotalDisplayRecords' => $iFilteredTotal,
			'url' => urldecode($_SERVER['REQUEST_URI']),
			'aaData' => array()
		);
		foreach($rResult->result_array() as $aRow)
		{
			$row = array();
			for($i=0; $i<count($aColumns); $i++)
			{
				$key = explode(".", $aColumns[$i]);
				$key = (count($key)>1) ? trim($key[1]) : trim($key[0]);
				$row[] = $aRow[$key];
				if (trim($key) == trim($idColumn)) { $row['DT_RowId'] = $aRow[$key]; } // Sets DT_RowId
			}
			$output['aaData'][] = $row;
		}

		//url export
		$url= urldecode($_SERVER['REQUEST_URI']);
		$output['links'] = "$url";
		return $_GET['callback'].'('.json_encode( $output ).');';
	}
}
?>