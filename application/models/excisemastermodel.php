<?php

class excisemastermodel extends CI_Model{
 
    /*@method InserMasterModel()
     * @param $data
     * @date 18.02.2016
     * @author Mithilesh
     */
      public function insertExcisemaster($data){
       
         try {
            $this->db->trans_begin();
            $this->db->insert('excise_master',$data);
            
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
    
    /*@method UpdateData()
     * @param $unitMaster
     * @date 18.02.2016
     * @author Mithilesh
     */
    
     public function updateExciseMaster($exciseUpd){
        $exciseId =  $exciseUpd['id'] ;
        /* echo "<pre>";
            print_r($rawMatUpd);
        echo "</pre>";*/
         try {
             $this->db->where('id',$exciseId);
             $this->db->update('excise_master',$exciseUpd);
           //  echo($this->db->last_query());exit;

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
  
    
    /*@method unitlisting()
     * @param 
     * @date 18.02.2016
     * @author Mithilesh
     */
    
      public function exciseMasterList(){
        $sql = "SELECT * FROM `excise_master`";
        
        $query =$this->db->query($sql);
        if($query->num_rows()> 0){
            foreach ($query->result() as $rows){
                $data[]=array(
                    "id"=>$rows->id,
                   "rate"=>$rows->rate,
                    "description"=>$rows->description
                );
            }

          return $data;
        }
        else{
            return $data=array();
        }
        
    }
    
     /*@method getUnitMasterData()
     * @param $unitId
     * @date 18.02.2016
     * @author Mithilesh
     */
    
     public function getExciseMasterdata($exciseId) {

        $sql = "SELECT * FROM excise_master WHERE `excise_master`.`id`='".$exciseId."'";
        $query = $this->db->query($sql);

      /*  if ($query->num_rows() > 0) {
            $rows = $query->row();
            return $rows;
        } else {
            return FALSE;
        }*/
           
        if($query->num_rows()> 0){
            foreach ($query->result() as $rows){
                $data=array(
                    "rate"=>$rows->rate,
                    "description"=>$rows->description
                );
            }

          return $data;
        }
        else{
            return $data=array();
        }
    }
}
?>