<?php

class generalledgermodel extends CI_Model {
    
    public function getGeneralLedgerReport($compny,$year,$accId,$frmDate,$toDate,$fiscalSdt){
     
      
         $data = array();
         $call_procedure = "CALL usp_generalLedger($compny,$year,$accId,"."'".$frmDate."'".","."'".$toDate."'".","."'".$fiscalSdt."'".")";
         
        /* echo $call_procedure;
         exit; */
         
       //  $call_procedure = "CALL usp_TrialBalance(1,6,'2016-04-01','2017-03-31','2016-04-01')";
          $query = $this->db->query($call_procedure);
            if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
                 $data[] = array(
                       "account"=>$rows->_accountName,
                        "narration"=>$rows->_narration,
                        "voucherdate"=>$rows->_voucherdate,
                        "vouchernumber"=>$rows->_vouchernumber,
                        "accounttag"=>$rows->_acctag,
                        "transtype"=>$rows->_trantype,
                        "debitamt"=>$rows->_debitamount,
                        "creditamt"=>$rows->_creditamount
                        
                       
                               
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
    
    public function getAccountnameById($accId){
         $data = array();
        $sql = "SELECT * FROM account_master WHERE account_master.id=".$accId;
        $query = $this->db->query($sql);
        
       if ($query->num_rows() > 0) {
                foreach ($query->result() as $rows) {
                    return $rows->account_name;
                }
         }
         
    }
    
    public function getAccountList($compny,$yearid){
        $data = array();
        $sql="SELECT account_master.id AS accId,
                account_master.account_name,
                account_opening_master.`financialyear_id`,
                account_opening_master.`account_master_id`
                FROM account_master 
                LEFT JOIN `account_opening_master` 
                ON account_master.id=account_opening_master.`account_master_id` AND account_opening_master.`financialyear_id`=".$yearid." 
                WHERE account_master.`company_id`=".$compny." ORDER BY account_master.account_name" ;
        
         $query = $this->db->query($sql);
            if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
                 $data[] = array(
                       "accId"=>$rows->accId,
                       "accname"=>$rows->account_name
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