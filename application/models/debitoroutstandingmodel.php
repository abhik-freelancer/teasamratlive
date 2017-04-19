<?php

class debitoroutstandingmodel extends CI_Model {
    
    
     public function getDebitorOutstandingList($year,$compny,$frmDate,$toDate){
     
      
         $data = array();
         $call_procedure = "CALL usp_DebtorsDue($year,$compny,"."'".$frmDate."'".","."'".$toDate."'".")";
         
      /*   echo $call_procedure;
         exit; 
       * 
       */
         
       //  $call_procedure = "CALL usp_TrialBalance(1,6,'2016-04-01','2017-03-31','2016-04-01')";
          $query = $this->db->query($call_procedure);
            if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
                 $data[] = array(
                       "accountId"=>$rows->AccountId,
                        "accountname"=>$rows->AccountDescription,
                        "opening"=>$rows->Opening,
                        "debitAmt"=>$rows->DebitAmount,
                        "creditAmt"=>$rows->CreditAmount,
                        "balance"=>$rows->Balance,
                        "balancetag"=>$rows->BalanceTag
                      );
               
                
            }
         
            return $data;
        } 
        
        else {
            return $data;
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
    
}
?>