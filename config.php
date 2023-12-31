<?php
class db  
{
	//ubah untuk menyesuaikan data base 
	var $host = "arezzo-db.id.domainesia.com";
	var $username = "dasdevcl_rekam_medis_mysql";
	var $pass = "_APsFt8vjuD]";
	var $db = "dasdevcl_rekam_medis";
	var $res;
	var $link = "http://localhost/persediaan/";
	//membuat koneksi langsung terjalankan ketika membuat object dari class db  
	function __construct()
	{
		# code...
		$this->res = mysqli_connect($this->host, $this->username, $this->pass) ;
		mysqli_select_db($this->res,$this->db) ;
	}

	function insert($table ,$data){ // fungsi inseert dapat digunakandengan mengirimkan paramter tabel yang di insert dan data baru berupa array asosiativ yang berisi kolom dan value nya 
		$keys = implode(', ', array_keys($data));
		$values = "'" .implode("','", array_values($data)) . "'";
		$sql = 'insert into '.$table.'('.$keys.') values ('.$values.')';
		// echo($sql);
		if(!$result = mysqli_query($this->res,$sql)){ 
			return ('There was an error running the query [' . $this->res->error . ']'); 
		}
		else{
			// echo "Data inserted.";
			return "sukses";
		}
	}


	function manual_query($query){
		$stmt = $this->res->prepare($query);
		$stmt->execute();

// 		$data = $stmt->get_result();
		// if (!is_array($data)) return;
		$meta = $stmt->result_metadata();
        $params = array();
        while ($field = $meta->fetch_field()) {
            $params[] = &$row[$field->name];
        }
        
        call_user_func_array(array($stmt, 'bind_result'), $params);
        
        $hasil = array();
        while ($stmt->fetch()) {
            $hasil[] = array_map('utf8_encode', $row);
        }
		if (isset($hasil)) {
			# code...
			return $hasil;
		}else{
			return null;
		}
	}

	function edit($table,$col_new,$val_new,$col_clause,$val_clause){// fungsi edit dapat dilakukan dengan mengirimkan nama tabel , kolom yang diedit beserta isi nya dan kolom yang menjadi kalusa  beserta isi nya sebagai kata kunci 
		$stmt = $this->res->prepare("UPDATE `$table` SET `$col_new` = ? WHERE `$table`.`$col_clause` = ?");
		$stmt->bind_param('ss',$val_new,$val_clause);
		$stmt->execute();
		$data = $stmt->get_result();
	}

	function delete($table,$col_clause,$val_clause){// fungsi delete dapat dilakukan dengan mengirimkan nama tabel , kolom yang menjadi klausa dan isi nya sebagai kata kunci   
		$stmt = $this->res->prepare("DELETE from `$table` WHERE `$table`.`$col_clause` = ?");
		$stmt->bind_param('s',$val_clause);
		$stmt->execute();
		$data = $stmt->get_result();
	}


}