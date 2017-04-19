<?php

class generalvouchermodel extends CI_Model{
 
   
    
      public function getVoucherList(){
  
        $sql="SELECT `voucher_master`.`id` AS voucherMasterId,
                `voucher_master`.`voucher_number`,
                DATE_FORMAT(`voucher_master`.`voucher_date`, '%d-%m-%Y') AS VoucherDate,
                `voucher_master`.`paid_to`,
                `voucher_master`.`vouchertype`  FROM voucher_master 
				WHERE `voucher_master`.`transaction_type`='GV';";
        
        $query =$this->db->query($sql);
        if($query->num_rows()> 0){
            foreach ($query->result() as $rows){
                $data[]=array(
                   "voucherMasterId"=>$rows->voucherMasterId,
                   // "voucherDtlId"=>$rows->voucherDtlId,
                    "voucher_number"=>$rows->voucher_number,
                    "VoucherDate"=>$rows->VoucherDate,
                    "paid_to"=>$rows->paid_to,
                    "vouchertype"=>$rows->vouchertype,
                    "accountDtl"=>$this->getVoucherDetaildata($rows->voucherMasterId)
                    
                );
            }

          return $data;
        }
        else{
            return $data=array();
        }
        
    }
    
    public function getVoucherDetaildata($vouchmastId){
        $sql="SELECT 
            `account_master`.`account_name`,
            `voucher_detail`.`voucher_amount`,
            `voucher_detail`.`is_debit` AS drCr
             FROM `voucher_detail`
             INNER JOIN `account_master`
             ON `account_master`.`id`=`voucher_detail`.`account_master_id`
             WHERE `voucher_detail`.`voucher_master_id`='".$vouchmastId."'";
          $query = $this->db->query($sql);
            if ($query->num_rows() > 0) {
                foreach ($query->result() as $rows) {
                    $data[] = $rows;
                }


                return $data;
            } else {
                return $data;
            }
        
    }

	public function getVoucherNumber($voucherMastId){
        $sql="SELECT `voucher_master`.`voucher_number` FROM `voucher_master` WHERE `voucher_master`.`id`='".$voucherMastId."' AND `voucher_master`.`transaction_type`='GV'";
		$query = $this->db->query($sql);
       if ($query->num_rows() > 0) {
           $row = $query->row();
            return $row->voucher_number;
       } 
       else{
           return 0;
       }
    } 
    
public function getAccountName($tag=""){
		if($tag=='GV'){
        $sql="SELECT `account_master`.`id` AS acountId,
            `group_master`.`id` AS groupMasterId,
            `account_master`.`account_name`
            FROM account_master
            INNER JOIN `group_master`
            ON `group_master`.`id`=`account_master`.`group_master_id`
            WHERE `group_master`.`group_name` NOT IN('Sundry Debtors','Sundry Creditors','Cash Balance','Bank Balance')";
        }
		elseif($tag=='CN'){
			$sql="SELECT `account_master`.`id` AS acountId,
				`group_master`.`id` AS groupMasterId,
				`account_master`.`account_name`
				FROM account_master
				INNER JOIN `group_master`
				ON `group_master`.`id`=`account_master`.`group_master_id`
				WHERE `group_master`.`group_name` IN ('Cash Balance','Bank Balance')";
		}
                
                elseif($tag=="JV"){
                    $sql="SELECT `account_master`.`id` AS acountId,
				`group_master`.`id` AS groupMasterId,
				`account_master`.`account_name`
				FROM account_master
				INNER JOIN `group_master`
				ON `group_master`.`id`=`account_master`.`group_master_id`
				WHERE `group_master`.`group_name` NOT IN ('Cash Balance','Bank Balance')";
                }
         $query =$this->db->query($sql);
        if($query->num_rows()> 0){
            foreach ($query->result() as $rows){
                $data[]=array(
                   "acountId"=>$rows->acountId,
                    "groupMasterId"=>$rows->groupMasterId,
                    "account_name"=>$rows->account_name
                );
            }

          return $data;
        }
        else{
            return $data=array();
        }
    }
    
    public function getAccountByGroupMaster(){
        $sql="SELECT `account_master`.`account_name`,
            `account_master`.`id` AS accountId,
            `group_master`.`id` AS groupmasterId,
            `group_master`.`group_name`
            FROM `account_master`
            INNER JOIN `group_master`
            ON `group_master`.`id`=`account_master`.`group_master_id`
            WHERE `group_master`.`group_name` IN('Cash Balance','Bank Balance')";
        
           $query =$this->db->query($sql);
           if($query->num_rows()> 0){
               foreach ($query->result() as $rows){
                   $data[]=array(
                      "accountId"=>$rows->accountId,
                       "groupmasterId"=>$rows->groupmasterId,
                       "group_name"=>$rows->group_name,
                       "account_name"=>$rows->account_name
                   );
               }

             return $data;
        }
        else{
            return $data=array();
        }
        
    }
    
    public function getGeneralVoucherMasterData($voucherMaterId){
        $sql="SELECT 
            `voucher_master`.`voucher_number`,
            DATE_FORMAT(`voucher_master`.`voucher_date`,'%d-%m-%Y') AS VoucherDate,
            `voucher_master`.`vouchertype`,
            `voucher_master`.`paid_to`,
            `voucher_master`.`cheque_number`,
            DATE_FORMAT(`voucher_master`.`cheque_date`,'%d-%m-%Y') AS checqueDate,
            `voucher_master`.`unitid`,
            `voucher_master`.`narration`,
            `voucher_master`.serial_number,
            `voucher_detail`.`voucher_amount`,
            `account_master`.`id` AS accountId,
            `account_master`.`account_name`
             FROM `voucher_master`
             INNER JOIN `voucher_detail`
             ON `voucher_detail`.`voucher_master_id`=`voucher_master`.`id`
             INNER JOIN `account_master`
            ON `voucher_detail`.`account_master_id`=`account_master`.`id`
            WHERE `voucher_master`.`id`='".$voucherMaterId."' AND `voucher_detail`.`is_master`='Y'";
            $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
                $data = array(
                    "voucher_number"=>$rows->voucher_number,
                    "voucher_date"=>$rows->VoucherDate,
                    "vouchertype"=>$rows->vouchertype,
                    "paid_to"=>$rows->paid_to,
                    "cheque_number"=>$rows->cheque_number,
                    "cheque_date"=>$rows->checqueDate,
                    "unitid"=>$rows->unitid,
                    "narration"=>$rows->narration,
                    "serial_number"=>$rows->serial_number,
                    "voucher_amount"=>$rows->voucher_amount,
                    "accountId"=>$rows->accountId,
                    "account_name"=>$rows->account_name
                 );
            }


            return $data;
        } else {
            return $data;
        }
    }
   /* 
    public function getGeneralDtlAccountName($voucherMaterId){
        
    }*/
    public function getGeneralVoucherDetailData($voucherMaterId){
        $sql="SELECT 
            `voucher_master`.`id` AS voucherMastId,
            `voucher_detail`.`id` AS VoucherDtlId,
            `voucher_detail`.`is_debit`,
            `account_master`.`account_name`,
            `subledger`.`subledgerid` AS subLedgerId,
            `subledger`.`subledger`,
            `account_master`.`id` AS accountId,
            `voucher_detail`.`voucher_amount`
            FROM `voucher_detail`
            INNER JOIN `voucher_master`
            ON `voucher_detail`.`voucher_master_id`=`voucher_master`.`id`

            INNER JOIN `account_master`
            ON `account_master`.`id`=`voucher_detail`.`account_master_id`
            LEFT JOIN `subledger`
            ON `subledger`.`subledgerid`=`voucher_detail`.`subledger_id`
            WHERE `voucher_master`.`id`='".$voucherMaterId."' AND `voucher_detail`.`is_master`='N'";
        
         $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
                $data[] = array(
                    "voucherMastId"=>$rows->voucherMastId,
                    "VoucherDtlId"=>$rows->VoucherDtlId,
                    "is_debit"=>$rows->is_debit,
                    "account_name"=>$rows->account_name,
                    "subLedgerId"=>$rows->subLedgerId,
                    "subledgerName"=>$rows->subledger,
                    "accountId"=>$rows->accountId,
                    "VouchrDtlAmt"=>$rows->voucher_amount,
                   // "TotalDebit"=>$this->getTotalDebitedAmount($rows->voucherMastId)
                    
                );
            }


            return $data;
        } else {
            return $data;
        }
    }
   
   public function insertgeneralVoucherMaster($insertVoucherMaster,$searcharray){
       try {
            $this->db->trans_begin();
            $this->db->insert('voucher_master',$insertVoucherMaster);
            // echo($this->db->last_query());
            //exit;

             $VoucherMasterId = $this->db->insert_id();
              $this->insertVoucherData($VoucherMasterId,$searcharray);
               // echo($this->db->last_query());exit;
              $this->updateVoucherDetailsData($VoucherMasterId, $searcharray);
             // echo($this->db->last_query());exit;
              $this->updateGeneralvoucherSerial($insertVoucherMaster);

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
   
   function insertVoucherData($VoucherMasterId,$searcharray){
    $voucherDetailData = array();
   $voucherDetailData['voucher_master_id'] = $VoucherMasterId;
   $voucherDetailData['account_master_id'] = $searcharray['paymentType'];
   $voucherDetailData['voucher_amount'] = $searcharray['amount'];
   $isDebit = $searcharray['paymentmode'];
    if($isDebit=='RC'){
        $voucherDetailData['is_debit']='Y';
    }
    else{
        $voucherDetailData['is_debit']='N';
    }
   $voucherDetailData['account_id_for_trial'] = $searcharray['paymentType'];
   $voucherDetailData['subledger_id'] = 0;
   $voucherDetailData['is_master'] = 'Y';
     $this->db->insert('voucher_detail',$voucherDetailData);
}



  public function UpdategeneralVouchr($updateGeneralVoucher,$searcharray){
      
        $vouchrMastId = $updateGeneralVoucher['id'];
       // unset($updateGeneralVoucher['id']);
  
        try {
             $this->db->where('id', $vouchrMastId);
             $this->db->update('voucher_master' ,$updateGeneralVoucher);
             // echo($this->db->last_query());
             $this->insertIntoVouchrDtl($vouchrMastId,$searcharray);
             
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
    
   public function updateGeneralvoucherSerial($voucherNo){
   
        $seriallTable=array();
        $moduleType="vouchertype";
       $newSerialNo=$voucherNo['voucher_number'];
       $seriallTable['moduleType']=$moduleType;
       $seriallTable['srl_number']=$newSerialNo;
       $seriallTable['company_id']=$voucherNo['company_id'];
       $seriallTable['year_id']=$voucherNo['year_id'];
        $this->db->where('id', 1);
        $this->db->update('serials' ,$seriallTable);
       
       
       
    }
    
  public function insertIntoVouchrDtl($vouchrMastId,$searcharray){
      $this->deleteFromVouchrDtl($vouchrMastId);
      $this->insertVoucherData($vouchrMastId,$searcharray);
      $this->insertIntoVoucherDetail($vouchrMastId,$searcharray);
  }
  
  
  
  public function deleteFromVouchrDtl($VoucherMasterId){
        $this->db->where('voucher_master_id', $VoucherMasterId);
        $this->db->delete('voucher_detail');
  }

  
   public function insertIntoVoucherDetail($VoucherMasterId,$dtlArr){
        $voucherDtlData = array();
      
        $numberOfDtl = count($dtlArr['amountDtl']);
        for ($i = 0; $i < $numberOfDtl; $i++) {
            $voucherDtlData['voucher_master_id'] = $VoucherMasterId;
            $voucherDtlData['account_master_id'] = $dtlArr['acHead'][$i];
          
            $voucherDtlData['voucher_amount'] =($dtlArr['amountDtl'][$i] == "" ? 0 : $dtlArr['amountDtl'][$i]);
            $debitCheck=$dtlArr['debitcredit'][$i];
            if($debitCheck=='Dr'){
                $is_Debit='Y';
                $voucherDtlData['is_debit']=$is_Debit;
            }
            else{
                 $is_Debit='N';
                $voucherDtlData['is_debit']=$is_Debit;
            }
            $voucherDtlData['account_id_for_trial'] = $dtlArr['acHead'][$i];
            $voucherDtlData['subledger_id'] = $dtlArr['subledger'][$i];
            $is_master='N';
            if( $is_master=='N'){
            $voucherDtlData['is_master'] =$is_master;
           // $voucherDtlData['is_master'] =$is_master[$i];
            }
           
          
            //if ($dtlArr['txtpacket'][$i] != 0) {
                 $this->db->insert('voucher_detail',$voucherDtlData);
            //}//
        }
   
}


   public function updateVoucherDetailsData($VoucherMasterId,$dtlArr){
        $voucherDtlData = array();
       
        $numberOfDtl = count($dtlArr['amountDtl']);
        for ($i = 0; $i < $numberOfDtl; $i++) {
            $voucherDtlData['voucher_master_id'] = $VoucherMasterId;
            $voucherDtlData['account_master_id'] = $dtlArr['acHead'][$i];
          
            $voucherDtlData['voucher_amount'] =($dtlArr['amountDtl'][$i] == "" ? 0 : $dtlArr['amountDtl'][$i]);
            $debitCheck=$dtlArr['debitcredit'][$i];
            if($debitCheck=='Dr'){
                $is_Debit='Y';
                $voucherDtlData['is_debit']=$is_Debit;
            }
            else{
                 $is_Debit='N';
                $voucherDtlData['is_debit']=$is_Debit;
            }
            $voucherDtlData['account_id_for_trial'] = $dtlArr['acHead'][$i];
            $voucherDtlData['subledger_id'] = $dtlArr['subledger'][$i];
            $is_master='N';
            if( $is_master=='N'){
            $voucherDtlData['is_master'] =$is_master;
           // $voucherDtlData['is_master'] =$is_master[$i];
            }
           
          
            //if ($dtlArr['txtpacket'][$i] != 0) {
                 $this->db->insert('voucher_detail',$voucherDtlData);
            //}//
        }
   
}



public function getLastSerialNo($cid,$yid)
	{
		$sql="select serial_number from voucher_master where company_id=".$cid." and year_id=".$yid." order by serial_number desc limit 1";
		$query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
                $data = array(
                    "serialNo" => $rows->serial_number
                );
            }

            return $data;
        } else {
            return $data;
        }
	}
    public function getSerailvoucherNo($cid,$yid){
    
	 $sql="select srl_number from serials where `serials`.`moduleType`='vouchertype' AND company_id=".$cid." AND year_id=".$yid."";
		$query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
           $row = $query->row();
            return $row->srl_number;
       } 
       else{
           return 0;
       }
      
       
}
        
       public function TotalDebitAmt($vouchrMastId){
           $sql="SELECT 
                SUM(`voucher_detail`.`voucher_amount`) AS DebtAmt 
                FROM `voucher_detail`
                WHERE `voucher_detail`.`voucher_master_id`='".$vouchrMastId."'
                AND `voucher_detail`.`is_debit`='Y'";
           $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
                $data = array(
                    "totalDebtAmt" => $rows->DebtAmt
                );
            }

            return $data;
        } else {
            return $data;
        }
           
       }
        public function TotalCreditAmt($vouchrMastId){
           $sql="SELECT 
                SUM(`voucher_detail`.`voucher_amount`) AS CreditAmt 
                FROM `voucher_detail`
                WHERE `voucher_detail`.`voucher_master_id`='".$vouchrMastId."'
                AND `voucher_detail`.`is_debit`='N'";
           $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
                $data = array(
                    "totalCreditAmt" => $rows->CreditAmt
                );
            }

            return $data;
        } else {
            return $data;
        }
           
       }

 public function deleteGeneralVoucher($voucherMastId)
     {
        
        
       $this->deleteVoucherDetailData($voucherMastId);
       $this->deleteVoucherMasterDetail($voucherMastId);
    
        
    }
	 public function deleteVoucherDetailData($vmastId){
        
            $this->db->where('voucher_master_id', $vmastId);
          $this->db->delete('voucher_detail');  
          if($this->db->delete('voucher_detail')){
              return true;
          }
          else{
              return false;
          }
         
    }
     public function deleteVoucherMasterDetail($vmastId){
        
            $this->db->where('id', $vmastId);
          $this->db->delete('voucher_master');  
          if($this->db->delete('voucher_master')){
              return true;
          }
          else{
              return false;
          }
         
    }


}
?>