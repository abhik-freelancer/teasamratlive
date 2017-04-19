<?php

class vendorAdvanceAdjstmodel extends CI_Model{
    
    public function getVendorAdvanceVoucher($vendorId){
        $data=  array();
        $sql="SELECT `vendoradvancemaster`.`advanceId`,
            voucher_master.`voucher_number`
            FROM 
            `vendoradvancemaster`
            INNER JOIN
            `voucher_master` 
            ON vendoradvancemaster.`voucherId` = `voucher_master`.`id`
            WHERE `vendoradvancemaster`.`vendorId`=".$vendorId;
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
    
    public function getAdvanceAmountByAdvanceId($vendorAdvanceId){
        
        $data=0;
        /*$sql=" SELECT  
                    vendoradvancemaster.`advanceId`,
                    vendoradvancemaster.`advanceAmount`
                FROM `vendoradvancemaster`
                WHERE `vendoradvancemaster`.`advanceId`=".$vendorAdvanceId;*/
        $sql="SELECT 
                (vendoradvancemaster.`advanceAmount` - IFNULL(SUM(vendoradvanceadjustmentmaster.`TotalAmountAdjusted`),0)) AS totalAdjusted,
                vendoradvancemaster.`advanceId`
                FROM `vendoradvancemaster` 
                LEFT JOIN vendoradvanceadjustmentmaster ON vendoradvancemaster.`advanceId` = vendoradvanceadjustmentmaster.`advanceMasterId`
                WHERE vendoradvancemaster.`advanceId`=".$vendorAdvanceId.
                " GROUP BY vendoradvancemaster.`advanceId`";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $data=$this->db->query($sql)->row()->totalAdjusted;
            return $data;
        } else {
            return $data;
        }
    }
    
    public function getPurchaseInvoiceByVendor($vendorId){
        $data="";
        
        $sql="SELECT 
                vendorbillmaster.`vendorBillMasterId`,
                vendorbillmaster.`invoiceMasterId`,
              CASE
            WHEN `purchase_invoice_master`.`purchase_invoice_number` IS NULL THEN `rawmaterial_purchase_master`.`invoice_no`
            WHEN  `rawmaterial_purchase_master`.`invoice_no` IS NULL THEN `purchase_invoice_master`.`purchase_invoice_number`
            END AS InvoiceNumber
                    FROM `vendorbillmaster` 
            LEFT JOIN purchase_invoice_master
            ON
            vendorbillmaster.`invoiceMasterId` = purchase_invoice_master.`id` 
            AND vendorbillmaster.`purchaseType` ='T'
            LEFT JOIN rawmaterial_purchase_master
            ON
            vendorbillmaster.`invoiceMasterId` = rawmaterial_purchase_master.`id`
            AND vendorbillmaster.`purchaseType`='O'
            WHERE 
            vendorbillmaster.`vendorAccountId` =".$vendorId;
        
        
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
                $data[] = array(
                    "vendorBillMasterId" => $rows->vendorBillMasterId,
                    "InvoiceNumber" => $rows->InvoiceNumber,
                    );
            }


            return $data;
        } else {
            return $data;
        }
        
    }
    
    public function getVendorUnpaidBill($vendorBillMasterId,$companyId){
        
        $data = array();
        $call_procedure = "CALL GetVendorUnpaidBill(" . $companyId . ",".$vendorBillMasterId.",@unpaidAmount".")";
        $this->db->trans_start();
        $this->db->query($call_procedure); // not need to get output
        $query = $this->db->query("SELECT @unpaidAmount As unpaid");
        $this->db->trans_complete();

        

       // if($query->num_rows() > 0)
            $unpaid = $query->row()->unpaid;
      //echo($unpaid);exit;
        
        return $unpaid;
    }
    
    
    public function getBillDateAndOthers($vendorBillMasterID){
        
        $sql="SELECT 
            DATE_FORMAT(`vendorBillMaster`.`billDate`,'%d-%m-%Y')AS billDate,
            `vendorBillMaster`.`invoiceMasterId`,
            `vendorBillMaster`.`vendorBillMasterId`
            FROM `vendorBillMaster`
            WHERE `vendorBillMaster`.`vendorBillMasterId` =".$vendorBillMasterID;
         $result = $this->db->query($sql);
           if ($result->num_rows() > 0) {
                    $data =array(
                    "billDate"=>$result->row()->billDate,
                    "invoiceMasterId"=>$result->row()->invoiceMasterId,
                    "vendorBillMasterId"=>$result->row()->vendorBillMasterId
                );
                return $data;
        } else {
            return $data;
        }
        
    }
    
    public function  insertVendorBillAdjustment($masterData,$billDetails){
        try{
            $this->db->trans_begin();
            $this->db->insert('vendoradvanceadjustmentmaster', $masterData);
            $InsertedMasterId = $this->db->insert_id();
            $this->detailsInsert($InsertedMasterId,$billDetails);
              if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                return false;
            } else {
                $this->db->trans_commit();
                return true;
            }
        }catch (Exception $ex){
            echo $exc->getTraceAsString();
        }
    }
    
    private function detailsInsert($InsertedMasterId,$billDetails){
        
        foreach ($billDetails as $data){
            $data=array("vendAdjstMstId"=>$InsertedMasterId,
                        "vendorBillMasterId"=>$data["vendorBillMasterId"],
                        "adjustedAmount"=>$data["adjustedAmount"]
                );
                $this->db->insert('vendoradjustmentdetails',$data);
        }
    }
    
    public function getAdjustmentList(){
        $sql="SELECT vendoradvanceadjustmentmaster.`AdjustmentId`,
DATE_FORMAT(vendoradvanceadjustmentmaster.`DateOfAdjustment`,'%d-%m-%Y') AS DateOfAdjustment,
vendoradvanceadjustmentmaster.`AdjustmentRefNo`,
vendoradvanceadjustmentmaster.`TotalAmountAdjusted`,
vendoradvanceadjustmentmaster.`vendorAccId`,
vendor.`vendor_name`
FROM `vendoradvanceadjustmentmaster`
INNER JOIN
vendor
ON
`vendoradvanceadjustmentmaster`.`vendorAccId`=vendor.`account_master_id`
ORDER BY vendoradvanceadjustmentmaster.`DateOfAdjustment` DESC";
        
         $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
                $data[] = array(
                    "AdjustmentId" => $rows->AdjustmentId,
                    "DateOfAdjustment" => $rows->DateOfAdjustment,
                    "AdjustmentRefNo"=>$rows->AdjustmentRefNo,
                    "TotalAmountAdjusted"=>$rows->TotalAmountAdjusted,
                    "vendorAccId"=>$rows->vendorAccId,
                    "vendor_name"=>$rows->vendor_name
                    );
            }


            return $data;
        } else {
            return $data;
        }
        
    }
}