<?php

class rawmaterialpurchasemodel extends CI_Model {

  /*@method getProductList
   * @retun $data
   * @date 07-03-2016
   */  
    
   public function getProductList(){
       $sql="SELECT 
            `raw_material_master`.`id`,
            `raw_material_master`.`product_description` 
             FROM `raw_material_master`  WHERE raw_material_master.type='R' ORDER BY `raw_material_master`.`product_description`";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
                $data[] = array(
                    "productid" => $rows->id,
                    "productdescript" => $rows->product_description
                  );
            }


            return $data;
        } else {
            return $data;
        }
   }
   /**
    * @author Abhik<amiabhik@gmail.com>
    * @method getServiceList
    * @return type array
    */
   public function getServiceList(){
       $sql="SELECT 
            `raw_material_master`.`id`,
            `raw_material_master`.`product_description`
             FROM `raw_material_master` 
             WHERE raw_material_master.type='S'
             ORDER BY `raw_material_master`.`product_description` ";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
                $data[] = array(
                    "productid" => $rows->id,
                    "productdescript" => $rows->product_description
                  );
            }


            return $data;
        } else {
            return $data;
        }
   }
   
   /*@method getRawPurchaseList
   * @retun $data
   * @date 07-03-2016
   */  
   
   public function getRawPurchaseList($cmpny,$year){
       $sql="SELECT 
        `rawmaterial_purchase_master`.`id` AS rawMatPurchMastId,
        `rawmaterial_purchase_master`.`invoice_no`,
        DATE_FORMAT(`rawmaterial_purchase_master`.`invoice_date`,'%d-%m-%Y') AS InvoiceDate,
        `rawmaterial_purchase_master`.`invoice_value`,
        `vendor`.`vendor_name`
        FROM `rawmaterial_purchase_master`
        INNER JOIN `vendor`
        ON `rawmaterial_purchase_master`.`vendor_id`=`vendor`.`id`
        WHERE `rawmaterial_purchase_master`.`companyid`=".$cmpny." AND  `rawmaterial_purchase_master`.`yearid`=".$year.
               " AND rawmaterial_purchase_master.IsGST='N'";
       $query = $this->db->query($sql);
       if($query->num_rows()>0){
           foreach($query->result() as $rows){
               $data[]=array(
                   "rawMatPurchMastId"=>$rows->rawMatPurchMastId,
                   "invoice_no"=>$rows->invoice_no,
                   "InvoiceDate"=>$rows->InvoiceDate,
                   "invoice_value"=>$rows->invoice_value,
                   "vendor_name"=>$rows->vendor_name
                   
               );
           }
           return $data;
       }else{
           return $data;
       }
   }
   
   public function GSTRawPurchaseList($cmpny,$year){
       $data=array();
       $sql="SELECT 
        `rawmaterial_purchase_master`.`id` AS rawMatPurchMastId,
        `rawmaterial_purchase_master`.`invoice_no`,
        DATE_FORMAT(`rawmaterial_purchase_master`.`invoice_date`,'%d-%m-%Y') AS InvoiceDate,
        `rawmaterial_purchase_master`.`invoice_value`,
        `vendor`.`vendor_name`
        FROM `rawmaterial_purchase_master`
        INNER JOIN `vendor`
        ON `rawmaterial_purchase_master`.`vendor_id`=`vendor`.`id`
        WHERE `rawmaterial_purchase_master`.`companyid`=".$cmpny." AND  `rawmaterial_purchase_master`.`yearid`=".$year.
        " AND  rawmaterial_purchase_master.IsGST='Y'";
       $query = $this->db->query($sql);
       if($query->num_rows()>0){
           foreach($query->result() as $rows){
               $data[]=array(
                   "rawMatPurchMastId"=>$rows->rawMatPurchMastId,
                   "invoice_no"=>$rows->invoice_no,
                   "InvoiceDate"=>$rows->InvoiceDate,
                   "invoice_value"=>$rows->invoice_value,
                   "vendor_name"=>$rows->vendor_name
                   
               );
           }
           return $data;
       }else{
           return $data;
       }
   }
   
   /**
   *GstServicePurchaseList
   *
   **/
   
    public function GstServicePurchaseList($cmpny,$year){
       $data=array();
       $sql="SELECT 
        `rawmaterial_purchase_master`.`id` AS rawMatPurchMastId,
        `rawmaterial_purchase_master`.`invoice_no`,
        DATE_FORMAT(`rawmaterial_purchase_master`.`invoice_date`,'%d-%m-%Y') AS InvoiceDate,
        `rawmaterial_purchase_master`.`invoice_value`,
        `vendor`.`vendor_name`
        FROM `rawmaterial_purchase_master`
        INNER JOIN `vendor`
        ON `rawmaterial_purchase_master`.`vendor_id`=`vendor`.`id`
        WHERE `rawmaterial_purchase_master`.`companyid`=".$cmpny." AND  `rawmaterial_purchase_master`.`yearid`=".$year.
        " AND  rawmaterial_purchase_master.IsGST='Y' AND rawmaterial_purchase_master.IsService='Y'";
       $query = $this->db->query($sql);
       if($query->num_rows()>0){
           foreach($query->result() as $rows){
               $data[]=array(
                   "rawMatPurchMastId"=>$rows->rawMatPurchMastId,
                   "invoice_no"=>$rows->invoice_no,
                   "InvoiceDate"=>$rows->InvoiceDate,
                   "invoice_value"=>$rows->invoice_value,
                   "vendor_name"=>$rows->vendor_name
                   
               );
           }
           return $data;
       }else{
           return $data;
       }
   }
   
   
   
   
   
   
   public function getRawMatpurchaseMastData($mastId){
       $sql="SELECT 
            `rawmaterial_purchase_master`.`id` AS rawpurchaseMastId,
            `rawmaterial_purchase_master`.`invoice_no`,
            DATE_FORMAT(`rawmaterial_purchase_master`.`invoice_date`,'%d-%m-%Y') AS Invoicedate,
            `rawmaterial_purchase_master`.`challan_no`,
            DATE_FORMAT(`rawmaterial_purchase_master`.`challan_date`,'%d-%m-%Y') AS ChalanDt,
            `rawmaterial_purchase_master`.`order_no`,
            DATE_FORMAT(`rawmaterial_purchase_master`.`order_date`,'%d-%m-%Y') AS OrderDt,
            `rawmaterial_purchase_master`.`excise_invoice_no`,
            DATE_FORMAT(`rawmaterial_purchase_master`.`excise_invoice_date`,'%d-%m-%Y') AS ExciseDt,
            `rawmaterial_purchase_master`.`vendor_id`,
            `rawmaterial_purchase_master`.`item_amount`,
            `rawmaterial_purchase_master`.`excise_id`,
            `rawmaterial_purchase_master`.`excise_amount`,
            `rawmaterial_purchase_master`.`round_off`,
            `rawmaterial_purchase_master`.`taxamount`,
            `rawmaterial_purchase_master`.`taxrateType`,
            `rawmaterial_purchase_master`.`taxrateTypeId`,
            `rawmaterial_purchase_master`.`invoice_value`
            FROM `rawmaterial_purchase_master` WHERE `rawmaterial_purchase_master`.`id`=".$mastId."";
       
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
                $data = array(
                   "rawpurchaseMastId"=>$rows->rawpurchaseMastId,
                    "invoice_no"=>$rows->invoice_no,
                    "Invoicedate"=>$rows->Invoicedate,
                    "challan_no"=>$rows->challan_no,
                    "ChalanDt"=>$rows->ChalanDt,
                    "order_no"=>$rows->order_no,
                    "OrderDt"=>$rows->OrderDt,
                    "excise_invoice_no"=>$rows->excise_invoice_no,
                    "ExciseDt"=>$rows->ExciseDt,
                    "vendor_id"=>$rows->vendor_id,
                    "item_amount"=>$rows->item_amount,
                    "excise_id"=>$rows->excise_id,
                    "excise_amount"=>$rows->excise_amount,
                    "round_off"=>$rows->round_off,
                    "taxamount"=>$rows->taxamount,
                    "taxrateType"=>$rows->taxrateType,
                    "taxrateTypeId"=>$rows->taxrateTypeId,
                    "invoice_value"=>$rows->invoice_value
                );
            }


            return $data;
        } else {
            return $data;
        }
   }
   
   public function GSTgetRawMatpurchaseMastData($mastId){
       $sql="SELECT 
            `rawmaterial_purchase_master`.`id` AS rawpurchaseMastId,
            `rawmaterial_purchase_master`.`invoice_no`,
            DATE_FORMAT(`rawmaterial_purchase_master`.`invoice_date`,'%d-%m-%Y') AS Invoicedate,
            `rawmaterial_purchase_master`.`challan_no`,
            DATE_FORMAT(`rawmaterial_purchase_master`.`challan_date`,'%d-%m-%Y') AS ChalanDt,
            `rawmaterial_purchase_master`.`order_no`,
            DATE_FORMAT(`rawmaterial_purchase_master`.`order_date`,'%d-%m-%Y') AS OrderDt,
            `rawmaterial_purchase_master`.`excise_invoice_no`,
            DATE_FORMAT(`rawmaterial_purchase_master`.`excise_invoice_date`,'%d-%m-%Y') AS ExciseDt,
            `rawmaterial_purchase_master`.`vendor_id`,
            `rawmaterial_purchase_master`.`item_amount`,
            `rawmaterial_purchase_master`.`round_off`,
            `rawmaterial_purchase_master`.`taxamount`,
            `rawmaterial_purchase_master`.`invoice_value`,
            
            rawmaterial_purchase_master.GST_Discountamount,
            rawmaterial_purchase_master.GST_Taxableamount,
            rawmaterial_purchase_master.GST_Totalgstincluded,
            rawmaterial_purchase_master.totalCGST,
            rawmaterial_purchase_master.totalSGST,
            rawmaterial_purchase_master.totalIGST,
            rawmaterial_purchase_master.IsGST


            FROM `rawmaterial_purchase_master` WHERE `rawmaterial_purchase_master`.`id`=".$mastId."";
       
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
                $data = array(
                   "rawpurchaseMastId"=>$rows->rawpurchaseMastId,
                    "invoice_no"=>$rows->invoice_no,
                    "Invoicedate"=>$rows->Invoicedate,
                    "challan_no"=>$rows->challan_no,
                    "ChalanDt"=>$rows->ChalanDt,
                    "order_no"=>$rows->order_no,
                    "OrderDt"=>$rows->OrderDt,
                    "vendor_id"=>$rows->vendor_id,
                    "item_amount"=>$rows->item_amount,
                    "round_off"=>$rows->round_off,
                    "taxamount"=>$rows->taxamount,
                    "invoice_value"=>$rows->invoice_value,
                    
                    "GST_Discountamount"=>$rows->GST_Discountamount,
                    "GST_Taxableamount"=>$rows->GST_Taxableamount,
                    "GST_Totalgstincluded"=>$rows->GST_Totalgstincluded,
                    "totalCGST"=>$rows->totalCGST,
                    "totalSGST"=>$rows->totalSGST,
                    "totalIGST"=>$rows->totalIGST
                    
                );
            }


            return $data;
        } else {
            return $data;
        }
   }
   
   public function GSTgetRawMaterialDtldata($mastId){
       $sql="SELECT 
            `rawmaterial_purchasedetail`.`id` AS rawPurDtlId,
            `rawmaterial_purchasedetail`.`rawmat_purchase_masterId` AS rawPurchMastid,
            `rawmaterial_purchasedetail`.`productid`,
            `rawmaterial_purchasedetail`.`quantity`,
            `rawmaterial_purchasedetail`.`rate`,
            `rawmaterial_purchasedetail`.`amount`,
            `rawmaterial_purchasedetail`.gstdiscount,
            `rawmaterial_purchasedetail`.gstTaxableamount,
            `rawmaterial_purchasedetail`.cgstRateId,
            `rawmaterial_purchasedetail`.cgstamt,
            `rawmaterial_purchasedetail`.sgstRateId,
            `rawmaterial_purchasedetail`.sgstamt,
             `rawmaterial_purchasedetail`.igstRateId,
             `rawmaterial_purchasedetail`.igstamt,
              `rawmaterial_purchasedetail`.HSN,rawmaterial_purchasedetail.serviceaccountId
            FROM `rawmaterial_purchasedetail`
            WHERE `rawmaterial_purchasedetail`.`rawmat_purchase_masterId`=".$mastId."";
       $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
                $data[] = array(
                    "rawPurchMastid"=>$rows->rawPurchMastid,
                   "rawPurDtlId"=>$rows->rawPurDtlId,
                    "productid"=>$rows->productid,
                    "quantity"=>$rows->quantity,
                    "rate"=>$rows->rate,
                    "amount"=>$rows->amount,
                    "gstdiscount"=>$rows->gstdiscount,
                    "gstTaxableamount"=>$rows->gstTaxableamount,
                    "cgstRateId"=>$rows->cgstRateId,
                    "cgstamt"=>$rows->cgstamt,
                    "sgstRateId"=>$rows->sgstRateId,
                    "sgstamt"=>$rows->sgstamt,
                    "igstRateId"=>$rows->igstRateId,
                    "igstamt"=>$rows->igstamt,
                    "HSN"=>$rows->HSN,
                        "serviceaccountId"=>$rows->serviceaccountId
                );
            }


            return $data;
        } else {
            return $data;
        }
       
   }
   
   
   
   
   
   
   
   public function getRawMaterialDtldata($mastId){
       $sql="SELECT 
            `rawmaterial_purchasedetail`.`id` AS rawPurDtlId,
            `rawmaterial_purchasedetail`.`rawmat_purchase_masterId` AS rawPurchMastid,
            `rawmaterial_purchasedetail`.`productid`,
            `rawmaterial_purchasedetail`.`quantity`,
            `rawmaterial_purchasedetail`.`rate`,
            `rawmaterial_purchasedetail`.`amount`
            FROM `rawmaterial_purchasedetail`
            WHERE `rawmaterial_purchasedetail`.`rawmat_purchase_masterId`=".$mastId."";
       $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
                $data[] = array(
                    "rawPurchMastid"=>$rows->rawPurchMastid,
                   "rawPurDtlId"=>$rows->rawPurDtlId,
                    "productid"=>$rows->productid,
                    "quantity"=>$rows->quantity,
                    "rate"=>$rows->rate,
                    "amount"=>$rows->amount
                );
            }


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
       
        //Purchase Account
        $voucherDtl["voucher_master_id"] =$voucherMasterId; 
        $voucherDtl["account_master_id"] = $this->getPurchaseAccId($session['company']);
        $voucherDtl["voucher_amount"] = ($dataArr["txtTaxAmount"]+ $dataArr["txtRoundOff"]);
        $voucherDtl["is_debit"] = "Y";
        $voucherDtl["account_id_for_trial"] = NULL;
        $voucherDtl["subledger_id"] = NULL;
        $voucherDtl["is_master"] = NULL;
        $this->db->insert("voucher_detail",$voucherDtl);
        
        
        $vMastId=$voucherMasterId;
        
        // for GST(cgst+sgst+igst)
       $numberofDetails = count($dataArr['txtDetailQuantity']);
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
            

           
            $this->db->insert('rawmaterial_purchasedetail',$rawMatpurchaseDetails);
          
        }
    }
   
   
   
   
     /**
     * 
     * @param type $saleBillMaster
     * @param type $searcharray
     * @return boolean
     */
    public function insertData($rawMatPurchaseMaster,$searcharray){
         try {
            $this->db->trans_begin();
                //Voucher Insertion
                $voucherId=$this->insertVoucherMaster($rawMatPurchaseMaster);
                //echo ("VC: ".$voucherId);
                $this->insertVoucherDetails($voucherId, $rawMatPurchaseMaster);
                //Voucher Insertion
               
                
            $rawMatPurchaseMaster['voucher_id']=$voucherId;
            $this->db->insert('rawmaterial_purchase_master', $rawMatPurchaseMaster);
            $newrawDtlId = $this->db->insert_id();
            $vendorBillMasterSave = $this->insertVendorBillMaster($newrawDtlId,$rawMatPurchaseMaster);//vendor bill master 19-08-2016
            $this->updateRawmatPurchaseDetails($newrawDtlId, $searcharray);
           //  echo"<br>qqq".($this->db->last_query());exit;

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
    private function insertVoucherMaster($rawMatPurchaseMaster){
     $voucherMaster=array();
     $voucherMasterId;
        $voucherMaster["year_id"] = $rawMatPurchaseMaster['yearid'];
        $voucherMaster["vouchertype"]='RPR';
        $voucherMaster["voucher_number"]=$rawMatPurchaseMaster['invoice_no'];
        $voucherMaster["voucher_date"]=$rawMatPurchaseMaster['invoice_date'];
        $voucherMaster["transaction_type"]='RP';
        $voucherMaster["serial_number"]=0;
        $voucherMaster["paid_to"]=NULL;
        $voucherMaster["narration"] = 'Raw material purchase agnst. invoice num :'.$rawMatPurchaseMaster['invoice_no'];
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
     * @date 19-08-2016
     * @param type $voucherMasterId
     * @param type $rawMatPurchaseMaster
     */
    private function upDateVoucherMaster($voucherMasterId,$rawMatPurchaseMaster){
       
        $voucherMaster["voucher_number"]=$rawMatPurchaseMaster['invoice_no'];
        $voucherMaster["voucher_date"]=$rawMatPurchaseMaster['invoice_date'];
        $voucherMaster["narration"] = 'Raw material purchase agnst. invoice num :'.$rawMatPurchaseMaster['invoice_no'];
        
        $this->db->where('id',$voucherMasterId);
        $this->db->update('voucher_master',$voucherMaster);
        $this->insertVoucherDetails($voucherMasterId, $rawMatPurchaseMaster);
    }
    /**
     * 
     * @param type $voucherMasterId
     * @param type $dataArr
     * @return boolean
     * @date 19-08-2016
     * @Abhik Ghosh
     */
    private function insertVoucherDetails($voucherMasterId,$dataArr){
        //voucher_detail
        $this->db->where ('voucher_master_id',$voucherMasterId);
        $this->db->delete('voucher_detail');
        
        //vendor account Id Cr
        $voucherDtl["voucher_master_id"] =$voucherMasterId; 
        $voucherDtl["account_master_id"] = $this->getVendorAccountId($dataArr["vendor_id"]);
        $voucherDtl["voucher_amount"] = $dataArr["invoice_value"];
        $voucherDtl["is_debit"] = "N";
        $voucherDtl["account_id_for_trial"] = NULL;
        $voucherDtl["subledger_id"] = NULL;
        $voucherDtl["is_master"] = NULL;
        $this->db->insert("voucher_detail",$voucherDtl);
        //Purchase Account
        if($dataArr["taxrateType"]=="V"){
            $cstAmount =0;
        }else{
            $cstAmount=$dataArr["taxamount"];
        }
        $voucherDtl["voucher_master_id"] =$voucherMasterId; 
        $voucherDtl["account_master_id"] = $this->getPurchaseAccId($dataArr["companyid"]);
        $voucherDtl["voucher_amount"] = ($dataArr["item_amount"]+ $dataArr["excise_amount"]+ $dataArr["round_off"]+$cstAmount);
        $voucherDtl["is_debit"] = "Y";
        $voucherDtl["account_id_for_trial"] = NULL;
        $voucherDtl["subledger_id"] = NULL;
        $voucherDtl["is_master"] = NULL;
        $this->db->insert("voucher_detail",$voucherDtl);
        //Tax Account
        if($dataArr["taxrateType"]=="V"){
            $voucherDtl["voucher_master_id"] =$voucherMasterId; 
            $voucherDtl["account_master_id"] = $this->getVatAccId($dataArr["companyid"]);
            $voucherDtl["voucher_amount"] = ($dataArr["taxamount"]);
            $voucherDtl["is_debit"] = "Y";
            $voucherDtl["account_id_for_trial"] = NULL;
            $voucherDtl["subledger_id"] = NULL;
            $voucherDtl["is_master"] = NULL;
            $this->db->insert("voucher_detail",$voucherDtl);

        }
        
        
        return TRUE;   
    }
    function getPurchaseAccId($compny){
      $sql="SELECT account_master.`id` FROM account_master WHERE account_master.`account_name`='Purchase A/c' AND account_master.`company_id`=".$compny;
       return $this->db->query($sql)->row()->id;
      
  }
  function getVatAccId($compny){
      $sql="SELECT account_master.`id` FROM account_master WHERE account_master.`account_name`='VAT(Input)' AND account_master.`company_id`=".$compny;
    return $this->db->query($sql)->row()->id;
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
    
    public function UpdateData($updRowmatPurchaseMast,$searcharray){
        $purRawmatId = $updRowmatPurchaseMast['id'];
        $voucherIdForEdit = $this->getVoucherId($purRawmatId);
       /* echo "<pre>";
        print_r($updRowmatPurchaseMast);
        echo "</pre>";*/
  
        try {
            
             $this->db->trans_begin();
            
             $this->db->where('id',$purRawmatId );
             $this->db->update('rawmaterial_purchase_master' ,$updRowmatPurchaseMast);
             
           //  echo $this->db->last_query();exit;
             
             $this->upDateVendorBillMaster($purRawmatId, $updRowmatPurchaseMast); //19-08-2016
             $this->upDateVoucherMaster($voucherIdForEdit,$updRowmatPurchaseMast);
             $this->insertIntorawRawMaterialDtl($purRawmatId,$searcharray);

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
    
    public function insertIntorawRawMaterialDtl($purRawmatId,$searcharray){
          $this->deleteFromRawPurchDetail($purRawmatId);
          $this->updateRawmatPurchaseDetails($purRawmatId,$searcharray);
    }
     
  public function deleteFromRawPurchDetail($RawPurMasterId){
        $this->db->where('rawmat_purchase_masterId', $RawPurMasterId);
        $this->db->delete('rawmaterial_purchasedetail');
        
  }
    
  public function updateRawmatPurchaseDetails($newrawDtlId,$dtlArr){
        $rawMatpurchaseDetails = array();
             
        $numberOfDtl = count($dtlArr['txtDetailQuantity']);
        for ($i = 0; $i < $numberOfDtl; $i++) {
            $rawMatpurchaseDetails['rawmat_purchase_masterId'] = $newrawDtlId;
            $rawMatpurchaseDetails['productid'] = $dtlArr['productlist'][$i];
            $rawMatpurchaseDetails['quantity'] = ($dtlArr['txtDetailQuantity'][$i] == "" ? 0 : $dtlArr['txtDetailQuantity'][$i]);
            $rawMatpurchaseDetails['rate'] = ($dtlArr['txtDetailRate'][$i] == "" ? 0 : $dtlArr['txtDetailRate'][$i]);
            $rawMatpurchaseDetails['amount'] = ($dtlArr['txtDetailAmount'][$i] == "" ? 0 : $dtlArr['txtDetailAmount'][$i]);

           
                $this->db->insert('rawmaterial_purchasedetail',$rawMatpurchaseDetails);
          
        }
    }
    
    
     public function get_product_rate_by_id($fid)
        {
            $data=0;
             $sql="SELECT `raw_material_master`.`purchase_rate` FROM `raw_material_master`
                WHERE `raw_material_master`.`id`=".$fid."";
            
	    $query = $this->db->query($sql);
                
            if ($query->num_rows() > 0)
            {
                $rows=$query->row();
                $data = $rows->purchase_rate;

                return $data;
            } else {
                return $data;
            }

        }
        
      public function get_excise_rate_by_id($exciseid)
        {
            $data=0;
             $sql="SELECT 
                    `excise_master`.`id`,
                    `excise_master`.`rate`
                    FROM `excise_master`
                WHERE `excise_master`.`id`=".$exciseid."";
            
	    $query = $this->db->query($sql);
                
            if ($query->num_rows() > 0)
            {
                $rows=$query->row();
                $data = $rows->rate;

                return $data;
            } else {
                return $data;
            }

        }
        
    public function getExciselist(){
        $sql="SELECT 
             `excise_master`.`id`,
             `excise_master`.`description`
              FROM `excise_master`";
         $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
                $data[] = $rows;
            }
             return $data;
        } 
    }
    
    
    
     /**
     * @name getCurrentvatrate
     * @param type $startYear
     * @param type $endYear
     * @return type
     */
    
 /*   public function getCurrentvatrate($startYear, $endYear) {
        $sql = "SELECT id, vat_rate FROM vat WHERE from_date BETWEEN '" . $startYear . "' AND '" . $endYear . "'";
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
                $data[] = $rows;
            }

            return $data;
        }
        
    }*/
    
    public function getCurrentvatrate() {
        $sql = "SELECT id, vat_rate FROM vat WHERE vat.is_active='Y' ORDER BY vat_rate";
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
                $data[] = $rows;
            }

            return $data;
        }
        
    }
    
      /**
    * @name getCurrentcstrate
    * @param type $startYear
    * @param type $endYear
    * @return type
    */ 
  /* public  function getCurrentcstrate($startYear, $endYear) {
        $sql = "SELECT id, cst_rate FROM cst WHERE from_date BETWEEN '" . $startYear . "' AND '" . $endYear . "'";
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
                $data[] = $rows;
            }

            return $data;
        } else {
            return $data = array();
        }
       
    }*/
   
    public  function getCurrentcstrate() {
        $sql = "SELECT id, cst_rate FROM cst WHERE cst.is_active='Y' ORDER BY cst_rate";
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
                $data[] = $rows;
            }

            return $data;
        } else {
            return $data = array();
        }
       
    }
    
   
}
?>
