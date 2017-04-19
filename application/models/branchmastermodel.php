<?php

class branchmastermodel extends CI_Model{
 
    /*@method InserMasterModel()
     * @param $data
     * @date 18.02.2016
     * @author Mithilesh
     */
      public function insertBranch($data){
       
         try {
            $this->db->trans_begin();
            $this->db->insert('branch_master',$data);
            
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
    
     public function updateBranch($branchUpd){
        $branchId =  $branchUpd['id'] ;
      
         try {
             $this->db->where('id',$branchId);
             $this->db->update('branch_master',$branchUpd);
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
  
    
    /*@method unitlisting()
     * @param 
     * @date 18.02.2016
     * @author Mithilesh
     */
    
      public function getBranchlist(){
        $sql = "SELECT * FROM `branch_master`";
        
        $query =$this->db->query($sql);
        if($query->num_rows()> 0){
            foreach ($query->result() as $rows){
                $data[]=array(
                    "id"=>$rows->id,
                   "branch"=>$rows->branch,
                    "branch_address"=>$rows->branch_address
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
    
     public function getBranchMasterdata($branchId) {

        $sql = "SELECT * FROM branch_master WHERE `branch_master`.`id`=".$branchId;
        $query = $this->db->query($sql);

           
        if($query->num_rows()> 0){
            foreach ($query->result() as $rows){
                $data=array(
                    "branch"=>$rows->branch,
                    "branch_address"=>$rows->branch_address
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