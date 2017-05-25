<?php
    
class customerpaymentmodel extends CI_Model {
    
    
     public function insertData($masterData, $billDetails) {
        
        
        $resultArray=array();
        try {
            $this->db->trans_begin();
            $masterData["voucherNumber"]= $this->getSerialNumber($masterData["companyId"], $masterData["yearId"]);
            $voucherId = $this->insertVoucherMaster($masterData);
           // $this->updateGeneralvoucherSerial($masterData);

            $customerreceiptmaster["voucherid"] = $voucherId;
            $customerreceiptmaster["customeraccountid"] = $masterData["customerId"];
            $customerreceiptmaster["totalreceipt"] = $masterData["totalPayment"];
            $customerreceiptmaster["dateofpayment"] = date("Y-m-d", strtotime($masterData["dateofpayment"]));
	    $customerreceiptmaster["customerchqbank"]=$masterData["customerchqbank"];
	    $customerreceiptmaster["customerchqbankbranch"]=$masterData["customerchqbankbranch"];

            $this->db->insert("customerreceiptmaster", $customerreceiptmaster);
            
            $customerReceiptMastId = $this->db->insert_id();
            
            //echo( $this->db->last_query());
            //echo($vendorBillMasterId);

            $this->insertCustomerReceiptDetails($customerReceiptMastId, $billDetails);

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $resultArray =array(
                        "voucherNumber"=>NULL,
                        "msg"=>FALSE
                        );
                return $resultArray;
            } else {
                $this->db->trans_commit();
                $resultArray =array(
                        "voucherNumber"=>$masterData["voucherNumber"],
                        "msg"=>TRUE
                        );
                 return $resultArray;
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }
    
    
     public function UpdateData($masterData, $billDetails){
        
        $resultArray=array();
        try {
            $this->db->trans_begin();
            $voucherId = $this->updateVoucherMaster($masterData);
            
            $customerPaymentId = $masterData["customerPaymentId"];

            
            $customerreceiptmaster["customeraccountid"] = $masterData["customerId"];
            $customerreceiptmaster["totalreceipt"] = $masterData["totalPayment"];
            $customerreceiptmaster["dateofpayment"] = date("Y-m-d", strtotime($masterData["dateofpayment"]));
	    $customerreceiptmaster["customerchqbank"]=$masterData["customerchqbank"];
	    $customerreceiptmaster["customerchqbankbranch"]=$masterData["customerchqbankbranch"];
			
			
            
            $this->db->where("customerpaymentid",$customerPaymentId);
            $this->db->update("customerreceiptmaster", $customerreceiptmaster);
           

            $this->insertCustomerReceiptDetails($customerPaymentId, $billDetails);

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $resultArray =array(
                        "voucherNumber"=>NULL,
                        "msg"=>FALSE
                        );
                return $resultArray;
            } else {
                $this->db->trans_commit();
                $resultArray =array(
                        "voucherNumber"=>"",
                        "msg"=>TRUE
                        );
                 return $resultArray;
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
        
    }
    
    private function insertCustomerReceiptDetails($customerReceiptMastId, $billDetails){
        
        $this->db->where("customerrecptmstid",$customerReceiptMastId);
        $this->db->delete("customerreceiptdetail");
        
        
           foreach ($billDetails as $row) {
            $data["customerrecptmstid"]= $customerReceiptMastId;
            $data["customerbillmasterid"] = $row["customerBillMasterId"];
            $data["receiptamount"] = $row["paidAmount"];
            //print_r($data);
            $this->db->insert("customerreceiptdetail", $data);
            /* echo( $this->db->last_query());
          exit;*/
        }
          //exit;
        
    }
    
    
    private function updateVoucherMaster($masterData){
        
        
        $voucherMasterArray["voucher_date"] = date("Y-m-d", strtotime($masterData["dateofpayment"])); //date("Y-m-d", strtotime($searcharray['saleBillDate']));
        $voucherMasterArray["narration"] = $masterData["narration"];
        if ($masterData["chequeNo"] != "") {
            $voucherMasterArray["cheque_number"] = $masterData["chequeNo"];
        } else {
            $voucherMasterArray["cheque_number"] = NULL;
        }

        if ($masterData["chequeDate"] == "") {
            $voucherMasterArray["cheque_date"] = NULL;
        } else {
            $voucherMasterArray["cheque_date"] = date("Y-m-d", strtotime($masterData["chequeDate"]));
        }
        $this->db->where("id",$masterData["voucherId"]);
        $this->db->update("voucher_master", $voucherMasterArray);
        //echo( $this->db->last_query());
        $voucherId = $masterData["voucherId"];
        $this->insertVoucherDetails($voucherId, $masterData);
        return $voucherId;
    
} 
    
    
    
    private function insertVoucherMaster($masterData) {

        $voucherMasterArray["voucher_number"] = $masterData["voucherNumber"];//$this->getSerialNumber($masterData["companyId"], $masterData["yearId"]);//$masterData["voucherNumber"];
        $voucherMasterArray["voucher_date"] = date("Y-m-d", strtotime($masterData["dateofpayment"])); //date("Y-m-d", strtotime($searcharray['saleBillDate']));
        $voucherMasterArray["narration"] = $masterData["narration"];
        if ($masterData["chequeNo"] != "") {
            $voucherMasterArray["cheque_number"] = $masterData["chequeNo"];
        } else {
            $voucherMasterArray["cheque_number"] = NULL;
        }

        if ($masterData["chequeDate"] == "") {
            $voucherMasterArray["cheque_date"] = NULL;
        } else {
            $voucherMasterArray["cheque_date"] = date("Y-m-d", strtotime($masterData["chequeDate"]));
        }
        $voucherMasterArray["transaction_type"] = "RC"; // 
        $voucherMasterArray["created_by"] = $masterData["userId"];
        $voucherMasterArray["serial_number"] = $masterData["voucherSerial"];
        $voucherMasterArray["company_id"] = $masterData["companyId"];
        $voucherMasterArray["year_id"] = $masterData["yearId"];

        $this->db->insert("voucher_master", $voucherMasterArray);
        $voucherId = $this->db->insert_id();
        $this->insertVoucherDetails($voucherId, $masterData);
        return $voucherId;
    }
    
     private function insertVoucherDetails($voucherMasterId, $voucherDetailArray) {
        $this->db->where("voucher_master_id", $voucherMasterId);
        $this->db->delete("voucher_detail");
         
        //customeraccId credit 
        $voucherDetail["voucher_master_id"] = $voucherMasterId;
        $voucherDetail["account_master_id"] = $voucherDetailArray["customerId"];
        $voucherDetail["voucher_amount"] = $voucherDetailArray["totalPayment"];
        $voucherDetail["is_debit"] = "N";
        $this->db->insert("voucher_detail", $voucherDetail);
         
        
        
        //debit cash or bank
        $voucherDetail["voucher_master_id"] = $voucherMasterId;
        $voucherDetail["account_master_id"] = $voucherDetailArray["debitAccountId"];
        $voucherDetail["voucher_amount"] = $voucherDetailArray["totalPayment"];
        $voucherDetail["is_debit"] = "Y";
        $this->db->insert("voucher_detail", $voucherDetail);
       
        //echo( $this->db->last_query());
        
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
    
    
    
    public function updateGeneralvoucherSerial($data) {

        // $moduleType="vouchertype";
        $updtArr = array();
        $newSerialNo = $data['lastSrNo'];
        //$seriallTable['moduleType']=$moduleType;
        $seriallTable['srl_number'] = $newSerialNo;


        $updtArr = array('company_id' => $data['companyId'], 'year_id' => $data['yearId']);
        $this->db->where($updtArr);
        $this->db->update('serials', $seriallTable);
        
    }
    
    
         public function getcustomerUnpaidBill($customerBillMasterId, $companyId , $customerPaymentId) {

        $data = array();
       // $call_procedure = "CALL GetVendorUnpaidBill(" . $companyId . "," . $vendorBillMasterId . ",@unpaidAmount" . ")";
        $call_procedure = "CALL GetCustomerUnpaidAmt(" . $companyId . "," . $customerBillMasterId . "," . $customerPaymentId . ",@unpaidAmount" . ")";
        $this->db->trans_start();
        $this->db->query($call_procedure); // not need to get output
        $query = $this->db->query("SELECT @unpaidAmount As unpaid");
        $this->db->trans_complete();



        // if($query->num_rows() > 0)
        $unpaid = $query->row()->unpaid;
        //echo($unpaid);exit;

        return $unpaid;
    }
    
    
     public  function getCustomerPaymentMasterDataById($cPaymentId){
        $sql =" SELECT
                `customerreceiptmaster`.`customerpaymentid`,
                DATE_FORMAT(`customerreceiptmaster`.`dateofpayment`,'%d-%m-%Y')AS dateofpayment,
                `customerreceiptmaster`.`customeraccountid`,
                `customerreceiptmaster`.`totalreceipt`,
                `customerreceiptmaster`.`voucherid`,customerreceiptmaster.customerchqbank,
                 voucher_master.`voucher_number`,customerreceiptmaster.customerchqbankbranch,
                 voucher_detail.`account_master_id`,
                 voucher_master.`cheque_number`,
                 DATE_FORMAT(voucher_master.`cheque_date`,'%d-%m-%Y')AS cheque_date,
                 voucher_master.`narration`
            FROM `customerreceiptmaster`
            INNER JOIN
            `voucher_master` ON customerreceiptmaster.`voucherid`=voucher_master.`id`
            INNER JOIN `voucher_detail` ON voucher_master.`id` = voucher_detail.`voucher_master_id` 
            AND voucher_detail.`is_debit` ='Y' 
            WHERE customerreceiptmaster.`customerpaymentid` =".$cPaymentId;
        
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
                $data = array(
                    "customerpaymentid" => $rows->customerpaymentid,
                    "dateofpayment" => $rows->dateofpayment,
                    "customeraccountid" => $rows->customeraccountid,
                    "totalreceipt" => $rows->totalreceipt,
                    "voucher_number" => $rows->voucher_number,
                    "debitaccountId" => $rows->account_master_id,
                    "cheque_number" => $rows->cheque_number,
                    "cheque_date" => $rows->cheque_date,
                    "narration"=>$rows->narration,
                    "voucherId"=>$rows->voucherid,
					"customerchqbank"=>$rows->customerchqbank,
					"customerchqbankbranch"=>$rows->customerchqbankbranch
                    

                );
            }


            return $data;
        } else {
            return $data;
        }
        
    }
    
    
      public  function getCustomerPaymentDetails($customerpaymentId){
        $sql="SELECT
                `customerreceiptdetail`.`id` as customerreceiptDtlId,
                `customerreceiptdetail`.`customerrecptmstid`,
                `customerreceiptdetail`.`customerbillmasterid`,
                `customerreceiptdetail`.`receiptamount`,
              (CASE
                      WHEN sale_bill_master.`id` IS NOT NULL THEN sale_bill_master.`salebillno`
                      WHEN rawteasale_master.`id` IS NOT NULL THEN rawteasale_master.`invoice_no`
              END)  AS billNo,
              (CASE
                      WHEN sale_bill_master.`id` IS NOT NULL THEN DATE_FORMAT(sale_bill_master.`salebilldate`,'%d-%m-%Y')
                      WHEN rawteasale_master.`id` IS NOT NULL THEN DATE_FORMAT(rawteasale_master.`sale_date`,'%d-%m-%Y')
              END)  AS BillDate,

              (CASE
                      WHEN sale_bill_master.`id` IS NOT NULL THEN sale_bill_master.`grandtotal`
                      WHEN rawteasale_master.`id` IS NOT NULL THEN rawteasale_master.`grandtotal`
              END)  AS BillAmount

              FROM `customerreceiptdetail`
              
              INNER JOIN `customerbillmaster` ON customerreceiptdetail.`customerbillmasterid` = customerbillmaster.`customerbillmasterid`
              LEFT JOIN `sale_bill_master` 
              ON customerbillmaster.`invoicemasterid` = sale_bill_master.`id` AND customerbillmaster.`saletype` ='T'
              LEFT JOIN `rawteasale_master` 
              ON customerbillmaster.`invoicemasterid` = rawteasale_master.`id` AND customerbillmaster.`saletype` ='R'
              WHERE 
               customerreceiptdetail.`customerrecptmstid`=".$customerpaymentId;
        
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
                $data[] = array(
                    "customerreceiptDtlId" => $rows->customerreceiptDtlId,
                    "customerpaymentid" => $rows->customerrecptmstid,
                    "customerBillMaster" => $rows->customerbillmasterid,
                    "paidAmount" => $rows->receiptamount,
                    "billNo" => $rows->billNo,
                    "BillDate" => $rows->BillDate,
                    "BillAmount" => $rows->BillAmount
                );
            }
            return $data;
        } else {
            return $data;
        }
        
    }
    
    public function getCustomerPaymentList($compy,$year){
        
        $sql= "SELECT
                    `customerpaymentid`,
                    DATE_FORMAT(`dateofpayment`,'%d-%m-%Y')AS dateofpayment,
                    `customeraccountid`,
                    `totalreceipt`,
                    `voucherid`,
                    `voucher_master`.`voucher_number`,
                    customer.`customer_name`
                FROM `customerreceiptmaster`
                INNER JOIN
                `voucher_master`  ON `customerreceiptmaster`.`voucherid` = `voucher_master`.`id`
                INNER JOIN customer ON customerreceiptmaster.`customeraccountid` = customer.`account_master_id`
                WHERE voucher_master.`company_id`=".$compy." AND voucher_master.`year_id`=".$year;
        
          $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
                $data[] = array(
                    "customerpaymentid"=>$rows->customerpaymentid,
                    "dateofpayment"=>$rows->dateofpayment,
                    "totalpaidamount"=>$rows->totalreceipt,
                    "voucher_number"=>$rows->voucher_number,
                    "customer_name"=>$rows->customer_name,
                    "debit_account"=>$this->getDebitAccount($rows->customerpaymentid)
                    
                   /* "credit_account"=>  $this->getCreditAccount($rows->vendorPaymentId) */
                   );
            }


            return $data;
        } else {
            return $data;
        }
    }
    
     private function getDebitAccount($customerPaymentId){
       $sql= "SELECT `voucher_detail`.`account_master_id`, `account_master`.`account_name` FROM `customerreceiptmaster` 
                INNER JOIN `voucher_detail` 
                ON `customerreceiptmaster`.`voucherid` = `voucher_detail`.`voucher_master_id`
                AND `voucher_detail`.`is_debit` ='Y'
                INNER JOIN `account_master` ON `voucher_detail`.`account_master_id` = `account_master`.`id`
                WHERE `customerreceiptmaster`.`customerpaymentid`=".$customerPaymentId;
       
       $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $data=$this->db->query($sql)->row()->account_name;
            return $data;
        } else {
            return $data;
        }
    }
    
    
    
    public function getDetail($customerPaymentId){
        $sql="SELECT `customerreceiptmaster`.`customerpaymentid`,
                    `customerreceiptdetail`.`receiptamount`,
                    `customerreceiptdetail`.`customerbillmasterid`,
                    `customerbillmaster`.`invoicemasterid`,`customerbillmaster`.`saletype`,

                    (CASE 
                    WHEN sale_bill_master.`id` IS NOT NULL THEN sale_bill_master.`salebillno`
                    WHEN rawteasale_master.`id` IS NOT NULL THEN rawteasale_master.`invoice_no`
                    END) AS sInvoiceNumber ,

                    (CASE 
                    WHEN sale_bill_master.`id` IS NOT NULL THEN DATE_FORMAT(sale_bill_master.`salebilldate`,'%d-%m-%Y')
                    WHEN rawteasale_master.`id` IS NOT NULL THEN DATE_FORMAT(rawteasale_master.`sale_date`,'%d-%m-%Y')
                    END) AS sInvoiceDate,

                    (CASE 
                    WHEN sale_bill_master.`id` IS NOT NULL THEN sale_bill_master.`grandtotal`
                    WHEN rawteasale_master.`id` IS NOT NULL THEN rawteasale_master.`grandtotal`
                    END) AS sAmount

                FROM
                `customerreceiptmaster`
                INNER JOIN
                `customerreceiptdetail`
                ON `customerreceiptmaster`.`customerpaymentid`=`customerreceiptdetail`.`customerrecptmstid`
                INNER JOIN `customerbillmaster` ON `customerreceiptdetail`.`customerbillmasterid` = `customerbillmaster`.`customerbillmasterid`
                LEFT JOIN `sale_bill_master` ON customerbillmaster.`invoicemasterid` = sale_bill_master.`id`
                LEFT JOIN `rawteasale_master` ON `customerbillmaster`.`invoicemasterid`  = rawteasale_master.`id`
                WHERE `customerreceiptmaster`.`customerpaymentid`=".$customerPaymentId;
        
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
                $data[] = array(
                    "sInvoiceNumber"=>$rows->sInvoiceNumber,
                    "sInvoiceDate"=>$rows->sInvoiceDate,
                    "sAmount"=>$rows->sAmount,
                    "paidAmount"=>$rows->receiptamount,
                    
                   );
            }


            return $data;
        } else {
            return $data;
        }
        
    }
	
	
	public function DeleteCustomerReceipt($customerRecptID)
	{
		$voucherID = $this->getVoucherMasterIDFromCustomerReceipt($customerRecptID);
		
		try 
		{
			$this->db->trans_begin();
			   
			// delete customerreceiptdetail
			$this->db->where('customerrecptmstid', $customerRecptID);
			$this->db->delete('customerreceiptdetail'); 
			
			// delete customerreceiptmaster
			$this->db->where('customerpaymentid', $customerRecptID);
			$this->db->delete('customerreceiptmaster'); 
			   
			// delete voucher_detail
			$this->db->where('voucher_master_id', $voucherID);
			$this->db->delete('voucher_detail'); 	
			
			// delete voucher_master
			$this->db->where('id', $voucherID);
			$this->db->delete('voucher_master'); 	
		
		 
			if ($this->db->trans_status() === FALSE) 
			{
				$this->db->trans_rollback();
				return false;
			}
			else
			{
				$this->db->trans_commit();
				return true;
			}
        }
		catch (Exception $e) 
		{
            echo ($e->getMessage());
        }
		
		
		
	}
	
	// use for delete purpose
	//
	private function getVoucherMasterIDFromCustomerReceipt($customerRecptID)
	{
		$voucherID =0;
		$sql = "SELECT  customerreceiptmaster.`voucherid`  FROM `customerreceiptmaster` WHERE `customerreceiptmaster`.`customerpaymentid`=".$customerRecptID;
		$query = $this->db->query($sql);
		if($query->num_rows()>0)
		{
			$row = $query->row();
			$voucherID = $row->voucherid;
		}
		return $voucherID;
		 
	}
	
    
    
}

?>