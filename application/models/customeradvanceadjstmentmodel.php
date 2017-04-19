<?php

class customeradvanceadjstmentmodel extends CI_Model{
    
     public function getCustomerAdvanceVoucher($customerAccId){
        $data=  array();
        $sql="SELECT `customeradvance`.`advanceId`,
            voucher_master.`voucher_number`
            FROM 
            `customeradvance`
            INNER JOIN
            `voucher_master` 
            ON customeradvance.`voucherid` = `voucher_master`.`id`
            WHERE `customeradvance`.`customeraccountid`=".$customerAccId;
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
                $data[] = array(
                    "advanceId" => $rows->advanceId,
                    "voucher" => $rows->voucher_number,
                    );
            }


            return $data;
        } else {
            return $data;
        }
    }
     public function getSaleInvoiceByCustomer($custAccid){
        $data="";
        $session = sessiondata_method();
        $companyId = $session['company'];
        
        $sql="SELECT 
                customerbillmaster.`customerbillmasterid`,
                customerbillmaster.`invoicemasterid`,
              CASE
            WHEN `sale_bill_master`.`salebillno` IS NULL THEN `rawteasale_master`.`invoice_no`
            WHEN  `rawteasale_master`.`invoice_no` IS NULL THEN `sale_bill_master`.`salebillno`
            END AS InvoiceNumber
                    FROM `customerbillmaster` 
            LEFT JOIN sale_bill_master
            ON
            customerbillmaster.`invoicemasterid` = sale_bill_master.`id` 
            AND customerbillmaster.`saletype` ='T'
            LEFT JOIN rawteasale_master
            ON
            customerbillmaster.`invoicemasterid` = rawteasale_master.`id`
            AND customerbillmaster.`saletype`='R'
            WHERE 
            customerbillmaster.`customeraccountid` =".$custAccid." AND customerbillmaster.companyid=".$companyId." AND customerbillmaster.yearid >5";
        
        
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
                $data[] = array(
                    "customerbillmasterid" => $rows->customerbillmasterid,
                    "InvoiceNumber" => $rows->InvoiceNumber,
                    );
            }


            return $data;
        } else {
            return $data;
        }
        
    }
    
    
    
     public function getAdvanceAmountByAdvanceId($custAdvanceId){
        
        $data=0;
        /*$sql=" SELECT  
                    vendoradvancemaster.`advanceId`,
                    vendoradvancemaster.`advanceAmount`
                FROM `vendoradvancemaster`
                WHERE `vendoradvancemaster`.`advanceId`=".$vendorAdvanceId;*/
        $sql="SELECT 
                (customeradvance.`advanceamount` - IFNULL(SUM(customeradvanceadadjustment.`totalamountadjusted`),0)) AS totalAdjusted,
                customeradvance.`advanceId`
                FROM `customeradvance` 
                LEFT JOIN customeradvanceadadjustment ON customeradvance.`advanceId` = customeradvanceadadjustment.`advanceid`
                WHERE customeradvance.`advanceId`=".$custAdvanceId.
                " GROUP BY customeradvance.`advanceId`";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $data=$this->db->query($sql)->row()->totalAdjusted;
            return $data;
        } else {
            return $data;
        }
    }
    
    
    
     public function getCustomerUnpaidBill($customerBillMasterId,$companyId,$custadjustMntId){
        
        $data = array();
     //   $call_procedure = "CALL GetCustomerUnpaidBill(" . $companyId . ",".$customerBillMasterId.",@unpaidAmount".")";
        $call_procedure = "CALL GetCustomerUnpaidBillAdjust (" . $companyId . "," . $customerBillMasterId . "," . $custadjustMntId . ",@unpaidAmount" . ")";
        $this->db->trans_start();
        $this->db->query($call_procedure); // not need to get output
        $query = $this->db->query("SELECT @unpaidAmount As unpaid");
        $this->db->trans_complete();

        

       // if($query->num_rows() > 0)
            $unpaid = $query->row()->unpaid;
      //echo($unpaid);exit;
        
        return $unpaid;
    }
    
    public function getBillDateAndOthers($customerBillMasterId){
        
        $sql="SELECT 
            DATE_FORMAT(`customerbillmaster`.`billdate`,'%d-%m-%Y')AS billDate,
            `customerbillmaster`.`invoicemasterid`,
            `customerbillmaster`.`customerbillmasterid`
            FROM `customerbillmaster`
            WHERE `customerbillmaster`.`customerbillmasterid` =".$customerBillMasterId;
         $result = $this->db->query($sql);
           if ($result->num_rows() > 0) {
                    $data =array(
                    "billDate"=>$result->row()->billDate,
                    "invoiceMasterId"=>$result->row()->invoicemasterid,
                    "customerBillMasterId"=>$result->row()->customerbillmasterid
                );
                return $data;
        } else {
            return $data;
        }
        
    }
    
    
     public function  insertCustomerBillAdjustment($masterData,$billDetails){
        try{
            $this->db->trans_begin();
            $this->db->insert('customeradvanceadadjustment', $masterData);
            $InsertedMasterId = $this->db->insert_id();
            $this->detailsInsert($InsertedMasterId,$billDetails);
              if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                return false;
            } else {
                $this->db->trans_commit();
                return true;
            }
        }catch (Exception $exc){
            echo $exc->getTraceAsString();
        }
    }
    
    /**
     * 
     * @param type $masterData
     * @param type $billDetails
     * @return boolean
     * @desc Update customer bill Adjustment
     */
    public function updateCustomerBillAdjustment($masterData, $billDetails) {
        try {
            $this->db->trans_begin();
            $this->db->where("AdjustmentId", $masterData["AdjustmentId"]);
            $this->db->update('customeradvanceadadjustment', $masterData);
            //$InsertedMasterId = $this->db->insert_id();
            $this->detailsInsert($masterData["AdjustmentId"], $billDetails);
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                return false;
            } else {
                $this->db->trans_commit();
                return true;
            }
        } catch (Exception $ex) {
            echo $exc->getTraceAsString();
        }
    }
    
     private function detailsInsert($InsertedMasterId,$billDetails){
          $this->db->where("custadjmstid", $InsertedMasterId);
          $this->db->delete("customeradvanceadjstdtl");
      
         foreach ($billDetails as $data){
            $data=array("custadjmstid"=>$InsertedMasterId,
                        "customerbillmaster"=>$data["customerBillMasterId"],
                        "adjustedamount"=>$data["adjustedAmount"]
                );
                $this->db->insert('customeradvanceadjstdtl',$data);
        }
        
        
    }
    
    public function getAdjustmentList($compny,$year){
        $sql="SELECT customeradvanceadadjustment.`adjustmentid`,
                DATE_FORMAT(customeradvanceadadjustment.`dateofadjustment`,'%d-%m-%Y') AS DateOfAdjustment,
                customeradvanceadadjustment.`adjustmentrefno`,
                customeradvanceadadjustment.`totalamountadjusted`,
                customeradvanceadadjustment.`customeraccid`,
                customer.`customer_name`
                FROM `customeradvanceadadjustment`
                INNER JOIN
                customer
                ON
                `customeradvanceadadjustment`.`customeraccid`=customer.`account_master_id`
                INNER JOIN `customeradvance` 
                ON `customeradvance`.`advanceId`=`customeradvanceadadjustment`.`advanceid`
                WHERE customeradvance.`companyid`=".$compny." AND customeradvance.`yearid`=".$year."
                ORDER BY customeradvanceadadjustment.`DateOfAdjustment` DESC";
        
         $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
                $data[] = array(
                    "AdjustmentId" => $rows->adjustmentid,
                    "DateOfAdjustment" => $rows->DateOfAdjustment,
                    "AdjustmentRefNo"=>$rows->adjustmentrefno,
                    "TotalAmountAdjusted"=>$rows->totalamountadjusted,
                    "customeraccid"=>$rows->customeraccid,
                    "customer_name"=>$rows->customer_name
                    );
            }


            return $data;
        } else {
            return $data;
        }
        
    }
    
    
    
      public function getDetail($custadjustmentId) {
        $sql = "SELECT 
    customeradvanceadjstdtl.`adjustedamount`,
    customeradvanceadjstdtl.`customerbillmaster`,
    (
      CASE
        WHEN sale_bill_master.`id` IS NOT NULL 
        THEN sale_bill_master.`salebillno` 
        WHEN rawteasale_master.`id` IS NOT NULL 
        THEN rawteasale_master.`invoice_no` 
      END
    ) AS sInvoiceNumber,
    (
      CASE
        WHEN sale_bill_master.`id` IS NOT NULL 
        THEN DATE_FORMAT(
          sale_bill_master.`salebilldate`,
          '%d-%m-%Y'
        ) 
        WHEN rawteasale_master.`id` IS NOT NULL 
        THEN DATE_FORMAT(
          rawteasale_master.`sale_date`,
          '%d-%m-%Y'
        ) 
      END
    ) AS sInvoiceDate,
    (
      CASE
        WHEN sale_bill_master.`id` IS NOT NULL 
        THEN sale_bill_master.`grandtotal` 
        WHEN rawteasale_master.`id` IS NOT NULL 
        THEN rawteasale_master.`grandtotal` 
      END
    ) AS sAmount 
  FROM
    `customeradvanceadjstdtl`
INNER JOIN customerbillmaster ON customeradvanceadjstdtl.`customerbillmaster` = customerbillmaster.`customerbillmasterid`    
LEFT JOIN `sale_bill_master` ON customerbillmaster.`invoicemasterid` = sale_bill_master.`id`
LEFT JOIN  rawteasale_master ON customerbillmaster.`invoicemasterid` = rawteasale_master.`id`
WHERE customeradvanceadjstdtl.`custadjmstid` = " . $custadjustmentId;

        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
                $data[] = array(
                    "sInvoiceNumber" => $rows->sInvoiceNumber,
                    "sInvoiceDate" => $rows->sInvoiceDate,
                    "sAmount" => $rows->sAmount,
                    "paidAmount" => $rows->adjustedamount
                );
            }


            return $data;
        } else {
            return $data;
        }
    }
    
    
     public function getCustomerAdjMstById($id) {
        $data = array();
        $sql = "SELECT 
                customeradvanceadadjustment.`adjustmentid`,
                customeradvanceadadjustment.`adjustmentrefno`,
                DATE_FORMAT(customeradvanceadadjustment.`dateofadjustment`,'%d-%m-%Y') AS DateOfAdjustment,
                customeradvanceadadjustment.`totalamountadjusted`,
                customeradvanceadadjustment.`customeraccid`,
                customeradvanceadadjustment.`advanceid`,
                voucher_master.`voucher_number`
                FROM 
                customeradvanceadadjustment
                INNER JOIN `customeradvance` ON `customeradvanceadadjustment`.`advanceid` = `customeradvance`.`advanceId`
                INNER JOIN `voucher_master` ON customeradvance.`voucherid` = voucher_master.`id`
                WHERE
                customeradvanceadadjustment.`adjustmentid` =" . $id;
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
                $data = array(
                    "AdjustmentId" => $rows->adjustmentid,
                    "AdjustmentRefNo" => $rows->adjustmentrefno,
                    "DateOfAdjustment" => $rows->DateOfAdjustment,
                    "TotalAmountAdjusted" => $rows->totalamountadjusted,
                    "customerAccId" => $rows->customeraccid,
                    "advanceMasterId" => $rows->advanceid,
                    "voucher_number" => $rows->voucher_number
                );
            }


            return $data;
        } else {
            return $data;
        }
    }
    
    
     public function getCustAdjstDtl($advanceMasterId) {

        $data = array();
        $sql = " SELECT
                    `customeradvanceadjstdtl`.`id` AS custAdjDtlId,
                   `customeradvanceadjstdtl`. `custadjmstid`,
                   `customeradvanceadjstdtl`. `customerbillmaster`,
                   `customeradvanceadjstdtl`. `adjustedamount`,
                    (CASE
                   WHEN sale_bill_master.id IS NOT NULL THEN sale_bill_master.`salebillno`
                   WHEN rawteasale_master.`id` IS NOT NULL THEN rawteasale_master.`invoice_no`
                   END)AS invoiceNo,
 
                    (CASE
                    WHEN sale_bill_master.id IS NOT NULL THEN DATE_FORMAT(sale_bill_master.`salebilldate`,'%d-%m-%Y')
                    WHEN rawteasale_master.`id` IS NOT NULL THEN DATE_FORMAT(rawteasale_master.`sale_date`,'%d-%m-%Y')
                    END)AS BillDate,

                   (CASE
                    WHEN sale_bill_master.id IS NOT NULL THEN sale_bill_master.`grandtotal`
                    WHEN rawteasale_master.`id` IS NOT NULL THEN rawteasale_master.`grandtotal`
                    END)AS BillAmount 
                   FROM `customeradvanceadjstdtl`
                        INNER JOIN customerbillmaster ON customeradvanceadjstdtl.`customerbillmaster` = customerbillmaster.`customerbillmasterid`    
                        LEFT JOIN `sale_bill_master` ON customerbillmaster.`invoicemasterid` = sale_bill_master.`id`
                        LEFT JOIN  rawteasale_master ON customerbillmaster.`invoicemasterid` = rawteasale_master.`id`
                        WHERE customeradvanceadjstdtl.`custadjmstid` = ".$advanceMasterId;

        
        

        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
                $data[] = array(
                    "custAdjstDtlId" => $rows->custAdjDtlId,
                    "custAdjstMstId" => $rows->custadjmstid,
                    "customerBillMasterId" => $rows->customerbillmaster,
                    "adjustedAmount" => $rows->adjustedamount,
                    "invoiceNo" => $rows->invoiceNo,
                    "BillDate" => $rows->BillDate,
                    "BillAmount" => $rows->BillAmount
                );
            }
            return $data;
        } else {
            return $data;
        }
    }
    
      public function delete($customerAdvanceAdjustment) {
        try {
            $this->db->trans_begin();
            $this->db->where("custadjmstid", $customerAdvanceAdjustment);
            $this->db->delete("customeradvanceadjstdtl");
            $this->db->where("adjustmentid",$customerAdvanceAdjustment);
             $this->db->delete("customeradvanceadadjustment");

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

    
}

?>