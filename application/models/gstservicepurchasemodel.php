<?php

class gstservicepurchasemodel extends CI_Model {
  /**
    * @method GSTinsertData
    * @param type $rawMatPurchaseMaster
    * @param type $searcharray
    * @return boolean
    * @date 05/07/2017
    */
   public function GSTinsertData($rawMatPurchaseMaster,$searcharray){
         try {
                $this->db->trans_begin();
                //Voucher Insertion
                $voucherId=$this->insertVoucherMaster($rawMatPurchaseMaster);
                //echo ("VC: ".$voucherId);
                $this->GSTinsertVoucherDetails($voucherId, $searcharray);
                //Voucher Insertion
               
                
            $rawMatPurchaseMaster['voucher_id']=$voucherId;
            $this->db->insert('rawmaterial_purchase_master', $rawMatPurchaseMaster);
            $newrawDtlId = $this->db->insert_id();
            $vendorBillMasterSave = $this->insertVendorBillMaster($newrawDtlId,$rawMatPurchaseMaster);//vendor bill master 19-08-2016
            $this->GSTupdateRawmatPurchaseDetails($newrawDtlId, $searcharray);
           

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
     * @method insertVoucherMaster
     * @param type $rawMatPurchaseMaster
     * @return type
     */
    private function insertVoucherMaster($rawMatPurchaseMaster){
     $voucherMaster=array();
     $voucherMasterId;
        $voucherMaster["year_id"] = $rawMatPurchaseMaster['yearid'];
        $voucherMaster["vouchertype"]='SPR';//service purchase
        $voucherMaster["voucher_number"]=$rawMatPurchaseMaster['invoice_no'];
        $voucherMaster["voucher_date"]=$rawMatPurchaseMaster['invoice_date'];
        $voucherMaster["transaction_type"]='SP';
        $voucherMaster["serial_number"]=0;
        $voucherMaster["paid_to"]=NULL;
        $voucherMaster["narration"] = 'Service purchase agnst. invoice num :'.$rawMatPurchaseMaster['invoice_no'];
        $voucherMaster["created_by"] = $rawMatPurchaseMaster['userid'];
        $voucherMaster["company_id"]=$rawMatPurchaseMaster['companyid'];
        $voucherMaster["cheque_number"]=NULL;
        $voucherMaster["cheque_date"]=NULL;

        $this->db->insert("voucher_master",$voucherMaster);
        $voucherMasterId = $this->db->insert_id();
      // echo( $this->db->last_query());
        return $voucherMasterId;
        
    }
    /**
     * 
     * @param type $voucherMasterId
     * @param type $dataArr
     * @return boolean
     */
    private function GSTinsertVoucherDetails($voucherMasterId,$dataArr){
       
        $session = sessiondata_method();
        //voucher_detail
        $this->db->where ('voucher_master_id',$voucherMasterId);
        $this->db->delete('voucher_detail');
        
        //vendor account Id Cr
        $voucherDtl["voucher_master_id"] =$voucherMasterId; 
        $voucherDtl["account_master_id"] = $this->getVendorAccountId($dataArr["vendor"]);
        $voucherDtl["voucher_amount"] = $dataArr["txtInvoiceValue"];
        $voucherDtl["is_debit"] = "N";
        $voucherDtl["account_id_for_trial"] = NULL;
        $voucherDtl["subledger_id"] = NULL;
        $voucherDtl["is_master"] = NULL;
        $this->db->insert("voucher_detail",$voucherDtl);
        
       $vMastId=$voucherMasterId;
       $numberofDetails = count($dataArr['txtDetailQuantity']);
       
       //service account 
       
       for($j=0;$j<$numberofDetails;$j++){
           
           $voucherDtl["voucher_master_id"] =$vMastId;
           $voucherDtl["account_master_id"]=$dataArr["account"][$j];
           $voucherDtl["voucher_amount"]=$dataArr["txtTaxableAmt"][$j];
           $voucherDtl["is_debit"] = "Y";
           $voucherDtl["account_id_for_trial"] = NULL;
           $voucherDtl["subledger_id"] = NULL;
           $voucherDtl["is_master"] = NULL;
           $this->db->insert("voucher_detail",$voucherDtl);
       }
       
       // for GST(cgst+sgst+igst)
       
       $cgstarray=array();
       $sgstarray =array();
       $igstarray =array();
       for ($i = 0; $i < $numberofDetails; $i++) {
            $cgstarray[] =array("id"=>$dataArr['cgst'][$i],"cgstamount"=>$dataArr['cgstAmt'][$i]);
            $sgstarray[] = array("id"=>$dataArr['sgst'][$i],"sgstamount"=>$dataArr['sgstAmt'][$i]);
            $igstarray[] = array("id"=>$dataArr['igst'][$i],"igstamount"=>$dataArr['igstAmt'][$i]);
       }
       //*************************************//
    $groups = array();
    $key = 0;
    foreach ($cgstarray as $item) {
        $key = $item['id'];
        if (!array_key_exists($key, $groups)) {
            $groups[$key] = array(
                'id' => $item['id'],
                'cgstamount' => $item['cgstamount']
                
            );
        } else {
           
            $groups[$key]['cgstamount'] = $groups[$key]['cgstamount'] + $item['cgstamount'];
        }
        $key++;
    }
    foreach ($groups as $value) {
       // echo ($value["id"]."||".$value["cgstamount"] );
        $this->GSTinsertionOnVoucherDetails($vMastId, $value["id"], $value["cgstamount"], "CGST");
    }
    /*******************SGST******************************/
     $groups = array();
     $key = 0;
    foreach ($sgstarray as $item) {
        $key = $item['id'];
        if (!array_key_exists($key, $groups)) {
            $groups[$key] = array(
                'id' => $item['id'],
                'sgstamount' => $item['sgstamount']
                
            );
        } else {
           
            $groups[$key]['sgstamount'] = $groups[$key]['sgstamount'] + $item['sgstamount'];
        }
        $key++;
    }
     foreach ($groups as $value) {
       // echo ($value["id"]."||".$value["cgstamount"] );
        $this->GSTinsertionOnVoucherDetails($vMastId, $value["id"], $value["sgstamount"], "SGST");
    }
    /**************************IGST***********************/
     $groups = array();
     $key = 0;
    foreach ($igstarray as $item) {
        $key = $item['id'];
        if (!array_key_exists($key, $groups)) {
            $groups[$key] = array(
                'id' => $item['id'],
                'igstamount' => $item['igstamount']
                
            );
        } else {
           
            $groups[$key]['igstamount'] = $groups[$key]['igstamount'] + $item['igstamount'];
        }
        $key++;
    }
     foreach ($groups as $value) {
       // echo ($value["id"]."||".$value["cgstamount"] );
        $this->GSTinsertionOnVoucherDetails($vMastId, $value["id"], $value["igstamount"], "IGST");
    }
      // exit();
     return TRUE;   
    }
    /**
     * @author Abhik Ghosh <amiabhik@gmail.com>
     * @param type $vouchermasterId
     * @param type $gstId
     * @param type $gstAmount
     * @param type $gstType
     * @Desc generic GST account insertion on voucher details
     */
    private function GSTinsertionOnVoucherDetails($vouchermasterId,$gstId,$gstAmount,$gstType){
       $sql="SELECT gstmaster.accountId
                FROM gstmaster
             WHERE gstmaster.id =".$gstId." AND gstmaster.gstType ='".$gstType."'";
       if($gstId!=0){
        $accountId = $this->db->query($sql)->row()->accountId;
       }
       if($gstId!=0){
                $vouchrDtlVat['voucher_master_id'] = $vouchermasterId;
                $vouchrDtlVat['account_master_id'] = $accountId;
                $vouchrDtlVat['voucher_amount'] = $gstAmount;
                $vouchrDtlVat['is_debit'] ='Y' ;
                $vouchrDtlVat['account_id_for_trial'] = NULL;
                $vouchrDtlVat['subledger_id'] = NULL;
                $vouchrDtlVat['is_master'] = NULL;
                $this->db->insert('voucher_detail', $vouchrDtlVat);
       }
   }
    
   /**
     * 
     * @param type $purchaseInvoiceMasterId
     * @param type $rawMatPurchaseMaster
     * @return type
     */
     private function insertVendorBillMaster($purchaseInvoiceMasterId,$rawMatPurchaseMaster){
         $vendBllMstArr=array(
             'billDate'=>$rawMatPurchaseMaster['invoice_date'],
             'billAmount'=>$rawMatPurchaseMaster['invoice_value'],
             'invoiceMasterId'=>$purchaseInvoiceMasterId,
             'purchaseType'=>'O',
             'vendorAccountId'=>$this->getVendorAccountId($rawMatPurchaseMaster['vendor_id']),
             'companyId'=>$rawMatPurchaseMaster['companyid'],
             'yearId'=>$rawMatPurchaseMaster['yearid']
         
         );
         $insrt=$this->db->insert('vendorbillmaster',$vendBllMstArr);
         return $insrt;
     }
     
     public function GSTupdateRawmatPurchaseDetails($newrawDtlId,$dtlArr){
        $rawMatpurchaseDetails = array();
        $this->db->where ('rawmat_purchase_masterId',$newrawDtlId);
        $this->db->delete('rawmaterial_purchasedetail');
             
        $numberOfDtl = count($dtlArr['txtDetailQuantity']);
        for ($i = 0; $i < $numberOfDtl; $i++) {
            $rawMatpurchaseDetails['rawmat_purchase_masterId'] = $newrawDtlId;
            $rawMatpurchaseDetails['productid'] = $dtlArr['productlist'][$i];
            $rawMatpurchaseDetails['quantity'] = ($dtlArr['txtDetailQuantity'][$i] == "" ? 0 : $dtlArr['txtDetailQuantity'][$i]);
            $rawMatpurchaseDetails['rate'] = ($dtlArr['txtDetailRate'][$i] == "" ? 0 : $dtlArr['txtDetailRate'][$i]);
            $rawMatpurchaseDetails['amount'] = ($dtlArr['txtDetailAmount'][$i] == "" ? 0 : $dtlArr['txtDetailAmount'][$i]);
            
            #gst section
            $rawMatpurchaseDetails['gstdiscount'] = ($dtlArr['txtDiscount'][$i] == "" ? 0 : $dtlArr['txtDiscount'][$i]);
            $rawMatpurchaseDetails['gstTaxableamount'] = ($dtlArr['txtTaxableAmt'][$i] == "" ? 0 : $dtlArr['txtTaxableAmt'][$i]);
            
            $rawMatpurchaseDetails['cgstRateId'] = ($dtlArr['cgst'][$i] == 0 ? NULL : $dtlArr['cgst'][$i]);
            $rawMatpurchaseDetails['cgstamt'] = ($dtlArr['cgstAmt'][$i] == "" ? NULL : $dtlArr['cgstAmt'][$i]);
            
            $rawMatpurchaseDetails['sgstRateId'] = ($dtlArr['sgst'][$i] == 0 ? NULL : $dtlArr['sgst'][$i]);
            $rawMatpurchaseDetails['sgstamt'] = ($dtlArr['sgstAmt'][$i] == "" ? NULL : $dtlArr['sgstAmt'][$i]);
            
            $rawMatpurchaseDetails['igstRateId'] = ($dtlArr['igst'][$i] == 0 ? NULL : $dtlArr['igst'][$i]);
            $rawMatpurchaseDetails['igstamt'] = ($dtlArr['igstAmt'][$i] == "" ? NULL : $dtlArr['igstAmt'][$i]);
            //HSN
            $rawMatpurchaseDetails['HSN'] = ($dtlArr['txtHSNNumber'][$i] == "" ? NULL : $dtlArr['txtHSNNumber'][$i]);
            $rawMatpurchaseDetails['serviceaccountId']=($dtlArr['account'][$i] == "" ? NULL : $dtlArr['account'][$i]);

           
            $this->db->insert('rawmaterial_purchasedetail',$rawMatpurchaseDetails);
          
        }
    }
   
    
     public function getVendorAccountId($vendorId){
         $sql="SELECT vendor.`account_master_id`
                    FROM vendor 
                    WHERE vendor.`id`=".$vendorId;
             $query = $this->db->query($sql);
       
        if ($query->num_rows() > 0) {
            $data=$this->db->query($sql)->row()->account_master_id;
            return $data;
            } else {
                return $data;
            }
    }
    
    
    /**
   * GSTUpdateData
   * @param type $updRowmatPurchaseMast
   * @param type $searcharray
   * @return boolean
   */
   public function GSTUpdateData($updRowmatPurchaseMast,$searcharray){
        $purRawmatId = $updRowmatPurchaseMast['id'];
        $voucherIdForEdit = $this->getVoucherId($purRawmatId);
       
  
        try {
            
             $this->db->trans_begin();
            
             $this->db->where('id',$purRawmatId );
             $this->db->update('rawmaterial_purchase_master' ,$updRowmatPurchaseMast);
             
             $this->upDateVendorBillMaster($purRawmatId, $updRowmatPurchaseMast); //19-08-2016
             $this->upDateVoucherMaster($voucherIdForEdit,$updRowmatPurchaseMast);
           
             $this->GSTinsertVoucherDetails($voucherIdForEdit, $searcharray);
             
             //$this->insertIntorawRawMaterialDtl($purRawmatId,$searcharray);
             $this->GSTupdateRawmatPurchaseDetails($purRawmatId, $searcharray);
             
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                return false;
            } else {
                $this->db->trans_commit();
                return true;
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
            return FALSE;
        }
    }
    
    
     public function upDateVendorBillMaster($purchaseInvoiceMstId,$updRowmatPurchaseMast){
        $fieldsArr = array('invoiceMasterId'=>$purchaseInvoiceMstId,'purchaseType'=>'O');
        $updtArr=array('billDate'=>$updRowmatPurchaseMast['invoice_date'],
                        'billAmount'=>$updRowmatPurchaseMast['invoice_value'],
                        'vendorAccountId'=>  $this->getVendorAccountId($updRowmatPurchaseMast['vendor_id'])
            );
            $this->db->where($fieldsArr);
            $this->db->update("vendorbillmaster",$updtArr);
    }
    
    
     /**
     * @date 19-08-2016
     * @param type $voucherMasterId
     * @param type $rawMatPurchaseMaster
     */
    private function upDateVoucherMaster($voucherMasterId,$rawMatPurchaseMaster){
       
        $voucherMaster["voucher_number"]=$rawMatPurchaseMaster['invoice_no'];
        $voucherMaster["voucher_date"]=$rawMatPurchaseMaster['invoice_date'];
        $voucherMaster["narration"] = 'Service purchase agnst. invoice num :'.$rawMatPurchaseMaster['invoice_no'];
        
        $this->db->where('id',$voucherMasterId);
        $this->db->update('voucher_master',$voucherMaster);
        
    }
    
    /**
     * 
     * @param type $rawPmstId
     * @return type
     * @date 19-08-2016
     */
    private function getVoucherId($rawPmstId){
        $sql="SELECT rawmaterial_purchase_master.`voucher_id`
                FROM rawmaterial_purchase_master
              WHERE rawmaterial_purchase_master.`id` = ".$rawPmstId;
         $query = $this->db->query($sql);
       
        if ($query->num_rows() > 0) {
            $data=$this->db->query($sql)->row()->voucher_id;
            return $data;
            } else {
                return $data;
            }
    }
    
   ///============================================================================///
}
?>
