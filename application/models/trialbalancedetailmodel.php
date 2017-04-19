<?php

class trialbalancedetailmodel extends CI_Model {
    
    public function getTrialBalanceData($compny,$year,$frmDate,$toDate,$fiscalSdt){
     
      
         $data = array();
         $call_procedure = "CALL usp_trialDetail($compny,$year,"."'".$frmDate."'".","."'".$toDate."'".","."'".$fiscalSdt."'".")";
         
        /* echo $call_procedure;
         exit;*/
         
       //  $call_procedure = "CALL usp_TrialBalance(1,6,'2016-04-01','2017-03-31','2016-04-01')";
          $query = $this->db->query($call_procedure);
            if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
                 $data[] = array(
                       "account"=>$rows->Account,
                       "opening"=>$rows->Opening,
                       "debit"=>$rows->Debit,
                       "credit"=>$rows->Credit,
                       "closingDebit"=>$rows->closingDebit,
                       "closingCredit"=>$rows->closingCredit
                               
                     );
               
                
            }
         
            return $data;
        } 
        
        else {
            return $data;
        }
        
    }
   
    public function getFiscalStartDt($yearid){
        $sql="SELECT start_date FROM financialyear WHERE financialyear.id=".$yearid;
        $query = $this->db->query($sql);
         if ($query->num_rows() > 0) {
                foreach ($query->result() as $rows) {
                    return $rows->start_date;
                }
         }
        
    }
    
    public function getAccountingPeriod($yearid){
        $data = array();
         $sql="SELECT * FROM financialyear WHERE financialyear.id=".$yearid;
         $query = $this->db->query($sql);
         if ($query->num_rows() > 0) {
                foreach ($query->result() as $rows) {
                 $data=array(
                     "start_date"=>$rows->start_date,
                     "end_date"=>$rows->end_date
                 );
                          
                }
                return $data;
         }else{
              return $data;
         }
         
         
    }
    public function getTypeOfAccount(){
        $data=array();
        $sql = "SELECT group_master.`id`,group_master.`group_name`
                FROM group_master WHERE group_master.`group_name` LIKE 'Sundry%' ";
        $query = $this->db->query($sql);
         if ($query->num_rows() > 0) {
                foreach ($query->result() as $rows) {
                 $data[]=array(
                     "id"=>$rows->id,
                     "group_name"=>$rows->group_name
                 );
                          
                }
                return $data;
         }else{
              return $data;
         }
    }
    
     public function getGroupName($groupId){
        $data = array();
         $sql="SELECT group_master.`id`,group_master.`group_name` FROM group_master WHERE group_master.id=".$groupId;
         $query = $this->db->query($sql);
         if ($query->num_rows() > 0) {
                foreach ($query->result() as $rows) {
                 $data=array(
                    "id"=>$rows->id,
                     "group_name"=>$rows->group_name
                 );
                          
                }
                return $data;
         }else{
              return $data;
         }
         
         
    }
    
    
    
     public function sundrycreddebtrtrialData($compny,$year,$frmDate,$toDate,$fiscalSdt,$grpId){
     
      
         $data = array();
         $call_procedure = "CALL sp_sundrydebtorAndCreditortrial($compny,$year,"."'".$frmDate."'".","."'".$toDate."'".","."'".$fiscalSdt."'".",".$grpId.")";
         
         /*echo $call_procedure;
         exit;*/
         
    
          $query = $this->db->query($call_procedure);
            if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
                 $data[] = array(
                       "account"=>$rows->Account,
                       "opening"=>$rows->Opening,
                       "debit"=>$rows->Debit,
                       "credit"=>$rows->Credit,
                       "closingDebit"=>$rows->closingDebit,
                       "closingCredit"=>$rows->closingCredit
                               
                     );
               
                
            }
         
            return $data;
        } 
        
        else {
            return $data;
        }
        
    }
    
   
}

?>