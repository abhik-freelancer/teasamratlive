<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of vendormodel
 *
 * @author pc1
 */
class vendorpaymentmodel extends CI_Model {

    //put your code here


    public function insertData($masterData, $billDetails) {
        
        $resultArray=array();
        try {
            $this->db->trans_begin();

            $voucherId = $this->insertVoucherMaster($masterData);
             $this->updateGeneralvoucherSerial($masterData);

            $vendorpaymentmaster["voucherId"] = $voucherId;
            $vendorpaymentmaster["vendorid"] = $masterData["vendorId"];
            $vendorpaymentmaster["totalpaidamount"] = $masterData["totalPayment"];
            $vendorpaymentmaster["dateofpayment"] = date("Y-m-d", strtotime($masterData["dateofpayment"]));

            $this->db->insert("vendorbillpaymentmaster", $vendorpaymentmaster);
            $vendorBillMasterId = $this->db->insert_id();
            
            //echo( $this->db->last_query());
            //echo($vendorBillMasterId);

            $this->insertVendorBillPaymentDetails($vendorBillMasterId, $billDetails);

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

    private function insertVendorBillPaymentDetails($vendorBillMasterId, $billDetails) {
           
          
        
        
        foreach ($billDetails as $row) {
            $data["vendorpaymentid"]= $vendorBillMasterId;
            $data["vendorBillMaster"] = $row["vendorBillMasterId"];
            $data["paidAmount"] = $row["paidAmount"];
            //print_r($data);
            $this->db->insert("vendorbillpaymentdetail", $data);
        }
          //exit;
        
    }

    private function insertVoucherMaster($masterData) {

        $voucherMasterArray["voucher_number"] = $masterData["voucherNumber"];
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
        $voucherMasterArray["transaction_type"] = "PY"; // vendor advance
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

        //credit cash or bank
        $voucherDetail["voucher_master_id"] = $voucherMasterId;
        $voucherDetail["account_master_id"] = $voucherDetailArray["creditAccountId"];
        $voucherDetail["voucher_amount"] = $voucherDetailArray["totalPayment"];
        $voucherDetail["is_debit"] = "N";
        $this->db->insert("voucher_detail", $voucherDetail);
         //echo( $this->db->last_query());
        //vendor debit
        $voucherDetail["voucher_master_id"] = $voucherMasterId;
        $voucherDetail["account_master_id"] = $voucherDetailArray["vendorId"];
        $voucherDetail["voucher_amount"] = $voucherDetailArray["totalPayment"];
        $voucherDetail["is_debit"] = "Y";
        $this->db->insert("voucher_detail", $voucherDetail);
         //echo( $this->db->last_query());
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
    
    public function getVendorPaymentList(){
        
        $sql= "SELECT
                    `vendorPaymentId`,
                    DATE_FORMAT(`dateofpayment`,'%d-%m-%Y')AS dateofpayment,
                    `vendorid`,
                    `totalpaidamount`,
                    `voucherId`,
                    `typeofpayment`,
                    `voucher_master`.`voucher_number`,
                    vendor.`vendor_name`
                FROM `vendorbillpaymentmaster`
                INNER JOIN
                `voucher_master`  ON `vendorbillpaymentmaster`.`voucherId` = `voucher_master`.`id`
                INNER JOIN vendor ON vendorbillpaymentmaster.`vendorid` = vendor.`account_master_id`";
        
          $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
                $data[] = array(
                    "vendorPaymentId"=>$rows->vendorPaymentId,
                    "dateofpayment"=>$rows->dateofpayment,
                    "totalpaidamount"=>$rows->totalpaidamount,
                    "voucher_number"=>$rows->voucher_number,
                    "vendor_name"=>$rows->vendor_name,
                    "credit_account"=>  $this->getCreditAccount($rows->vendorPaymentId)
                   );
            }


            return $data;
        } else {
            return $data;
        }
    }
    
    private function getCreditAccount($vendorPaymentId){
       $sql= "SELECT `voucher_detail`.`account_master_id`, `account_master`.`account_name` FROM `vendorbillpaymentmaster` 
                INNER JOIN `voucher_detail` 
                ON `vendorbillpaymentmaster`.`voucherId` = `voucher_detail`.`voucher_master_id`
                AND `voucher_detail`.`is_debit` ='N'
                INNER JOIN `account_master` ON `voucher_detail`.`account_master_id` = `account_master`.`id`
                WHERE `vendorbillpaymentmaster`.`vendorPaymentId`=".$vendorPaymentId;
       
       $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $data=$this->db->query($sql)->row()->account_name;
            return $data;
        } else {
            return $data;
        }
    }
    
    
    
    public function getDetail($vendorPaymentId){
        $sql="SELECT `vendorbillpaymentmaster`.`vendorPaymentId`,
                    `vendorbillpaymentdetail`.`paidAmount`,
                    `vendorbillpaymentdetail`.`vendorBillMaster`,
                    `vendorbillmaster`.`invoiceMasterId`,`vendorbillmaster`.`purchaseType`,

                    (CASE 
                    WHEN purchase_invoice_master.`id` IS NOT NULL THEN purchase_invoice_master.`purchase_invoice_number`
                    WHEN rawmaterial_purchase_master.`id` IS NOT NULL THEN rawmaterial_purchase_master.`invoice_no`
                    END) AS pInvoiceNumber ,

                    (CASE 
                    WHEN purchase_invoice_master.`id` IS NOT NULL THEN DATE_FORMAT(purchase_invoice_master.`purchase_invoice_date`,'%d-%m-%Y')
                    WHEN rawmaterial_purchase_master.`id` IS NOT NULL THEN DATE_FORMAT(rawmaterial_purchase_master.`invoice_date`,'%d-%m-%Y')
                    END) AS pInvoiceDate,

                    (CASE 
                    WHEN purchase_invoice_master.`id` IS NOT NULL THEN purchase_invoice_master.`total`
                    WHEN rawmaterial_purchase_master.`id` IS NOT NULL THEN rawmaterial_purchase_master.`invoice_value`
                    END) AS pAmount

                FROM
                `vendorbillpaymentmaster`
                INNER JOIN
                `vendorbillpaymentdetail`
                ON `vendorbillpaymentmaster`.`vendorPaymentId`=`vendorbillpaymentdetail`.`vendorpaymentid`
                INNER JOIN `vendorbillmaster` ON `vendorbillpaymentdetail`.`vendorBillMaster` = `vendorbillmaster`.`vendorBillMasterId`
                LEFT JOIN `purchase_invoice_master` ON vendorbillmaster.`invoiceMasterId` = purchase_invoice_master.`id`
                LEFT JOIN `rawmaterial_purchase_master` ON `vendorbillmaster`.`invoiceMasterId`  = rawmaterial_purchase_master.`id`
                WHERE `vendorbillpaymentmaster`.`vendorPaymentId`=".$vendorPaymentId;
        
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
                $data[] = array(
                    "pInvoiceNumber"=>$rows->pInvoiceNumber,
                    "pInvoiceDate"=>$rows->pInvoiceDate,
                    "pAmount"=>$rows->pAmount,
                    "paidAmount"=>$rows->paidAmount,
                    
                   );
            }


            return $data;
        } else {
            return $data;
        }
        
    }

}
