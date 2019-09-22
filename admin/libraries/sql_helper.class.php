<?php
class SQLHelper extends db
{
	function cget_row($table_name="", $where="")
	{		
		if ( $where != "" ) {
			$where = ' WHERE ' . $where ;
		}else{
			$where = '';
		}
		$sql = "SELECT * FROM $table_name " . $where;
		$row = $this->get_row($sql) ;
		return $row;
	}	


	function insert_id($sql)
	{
		mysql_query($sql);
		$id = mysql_insert_id();
		return $id;
	}


	function insert_all($tablename="",$values=array())
	{
		$fields			= "";
		$data_values	= "";
		$ctr			= 0;
		foreach($values as $key=> $value)
		{
			if( $ctr == 0 )
			{
				if($value == "now")
				{
					$fields			.= "`$key`";
					$data_values	.= "NOW()";
				}
				else
				{
					$fields			.= "`$key`";
					$data_values	.= "'$value'";
				}
			}
			else
			{
				if($value == "now")
				{
					$fields			.= ",`$key`";
					$data_values	.= ", NOW()";
				}
				else
				{
					$fields			.= ",`$key`";
					$data_values	.= ",'$value'";	
				}
			}
			$ctr++;
		}
		echo $sql	= "INSERT INTO `$tablename` ( $fields ) VALUES ($data_values)";
		//exit();
		return $this->insert_id($sql);
	}
	
	
	function update_all($tablename="", $id="", $id_value,$values=array())
	{		
		$data_values	= "";
		$ctr			= 0;
		foreach($values as $key=> $value)
		{
			if( $ctr == 0 )
			{
				if($value == "now")
					$data_values	.= "`$key` = NOW() ";
				else
					$data_values	.= "`$key` = '$value' ";
			}
			else
			{
				if($value == "now")
					$data_values	.= ",`$key` = NOW() ";
				else
					$data_values	.= ",`$key` = '$value' ";
			}
			$ctr++;
		}
		echo $sql	= "UPDATE `$tablename` SET $data_values  WHERE `$id` = $id_value ";
		//exit();
		$this->query($sql);
		return mysql_affected_rows();		
	}
	
	
	function delete($tablename="",$id="",$id_value)
	{
		$sql	= "DELETE FROM `$tablename`
					WHERE `$id` = $id_value ";
		$this->query($sql);
		return mysql_affected_rows();		
	}
	
	
	function where_like($fields=array(), $value="")
	{
		$where = " WHERE (";
		$ctr = 0;
		foreach($fields as $field) 
		{
			$where .= " $field LIKE '%$value%'";
			$ctr++;
			if ( $ctr < count($fields) ) {
				$where .= " OR";
			}
			
		}
		return $where . ") ";
	}
	
	function sql_count($sql)
	{
		$result = 0;
		$rs     = mysql_query($sql);

		if( mysql_num_rows($rs) > 0 )
		{
			$result = mysql_fetch_array($rs);
			$result = $result[0];
		}

		return $result;
	}


	function addto_available_colors($product_id, $color_ids=array())
	{
		$count_insert = 0;
		foreach ($color_ids as $color_id)
		{
			$count_exists = $this->get_var("SELECT count(*) FROM `bp_product_available_colors` WHERE `product_id` = $product_id AND `color_id` = $color_id");
			if ( $count_exists == 0 )
			{
				$sql = "INSERT INTO `bp_product_available_colors` ( product_id, color_id )
						VALUES ( $product_id, $color_id )";		
				if ( $this->insert_id($sql) > 0 )
				{
					$count_insert++;
				}
			}
		}
		return $count_insert;
	}	


	function deletefrom_available_colors($product_id, $color_ids=array())
	{
		$count_delete = 0;
		// Get product's current available colors
		$product_colors = $this->get_results("SELECT * FROM `bp_product_available_colors` WHERE `product_id` = $product_id");
		foreach ( $product_colors as $product_color )		
		{
			// delete color from `bp_product_available_colors` when current colors is not included in the new selections
			$count_exists = 0;
			foreach ($color_ids as $color_id)
			{													
				if ( $product_color->color_id == $color_id ) 
				{
					$count_exists++;
				}
			}

			if ( $count_exists == 0 ) {
				$sql = "DELETE FROM `bp_product_available_colors` WHERE `product_id` = $product_id AND `color_id` = ".$product_color->color_id;
				$this->query($sql);
				if ( mysql_affected_rows() > 0 ) 
				{
					$count_delete++;
				}
			}					

		}
		return $count_delete;
	}	

	function updateimgto_available_colors($product_id, $color_ids=array(),$photos=array())
	{
		$i = 0;
		$count = 0;
		foreach ($color_ids as $color_id)
		{
			$sql = "UPDATE `bp_product_available_colors` SET actual_photo = '".$photos[$i]."' 
					WHERE product_id = '$product_id' AND color_id = '$color_id'";
			$i++;
			$this->query($sql);
			if (mysql_affected_rows() > 0) {
				$count++; 
			}
		}
		return $count;
	}	


	function addto_available_sizes($product_id, $size_ids=array())
	{
		$count_insert = 0;
		foreach ($size_ids as $size_id)
		{
			$count_exists =  $this->get_var("SELECT count(*) FROM `bp_product_available_sizes` WHERE `product_id` = $product_id AND `size_id` = $size_id");
			if ( $count_exists == 0 )
			{
				$sql = "INSERT INTO `bp_product_available_sizes` ( product_id, size_id )
						VALUES ( $product_id, $size_id )";		
				if ( $this->insert_id($sql) > 0 )
				{
					$count_insert++;
				}
			}
		}
		return $count_insert;
	}	
	
	
	function deletefrom_available_sizes($product_id, $size_ids=array())
	{
		$count_delete = 0;
		// Get product's current available sizes
		$product_sizes = $this->get_results("SELECT * FROM `bp_product_available_sizes` WHERE `product_id` = $product_id");
		foreach ( $product_sizes as $product_size )		
		{
			// delete size from `bp_product_available_sizes` when current sizes is not included in the new selections
			$count_exists = 0;
			foreach ($size_ids as $size_id)
			{													
				if ( $product_size->size_id == $size_id ) 
				{
					$count_exists++;
				}
			}

			if ( $count_exists == 0 ) {
				$sql = "DELETE FROM `bp_product_available_sizes` WHERE `product_id` = $product_id AND `size_id` = ".$product_size->size_id;
				$this->query($sql);
				if ( mysql_affected_rows() > 0 ) 
				{
					$count_delete++;
				}
			}					

		}
		return $count_delete;
	}	

}

?>