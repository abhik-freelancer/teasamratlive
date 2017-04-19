<?php

class vendoradvancemodel extends CI_Model {

    public function insertVendorAdvance($advanceArray) {
        $voucherMasterArray = array();
        $voucherDetailArray = array();
        try {
            $voucherMasterArray["voucher_number"] = $advanceArray["voucherNumber"];
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
            $voucherMasterArray["transaction_type"] = "VADV"; // vendor advance
            $voucherMasterArray["created_by"] = $advanceArray["userId"];
            $voucherMasterArray["serial_number"] = $advanceArray["voucherSerial"];
            $voucherMasterArray["company_id"] = $advanceArray["companyId"];
            $voucherMasterArray["year_id"] = $advanceArray["yearId"];

            //var_dump($voucherMasterArray);exit;

            $this->db->trans_begin();
            $this->db->insert('voucher_master', $voucherMasterArray); // voucher master Id
            //echo( $this->db->last_query());
            $InsertedVoucherMasterId = $this->db->insert_id(); //voucher master id
            //echo($InsertedVoucherMasterId.' :VNum');

            $this->updateGeneralvoucherSerial($advanceArray);

            $voucherDetailArray["creditAccountId"] = $advanceArray["cashorbank"];
            $voucherDetailArray["debitAccountId"] = $advanceArray["vendoradvance"];
            $voucherDetailArray["voucher_amount"] = $advanceArray["advanceAmount"];
            $voucherDetailArray["voucherMasterId"] = $InsertedVoucherMasterId;
            $this->InsertVoucherDetail($voucherDetailArray);

            //advance insert

            $advVend["advanceDate"] = date("Y-m-d", strtotime($advanceArray["advanceDate"]));
            $advVend["voucherId"] = $InsertedVoucherMasterId;
            $advVend["advanceAmount"] = $advanceArray["advanceAmount"];
            ;
            $advVend["vendorId"] = $advanceArray["vendoradvance"];
            $advVend["isFullAdjusted"] = 'N';
            $advVend["companyId"] = $advanceArray["companyId"];
            $advVend["yearId"] = $advanceArray["yearId"];
            $this->db->insert('vendoradvancemaster', $advVend);

            //echo( $this->db->last_query()); exit();

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
    /**
     * 
     * @param type $data
     */
    public function UpdateVendorAdvance($advanceArray) {
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
           
            

            $voucherDetailArray["creditAccountId"] = $advanceArray["cashorbank"];
            $voucherDetailArray["debitAccountId"] = $advanceArray["vendoradvance"];
            $voucherDetailArray["voucher_amount"] = $advanceArray["advanceAmount"];
            $voucherDetailArray["voucherMasterId"] = $advanceArray['voucherId'];
            $this->InsertVoucherDetail($voucherDetailArray);

            //advance insert

            $advVend["advanceDate"] = date("Y-m-d", strtotime($advanceArray["advanceDate"]));
            $advVend["advanceAmount"] = $advanceArray["advanceAmount"];
            $advVend["vendorId"] = $advanceArray["vendoradvance"];
            
            $this->db->where('advanceId',$advanceArray['advanceId']);
            $this->db->update('vendoradvancemaster', $advVend);
           
            

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

    public function getAdvanceById($vendoradvanceId) {
        $sql = " 
                SELECT
                        vendoradvancemaster.`advanceId`,
                       DATE_FORMAT(vendoradvancemaster.`advanceDate`,'%d-%m-%Y') AS advanceDate,
                         vendoradvancemaster.`voucherId`,
                         vendoradvancemaster.`advanceAmount`,
                         vendoradvancemaster.`vendorId`,
                         vendoradvancemaster.`isFullAdjusted`,
                         vendoradvancemaster.`companyId`,
                         vendoradvancemaster.`yearId`,
                         DATE_FORMAT(voucher_master.`cheque_date`,'%d-%m-%Y') AS cheque_date,
                         voucher_master.`cheque_number`,voucher_master.`narration`
                       FROM `vendoradvancemaster`
                INNER JOIN `voucher_master` ON vendoradvancemaster.`voucherId` = voucher_master.`id`WHERE 
                vendoradvancemaster.`advanceId`=" . $vendoradvanceId;

        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
                $data = array(
                    "advanceId" => $rows->advanceId,
                    "advanceDate" => $rows->advanceDate,
                    "voucherId" => $rows->voucherId,
                    "advanceAmount" => $rows->advanceAmount,
                    "vendorId" => $rows->vendorId,
                    "cheque_date" => $rows->cheque_date,
                    "cheque_number" => $rows->cheque_number,
                    "narration"=>$rows->narration,
                    "cashorbankId"=>  $this->getCreditAccountId($rows->voucherId));
            }


            return $data;
        } else {
            return $data;
        }
    }
    
    public function getCreditAccountId($voucherId){
        $sql=" SELECT `voucher_detail`.`account_master_id` FROM `voucher_detail` WHERE `voucher_detail`.`voucher_master_id`=".$voucherId
              ." AND `voucher_detail`.`is_debit`='N' ";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            
            $data=$this->db->query($sql)->row()->account_master_id;
            


            return $data;
        } else {
            return $data;
        }
        
    }
    public function getVendorAdvanceList($companyId,$yearId){
        $sql=" SELECT
                     vendoradvancemaster.`advanceId`,
                    DATE_FORMAT(vendoradvancemaster.`advanceDate`,'%d-%m-%Y') AS advanceDate,
                      vendoradvancemaster.`voucherId`,
                      vendoradvancemaster.`advanceAmount`,
                      vendoradvancemaster.`vendorId`,account_master.`account_name`,
                      vendoradvancemaster.`isFullAdjusted`,
                      vendoradvancemaster.`companyId`,
                      vendoradvancemaster.`yearId`,
                      DATE_FORMAT(voucher_master.`cheque_date`,'%d-%m-%Y') AS cheque_date,
                      voucher_master.`cheque_number`,voucher_master.`narration`,voucher_master.voucher_number
                    FROM `vendoradvancemaster`
                    INNER JOIN `voucher_master` ON vendoradvancemaster.`voucherId` = voucher_master.`id`
                    INNER JOIN `account_master` ON vendoradvancemaster.`vendorId` =account_master.`id`
                    WHERE vendoradvancemaster.`companyId`= ".$companyId. " AND vendoradvancemaster.`yearId`= ".$yearId;
        
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
                $data[] = array(
                    "advanceId" => $rows->advanceId,
                    "advanceDate" => $rows->advanceDate,
                    "voucherId" => $rows->voucherId,
                    "advanceAmount" => $rows->advanceAmount,
                    "vendorId" => $rows->vendorId,
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

}
