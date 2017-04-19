<?php

class trialbalancemodel extends CI_Model {
    
    public function getTrialBalanceData($compny,$year,$frmDate,$toDate,$fiscalSdt){
     
      
         $data = array();
         $call_procedure = "CALL usp_TrialBalance($compny,$year,"."'".$frmDate."'".","."'".$toDate."'".","."'".$fiscalSdt."'".")";
         
       /* echo $call_procedure;
         exit;*/
         
       //  $call_procedure = "CALL usp_TrialBalance(1,6,'2016-04-01','2017-03-31','2016-04-01')";
          $query = $this->db->query($call_procedure);
            if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
                 $data[] = array(
                   /*    "totalDebit"=>$rows->_totalDebit,
                       "totalCredit"=>$rows->_totalCredit,
                       "AccountName"=>$rows->_AccountName */
                     
                     "account"=>$rows->Account,
                     "opening"=> $rows->Opening,
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
    
   
}

?>