<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of finishproductpurchasemodel
 * @author Abhik Ghosh
 */
class finishproductpurchasemodel extends CI_Model{
     public function getFinishProdPurchaseList($cid,$yid){
         $data = array();
         $sql = "SELECT
                    purchase_finishproductmaster.id,  purchase_finishproductmaster.srl_no,
                    purchase_finishproductmaster.purchasebillno,  
                    DATE_FORMAT(purchase_finishproductmaster.purchasebilldate,'%d-%m-%Y') as purchasebilldate,
                    purchase_finishproductmaster.vendorId,  purchase_finishproductmaster.voucher_master_id,
                    purchase_finishproductmaster.vehicleno,  purchase_finishproductmaster.taxrateType,
                    purchase_finishproductmaster.taxtRateTypeId,  purchase_finishproductmaster.taxAmount,
                    purchase_finishproductmaster.discountRate,  purchase_finishproductmaster.discountAmount,
                    purchase_finishproductmaster.deliverycharges,  purchase_finishproductmaster.totalpacket,
                    purchase_finishproductmaster.totalquantity,  purchase_finishproductmaster.totalamount,
                    purchase_finishproductmaster.roundoff,  purchase_finishproductmaster.grandtotal,
                    purchase_finishproductmaster.yearid,  purchase_finishproductmaster.companyid,
                    purchase_finishproductmaster.creationdate,  purchase_finishproductmaster.userid,
                    vendor.vendor_name
                FROM purchase_finishproductmaster
                INNER JOIN
                vendor ON purchase_finishproductmaster.vendorId = vendor.id
                WHERE purchase_finishproductmaster.companyid = ".$cid." 
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
     * get current vat rate
     */
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
     * get current cst rate
     * @return type
     */
    
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
    
    /**
     * @name getFinishProdMasterData
     * @param type $
     * @return type
     */
    
    public function getFinishProdMasterData($purchaseBillId){
       $sql="SELECT
            id,srl_no,
            purchasebillno, 
            DATE_FORMAT(purchasebilldate,'%d-%m-%Y') AS purchasebilldate,
            vendorId,
            voucher_master_id,    taxrateType,
            taxtRateTypeId,  taxAmount,
            discountRate,  discountAmount,
            totalpacket,  totalquantity,  totalamount,
            roundoff,  grandtotal,  yearid,
            companyid,  creationdate,  userid
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
                    "grandtotal"=>$rows->grandtotal
                    
                );
            }


            return $data;
        } else {
            return $data;
        }
        
    }
    
    public function getFinishProdDetailData($pBillid){
        $sql="SELECT
                id,
                purchase_finishmasterId,
                productpacketid,
                packingbox,
                packingnet,
                quantity,
                rate,
                amount
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
                    "amount"=>$rows->amount
                    
                );
            }


            return $data;
        } else {
            return $data;
        }
    }
    /***********************************************************************************/
     public function UpdateData($voucherMastId,$taxinvoiceId,$voucherUpd, $searcharray){
        $SaleBillId = $taxinvoiceId;
       // unset($saleBillMaster['id']);
  
        try {
             $this->db->where('id', $voucherMastId);
             $this->db->update('voucher_master' ,$voucherUpd);
             $this->insertintoVouchrDtl($voucherMastId,$searcharray);
             $this->updateSalebillMaster($SaleBillId,$searcharray);
           
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
    
     public function updateSalebillMaster($taxinvoiceId,$searcharray){
        $session = sessiondata_method();
        $saleBillMaster = array();
        
         $saleBillMaster['id'] = $taxinvoiceId;
         $saleBillMaster['purchasebilldate'] = date("Y-m-d", strtotime($searcharray['saleBillDate']));
         $saleBillMaster['vendorId'] = $searcharray['vendor'];
         //$saleBillMaster['vehichleno'] = $searcharray['vehichleno'];
         $saleBillMaster['taxrateType'] = $searcharray['rateType'];
            if ($searcharray['rateType'] == 'V') {
                $saleBillMaster['taxtRateTypeId'] = $searcharray['vat'];
            } else {
                $saleBillMaster['taxtRateTypeId'] = $searcharray['cst'];
            }
        $saleBillMaster['taxAmount'] = $searcharray['txtTaxAmount'];
        $saleBillMaster['discountRate'] = $searcharray['txtDiscountPercentage'];
        $saleBillMaster['discountAmount'] = $searcharray['txtDiscountAmount'];
        //$saleBillMaster['deliverychgs'] = $searcharray['txtDeliveryChg'];
        $saleBillMaster['totalpacket'] = $searcharray['txtTotalPacket'];
        $saleBillMaster['totalquantity'] = $searcharray['txtTotalQty'];
        $saleBillMaster['totalamount'] = $searcharray['txtTotalAmount'];
        $saleBillMaster['roundoff'] = $searcharray['txtRoundOff'];
        $saleBillMaster['grandtotal'] = $searcharray['txtGrandTotal'];
        $saleBillMaster['yearid'] = $session['yearid'];
        $saleBillMaster['companyid'] = $session['company'];
        $saleBillMaster['creationdate'] = date("Y-m-d");
        $saleBillMaster['userid'] = $session['user_id'];
        
        $this->db->where('id', $taxinvoiceId);
        $this->db->update('purchase_finishproductmaster' ,$saleBillMaster);
        
        
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
    
    /*************************************************************************************/
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
    
    
    /**
     * getSerialNumber
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
            WHERE companyid=".$company." AND yearid=".$year." AND module='PUR'";
        
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
        $array = array('companyid' => $company, 'yearid' => $year, 'module' => "PUR");
        $this->db->where($array); 
        $this->db->update('serialmaster', $data);
        
        return $autoSaleNo;
        
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
       $sAmount = ($searcharray['txtTotalAmount']+ $searcharray['txtDeliveryChg']+$searcharray['txtRoundOff']);
       $saleAmt = $sAmount - $searcharray['txtDiscountAmount']; // for sale
       $vatAmt = $searcharray['txtTaxAmount']; // for vat
       
       
       
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
       
         //For VAT Acc
       $vouchrDtlVat['voucher_master_id'] = $vMastId;
       $vouchrDtlVat['account_master_id'] = $vatAccId;
       $vouchrDtlVat['voucher_amount'] = $vatAmt;
       $vouchrDtlVat['is_debit'] ='Y' ;
       $vouchrDtlVat['account_id_for_trial'] = NULL;
       $vouchrDtlVat['subledger_id'] = NULL;
       $vouchrDtlVat['is_master'] = NULL;
       $this->db->insert('voucher_detail', $vouchrDtlVat);
      
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

            if ($searcharray['rateType'] == 'V') {
                $fnshPurcMst['taxtRateTypeId'] = $searcharray['vat'];
            } else {
                $fnshPurcMst['taxtRateTypeId'] = $searcharray['cst'];
            }


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
