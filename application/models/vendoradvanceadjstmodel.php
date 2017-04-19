<?php

class vendoradvanceadjstmodel extends CI_Model {

    public function getVendorAdvanceVoucher($vendorId) {
        $data = array();
        $sql = "SELECT `vendoradvancemaster`.`advanceId`,
            voucher_master.`voucher_number`
            FROM 
            `vendoradvancemaster`
            INNER JOIN
            `voucher_master` 
            ON vendoradvancemaster.`voucherId` = `voucher_master`.`id`
            WHERE `vendoradvancemaster`.`vendorId`=" . $vendorId;
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

    public function getAdvanceAmountByAdvanceId($vendorAdvanceId) {

        $data = 0;
        /* $sql=" SELECT  
          vendoradvancemaster.`advanceId`,
          vendoradvancemaster.`advanceAmount`
          FROM `vendoradvancemaster`
          WHERE `vendoradvancemaster`.`advanceId`=".$vendorAdvanceId; */
        $sql = "SELECT 
                (vendoradvancemaster.`advanceAmount` - IFNULL(SUM(vendoradvanceadjustmentmaster.`TotalAmountAdjusted`),0)) AS totalAdjusted,
                vendoradvancemaster.`advanceId`
                FROM `vendoradvancemaster` 
                LEFT JOIN vendoradvanceadjustmentmaster ON vendoradvancemaster.`advanceId` = vendoradvanceadjustmentmaster.`advanceMasterId`
                WHERE vendoradvancemaster.`advanceId`=" . $vendorAdvanceId .
                " GROUP BY vendoradvancemaster.`advanceId`";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $data = $this->db->query($sql)->row()->totalAdjusted;
            return $data;
        } else {
            return $data;
        }
    }

    public function getVendorAdjMstById($id) {
        $data = array();
        $sql = "SELECT 
                vendoradvanceadjustmentmaster.`AdjustmentId`,
                vendoradvanceadjustmentmaster.`AdjustmentRefNo`,
                DATE_FORMAT(vendoradvanceadjustmentmaster.`DateOfAdjustment`,'%d-%m-%Y') AS DateOfAdjustment,
                vendoradvanceadjustmentmaster.`TotalAmountAdjusted`,
                vendoradvanceadjustmentmaster.`vendorAccId`,
                vendoradvanceadjustmentmaster.`advanceMasterId`,
                voucher_master.`voucher_number`
                FROM 
                vendoradvanceadjustmentmaster
                INNER JOIN `vendoradvancemaster` ON `vendoradvanceadjustmentmaster`.`advanceMasterId` = `vendoradvancemaster`.`advanceId`
                INNER JOIN `voucher_master` ON vendoradvancemaster.`voucherId` = voucher_master.`id`
                WHERE
                vendoradvanceadjustmentmaster.`AdjustmentId` =" . $id;
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
                $data = array(
                    "AdjustmentId" => $rows->AdjustmentId,
                    "AdjustmentRefNo" => $rows->AdjustmentRefNo,
                    "DateOfAdjustment" => $rows->DateOfAdjustment,
                    "TotalAmountAdjusted" => $rows->TotalAmountAdjusted,
                    "vendorAccId" => $rows->vendorAccId,
                    "advanceMasterId" => $rows->advanceMasterId,
                    "voucher_number" => $rows->voucher_number,
                );
            }


            return $data;
        } else {
            return $data;
        }
    }

    public function getVendAdjstDtl($advanceMasterId) {

        $data = array();
        $sql = " SELECT
                    `vendoradjustmentdetails`.`vendAdjstDtlId`,
                   `vendoradjustmentdetails`. `vendAdjstMstId`,
                   `vendoradjustmentdetails`. `vendorBillMasterId`,
                   `vendoradjustmentdetails`. `adjustedAmount`,
                    (CASE
                   WHEN purchase_invoice_master.id IS NOT NULL THEN purchase_invoice_master.`purchase_invoice_number`
                   WHEN rawmaterial_purchase_master.`id` IS NOT NULL THEN rawmaterial_purchase_master.`invoice_no`
                   END)AS invoiceNo,
 
                    (CASE
                    WHEN purchase_invoice_master.id IS NOT NULL THEN DATE_FORMAT(purchase_invoice_master.`purchase_invoice_date`,'%d-%m-%Y')
                    WHEN rawmaterial_purchase_master.`id` IS NOT NULL THEN DATE_FORMAT(rawmaterial_purchase_master.`invoice_date`,'%d-%m-%Y')
                    END)AS BillDate,

                   (CASE
                    WHEN purchase_invoice_master.id IS NOT NULL THEN purchase_invoice_master.`total`
                    WHEN rawmaterial_purchase_master.`id` IS NOT NULL THEN rawmaterial_purchase_master.`invoice_value`
                    END)AS BillAmount 
                   FROM `vendoradjustmentdetails`
              INNER JOIN 
                 `vendorbillmaster` ON vendoradjustmentdetails.`vendorBillMasterId` = vendorbillmaster.`vendorBillMasterId`
              LEFT JOIN `purchase_invoice_master` ON vendorbillmaster.`invoiceMasterId` = purchase_invoice_master.`id`
              LEFT JOIN `rawmaterial_purchase_master` ON vendorbillmaster.`invoiceMasterId` = rawmaterial_purchase_master.`id`
              WHERE vendoradjustmentdetails.`vendAdjstMstId` =" . $advanceMasterId;

        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
                $data[] = array(
                    "vendAdjstDtlId" => $rows->vendAdjstDtlId,
                    "vendAdjstMstId" => $rows->vendAdjstMstId,
                    "vendorBillMasterId" => $rows->vendorBillMasterId,
                    "adjustedAmount" => $rows->adjustedAmount,
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

    public function getPurchaseInvoiceByVendor($vendorId) {
        $data = "";
        $session = sessiondata_method();
        $companyId = $session['company'];

        $sql = "SELECT 
                    vendorbillmaster.`vendorBillMasterId`,
                    vendorbillmaster.`invoiceMasterId`,
                CASE
                  WHEN `purchase_invoice_master`.`purchase_invoice_number` IS NOT NULL  THEN `purchase_invoice_master`.`purchase_invoice_number` 
                  WHEN `rawmaterial_purchase_master`.`invoice_no` IS NOT NULL THEN `rawmaterial_purchase_master`.`invoice_no` 
                  WHEN  purchase_finishproductmaster.purchasebillno IS NOT NULL THEN purchase_finishproductmaster.purchasebillno
                END AS InvoiceNumber 
                FROM
                `vendorbillmaster` 
                LEFT JOIN purchase_invoice_master 
                  ON vendorbillmaster.`invoiceMasterId` = purchase_invoice_master.`id` 
                  AND vendorbillmaster.`purchaseType` = 'T' 
                LEFT JOIN rawmaterial_purchase_master 
                  ON vendorbillmaster.`invoiceMasterId` = rawmaterial_purchase_master.`id` 
                  AND vendorbillmaster.`purchaseType` = 'O' 
                LEFT JOIN purchase_finishproductmaster
                  ON  vendorbillmaster.`invoiceMasterId` = purchase_finishproductmaster.id AND vendorbillmaster.purchaseType ='F'  
              WHERE vendorbillmaster.`vendorAccountId` =".$vendorId." AND vendorbillmaster.companyId = ".$companyId. 
                  " AND vendorbillmaster.yearId >5 ";


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

    public function getVendorUnpaidBill($vendorBillMasterId,$companyId,$vendorAdjustmntId) {

        $data = array();
       // $call_procedure = "CALL GetVendorUnpaidBill(" . $companyId . "," . $vendorBillMasterId . ",@unpaidAmount" . ")";
         $call_procedure = "CALL GetVendorUnpaidAdjustmnt (" . $companyId . "," . $vendorBillMasterId . "," . $vendorAdjustmntId . ",@unpaidAmount" . ")";
        $this->db->trans_start();
        $this->db->query($call_procedure); // not need to get output
        $query = $this->db->query("SELECT @unpaidAmount As unpaid");
        $this->db->trans_complete();



        // if($query->num_rows() > 0)
        $unpaid = $query->row()->unpaid;
        //echo($unpaid);exit;

        return $unpaid;
    }

    public function getBillDateAndOthers($vendorBillMasterID) {

        $sql = "SELECT 
            DATE_FORMAT(`vendorbillmaster`.`billDate`,'%d-%m-%Y')AS billDate,
            `vendorbillmaster`.`invoiceMasterId`,
            `vendorbillmaster`.`vendorBillMasterId`
            FROM `vendorbillmaster`
            WHERE `vendorbillmaster`.`vendorBillMasterId` =" . $vendorBillMasterID;
        $result = $this->db->query($sql);
        if ($result->num_rows() > 0) {
            $data = array(
                "billDate" => $result->row()->billDate,
                "invoiceMasterId" => $result->row()->invoiceMasterId,
                "vendorBillMasterId" => $result->row()->vendorBillMasterId
            );
            return $data;
        } else {
            return $data;
        }
    }

    public function insertVendorBillAdjustment($masterData, $billDetails) {
        try {
            $this->db->trans_begin();
            $this->db->insert('vendoradvanceadjustmentmaster', $masterData);
            $InsertedMasterId = $this->db->insert_id();
            $this->detailsInsert($InsertedMasterId, $billDetails);
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

    /**
     * 
     * @param type $masterData
     * @param type $billDetails
     * @return boolean
     * @desc Update vendor bill Adjustment
     */
    public function updateVendorBillAdjustment($masterData, $billDetails) {
        try {
            $this->db->trans_begin();
            $this->db->where("AdjustmentId", $masterData["AdjustmentId"]);
            $this->db->update('vendoradvanceadjustmentmaster', $masterData);
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

    private function detailsInsert($InsertedMasterId, $billDetails) {
        $this->db->where("vendAdjstMstId", $InsertedMasterId);
        $this->db->delete("vendoradjustmentdetails");


        foreach ($billDetails as $data) {
            $data = array("vendAdjstMstId" => $InsertedMasterId,
                "vendorBillMasterId" => $data["vendorBillMasterId"],
                "adjustedAmount" => $data["adjustedAmount"]
            );
            $this->db->insert('vendoradjustmentdetails', $data);
        }
    }

    public function getAdjustmentList($cmpny,$year) {
        $sql = "SELECT vendoradvanceadjustmentmaster.`AdjustmentId`,
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
                INNER JOIN vendoradvancemaster
                ON vendoradvancemaster.`advanceId`= vendoradvanceadjustmentmaster.`advanceMasterId`
                WHERE vendoradvancemaster.`companyId`=".$cmpny." AND  vendoradvancemaster.`yearId`=".$year."
                ORDER BY vendoradvanceadjustmentmaster.`DateOfAdjustment` DESC";

        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
                $data[] = array(
                    "AdjustmentId" => $rows->AdjustmentId,
                    "DateOfAdjustment" => $rows->DateOfAdjustment,
                    "AdjustmentRefNo" => $rows->AdjustmentRefNo,
                    "TotalAmountAdjusted" => $rows->TotalAmountAdjusted,
                    "vendorAccId" => $rows->vendorAccId,
                    "vendor_name" => $rows->vendor_name
                );
            }


            return $data;
        } else {
            return $data;
        }
    }

    public function getDetail($vendoradjustmentId) {
        $sql = "SELECT 
    vendoradjustmentdetails.`adjustedAmount`,
    vendoradjustmentdetails.`vendorBillMasterId`,
    (
      CASE
        WHEN purchase_invoice_master.`id` IS NOT NULL 
        THEN purchase_invoice_master.`purchase_invoice_number` 
        WHEN rawmaterial_purchase_master.`id` IS NOT NULL 
        THEN rawmaterial_purchase_master.`invoice_no` 
      END
    ) AS pInvoiceNumber,
    (
      CASE
        WHEN purchase_invoice_master.`id` IS NOT NULL 
        THEN DATE_FORMAT(
          purchase_invoice_master.`purchase_invoice_date`,
          '%d-%m-%Y'
        ) 
        WHEN rawmaterial_purchase_master.`id` IS NOT NULL 
        THEN DATE_FORMAT(
          rawmaterial_purchase_master.`invoice_date`,
          '%d-%m-%Y'
        ) 
      END
    ) AS pInvoiceDate,
    (
      CASE
        WHEN purchase_invoice_master.`id` IS NOT NULL 
        THEN purchase_invoice_master.`total` 
        WHEN rawmaterial_purchase_master.`id` IS NOT NULL 
        THEN rawmaterial_purchase_master.`invoice_value` 
      END
    ) AS pAmount 
  FROM
    `vendoradjustmentdetails`
INNER JOIN vendorbillmaster ON vendoradjustmentdetails.`vendorBillMasterId` = vendorbillmaster.`vendorBillMasterId`    
LEFT JOIN `purchase_invoice_master` ON vendorbillmaster.`invoiceMasterId` = purchase_invoice_master.`id`
LEFT JOIN  rawmaterial_purchase_master ON vendorbillmaster.`invoiceMasterId` = rawmaterial_purchase_master.`id`
WHERE vendoradjustmentdetails.`vendAdjstMstId` = " . $vendoradjustmentId;

        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
                $data[] = array(
                    "pInvoiceNumber" => $rows->pInvoiceNumber,
                    "pInvoiceDate" => $rows->pInvoiceDate,
                    "pAmount" => $rows->pAmount,
                    "paidAmount" => $rows->adjustedAmount,
                );
            }


            return $data;
        } else {
            return $data;
        }
    }

    public function delete($vendorAdvanceAdjustment) {
        try {
            $this->db->trans_begin();
            $this->db->where("vendAdjstMstId", $vendorAdvanceAdjustment);
            $this->db->delete("vendoradjustmentdetails");
            $this->db->where("AdjustmentId",$vendorAdvanceAdjustment);
             $this->db->delete("vendoradvanceadjustmentmaster");

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
