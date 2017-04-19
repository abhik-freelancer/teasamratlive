<?php

class subledgermodel extends CI_Model{
 
    /*@method insertSubledger()
     * @param $data
     * @date 18.02.2016
     * @author Mithilesh
     * 
     */
      public function insertSubledger($data){
       
         try {
            $this->db->trans_begin();
            $this->db->insert('subledger',$data);
            
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
 /*@method UpdateSubledger()
     * @param $unitMaster
     * @date 18.02.2016
     * @author Mithilesh
     */
    
     public function UpdateSubledger($unitMaster){
        $subledgerid =  $unitMaster['subledgerid'] ;
       
        
        /* echo "<pre>";
            print_r($unitMaster);
        echo "</pre>";*/
         try {
             $this->db->where('subledgerid', $subledgerid);
             $this->db->update('subledger' ,$unitMaster);
             

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
   
   /*@method subledgerlisting()
     * @param 
     * @date 18.02.2016
     * @author Mithilesh
     */
    
      public function subledgerlisting($cmpny){
        $sql = "SELECT * FROM subledger WHERE subledger.company_id=".$cmpny;
        
        $query =$this->db->query($sql);
        if($query->num_rows()> 0){
            foreach ($query->result() as $rows){
                $data[]=array(
                    "subledgerid"=>$rows->subledgerid,
                   "subledger"=>$rows->subledger
                );
            }

          return $data;
        }
        else{
            return $data=array();
        }
        
    }
    /*@method getLedgerData()
     * @param $subledId
     * @date 18.02.2016
     * @author Mithilesh
     */
    
     public function getLedgerData($subledId) {

        $sql = "SELECT * FROM subledger WHERE `subledger`.`subledgerid`='".$subledId."'";
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