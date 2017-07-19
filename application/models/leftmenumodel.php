<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class leftmenumodel extends CI_Model{
 
    /**
     * returns a list of articles
     * @return array 
     */
    function getLeftmenu($userid,$roleid){

	   $query = $this->db->query("	SELECT p.*,
								    GROUP_CONCAT(c.`id` ORDER BY c.menu_name ASC)  AS cid,
									GROUP_CONCAT(c.`menu_name` ORDER BY c.menu_name ASC)  AS cmenu,
									GROUP_CONCAT(c.`menu_link` ORDER BY c.menu_name ASC)  AS clink,
									GROUP_CONCAT(c.`menu_code` ORDER BY c.menu_name ASC)  AS ccode,
									GROUP_CONCAT(c.`is_parent` ORDER BY c.menu_name ASC)  AS cisparent/*,
									GROUP_CONCAT(sc.id) AS scid, 
									GROUP_CONCAT(sc.`parent_id`) AS scparentid, 
									GROUP_CONCAT(sc.`menu_name` ORDER BY sc.menu_name ASC)  AS scmenu,
									GROUP_CONCAT(sc.`menu_link` ORDER BY sc.menu_name ASC)  AS sclink,
									GROUP_CONCAT(sc.`menu_code` ORDER BY sc.menu_name ASC)  AS sccode */
									FROM menu AS p 
									LEFT JOIN menu AS c ON p.`id` = c.`parent_id` 
									/*LEFT JOIN menu AS sc ON c.`id` = sc.`parent_id` */
									WHERE p.is_parent = 'P' 
									GROUP BY p.`menu_name`");
	 
	   if($query -> num_rows() > 0)
	   {
		 
		  foreach($query->result() as $rows){
			$data[] = $rows;
			
			$childisparent  = explode(',',$rows->cisparent);
			$childcid  = explode(',',$rows->cid);
			$i = 0;
            foreach ($childisparent as $value)
			{
				$cisparent = $childisparent[$i];
				if($cisparent ==  "SC")
				{
					$subchildid = $childcid[$i];
					$subchild = $this->subchildMenu($childcid[$i]);
				}	$i++;
			}
			$data1['detail'] = $data;
			$data1['subchild_'.$subchildid] = $subchild;
			}
			//echo '<pre>';print_r($data1);echo'</pre>';
		   return $data1;
		
	   }
	   else
	   {
		 return false;
	   }
    }
	
	
	function subchildMenu($childid)
	{
	 		$query = $this->db->query("	SELECT 
										c.`menu_name`  AS scmenu,
										c.`menu_link`  AS sclink,
										c.`menu_code`  AS sccode,
										c.`is_parent`  AS sisp
										FROM menu AS p 
										LEFT JOIN menu AS c ON p.`id` = c.`parent_id` 
										WHERE p.is_parent = 'SC' 
										AND p.id = ".$childid." 
										ORDER BY c.menu_name ASC");
	  if($query -> num_rows() > 0)
	   {
		    foreach($query->result() as $rows)
			{
				$data[] = $rows;
			}
			return $data;
	   }
		
	}
	
	/*
	public function getAllMenu()
	{
		$data = array();
		$sql = "SELECT * FROM menu WHERE menu.`is_parent`='P'";
		 $query = $this->db->query($sql);
		   if ($query->num_rows() > 0) 
		   {
			  foreach($query->result() as $rows){
				
						$data[] = array(
							"first_menu_id" => $rows->id,
							"menu_name" => $rows->menu_name,
							"menu_link" => $rows->menu_link,
							"is_parent" => $rows->is_parent,
							"parent_id" => $rows->parent_id,
							"menu_code" => $rows->menu_code,
							"secondLevelMenu" => $this->getSecondLevelMenu($rows->id) 
						 );
					
                
				}
		   }
		   return $data;
	}
	
	public function getSecondLevelMenu($parentID)
	{
		$data = array();
		$sql = "SELECT * FROM menu WHERE menu.`parent_id`=".$parentID." ORDER BY menu.`menu_name` ASC";
		 $query = $this->db->query($sql);
		   if ($query->num_rows() > 0) 
		   {
			  foreach($query->result() as $rows){
				
						$data[] = array(
							"second_menu_id" => $rows->id,
							"second_menu_name" => $rows->menu_name,
							"second_menu_link" => $rows->menu_link,
							"second_is_parent" => $rows->is_parent,
							"second_parent_id" => $rows->parent_id,
							"second_menu_code" => $rows->menu_code,
							"thirdLevelMenu" => $this->getThirdLevelMenu($rows->id) 
						 );
					
                
				}
		   }
		   return $data;
	}
	
	public function getThirdLevelMenu($parentID)
	{
		$data = array();
		$sql = "SELECT * FROM menu WHERE menu.`parent_id`=".$parentID." ORDER BY menu.`menu_name` ASC";
		 $query = $this->db->query($sql);
		   if ($query->num_rows() > 0) 
		   {
			  foreach($query->result() as $rows){
				
						$data[] = array(
							"third_menu_id" => $rows->id,
							"third_menu_name" => $rows->menu_name,
							"third_menu_link" => $rows->menu_link,
							"third_is_parent" => $rows->is_parent,
							"third_parent_id" => $rows->parent_id,
							"third_menu_code" => $rows->menu_code
						);
					
                
				}
		   }
		   return $data;
	}
	
	*/
	
	
	/*******************************************************/
	
	public function getAllMenu()
	{
		$data = array();
		$sql = "SELECT * FROM menu_design WHERE menu_design.`is_parent`='P' ORDER BY menu_design.`menu_srl` ASC";
		 $query = $this->db->query($sql);
		   if ($query->num_rows() > 0) 
		   {
			  foreach($query->result() as $rows){
				
						$data[] = array(
							"first_menu_id" => $rows->id,
							"menu_name" => $rows->menu_name,
							"menu_link" => $rows->menu_link,
							"is_parent" => $rows->is_parent,
							"parent_id" => $rows->parent_id,
							"secondLevelMenu" => $this->getSecondLevelMenu($rows->id) 
						 );
					
                
				}
		   }
		   return $data;
	}
	
	public function getSecondLevelMenu($parentID)
	{
		$data = array();
		$sql = "SELECT * FROM menu_design WHERE menu_design.`parent_id`=".$parentID." ORDER BY menu_design.`menu_srl` ASC";
		 $query = $this->db->query($sql);
		   if ($query->num_rows() > 0) 
		   {
			  foreach($query->result() as $rows){
				
						$data[] = array(
							"second_menu_id" => $rows->id,
							"second_menu_name" => $rows->menu_name,
							"second_menu_link" => $rows->menu_link,
							"second_is_parent" => $rows->is_parent,
							"second_parent_id" => $rows->parent_id,
							"thirdLevelMenu" => $this->getThirdLevelMenu($rows->id) 
						 );
					
                
				}
		   }
		   return $data;
	}
	
	public function getThirdLevelMenu($parentID)
	{
		$data = array();
		$sql = "SELECT * FROM menu_design WHERE menu_design.`parent_id`=".$parentID." ORDER BY menu_design.`menu_srl` ASC";
		 $query = $this->db->query($sql);
		   if ($query->num_rows() > 0) 
		   {
			  foreach($query->result() as $rows){
				
						$data[] = array(
							"third_menu_id" => $rows->id,
							"third_menu_name" => $rows->menu_name,
							"third_menu_link" => $rows->menu_link,
							"third_is_parent" => $rows->is_parent,
							"third_parent_id" => $rows->parent_id,
							
						);
					
                
				}
		   }
		   return $data;
	}
	
	
	public function getSiteMapMenuByTitle($menuTitle)
	{
		$data = array();
		$sql = "SELECT * FROM menu_design WHERE menu_design.`menu_title`='".$menuTitle."' AND menu_design.`is_parent`='P'";
		
		$query = $this->db->query($sql);
		   if ($query->num_rows() > 0) 
		   {
			  foreach($query->result() as $rows)
			  {
						$data[] = array(
							"first_menu_id" => $rows->id,
							"menu_name" => $rows->menu_name,
							"menu_link" => $rows->menu_link,
							"is_parent" => $rows->is_parent,
							"parent_id" => $rows->parent_id,
							"secondLevelMenu" => $this->getSecondLevelMenu($rows->id) 
						 );
					
                
				}
		   }
		   return $data;
	}
	
	
	
	
	
	
}
?>