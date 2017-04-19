<?php

/**
 * Description of customeradvancemodel
 *
 * @author Abhik 
 */
class customeradvancemodel extends CI_Model {

    //put your code here
    private $advanceId;
    private $dateofadvance;
    private $voucherId;
    private $advanceamount;
    private $customeraccountId;
    private $isFullAdjusted;
    private $companyId;
    private $yearId;

    public function customeradvancemodel() {
        $this->advanceId = 0;
        $this->dateofadvance = "";
        $this->advanceamount = 0;
        $this->companyId = 0;
        $this->customeraccountId = 0;
        $this->voucherId = 0;
        $this->isFullAdjusted = 'N';
        $this->yearId = 0;
    }

    public function insertCustomerAdvance($advanceArray = array()) {
        $voucherMasterArray = array();
        $voucherDetailArray = array();
        try {
            $this->db->trans_begin();
            $voucherMasterArray["voucher_number"] =  $this->getSerialNumber($advanceArray["companyid"], $advanceArray["yearid"]); //$advanceArray["voucherNumber"];
            $voucherMasterArray["voucher_date"] = date("Y-m-d", strtotime($advanceArray["dateofadvance"])); //date("Y-m-d", strtotime($searcharray['saleBillDate']));
            $voucherMasterArray["narration"] = $advanceArray["narration"];
            if ($advanceArray["cheqno"] != "") {
                $voucherMasterArray["cheque_number"] = $advanceArray["cheqno"];
            } else {
                $voucherMasterArray["cheque_number"] = NULL;
            }

            if ($advanceArray["cheqdt"] == "") {
                $voucherMasterArray["cheque_date"] = NULL;
            } else {
                $voucherMasterArray["cheque_date"] = date("Y-m-d", strtotime($advanceArray["cheqdt"]));
            }
            $voucherMasterArray["transaction_type"] = "CADV"; // customer advance
            $voucherMasterArray["created_by"] = $advanceArray["userId"];
            $voucherMasterArray["serial_number"] =0; //$advanceArray["voucherSerial"];
            $voucherMasterArray["company_id"] = $advanceArray["companyid"];
            $voucherMasterArray["year_id"] = $advanceArray["yearid"];
            
            $this->db->insert('voucher_master', $voucherMasterArray); // voucher master Id
            $InsertedVoucherMasterId = $this->db->insert_id(); //voucher master id


            //$this->updateGeneralvoucherSerial($advanceArray);

            $voucherDetailArray["debitAccountId"] = $advanceArray["cashorbank"];
            $voucherDetailArray["creditAccountId"] = $advanceArray["customeraccountid"];
            $voucherDetailArray["voucher_amount"] = $advanceArray["advanceamount"];
            $voucherDetailArray["voucherMasterId"] = $InsertedVoucherMasterId;
            $this->InsertVoucherDetail($voucherDetailArray);

            //advance insert

            $advVend["dateofadvance"] = date("Y-m-d", strtotime($advanceArray["dateofadvance"]));
            $advVend["voucherid"] = $InsertedVoucherMasterId;
            $advVend["advanceamount"] = $advanceArray["advanceamount"];

            $advVend["customeraccountid"] = $advanceArray["customeraccountid"];
            $advVend["isfulladjusted"] = 'N';
            $advVend["companyid"] = $advanceArray["companyid"];
            $advVend["yearid"] = $advanceArray["yearid"];
            $this->db->insert('customeradvance', $advVend);
            //echo( $this->db->last_query());

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
 private function getSerialNumber($company,$year){
        $lastnumber = (int)(0);
        $tag = "";
        $noofpaddingdigit = (int)(0);
        $autoSaleNo="";
        $yeartag ="";
        $sql="SELECT
                id,
                SERIAL,
                moduleTag,
                lastnumber,
                noofpaddingdigit,
                module,
                companyid,
                yearid,
                yeartag
            FROM serialmaster
            WHERE companyid=".$company." AND yearid=".$year." AND module='VC' LOCK IN SHARE MODE";
        
                  $query = $this->db->query($sql);
		  if ($query->num_rows() > 0) {
			  $row = $query->row(); 
			  $lastnumber = $row->lastnumber;
                          $tag = $row->moduleTag;
                          $noofpaddingdigit = $row->noofpaddingdigit;
                          $yeartag = $row->yeartag;
                          
                          
		  }
          $digit = (int)(log($lastnumber,10)+1) ;  
          if($digit==5){
              $autoSaleNo = $tag."/".$lastnumber."/".$yeartag;
          }elseif ($digit==4) {
              $autoSaleNo = $tag."/0".$lastnumber."/".$yeartag;
            
        }elseif($digit==3){
            $autoSaleNo = $tag."/00".$lastnumber."/".$yeartag;
        }elseif($digit==2){
            $autoSaleNo = $tag."/000".$lastnumber."/".$yeartag;
        }elseif($digit==1){
            $autoSaleNo = $tag."/0000".$lastnumber."/".$yeartag;
        }
        $lastnumber = $lastnumber + 1;
        
        //update
        $data = array(
        'SERIAL' => $lastnumber,
        'lastnumber' => $lastnumber
        );
        $array = array('companyid' => $company, 'yearid' => $year, 'module' => "VC");
        $this->db->where($array); 
        $this->db->update('serialmaster', $data);
        
        return $autoSaleNo;
        
    }
    
    
    
    private function InsertVoucherDetail($voucherDetailArray) {

        $voucherMasterId = $voucherDetailArray["voucherMasterId"];
        $details = array();
        $this->db->where('voucher_master_id', $voucherMasterId);
        $this->db->delete('voucher_detail');
        // var_dump($voucherDetailArray);
        //Credit section
        $details["voucher_master_id"] = $voucherMasterId;
        $details["account_master_id"] = $voucherDetailArray["creditAccountId"];
        $details["voucher_amount"] = $voucherDetailArray["voucher_amount"];
        $details["is_debit"] = 'N';
        $details["account_id_for_trial"] = NULL;
        $details["subledger_id"] = NULL;
        $details["is_master"] = NULL;
        $this->db->insert('voucher_detail', $details);
        //echo( $this->db->last_query());
        //debit
        $details["voucher_master_id"] = $voucherMasterId;
        $details["account_master_id"] = $voucherDetailArray["debitAccountId"];
        $details["voucher_amount"] = $voucherDetailArray["voucher_amount"];
        $details["is_debit"] = 'Y';
        $details["account_id_for_trial"] = NULL;
        $details["subledger_id"] = NULL;
        $details["is_master"] = NULL;
        $this->db->insert('voucher_detail', $details);
        //echo( $this->db->last_query());
    }

    public function updateGeneralvoucherSerial($data) {
        // $moduleType="vouchertype";
        $updtArr = array();
        $newSerialNo = $data['lastSrNo'];
        $seriallTable['srl_number'] = $newSerialNo;
        $updtArr = array('company_id' => $data['companyId'], 'year_id' => $data['yearId']);
        $this->db->where($updtArr);
        $this->db->update('serials', $seriallTable);
    }
    
    
  public function updateCustomerAdvance($advanceArray) {
        $voucherMasterArray = array();
        $voucherDetailArray = array();
        try {
            
            $voucherMasterArray["voucher_date"] = date("Y-m-d", strtotime($advanceArray["advanceDate"])); //date("Y-m-d", strtotime($searcharray['saleBillDate']));
            $voucherMasterArray["narration"] = $advanceArray["narration"];
            if ($advanceArray["cheqno"] != "") {
                $voucherMasterArray["cheque_number"] = $advanceArray["cheqno"];
            } else {
                $voucherMasterArray["cheque_number"] = NULL;
            }

            if ($advanceArray["cheqdt"] == "") {
                $voucherMasterArray["cheque_date"] = NULL;
            } else {
                $voucherMasterArray["cheque_date"] = date("Y-m-d", strtotime($advanceArray["cheqdt"]));
            }
            
            
            //var_dump($voucherMasterArray);exit;

            $this->db->trans_begin();
            $this->db->where('id',$advanceArray['voucherId']);
            $this->db->update('voucher_master', $voucherMasterArray);
           
            

            $voucherDetailArray["debitAccountId"] = $advanceArray["cashorbank"];
            $voucherDetailArray["creditAccountId"] = $advanceArray["customeraccountid"];
            $voucherDetailArray["voucher_amount"] = $advanceArray["advanceamount"];
            $voucherDetailArray["voucherMasterId"] = $advanceArray['voucherid'];
            $this->InsertVoucherDetail($voucherDetailArray);

            //advance insert

            $advVend["dateofadvance"] = date("Y-m-d", strtotime($advanceArray["dateofadvance"]));
            $advVend["advanceamount"] = $advanceArray["advanceamount"];
            $advVend["customeraccountid"] = $advanceArray["customeraccountid"];
            
            $this->db->where('advanceId',$advanceArray['advanceId']);
            $this->db->update('customeradvance', $advVend);
           
            

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
    
    
    
  /*  public function getCustomerAdvanceList($companyId) {

        $sql = "SELECT
                `advanceId`,
                DATE_FORMAT(`dateofadvance`,'%d-%m-%Y') as dateofadvance,
                `voucherid`,
                `advanceamount`,
                `customeraccountid`,
                account_master.`account_name`,
                voucher_master.`voucher_number`,
                DATE_FORMAT(voucher_master.`cheque_date`,'%d-%m-%Y') AS cheque_date,
                voucher_master.`cheque_number`,
                voucher_master.`narration`,
                `isfulladjusted`,
                `companyid`,
                `yearid`
                FROM `customeradvance`
                INNER JOIN voucher_master ON customeradvance.`voucherid` = voucher_master.`id`
                INNER JOIN account_master ON customeradvance.`customeraccountid` = account_master.`id`
                WHERE customeradvance.`companyid` = " . $companyId;


        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
                $data[] = array(
                    "advanceId" => $rows->advanceId,
                    "dateofadvance" => $rows->dateofadvance,
                    "voucherid" => $rows->voucherid,
                    "advanceamount" => $rows->advanceamount,
                    "customeraccountid" => $rows->customeraccountid,
                    "cheque_date" => $rows->cheque_date,
                    "cheque_number" => $rows->cheque_number,
                    "narration" => $rows->narration,
                    "account_name" => $rows->account_name,
                    "voucher_number" => $rows->voucher_number);
            }


            return $data;
        } else {
            return $data;
        }
    }

 */   
    
    
    public function getCustomerAdvanceList($companyId,$yearId){
        $data=array();
        $sql ="SELECT 
                    customeradvance.`advanceId`,
                    IFNULL(SUM(customeradvanceadadjustment.`totalamountadjusted`),0) AS totalAdjst,
                    IF ((IFNULL(SUM(customeradvanceadadjustment.`totalamountadjusted`),0))= customeradvance.`advanceamount`,0,1) AS editable,
                    DATE_FORMAT(customeradvance.`dateofadvance`,'%d-%m-%Y') AS advanceDate,
                    customeradvance.`voucherid`,
                    customeradvance.`advanceamount`,
                    customeradvance.`customeraccountid`,
                    account_master.`account_name`,
                    customeradvance.`isfulladjusted`,
                    customeradvance.`companyid`,
                    customeradvance.`yearid`,
                    DATE_FORMAT(voucher_master.`cheque_date`,'%d-%m-%Y') AS cheque_date,
                    voucher_master.`cheque_number`,
                    voucher_master.`narration`,
                    voucher_master.voucher_number 
                FROM
                    `customeradvance` 
                    INNER JOIN `voucher_master` 
                    ON customeradvance.`voucherid` = voucher_master.`id` 
                    INNER JOIN `account_master` 
                    ON customeradvance.`customeraccountid` = account_master.`id` 
                    LEFT JOIN `customeradvanceadadjustment` ON   customeradvance.`advanceId` = customeradvanceadadjustment.`advanceid`
                    WHERE customeradvance.`companyid` =".$companyId. 
                    " AND customeradvance.`yearid` = " .$yearId.
               " GROUP BY customeradvance.`advanceId`";
        
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
                $data[] = array(
                    "advanceId" => $rows->advanceId,
                    "advanceDate" => $rows->advanceDate,
                    "voucherId" => $rows->voucherid,
                    "advanceAmount" => $rows->advanceamount,
                    "editable"=>$rows->editable,
                    "customeraccountid" => $rows->customeraccountid,
                    "cheque_date" => $rows->cheque_date,
                    "cheque_number" => $rows->cheque_number,
                    "narration"=>$rows->narration,
                    "account_name"=>$rows->account_name,
                    "voucher_number"=>$rows->voucher_number);
            }


            return $data;
        } else {
            return $data;
        }
    }    
    
    
    
    public function getCustomerAdvanceById($customeradvanceId) {

        $sql = "SELECT
        `advanceId`,
        DATE_FORMAT(`dateofadvance`,'%d-%m-%Y')AS dateofadvance,
        `voucherid`,
        `advanceamount`,
        `customeraccountid`,
        account_master.`account_name`,
        voucher_master.`voucher_number`,
        DATE_FORMAT(voucher_master.`cheque_date`,'%d-%m-%Y') AS cheque_date,
        voucher_master.`cheque_number`,
        voucher_master.`narration`,
        `isfulladjusted`,
        `companyid`,
        `yearid`
      FROM `customeradvance`
      INNER JOIN voucher_master ON customeradvance.`voucherid` = voucher_master.`id`
      INNER JOIN account_master ON customeradvance.`customeraccountid` = account_master.`id`
      WHERE customeradvance.`advanceId`=" . $customeradvanceId;
        
        
         $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
                $data = array(
                    "advanceId" => $rows->advanceId,
                    "dateofadvance" => $rows->dateofadvance,
                    "voucherid" => $rows->voucherid,
                    "advanceamount" => $rows->advanceamount,
                    "customeraccountid" => $rows->customeraccountid,
                    "cheque_date" => $rows->cheque_date,
                    "cheque_number" => $rows->cheque_number,
                    "narration" => $rows->narration,
                    "account_name" => $rows->account_name,
                    "voucher_number" => $rows->voucher_number,
                     "cashorbankId"=>  $this->getDebitAccountId($rows->voucherid));
            }


            return $data;
        } else {
            return $data;
        }
        
    }
    
    
    
     public function getDebitAccountId($voucherId){
        $sql=" SELECT `voucher_detail`.`account_master_id` FROM `voucher_detail` WHERE `voucher_detail`.`voucher_master_id`=".$voucherId
              ." AND `voucher_detail`.`is_debit`='Y' ";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            
            $data=$this->db->query($sql)->row()->account_master_id;
            


            return $data;
        } else {
            return $data;
        }
        
    }
    

}
