<?php

class contravouchermodel extends CI_Model{
 
   
    
      public function getContraVoucherList($cmpny,$year){
  
        $sql="SELECT 
             `voucher_master`.`id` AS voucherMasterId,
             `voucher_master`.`voucher_number`,
              DATE_FORMAT(`voucher_master`.`voucher_date`,'%d-%m-%Y') AS VoucherDate,
             `voucher_master`.`cheque_number`,
             DATE_FORMAT(`voucher_master`.`cheque_date`,'%d-%m-%Y') AS ChqDate 
             FROM `voucher_master`
             WHERE `voucher_master`.`transaction_type`='CN'
             AND `voucher_master`.`company_id`=".$cmpny." AND `voucher_master`.`year_id`=".$year;
        
        $query =$this->db->query($sql);
        if($query->num_rows()> 0){
            foreach ($query->result() as $rows){
                $data[]=array(
                   "voucherMasterId"=>$rows->voucherMasterId,
                   // "voucherDtlId"=>$rows->voucherDtlId,
                    "voucher_number"=>$rows->voucher_number,
                    "VoucherDate"=>$rows->VoucherDate,
                    "vouchertype"=>$rows->vouchertype,
                    "ChqDate"=>$rows->ChqDate,
                    "cheque_number"=>$rows->cheque_number,
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
        $sql="SELECT `voucher_master`.`voucher_number` FROM `voucher_master` WHERE `voucher_master`.`id`='".$voucherMastId."' AND `voucher_master`.`transaction_type`='CN'";
		$query = $this->db->query($sql);
       if ($query->num_rows() > 0) {
           $row = $query->row();
            return $row->voucher_number;
       } 
       else{
           return 0;
       }
    } 
    
    
     public function getcontraMasterDataPdf($voucherMastId){
  
        $sql="SELECT 
             `voucher_master`.`id` AS voucherMasterId,
             `voucher_master`.`voucher_number`,
              DATE_FORMAT(`voucher_master`.`voucher_date`,'%d-%m-%Y') AS VoucherDate,
             `voucher_master`.`cheque_number`,
             `voucher_master`.`narration`,
             DATE_FORMAT(`voucher_master`.`cheque_date`,'%d-%m-%Y') AS ChqDate 
             FROM `voucher_master`
             WHERE `voucher_master`.`transaction_type`='CN' AND `voucher_master`.`id`='".$voucherMastId."'";
        
        $query =$this->db->query($sql);
        if($query->num_rows()> 0){
            foreach ($query->result() as $rows){
                $data[]=array(
                   "voucherMasterId"=>$rows->voucherMasterId,
                   // "voucherDtlId"=>$rows->voucherDtlId,
                    "voucher_number"=>$rows->voucher_number,
                    "VoucherDate"=>$rows->VoucherDate,
                    "vouchertype"=>$rows->vouchertype,
                    "ChqDate"=>$rows->ChqDate,
                    "cheque_number"=>$rows->cheque_number,
                    "narration"=>$rows->narration,
                  
                    
                );
            }

          return $data;
        }
        else{
            return $data=array();
        }
        
    }
    public function getcounterDetailPdf($vouchmastId){
         $sql="SELECT 
            `account_master`.`account_name`,
            `voucher_detail`.`voucher_amount`,
            `voucher_detail`.`is_debit` AS drCr
             FROM `voucher_detail`
             INNER JOIN `account_master`
             ON `account_master`.`id`=`voucher_detail`.`account_master_id`
             WHERE `voucher_detail`.`voucher_master_id`='".$vouchmastId."'";
        $query =$this->db->query($sql);
        if($query->num_rows()> 0){
            foreach ($query->result() as $rows){
                $data[]=array(
                   "account_name"=>$rows->account_name,
                    "drCr"=>$rows->drCr,
                    "voucher_amount"=>$rows->voucher_amount
                  
                    
                );
            }

          return $data;
        }
        else{
            return $data=array();
        }
    }
    /*public function getAccountName($tag=""){
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
    */
   /* public function getAccountByGroupMaster(){
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
        
    }*/
    
    public function getcontraVoucherMasterData($voucherMaterId){
        $sql="SELECT 
                `voucher_master`.`voucher_number`,
                `voucher_master`.`serial_number`,
                DATE_FORMAT(`voucher_master`.`voucher_date`,'%d-%m-%Y') AS VoucherDate,
                `voucher_master`.`cheque_number`,
                DATE_FORMAT(`voucher_master`.`cheque_date`,'%d-%m-%Y') AS checqueDate,
                `voucher_master`.`narration`,
                `voucher_master`.`branchid`
                FROM voucher_master
                WHERE `voucher_master`.`id`='".$voucherMaterId."' AND `voucher_master`.`transaction_type`='CN';";
            $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
                $data = array(
                    "voucher_number"=>$rows->voucher_number,
                    "serial_number"=>$rows->serial_number,
                    "voucher_date"=>$rows->VoucherDate,
                    "cheque_number"=>$rows->cheque_number,
                    "cheque_date"=>$rows->checqueDate,
                    "branchid"=>$rows->branchid,
                    "narration"=>$rows->narration
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
    public function getContraVoucherDetailData($voucherMaterId){
        $sql="SELECT 
            `voucher_detail`.`voucher_master_id` AS voucherMastId,
            `voucher_detail`.`id` AS VoucherDtlId,
            `account_master`.`id` AS accountId,
            `subledger`.`subledgerid` AS subLedgerId,
            `voucher_detail`.`voucher_amount` AS VouchrDtlAmt,
            `voucher_detail`.`is_debit` 
             FROM `voucher_detail`
             INNER JOIN `account_master`
             ON `account_master`.`id`=`voucher_detail`.`account_master_id`
             LEFT JOIN `subledger`
             ON `subledger`.`subledgerid`=`voucher_detail`.`subledger_id`
             WHERE `voucher_detail`.`voucher_master_id`='".$voucherMaterId."'";
        
         $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
                $data[] = array(
                    "voucherMastId"=>$rows->voucherMastId,
                    "VoucherDtlId"=>$rows->VoucherDtlId,
                    "is_debit"=>$rows->is_debit,
                   // "account_name"=>$rows->account_name,
                    "subLedgerId"=>$rows->subLedgerId,
                   // "subledgerName"=>$rows->subledger,
                    "accountId"=>$rows->accountId,
                    "VouchrDtlAmt"=>$rows->VouchrDtlAmt
                   // "TotalDebit"=>$this->getTotalDebitedAmount($rows->voucherMastId)
                    
                );
            }


            return $data;
        } else {
            return $data;
        }
    }
   
   public function insertContraVoucherMaster($insertVoucherMaster,$searcharray){
       try {
            $this->db->trans_begin();
            
            $insertVoucherMaster['voucher_number'] = $this->getSerialNumber($insertVoucherMaster['company_id'], $insertVoucherMaster['year_id']);
            $this->db->insert('voucher_master',$insertVoucherMaster);
            $VoucherMasterId = $this->db->insert_id();
            $this->updateVoucherDetailsData($VoucherMasterId, $searcharray);
            //$this->updateContravoucherSerial($insertVoucherMaster);

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
/**
    * getSerialNumber generate serial number agnst companyId and yearId
    * @param type $company
    * @param type $year
    * @return string
    */
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
    
   public function updateContravoucherSerial($voucherNo){
          $session = sessiondata_method();
         $cmpny = $session['company'];
         $year =$session['yearid'];
         
        $seriallTable=array();
        $newSerialNo=$voucherNo['voucher_number'];
        $seriallTable['srl_number']=$newSerialNo;
        $where = array(
           "company_id"=>$cmpny,
           "year_id"=>$year
        );
        $this->db->where($where);
        $this->db->update('serials' ,$seriallTable);
       
       
       
    }
    
  public function insertIntoVouchrDtl($vouchrMastId,$searcharray){
      $this->deleteFromVouchrDtl($vouchrMastId);
    
      $this->updateVoucherDetailsData($vouchrMastId,$searcharray);
  }
  
  
  
  public function deleteFromVouchrDtl($VoucherMasterId){
        $this->db->where('voucher_master_id', $VoucherMasterId);
        $this->db->delete('voucher_detail');
  }

  
   public function insertIntoVoucherDetail($VoucherMasterId,$dtlArr){
       
     /*   $voucherDtlData = array();
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
            
            $voucherDtlData['is_master'] =$is_master;
           //if ($dtlArr['txtpacket'][$i] != 0) {
                 $this->db->insert('voucher_detail',$voucherDtlData);
            //}//
        }*/
       
       
   
}


   public function updateVoucherDetailsData($VoucherMasterId,$searcharray){
        $voucherDtlData = array();
       
       /* $numberOfDtl = count($dtlArr['amountDtl']);
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
            
            $voucherDtlData['is_master'] ='N';
          
              $this->db->insert('voucher_detail',$voucherDtlData); 
        }*/
        // insert for debit
          $voucherDtlDebt['voucher_master_id'] = $VoucherMasterId;
          $voucherDtlDebt['account_master_id'] = $searcharray['acheaddebit'];
          $voucherDtlDebt['voucher_amount'] = $searcharray['debitAmt'];
          $voucherDtlDebt['is_debit'] ='Y';
          $voucherDtlDebt['account_id_for_trial'] = $searcharray['acheaddebit'];
          $voucherDtlDebt['subledger_id'] = $searcharray['debitsubledger'];
          $voucherDtlDebt['is_master'] ='N';
          $this->db->insert('voucher_detail',$voucherDtlDebt); 
        
        // insert for credit
          
          $voucherDtlCredit['voucher_master_id'] = $VoucherMasterId;
          $voucherDtlCredit['account_master_id'] = $searcharray['acheadcredit'];
          $voucherDtlCredit['voucher_amount'] = $searcharray['creditAmt'];
          $voucherDtlCredit['is_debit'] ='N';
          $voucherDtlCredit['account_id_for_trial'] = $searcharray['acheadcredit'];
          $voucherDtlCredit['subledger_id'] = $searcharray['creditsubledger'];
          $voucherDtlCredit['is_master'] ='N';
          $this->db->insert('voucher_detail',$voucherDtlCredit); 
   
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
    public function getSerailContravoucherNo($cid,$yid){
    
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
       
 public function deleteContraVoucher($voucherMastId)
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