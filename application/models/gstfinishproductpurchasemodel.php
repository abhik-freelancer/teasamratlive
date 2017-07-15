<?php


class gstfinishproductpurchasemodel extends CI_Model{
     public function getFinishProdPurchaseList($cid,$yid){
         $data = array();
         $sql = "SELECT
                    purchase_finishproductmaster.id,  purchase_finishproductmaster.srl_no,
                    purchase_finishproductmaster.purchasebillno,  
                    DATE_FORMAT(purchase_finishproductmaster.purchasebilldate,'%d-%m-%Y') as purchasebilldate,
                    purchase_finishproductmaster.vendorId,  purchase_finishproductmaster.voucher_master_id,
                    purchase_finishproductmaster.vehicleno, 
                    purchase_finishproductmaster.discountAmount,
                    purchase_finishproductmaster.deliverycharges,  purchase_finishproductmaster.totalpacket,
                    purchase_finishproductmaster.totalquantity,  purchase_finishproductmaster.totalamount,
                    purchase_finishproductmaster.roundoff,  purchase_finishproductmaster.grandtotal,
                    purchase_finishproductmaster.yearid,  purchase_finishproductmaster.companyid,
                    purchase_finishproductmaster.creationdate,  purchase_finishproductmaster.userid,
                    vendor.vendor_name
                FROM purchase_finishproductmaster
                INNER JOIN
                vendor ON purchase_finishproductmaster.vendorId = vendor.id
                WHERE purchase_finishproductmaster.IsGST='Y' AND  purchase_finishproductmaster.companyid = ".$cid." 
                AND purchase_finishproductmaster.yearid =".$yid." ORDER BY "
                 . "purchase_finishproductmaster.purchasebilldate DESC ";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
                $data[] = array(
                    "id"=>$rows->id,
                    "vendor_name"=>$rows->vendor_name,
                    "purchasebillno"=>$rows->purchasebillno,
                    "purchasebilldate"=>$rows->purchasebilldate,
                    "totalpacket"=>$rows->totalpacket,
                    "totalquantity"=>$rows->totalquantity,
                    "grandtotal"=>$rows->grandtotal
                );
            }


            return $data;
        } else {
            return $data;
        }
         
         
     }
     /**
     * @name getPacketProduct
     * @param void
     * @return type array
     * @desc Getting final product
     */
    public function getPacketProduct() {
        $data = array();
        $sql = "SELECT `product_packet`.`id` AS productPacketId,
                     `product`.`product`,
                     `packet`.`packet`,
                      CONCAT(`product`.`product`,'-',`packet`.`packet`) AS finalProduct,
                      `product_packet`.`Sale_rate` AS rate,
                      `product_packet`.`net_kgs` AS nett
              FROM
                     `product`
                      INNER JOIN `product_packet` ON `product`.`id`=`product_packet`.`productid`
                      INNER JOIN  `packet` ON `product_packet`.`packetid`= `packet`.`id` ORDER BY product";

        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
                $data[] = array(
                    "productPacketId" => $rows->productPacketId,
                    "finalproduct" => $rows->finalProduct,
                    "rate" => $rows->rate,
                    "net" => $rows->nett,
                );
            }


            return $data;
        } else {
            return $data;
        }
    }
    
    /**
     * @name   getVendorList
     * @return type
     * @des    getting vendor list
     */

    public function getVendorList($compId) {
        $data=array();
        $session_data = sessiondata_method();
        $sql ="SELECT
                vendor.id,
                vendor.vendor_name,
                vendor.account_master_id,account_master.company_id
                FROM vendor
                INNER JOIN
                account_master ON vendor.account_master_id = account_master.id
                WHERE account_master.company_id = ".$compId."
                ORDER BY vendor.vendor_name";
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {

            foreach ($query->result() as $rows) {
                $data[] =array( 
                               "vendorId"=> $rows->id,
                               "name"=>$rows->vendor_name
                    );
            }
            return $data;
        } else {
            return $data;
        }
    }
    
   
    
    
    /**
     * @name getFinishProdMasterData
     * @param type $
     * @return type
     */
    
    public function getFinishProdMasterData($purchaseBillId){
       $sql="SELECT
            purchase_finishproductmaster.id,purchase_finishproductmaster.srl_no,
            purchase_finishproductmaster.purchasebillno, 
            DATE_FORMAT(purchase_finishproductmaster.purchasebilldate,'%d-%m-%Y') AS purchasebilldate,
            purchase_finishproductmaster.vendorId,
            purchase_finishproductmaster.voucher_master_id,  
			purchase_finishproductmaster.taxrateType,
            purchase_finishproductmaster.taxtRateTypeId, 
			purchase_finishproductmaster.taxAmount,
            purchase_finishproductmaster.discountRate, 
			purchase_finishproductmaster.discountAmount,
            purchase_finishproductmaster.totalpacket, 
			purchase_finishproductmaster.totalquantity, 
			purchase_finishproductmaster.totalamount,
            purchase_finishproductmaster.roundoff,  
			purchase_finishproductmaster.grandtotal, 
			
			purchase_finishproductmaster.GST_Discountamount,
			purchase_finishproductmaster.GST_Taxableamount,
			purchase_finishproductmaster.GST_Totalgstincluded,
			purchase_finishproductmaster.GST_Freightamount,
			purchase_finishproductmaster.GST_Insuranceamount,
			purchase_finishproductmaster.GST_PFamount,
			purchase_finishproductmaster.totalCGST,
			purchase_finishproductmaster.totalSGST,
			purchase_finishproductmaster.totalIGST,
			purchase_finishproductmaster.GST_placeofsupply,
			
			purchase_finishproductmaster.yearid,
            purchase_finishproductmaster.companyid, 
			creationdate,  
			userid
            FROM 
            purchase_finishproductmaster
            WHERE purchase_finishproductmaster.id=".$purchaseBillId;
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
                $data = array(
                    "id" => $rows->id,
                    "purchasebillno" => $rows->purchasebillno,
                    "purchasebilldate" => $rows->purchasebilldate,
                    "vendorId"=>$rows->vendorId,
                    "voucher_master_id"=>$rows->voucher_master_id,
                    
                    "taxrateType"=>$rows->taxrateType,
                    "taxrateTypeId"=>$rows->taxtRateTypeId,
                    "taxamount"=>$rows->taxAmount,
                    "discountRate"=>$rows->discountRate,
                    "discountAmount"=>$rows->discountAmount,
                   
                    "totalpacket"=>$rows->totalpacket,
                    "totalquantity"=>$rows->totalquantity,
                    "totalamount"=>$rows->totalamount,
                    "roundoff"=>$rows->roundoff,
                    "grandtotal"=>$rows->grandtotal,
					
					"GST_Discountamount"=> $rows->GST_Discountamount,
					"GST_Taxableamount"=> $rows->GST_Taxableamount,
					"GST_Totalgstincluded"=> $rows->GST_Totalgstincluded,
					"GST_Freightamount"=> $rows->GST_Freightamount,
					"GST_Insuranceamount"=> $rows->GST_Insuranceamount,
					"GST_PFamount"=> $rows->GST_PFamount,
					"totalCGST"=> $rows->totalCGST,
					"totalSGST"=> $rows->totalSGST,
					"totalIGST"=> $rows->totalIGST,
					"GST_placeofsupply"=> $rows->GST_placeofsupply
					
                    
                );
            }


            return $data;
        } else {
            return $data;
        }
        
    }
    
    public function getFinishProdDetailData($pBillid){
        $sql="SELECT
                purchase_finishproductdetail.id,
                purchase_finishproductdetail.purchase_finishmasterId,
                purchase_finishproductdetail.productpacketid,
                purchase_finishproductdetail.packingbox,
                purchase_finishproductdetail.packingnet,
                purchase_finishproductdetail.quantity,
                purchase_finishproductdetail.rate,
                purchase_finishproductdetail.amount,
				
				purchase_finishproductdetail.HSN,
                purchase_finishproductdetail.discount,
                purchase_finishproductdetail.taxableamount,
                purchase_finishproductdetail.cgstrateid,
                purchase_finishproductdetail.cgstamount,
                purchase_finishproductdetail.sgstrateid,
                purchase_finishproductdetail.sgstamount,
                purchase_finishproductdetail.igstrateid,
                purchase_finishproductdetail.igstamount
				
                FROM purchase_finishproductdetail WHERE purchase_finishmasterId=".$pBillid;
        
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
                $data[] = array(
                    "id" => $rows->id,
                    "purchase_finishmasterId" => $rows->purchase_finishmasterId,
                    "productpacketid" => $rows->productpacketid,
                    "packingbox"=>$rows->packingbox,
                    "packingnet"=>$rows->packingnet,
                    "quantity"=>$rows->quantity,
                    "rate"=>$rows->rate,
                    "amount"=>$rows->amount,
					"HSN" => $rows->HSN,
					"discount"=>$rows->discount,
					"taxableamount"=>$rows->taxableamount,
					"cgstrateid"=>$rows->cgstrateid,
					"cgstamount"=>$rows->cgstamount,
					"sgstrateid"=>$rows->sgstrateid,
					"sgstamount"=>$rows->sgstamount,
					"igstrateid"=>$rows->igstrateid,
					"igstamount"=>$rows->igstamount
					
                    
                );
            }


            return $data;
        } else {
            return $data;
        }
    }
    /***********************************UPDATE DATA************************************************/
     public function UpdateData($voucherMastId,$taxinvoiceId,$voucherUpd, $searcharray){
        $SaleBillId = $taxinvoiceId;
       // unset($saleBillMaster['id']);
  
        try {
             $this->db->where('id', $voucherMastId);
             $this->db->update('voucher_master' ,$voucherUpd);
             $this->insertintoVouchrDtl($voucherMastId,$searcharray);
             $this->updateFinishProductPurchaseMaster($SaleBillId,$searcharray);
           
             $this->updatefinishproductdetail($SaleBillId, $searcharray);
             $this->updateBillMaster($taxinvoiceId, $searcharray);
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
    
     public function updateFinishProductPurchaseMaster($taxinvoiceId,$searcharray){
        $session = sessiondata_method();
        $fnshPurcMst = array();
        
         $fnshPurcMst['id'] = $taxinvoiceId;
         $fnshPurcMst['purchasebilldate'] = date("Y-m-d", strtotime($searcharray['saleBillDate']));
         $fnshPurcMst['vendorId'] = $searcharray['vendor'];
         //$saleBillMaster['vehichleno'] = $searcharray['vehichleno'];
      
        $fnshPurcMst['taxAmount'] = $searcharray['txtTaxAmount'];
        $fnshPurcMst['discountRate'] = $searcharray['txtDiscountPercentage'];
        $fnshPurcMst['discountAmount'] = $searcharray['txtDiscountAmount'];
        //$saleBillMaster['deliverychgs'] = $searcharray['txtDeliveryChg'];
        $fnshPurcMst['totalpacket'] = $searcharray['txtTotalPacket'];
        $fnshPurcMst['totalquantity'] = $searcharray['txtTotalQty'];
        $fnshPurcMst['totalamount'] = $searcharray['txtTotalAmount'];
        $fnshPurcMst['roundoff'] = $searcharray['txtRoundOff'];
        $fnshPurcMst['grandtotal'] = $searcharray['txtGrandTotal'];
        $fnshPurcMst['yearid'] = $session['yearid'];
        $fnshPurcMst['companyid'] = $session['company'];
        $fnshPurcMst['creationdate'] = date("Y-m-d");
        $fnshPurcMst['userid'] = $session['user_id'];
		
		$fnshPurcMst['GST_Discountamount'] = $searcharray['txtDiscountAmount'];
        $fnshPurcMst['GST_Taxableamount'] = $searcharray['txtTaxableAmount'];
        $fnshPurcMst['GST_Totalgstincluded'] = $searcharray['txtTotalIncldTaxAmt'];
        $fnshPurcMst['GST_Freightamount'] = $searcharray['txtFreight'];
        $fnshPurcMst['GST_Insuranceamount'] = $searcharray['txtInsurance'];
        $fnshPurcMst['GST_PFamount'] = $searcharray['txtPckFrw'];
        $fnshPurcMst['totalCGST'] = $searcharray['txtTotalCGST'];
        $fnshPurcMst['totalSGST'] = $searcharray['txtTotalSGST'];
        $fnshPurcMst['totalIGST'] = $searcharray['txtTotalIGST'];
        $fnshPurcMst['IsGST'] = 'Y';
        $fnshPurcMst['GST_placeofsupply'] = $searcharray["placeofsupply"];
		
		
        
        $this->db->where('id', $taxinvoiceId);
        $this->db->update('purchase_finishproductmaster' ,$fnshPurcMst);
        
        
    }
     private  function updateBillMaster($taxinvoiceId,$searcharray){
        $session = sessiondata_method();
        $updatearr = array("invoiceMasterId"=>$taxinvoiceId,"purchaseType"=>'F');
       
        $billMasterArray["billDate"]=date("Y-m-d", strtotime($searcharray['saleBillDate']));
        $billMasterArray["billAmount"]=$searcharray['txtGrandTotal'];
        $billMasterArray["vendorAccountId"]=  $this->getVendorAccountId($searcharray['vendor'], $session['company']);
        $this->db->where($updatearr);
        $this->db->update("vendorbillmaster",$billMasterArray);
        
    }
    
    /*********************************INSERT DATA****************************************************/
    /**
     * 
     * @param type $fnshPurcMst
     * @param type $searcharray
     * @return boolean
     */
    public function insertData($voucherMast,$searcharray ){
         try {
                
                  $session = sessiondata_method();
                  $this->db->trans_begin();
                  
                  $voucherMast['voucher_number'] =trim($searcharray["txtSaleBillNo"]);  //$this->getSerialNumber($session['company'], $session['yearid']);
                  $purchaseBillNo = $voucherMast['voucher_number'];
                  
                  $this->db->insert('voucher_master', $voucherMast);
                  
                  $vMastId = $this->db->insert_id();
                  $this->insertintoVouchrDtl($vMastId,$searcharray);
            
                  $this->insertintoFinishPurchaselMaster($searcharray,$vMastId,0,$purchaseBillNo);
                  $lastInsertId = $this->db->insert_id();
                  $this->updatefinishproductdetail($lastInsertId, $searcharray);
                  $this->insertBillMaster($lastInsertId, $searcharray);
					

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
    
    

    
     public function insertintoVouchrDtl($vMastId,$searcharray){
            
       $this->deleteVoucherDetailData($vMastId);
            
       $session = sessiondata_method();
       $vouchrDtlCus = array();
       $vouchrDtlSale =array();
       $vouchrDtlVat = array();
          
       $vendorAccountId = $this->getVendorAccountId($searcharray['vendor'],$session['company']);
       $purchaseAccountId = $this->getPurchaseAccountId($session['company']);
       $vatAccId = $this->getVatAccId($session['company']);
       
       $totalAmt =$searcharray['txtGrandTotal']; // For Cuss acc Debt
      // $sAmount = ($searcharray['txtTotalAmount']+ $searcharray['txtDeliveryChg']+$searcharray['txtRoundOff']);
      // $sAmount = ($searcharray['txtTotalAmount']+ $searcharray['txtRoundOff']);
       $saleAmt =($searcharray['txtTaxableAmount']+ $searcharray['txtRoundOff']);
       //$vatAmt = $searcharray['txtTaxAmount']; // for vat
       
       
       
       //For Vendor Acc
       $vouchrDtlCus['voucher_master_id'] = $vMastId;
       $vouchrDtlCus['account_master_id'] = $vendorAccountId;
       $vouchrDtlCus['voucher_amount'] = $totalAmt;
       $vouchrDtlCus['is_debit'] ='N' ;
       $vouchrDtlCus['account_id_for_trial'] = NULL;
       $vouchrDtlCus['subledger_id'] = NULL;
       $vouchrDtlCus['is_master'] = NULL;
       $this->db->insert('voucher_detail', $vouchrDtlCus);
       
        //For Purchase Acc
       $vouchrDtlSale['voucher_master_id'] = $vMastId;
       $vouchrDtlSale['account_master_id'] = $purchaseAccountId;
       $vouchrDtlSale['voucher_amount'] = $saleAmt;
       $vouchrDtlSale['is_debit'] ='Y' ;
       $vouchrDtlSale['account_id_for_trial'] = NULL;
       $vouchrDtlSale['subledger_id'] = NULL;
       $vouchrDtlSale['is_master'] = NULL;
       $this->db->insert('voucher_detail', $vouchrDtlSale);
       
		
	   //for freight
       $sql="SELECT othercharges.accountid 
             FROM othercharges
             WHERE  othercharges.description ='Freight'
             AND othercharges.companyid = ".$session['company'];
       $frghtAccid = $this->db->query($sql)->row()->accountid;
       
       $vouchrDtlSale['voucher_master_id'] = $vMastId;
       $vouchrDtlSale['account_master_id'] = $frghtAccid;
       $vouchrDtlSale['voucher_amount'] =$searcharray['txtFreight'];
       $vouchrDtlSale['is_debit'] ='Y' ;
       $vouchrDtlSale['account_id_for_trial'] = NULL;
       $vouchrDtlSale['subledger_id'] = NULL;
       $vouchrDtlSale['is_master'] = NULL;
       if($searcharray['txtFreight']!=""){
       $this->db->insert('voucher_detail', $vouchrDtlSale);
       }
       
       
       //for Insurance
       $sql="SELECT othercharges.accountid 
             FROM othercharges
             WHERE  othercharges.description ='Insurance'
             AND othercharges.companyid = ".$session['company'];
       $inscrAccid = $this->db->query($sql)->row()->accountid;
       
       $vouchrDtlSale['voucher_master_id'] = $vMastId;
       $vouchrDtlSale['account_master_id'] = $inscrAccid;
       $vouchrDtlSale['voucher_amount'] =$searcharray['txtInsurance'];
       $vouchrDtlSale['is_debit'] ='Y' ;
       $vouchrDtlSale['account_id_for_trial'] = NULL;
       $vouchrDtlSale['subledger_id'] = NULL;
       $vouchrDtlSale['is_master'] = NULL;
       if($searcharray['txtInsurance']!=""){
       $this->db->insert('voucher_detail', $vouchrDtlSale);
       }
       
       //for P&F
       $sql="SELECT othercharges.accountid 
             FROM othercharges
             WHERE  othercharges.description ='Packing and Forwarding'
             AND othercharges.companyid = ".$session['company'];
       $PFAccid = $this->db->query($sql)->row()->accountid;
       
       $vouchrDtlSale['voucher_master_id'] = $vMastId;
       $vouchrDtlSale['account_master_id'] = $PFAccid;
       $vouchrDtlSale['voucher_amount'] =$searcharray['txtPckFrw'];
       $vouchrDtlSale['is_debit'] ='Y' ;
       $vouchrDtlSale['account_id_for_trial'] = NULL;
       $vouchrDtlSale['subledger_id'] = NULL;
       $vouchrDtlSale['is_master'] = NULL;
       if($searcharray['txtPckFrw']!=""){
       $this->db->insert('voucher_detail', $vouchrDtlSale);
       }
	   
	   /***************************************************************************************/
	   // for GST(cgst+sgst+igst)
       $numberofDetails = count($searcharray['txtDetailPacket']);
       $cgstarray=array();
       $sgstarray =array();
       $igstarray =array();
       for ($i = 0; $i < $numberofDetails; $i++) {
            $cgstarray[] =array("id"=>$searcharray['cgst'][$i],"cgstamount"=>$searcharray['cgstAmt'][$i]);
            $sgstarray[] = array("id"=>$searcharray['sgst'][$i],"sgstamount"=>$searcharray['sgstAmt'][$i]);
            $igstarray[] = array("id"=>$searcharray['igst'][$i],"igstamount"=>$searcharray['igstAmt'][$i]);
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
	
      
    }
	
	
	// GSTinsertionOnVoucherDetails
	private function GSTinsertionOnVoucherDetails($vouchermasterId,$gstId,$gstAmount,$gstType){
       $sql="SELECT gstmaster.accountId
                FROM gstmaster
             WHERE gstmaster.id =".$gstId." AND gstmaster.gstType ='".$gstType."'";
       if($gstId!=0){
        $accountId = $this->db->query($sql)->row()->accountId;
       }
       if($gstId!=0){
                $vouchrDtlTax['voucher_master_id'] = $vouchermasterId;
                $vouchrDtlTax['account_master_id'] = $accountId;
                $vouchrDtlTax['voucher_amount'] = $gstAmount;
                $vouchrDtlTax['is_debit'] ='Y' ;
                $vouchrDtlTax['account_id_for_trial'] = NULL;
                $vouchrDtlTax['subledger_id'] = NULL;
                $vouchrDtlTax['is_master'] = NULL;
                $this->db->insert('voucher_detail', $vouchrDtlTax);
       }
   }
        
    private function deleteVoucherDetailData($voucherId)
    {
        
         $this->db->where('voucher_master_id', $voucherId);
         $this->db->delete('voucher_detail');
    }
    /*@method insertintoSaleBillMaster
     * @date 01-06-2016
     * By Mithilesh
     */
     public function insertintoFinishPurchaselMaster($searcharray,$vMastId,$slno,$salebillno){
            $session = sessiondata_method();
            $fnshPurcMst = array();
         
            $fnshPurcMst['srl_no'] = 1;
            $fnshPurcMst['purchasebillno'] = $salebillno;
            $fnshPurcMst['purchasebilldate'] = date("Y-m-d", strtotime($searcharray['saleBillDate']));
            $fnshPurcMst['voucher_master_id'] = $vMastId;
            $fnshPurcMst['vendorId'] = $searcharray['vendor'];
            
            //$fnshPurcMst['vehichleno'] = $searcharray['vehichleno'];
            
            $fnshPurcMst['taxrateType'] = $searcharray['rateType'];
			
			$fnshPurcMst['taxAmount'] = $searcharray['txtTaxAmount'];
            $fnshPurcMst['discountRate'] = $searcharray['txtDiscountPercentage'];
            $fnshPurcMst['discountAmount'] = $searcharray['txtDiscountAmount'];
            //$fnshPurcMst['deliverychgs'] = $searcharray['txtDeliveryChg'];
            $fnshPurcMst['totalpacket'] = $searcharray['txtTotalPacket'];
            $fnshPurcMst['totalquantity'] = $searcharray['txtTotalQty'];
            $fnshPurcMst['totalamount'] = $searcharray['txtTotalAmount'];
            $fnshPurcMst['roundoff'] = $searcharray['txtRoundOff'];
            $fnshPurcMst['grandtotal'] = $searcharray['txtGrandTotal'];
            $fnshPurcMst['yearid'] = $session['yearid'];
            $fnshPurcMst['companyid'] = $session['company'];
            $fnshPurcMst['creationdate'] = date("Y-m-d");
            $fnshPurcMst['userid'] = $session['user_id'];
			
            $fnshPurcMst['GST_Discountamount'] = $searcharray['txtDiscountAmount'];
            $fnshPurcMst['GST_Taxableamount'] = $searcharray['txtTaxableAmount'];
            $fnshPurcMst['GST_Totalgstincluded'] = $searcharray['txtTotalIncldTaxAmt'];
            $fnshPurcMst['GST_Freightamount'] = $searcharray['txtFreight'];
            $fnshPurcMst['GST_Insuranceamount'] = $searcharray['txtInsurance'];
            $fnshPurcMst['GST_PFamount'] = $searcharray['txtPckFrw'];
            $fnshPurcMst['totalCGST'] = $searcharray['txtTotalCGST'];
            $fnshPurcMst['totalSGST'] = $searcharray['txtTotalSGST'];
            $fnshPurcMst['totalIGST'] = $searcharray['txtTotalIGST'];
            $fnshPurcMst['IsGST'] = 'Y';
            $fnshPurcMst['GST_placeofsupply'] = $searcharray["placeofsupply"];
			
			
            
            $this->db->insert('purchase_finishproductmaster', $fnshPurcMst);
             
     }
     public function updatefinishproductdetail($lastMasterId,$dtlArr){
        $saleBillDetails = array();
        
        if($dtlArr['txtModeOfoperation']=="Edit"){
            $this->db->where('purchase_finishmasterId', $lastMasterId);
            $this->db->delete('purchase_finishproductdetail');;
        }
        
        $numberOfDtl = count($dtlArr['txtDetailPacket']);
        for ($i = 0; $i < $numberOfDtl; $i++) {
            $saleBillDetails['purchase_finishmasterId'] = $lastMasterId;
            $saleBillDetails['productpacketid'] = $dtlArr['finalproduct'][$i];
            $saleBillDetails['packingbox'] = $dtlArr['txtDetailPacket'][$i];
            $saleBillDetails['packingnet'] = ($dtlArr['txtDetailNet'][$i] == "" ? 0 : $dtlArr['txtDetailNet'][$i]);
            $saleBillDetails['quantity'] = ($dtlArr['txtDetailQuantity'][$i] == "" ? 0 : $dtlArr['txtDetailQuantity'][$i]);
            $saleBillDetails['rate'] = ($dtlArr['txtDetailRate'][$i] == "" ? 0 : $dtlArr['txtDetailRate'][$i]);
            $saleBillDetails['amount'] = ($dtlArr['txtDetailAmount'][$i] == "" ? 0 : $dtlArr['txtDetailAmount'][$i]);
			
            $saleBillDetails['HSN'] = ($dtlArr['txtHSNNumber'][$i] == "" ? 0 : $dtlArr['txtHSNNumber'][$i]);
            $saleBillDetails['discount'] = ($dtlArr['txtDiscount'][$i] == "" ? 0 : $dtlArr['txtDiscount'][$i]);
            $saleBillDetails['taxableamount'] = ($dtlArr['txtTaxableAmt'][$i] == "" ? 0 : $dtlArr['txtTaxableAmt'][$i]);
            $saleBillDetails['cgstrateid'] = ($dtlArr['cgst'][$i] == 0 ? NULL : $dtlArr['cgst'][$i]);
            $saleBillDetails['cgstamount'] = ($dtlArr['cgstAmt'][$i] == "" ? NULL : $dtlArr['cgstAmt'][$i]);
            $saleBillDetails['sgstrateid'] = ($dtlArr['sgst'][$i] == 0 ? NULL : $dtlArr['sgst'][$i]);
            $saleBillDetails['sgstamount'] = ($dtlArr['sgstAmt'][$i] == "" ? NULL : $dtlArr['sgstAmt'][$i]);
            $saleBillDetails['igstrateid'] = ($dtlArr['igst'][$i] == 0 ? NULL : $dtlArr['igst'][$i]);
            $saleBillDetails['igstamount'] = ($dtlArr['igstAmt'][$i] == "" ? NULL : $dtlArr['igstAmt'][$i]);
			
            $this->db->insert('purchase_finishproductdetail', $saleBillDetails);
           
        }
    }
     public function insertBillMaster($invoiceId, $searcharray){
        
        $session = sessiondata_method();
        $billMasterArray["billDate"]=date("Y-m-d", strtotime($searcharray['saleBillDate']));
        $billMasterArray["billAmount"]=$searcharray['txtGrandTotal'];
        $billMasterArray["invoiceMasterId"]=$invoiceId;
        $billMasterArray["purchaseType"]="F";
        $billMasterArray["vendorAccountId"]=  $this->getVendorAccountId($searcharray['vendor'], $session['company']);
        $billMasterArray["companyId"]=$session['company'];
        $billMasterArray["yearId"]=$session['yearid'];
        $this->db->insert('vendorbillmaster', $billMasterArray);
        
    }
    /******************************************/
    private function getPurchaseAccountId($compny){
      $sql="SELECT account_master.`id` FROM account_master WHERE account_master.`account_name`='Purchase A/c' AND account_master.`company_id`=".$compny;
       return $this->db->query($sql)->row()->id;
    }
    
    private function getVendorAccountId($vendorId,$company){
        $sql ="SELECT vendor.account_master_id FROM 
                vendor 
                INNER JOIN account_master ON vendor.account_master_id = account_master.id
                WHERE vendor.id=".$vendorId." AND account_master.company_id =".$company;
        return $this->db->query($sql)->row()->account_master_id;
    }
    
    private function getVatAccId($compny){
        $sql="SELECT account_master.`id` FROM account_master WHERE account_master.`account_name`='VAT(Input)' AND account_master.`company_id`=".$compny;
        return $this->db->query($sql)->row()->id;
    }
    /******************************************/
    
     public function get_final_product_rate_by_id($fid)
        {
            $data=0;
            $sql="select `product_packet`.`sale_rate`,`product_packet`.`net_kgs` from product_packet where id=".$fid."";
            
	    $query = $this->db->query($sql);
          if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
                $data = array(
                    "sale_rate" => $rows->sale_rate,
                    "net_kgs" => $rows->net_kgs
                );
            }

            return $data;
        } else {
            return $data;
        }
          
        }
    
}
