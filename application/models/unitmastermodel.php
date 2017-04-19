<?php

class unitmastermodel extends CI_Model{
 
    
      public function InserMasterModel($data){
       
         try {
            $this->db->trans_begin();
            $this->db->insert('unitmaster',$data);
            
             // echo($this->db->last_query());exit;

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                return false;
            } else {
                $this->db->trans_commit();
                return true;
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    } 

    
     public function UpdateData($unitMaster){
        $unitid =  $unitMaster['unitid'] ;
       
        
        /* echo "<pre>";
            print_r($unitMaster);
        echo "</pre>";*/
         try {
             $this->db->where('unitid', $unitid);
             $this->db->update('unitmaster' ,$unitMaster);
             

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                return false;
            } else {
                $this->db->trans_commit();
                return true;
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
       
        
    }
   /*   public  function unitlisting() {
        $this->db->select('*');
        $this->db->from('unitmaster');
        $this->db->order_by("unitName","asc");

    echo    $query = $this->db->get();

        if ($query->num_rows() > 0) {

            foreach ($query->result() as $rows) {
                $data[] = $rows;
            }
            return $data;
        } else {
            return false;
        }
    }*/
	
    
      public function unitlisting(){
        $sql = "SELECT * FROM unitmaster";
        
        $query =$this->db->query($sql);
        if($query->num_rows()> 0){
            foreach ($query->result() as $rows){
                $data[]=array(
                    "unitid"=>$rows->unitid,
                   "unitName"=>$rows->unitName
                );
            }

          return $data;
        }
        else{
            return $data=array();
        }
        
    }
    
     public function getUnitMasterData($unitId) {

        $sql = "SELECT * FROM unitmaster WHERE `unitmaster`.`unitid`='".$unitId."'";
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            $rows = $query->row();
            return $rows;
        } else {
            return FALSE;
        }
    }
}
?>