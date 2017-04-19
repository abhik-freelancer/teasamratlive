<?php

class purchaseinvoicemastermodel extends CI_Model {

    /**
     * @method getPurchaseMasterData
     * @param type $purchaseInvId
     * @return boolean
     */
    public function getPurchaseMasterData($purchaseInvId = "") {

        $sql = "SELECT 
                    purchase_invoice_master.`id`,
                    purchase_invoice_master.`from_where`,
                    purchase_invoice_master.`vendor_id`,
                    purchase_invoice_master.`auctionareaid`,
                    purchase_invoice_master.`purchase_invoice_number`,
                    DATE_FORMAT(purchase_invoice_master.`purchase_invoice_date`,'%d-%m-%Y')AS invoicedate,
                    DATE_FORMAT(purchase_invoice_master.`sale_date`,'%d-%m-%Y') AS saledate,
                    `purchase_invoice_master`.`sale_number`,
                    DATE_FORMAT(purchase_invoice_master.`promt_date`,'%d-%m-%Y')as promptDate,
                    purchase_invoice_master.tea_value,
                    purchase_invoice_master.brokerage,
                    purchase_invoice_master.service_tax,
                    purchase_invoice_master.total_vat,
                    purchase_invoice_master.total_cst,
                    purchase_invoice_master.stamp,
                    purchase_invoice_master.other_charges,
                    purchase_invoice_master.round_off,
                    purchase_invoice_master.total
                     FROM purchase_invoice_master WHERE purchase_invoice_master.id='" . $purchaseInvId . "'";
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            $rows = $query->row();
            return $rows;
        } else {
            return FALSE;
        }
    }

    /**
     * @method getPurchaseDetails
     * @param type $masterId
     * @return type
     * NB if editable Y then you can edit.
     */
    public function getPurchaseDetails($masterId = '') {
        $sql ="SELECT 
                purchase_invoice_detail.id,
                purchase_invoice_detail.purchase_master_id,
                IF((ISNULL(do_to_transporter.is_sent) OR do_to_transporter.is_sent='N'),'Y','N')AS editable, 
                purchase_invoice_detail.lot,
                DATE_FORMAT(purchase_invoice_detail.doRealisationDate, '%d-%m-%Y') AS doRealisationDate,
                purchase_invoice_detail.do,
                purchase_invoice_detail.invoice_number,
                purchase_invoice_detail.garden_id,
                purchase_invoice_detail.location_id,
                purchase_invoice_detail.grade_id,
                purchase_invoice_detail.warehouse_id,
                purchase_invoice_detail.gp_number,  DATE_FORMAT(purchase_invoice_detail.date, '%d-%m-%Y') AS gpDate,
                purchase_invoice_detail.stamp,	 purchase_invoice_detail.gross,
                purchase_invoice_detail.brokerage, purchase_invoice_detail.total_weight,
                purchase_invoice_detail.rate_type_value, purchase_invoice_detail.price, purchase_invoice_detail.service_tax,
                purchase_invoice_detail.total_value, purchase_invoice_detail.value_cost, purchase_invoice_detail.rate_type,
                purchase_invoice_detail.rate_type_id, purchase_invoice_detail.service_tax_id, purchase_invoice_detail.teagroup_master_id,
                garden_master.garden_name
            FROM
                purchase_invoice_detail 
            LEFT JOIN 
                 do_to_transporter ON purchase_invoice_detail.id = do_to_transporter.purchase_inv_dtlid
            INNER JOIN garden_master ON  purchase_invoice_detail.garden_id=garden_master.id
                WHERE purchase_invoice_detail.purchase_master_id = '".$masterId."'" ;
                
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
                $data[] = array("id" => $rows->id,
                    "purchase_master_id" => $rows->purchase_master_id,
                    "lot" => $rows->lot,
                    "doRealisationDate" => $rows->doRealisationDate,
                    "do" => $rows->do,
                    "invoice_number" => $rows->invoice_number,
                    "garden_id" => $rows->garden_id,
                    "grade_id" => $rows->grade_id,
                    "location_id"=>$rows->location_id,
                    "warehouse_id" => $rows->warehouse_id,
                    "gp_number" => $rows->gp_number,
                    "gpDate" => $rows->gpDate,
                    "price" => $rows->price,
                    "stamp" => $rows->stamp,
                    "gross" => $rows->gross,
                    "brokerage" => $rows->brokerage,
                    "total_weight" => $rows->total_weight,
                    "total_bag"=>  $this->getTotalNumberOfBagInDetails($rows->id),
                    "rate_type" => $rows->rate_type,
                    "rate_type_value" => $rows->rate_type_value,
                    "rate_type_id" => $rows->rate_type_id,
                    "service_tax_id" => $rows->service_tax_id,
                    "teagroup_master_id" => $rows->teagroup_master_id,
                    "normalBag" => $this->getNormalBag($rows->id),
                    "sampleBag" => $this->getSampleBag($rows->id),
                    "service_tax" => $rows->service_tax,
                    "total_value" => $rows->total_value,
                    "editable"=>$rows->editable,
                    "garden"=>$rows->garden_name,
                );
            }

            return $data;
        } else {
            return $data = array();
        }
    }

    /**
     * 
     */
    public function getTotalNumberOfBagInDetails($purchaseInvoiceDetailId)
    {
       $totalNumberOfBag=0; 
       $sql ="SELECT SUM(no_of_bags) AS totalBgas
                FROM purchase_bag_details 
                    GROUP BY purchase_bag_details.`purchasedtlid`
                HAVING purchase_bag_details.`purchasedtlid`='".$purchaseInvoiceDetailId."'";
       
       $query = $this->db->query($sql);
       if ($query->num_rows() > 0) {
            $row = $query->row();
            return $row->totalBgas;
        }
        else{
            return '';
        }
       
       
        
    }
    /*
     * @method getNormalBag
     * @param $id
     * @return array
     */

    public function getNormalBag($id = "") {
        $data = array();
        $sql = "SELECT
            `id`,
            `purchasedtlid`,
            `bagtypeid`,
            `no_of_bags`,
            `net`,
            `shortkg`,
            `parent_bag_id`,
            `actual_bags`,
            `chestSerial`
          FROM `purchase_bag_details` WHERE purchasedtlid='" . $id . "' AND bagtypeid=1";
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            $rows = $query->row();
            $data = array("BagDetailId" => $rows->id,
                "purchaseDtlid" => $rows->purchasedtlid,
                "bagtypeid" => $rows->bagtypeid,
                "no_of_bags" => $rows->no_of_bags,
                "net" => $rows->net,
                "actual_bags" => $rows->actual_bags,
                "chestSerial" => $rows->chestSerial
            );
            return $data;
        } else {
            return $data;
        }
    }

    /*
     * @method getSampleBag
     * @param id
     * @return array
     */

    public function getSampleBag($id) {
        $data = array();
        $sql = "SELECT
            `id`,
            `purchasedtlid`,
            `bagtypeid`,
            `no_of_bags`,
            `net`,
            `shortkg`,
            `parent_bag_id`,
            `actual_bags`,
            `chestSerial`
          FROM `purchase_bag_details` WHERE purchasedtlid='" . $id . "' AND bagtypeid=2";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
                $data[] = array("BagDetailId" => $rows->id,
                    "purchaseDtlid" => $rows->purchasedtlid,
                    "bagtypeid" => $rows->bagtypeid,
                    "no_of_bags" => $rows->no_of_bags,
                    "net" => $rows->net,
                    "actual_bags" => $rows->actual_bags,
                    "chestSerial" => $rows->chestSerial
                );
            }
            return $data;
        } else {
            return $data;
        }
    }

    
    /**
     * 
     * @param type $pDtl
     * @param type $bagDtl
     * @return boolean
     * @description Update Purchase details(save).
     */
    public function updatePurchaseDetailData($pDtl, $bagDtl, $normalBagData) {

        $purchaseDetailId = $pDtl['id'];
        $masterDataforupdt = array();
        $BagData = array();
        try {
            $this->db->trans_begin();
            //detail
            $this->db->where('id', $purchaseDetailId);
            $this->db->update('purchase_invoice_detail', $pDtl);
            //master
            $masterDataforupdt = $this->getPurchaseDataDtls($pDtl['purchase_master_id'], $pDtl['rate_type']);
            $this->db->where('id', $pDtl['purchase_master_id']);
            $this->db->update('purchase_invoice_master', $masterDataforupdt);

            //bagDetail
            //delete
            $this->db->where('purchasedtlid', $purchaseDetailId);
            $this->db->delete('purchase_bag_details');
            //delete
            $this->db->insert('purchase_bag_details', $normalBagData);

            $i = 0;
            $noOfBags = count($bagDtl['sampleBag']['numberofSampleBag']);

            for ($i = 0; $i < $noOfBags; $i++) {

                $BagData['purchasedtlid'] = $purchaseDetailId;
                $BagData['bagtypeid'] = 2;
                $BagData['no_of_bags'] = $bagDtl['sampleBag']['numberofSampleBag'][$i];
                $BagData['net'] = $bagDtl['sampleBag']['QtyInSampleBag'][$i];
                $BagData['chestSerial'] = $bagDtl['sampleBag']['sampleBagChest'][$i];
                $BagData['actual_bags'] = $bagDtl['sampleBag']['numberofSampleBag'][$i];
                if ($bagDtl['sampleBag']['numberofSampleBag'][$i] != 0) {
                    $this->db->insert('purchase_bag_details', $BagData);
                }
            }

            /* echo('<pre>');
              print_r($bagDtl);
              echo('</pre>');exit; */

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                return false;
            } else {
                $this->db->trans_commit();
                return true;
            }
        } catch (Exception $e) {
            echo ($e->getMessage());
        }
    }

    /**
     * 
     * @param type $masterId
     * @param type $rateType
     * @return type
     * @description getting summation of purchase details.
     */
    public function getPurchaseDataDtls($masterId, $rateType) {
        $data = array();
        $sql = "SELECT 
            SUM(`purchase_invoice_detail`.value_cost) AS total_tea_value,
            SUM(`purchase_invoice_detail`.`brokerage`) AS total_brokerage,
            SUM(`purchase_invoice_detail`.`service_tax`) AS total_service_tax,
            SUM(`purchase_invoice_detail`.`rate_type_value`)AS tota_rType_value,
            SUM(`purchase_invoice_detail`.`stamp`) AS total_stamp,
            SUM(`purchase_invoice_detail`.`total_value`) AS total_cost
            FROM `purchase_invoice_detail` 
            GROUP BY purchase_invoice_detail.`purchase_master_id`
            HAVING purchase_invoice_detail.`purchase_master_id`='" . $masterId . "'";

        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            $rows = $query->row();

            $data['tea_value'] = $rows->total_tea_value;
            $data['brokerage'] = $rows->total_brokerage;
            $data['service_tax'] = $rows->total_service_tax;
            $data['total_cst'] = ($rateType == 'C' ? $rows->tota_rType_value : 0);
            $data['total_vat'] = ($rateType == 'V' ? $rows->tota_rType_value : 0);
            $data['stamp'] = $rows->total_stamp;
            $data['total'] = $this->getOtherCharges($masterId, $rows->total_cost);
             
        }
        return $data;
    }
/**
 * 
 */
    public function getOtherCharges($masterId,$totalCost)
    {
        $sql="SELECT purchase_invoice_master.`round_off`,
              purchase_invoice_master.`other_charges` 
              FROM
              purchase_invoice_master
              WHERE
              purchase_invoice_master.`id`='".$masterId."'";
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            $rows = $query->row();
            $other_charges=$rows->other_charges; 
            $roundoff = $rows->round_off;
        }
        $total = $other_charges + $totalCost + $roundoff;
        
        return $total;
    }
    /**
     * @method updatePurchaseMaster
     * @param type $dataArray
     * @return boolean
     * @description upadate master area on edit mode.
     */
    public function updatePurchaseMaster($dataArray) {
        $purchaseId = $dataArray['id'];
     try {
            $this->db->trans_begin();
            $this->db->where('id', $purchaseId);
            $this->db->update('purchase_invoice_master', $dataArray);

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
       return TRUE;
    }

    /**
     * @method insertNewPurchaseDetail
     * @param type $data
     * @param type $bagData
     * @param type $NormalbagData
     * @return boolean Add new purchasedetails
     * @date 27/08/2015
     */
    public function insertNewPurchaseDetail($data, $bagData, $NormalbagData) {
        $masterDataforupdt = array();
        $BagData = array();

        try {
            $this->db->trans_begin();
            $this->db->insert('purchase_invoice_detail', $data);
            $insertdetailId = $this->db->insert_id();
            /** masterdata* */
            $masterDataforupdt = $this->getPurchaseDataDtls($data['purchase_master_id'], $data['rate_type']);
            $this->db->where('id', $data['purchase_master_id']);
            $this->db->update('purchase_invoice_master', $masterDataforupdt);
            /*             * BagDtl* */
            $NormalbagData['purchasedtlid'] = $insertdetailId;
            $this->db->insert('purchase_bag_details', $NormalbagData);

            $i = 0;
            $noOfBags = count($bagData['sampleBag']['numberofSampleBag']);

            for ($i = 0; $i < $noOfBags; $i++) {

                $BagData['purchasedtlid'] = $insertdetailId;
                $BagData['bagtypeid'] = 2;
                $BagData['no_of_bags'] = $bagData['sampleBag']['numberofSampleBag'][$i];
                $BagData['net'] = $bagData['sampleBag']['QtyInSampleBag'][$i];
                $BagData['chestSerial'] = $bagData['sampleBag']['sampleBagChest'][$i];
                $BagData['actual_bags'] = $bagData['sampleBag']['numberofSampleBag'][$i];
                if ($bagData['sampleBag']['numberofSampleBag'][$i] != 0) {
                    $this->db->insert('purchase_bag_details', $BagData);
                }
            }

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
  * @method checkInvoiceExistance
  * @param type $purchaseInvoice
  * @author Mithilesh
  * @date 12/01/2016
  */
    public function checkExistingInvoice($purchaseInvoice){
         $sql = $this->db->select('id')->from('purchase_invoice_master')->where('purchase_invoice_number',$purchaseInvoice)->get();
          if ($sql->num_rows() > 0) {
           
            return TRUE;
        }
        else{
            return FALSE;
        }

      
  }
    
    
 /**
  * @method insertNewPurchaseData
  * @param type $pMaster
  * @param type $searcharray
  * @date 02/09/2015
  */   
 public function insertNewPurchaseData($pMaster,$searcharray){
     
     try {
          $this->db->trans_begin();
          $this->db->insert('purchase_invoice_master', $pMaster);
          $insertId = $this->db->insert_id();
         // print_r($pMaster);
          $this->pDetailsInsert($insertId,$searcharray);
          if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                return false;
            } else {
                $this->db->trans_commit();
                return true;
            }
         
     }
         
     catch (Exception $exc) {
         echo $exc->getTraceAsString();
     }
 }
  
  public function pDetailsInsert($insertId,$searcharray){
      $countDtl = count($searcharray['txtLot']);
      $detailsData=array();
      //echo('DTL :'.$countDtl);
      for($i=0;$i<$countDtl;$i++){
            
            $purchaseDetailsSerialNumber = $searcharray['txtSampleBagPurID'][$i]; //div serial number for bag details
            
            $rateSeletedTypeIndex = "rdRateType_".$purchaseDetailsSerialNumber;
            
            $detailsData['purchase_master_id'] = $insertId;
            $detailsData['lot'] = $searcharray['txtLot'][$i];
            $detailsData['doRealisationDate'] =($searcharray['txtDoDate'][$i]==""?NULL:date('Y-m-d',strtotime($searcharray['txtDoDate'][$i])));
            $detailsData['do'] = $searcharray['txtDo'][$i];
            $detailsData['invoice_number'] = $searcharray['txtInvoice'][$i];
            $detailsData['garden_id'] = $searcharray['drpGarden'][$i];
            $detailsData['grade_id'] = $searcharray['drpGrade'][$i];
            $detailsData['location_id'] = $searcharray['drplocation'][$i];
            $detailsData['warehouse_id'] = $searcharray['drpWarehouse'][$i];
            $detailsData['gp_number'] = $searcharray['txtGpnumber'][$i];
            $detailsData['date'] = ($searcharray['txtGpDate'][$i]==""?NULL:date('Y-m-d',  strtotime($searcharray['txtGpDate'][$i])));
            $detailsData['package'] = NULL;
            $detailsData['stamp'] = $searcharray['txtStamp'][$i];
            $detailsData['gross'] = $searcharray['txtGross'][$i];
            $detailsData['brokerage'] = $searcharray['txtBrokerage'][$i];
            $detailsData['total_weight'] = $searcharray['DtltotalWeight'][$i];
            $detailsData['rate_type_value'] =($searcharray[$rateSeletedTypeIndex][0]=='V'?$searcharray['txtVatAmount'][$i]:$searcharray['txtCstAmount'][$i]); 
            $detailsData['price'] = $searcharray['txtPrice'][$i];
            $detailsData['service_tax'] = $searcharray['serviceTax'][$i];
            $detailsData['total_value'] = $searcharray['DtltotalValue'][$i];
            $detailsData['chest_from'] = NULL;
            $detailsData['chest_to'] = null;
            $detailsData['value_cost'] = ($searcharray['DtltotalWeight'][$i] * $searcharray['txtPrice'][$i] );//total weight * price==>value_cost//
            $detailsData['net'] = 0;
            $detailsData['rate_type'] = $searcharray[$rateSeletedTypeIndex][0];
            $detailsData['rate_type_id'] = ($searcharray[$rateSeletedTypeIndex][0]=='V'?$searcharray['drpVatRate'][$i]:$searcharray['drpCSTRate'][$i]);
            $detailsData['service_tax_id'] = $searcharray['drpServiceTax'][$i];
            $detailsData['teagroup_master_id']= $searcharray['drpgroup'][$i];
            
           
            $this->db->insert('purchase_invoice_detail', $detailsData);
            $insertdtlId = $this->db->insert_id();
            
            //if purchase type SB[private purchase]//
            if($searcharray['purchasetype']=='SB'){
                $this->saveDataDoToTranspoerter($insertId,$insertdtlId,$searcharray['drplocation'][$i]);
            }
            //if purchase type SB
            
            $this->pBagInsert($insertdtlId,$purchaseDetailsSerialNumber,$searcharray,$i); //bag insert
          
      }
      
  }
  public function pBagInsert($dtlId,$dtlNumber,$searcharray,$indexof_i){
      $numberofsamplebagIndex = "txtNumOfSampleBag_".$dtlNumber;
      $netintosamplebagIndex = "txtNumOfSampleNet_".$dtlNumber;
      $chestofsamplebagIndex="txtNumOfSampleChess_".$dtlNumber;
      $sampleBagCount = count($searcharray[$numberofsamplebagIndex]);
      $bagDtl=array();
      
          //normal bag
          $bagDtl['purchasedtlid']=$dtlId;
          $bagDtl['bagtypeid']=1;
          $bagDtl['no_of_bags']=$searcharray['txtNumOfNormalBag'][$indexof_i];
          $bagDtl['net']=$searcharray['txtNumOfNormalNet'][$indexof_i];
          $bagDtl['actual_bags']=$searcharray['txtNumOfNormalBag'][$indexof_i];
          $bagDtl['chestSerial']=$searcharray['txtNumOfNormalChess'][$indexof_i];
          $this->db->insert('purchase_bag_details', $bagDtl);
          //normal bag
          
      for($j=0;$j<$sampleBagCount;$j++){
          if ($searcharray[$numberofsamplebagIndex][$j]!=0){
              
                $bagDtl['purchasedtlid']=$dtlId;
                $bagDtl['bagtypeid']=2;
                $bagDtl['no_of_bags']=$searcharray[$numberofsamplebagIndex][$j];
                $bagDtl['net']=$searcharray[$netintosamplebagIndex][$j];
                $bagDtl['actual_bags']=$searcharray[$numberofsamplebagIndex][$j];
                $bagDtl['chestSerial']=$searcharray[$chestofsamplebagIndex][$j];
                $this->db->insert('purchase_bag_details', $bagDtl);
          }
          
      }
  }
 /**
  * @method saveDataDoToTranspoerter
  * @param type $insertdtlId
  * @desc save data when purchasetype SB
  */ 
public function saveDataDoToTranspoerter($pMasterId,$pdtlId,$location_Id){
    $session = sessiondata_method();
    $data['purchase_inv_mst_id']=$pMasterId;
    $data['purchase_inv_dtlid']=$pdtlId;
    $data['is_sent']='Y';
    $data['in_Stock']='Y';
    $data['locationId']=$location_Id;
    $data['typeofpurchase']='SB';
    $data['yearid']=$session['yearid'];
    $data['companyid']=$session['company'];
    
    $this->db->insert('do_to_transporter', $data);
    
}
/**
 * @method updateOtherCharges
 * @return int success or fail update
 */
public function updateOtherCharges($pMasterId,$data){
    try {
        /*echo('<pre>');
        print_r($data);
        echo ('</pre>');*/
          $this->db->trans_begin();
          $this->db->where('id', $pMasterId);
          $this->db->update('purchase_invoice_master', $data); 
          
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

  /*****old code*******/
    
    function saveInvoicemaster($value) {
        $this->db->trans_begin();

        $this->db->insert('purchase_invoice_master', $value);
        $insertdetail = $this->db->insert_id();

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
        } else {
            $this->db->trans_commit();
        }
        return $insertdetail;
    }

    function saveInvoicedetail($value) {
        $this->db->trans_begin();

        $this->db->insert('purchase_invoice_detail', $value);
        $insertdetail = $this->db->insert_id();

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
        } else {
            $this->db->trans_commit();
        }
        return $insertdetail;
    }

    function updateInvoicedetail($value, $invoiceid) {

        $this->db->where('id', $invoiceid);
        $this->db->update('purchase_invoice_detail', $value);
    }

    function saveItemamster($value) {
        $this->db->trans_begin();

        $this->db->insert('item_master', $value);
        $insertdetail = $this->db->insert_id();

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
        } else {
            $this->db->trans_commit();
        }
        return $insertdetail;
    }

    function insertVoucher($valuevoucher) {
        $this->db->trans_begin();

        $this->db->insert('voucher_master', $valuevoucher);
        $insertdetail = $this->db->insert_id();

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
        } else {
            $this->db->trans_commit();
        }
        return $insertdetail;
    }

    function insertVoucherDetail($value) {
        $this->db->trans_begin();

        $this->db->insert('voucher_detail', $value);
        $insertdetail = $this->db->insert_id();

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
        } else {
            $this->db->trans_commit();
        }
        return $insertdetail;
    }

    function insertVendorBill($value) {
        $this->db->trans_begin();

        $this->db->insert('vendor_bill_master', $value);
        $insertdetail = $this->db->insert_id();

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
        } else {
            $this->db->trans_commit();
        }
        return $insertdetail;
    }

    function getVendorAccount($vendor_id) {
        $sql = " SELECT `account_master`.`id` FROM `account_master` 
				 INNER JOIN vendor ON `account_master`.`account_name` = `vendor`.`vendor_name` 
				  WHERE `vendor`.`id` = " . $vendor_id;
        $query = $this->db->query($sql);
        return ($query->result());
    }

    function lastvoucherid() {
        $sql = "SELECT YEAR(`voucher_date`) as year, `id` FROM `voucher_master` ORDER BY id DESC LIMIT 0,1";
        $query = $this->db->query($sql);
        return ($query->result());
    }

    function getserialnumber($comapny, $year) {
        $sql = "SELECT `serial_number` FROM `voucher_master` WHERE `transaction_type`= 'PR' AND `company_id`= " . $comapny . " AND `year_id`=" . $year . " ORDER BY id DESC LIMIT 0,1";
        $query = $this->db->query($sql);
        return ($query->result());
    }

    /*
     * @method saveInvoiceBagDetails
     * @param $valus
     * @desc Bagdetails will be save here , normal(1),Sample(2)
     * 
     */

    public function saveInvoiceBagDetails($value) {
        $this->db->trans_begin();

        $this->db->insert('purchase_bag_details', $value);
        $purchaseBagDetlsId = $this->db->insert_id();

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return 0;
        } else {
            $this->db->trans_commit();
            return $purchaseBagDetlsId;
        }
    }

    /*
     * @method updateBagDetails
     * @param array
     */

    public function updateBagDetails($id, $values) {
        $this->db->trans_begin();
        $this->db->where('id', $id);
        $this->db->update('purchase_bag_details', $values);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return 0;
        } else {
            $this->db->trans_commit();
            return 1;
        }
    }

    function getCurrentservicetax($startYear, $endYear) {
        $sql = "SELECT id, tax_rate FROM service_tax WHERE from_date BETWEEN '" . $startYear . "' AND '" . $endYear . "'";
        $query = $this->db->query($sql);
        return ($query->result());
    }

    function getCurrentvatrate($startYear, $endYear) {
        $sql = "SELECT id, vat_rate FROM vat WHERE from_date BETWEEN '" . $startYear . "' AND '" . $endYear . "'";
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
                $data[] = $rows;
            }

            return $data;
        }
        //return ($query->result());
    }

    function teagrouplist() {

        $sql = "SELECT `id`,`group_code`,`group_description` FROM teagroup_master";
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
                $data[] = $rows;
            }

            return $data;
        }
    }

    function getCurrentcstrate($startYear, $endYear) {
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
        //return ($query->result());
    }

    function getVendorlist($session) {
        $sql = "SELECT `id`,`vendor_name`,IF (id = " . $session . ", 'Y', 'N') selected	FROM `vendor`";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
                $data[] = $rows;
            }

            return $data;
        }
    }
    
    /*@getsalenumber
     *author:Mithilesh
     *Date:11/01/2016
     */
    
     function getsaleNumberlist($session) {
        $sql = "SELECT distinct sale_number FROM `purchase_invoice_master`";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
                $data[] = $rows;
            }

            return $data;
        }
    }
     /*@return all venderlist
     *author:Mithilesh
     *Date:11/01/2016
     */
   public  function populateVendorList() {
        $sql = "SELECT `id`,`vendor_name` FROM `vendor`";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
                $data[] = $rows;
            }
          //  print_r($data);
            return $data;
        }
    }

    
    
    
    function getPurchaselistingdata($session) {

        $vendorClause = "";
        if ($session['vendor'] != 0) {
            $vendorClause = " AND purchase_invoice_master.vendor_id='" . $session['vendor'] . "'";
        }

        $sql = "SELECT purchase_invoice_master.`id`,
					purchase_invoice_master.`purchase_invoice_number`,purchase_invoice_master.`purchase_invoice_date`,
					DATE_FORMAT(purchase_invoice_master.`purchase_invoice_date`,'%d-%m-%Y') AS invoicedate,
										purchase_invoice_master.`sale_number`,
                                        SUM(`purchase_bag_details`.`no_of_bags`) AS totalbags,
                                        SUM(`purchase_bag_details`.`net` * `purchase_bag_details`.`no_of_bags`) AS totalkgs,
                                            
					DATE_FORMAT(purchase_invoice_master.`sale_date`,'%d-%m-%Y') AS saledate,
					DATE_FORMAT(purchase_invoice_master.`promt_date`,'%d-%m-%Y') AS prompt_date,
					purchase_invoice_master.`tea_value`,
					purchase_invoice_master.`brokerage`,
					purchase_invoice_master.`service_tax`,
					IF(purchase_invoice_master.`total_vat`<>0.00,purchase_invoice_master.`total_vat`,purchase_invoice_master.`total_cst`) AS tax,
					IF(purchase_invoice_master.`total_vat`<>0.00,'VAT','CST') AS tax_type,
					purchase_invoice_master.`stamp`,
					purchase_invoice_master.`total`,
					`vendor`.`vendor_name`,
                                        `purchase_invoice_master`.`year_id`,
                                        `purchase_invoice_master`.`company_id`,
                                        `purchase_invoice_master`.`vendor_id`
					FROM `purchase_invoice_master` 
					INNER JOIN vendor ON `purchase_invoice_master`.`vendor_id` = `vendor`.`id` 
                                        INNER JOIN `purchase_invoice_detail` ON `purchase_invoice_detail`.`purchase_master_id`= `purchase_invoice_master`.`id`
                                        INNER JOIN `purchase_bag_details` ON `purchase_bag_details`.`purchasedtlid`=`purchase_invoice_detail`.`id`
                                        GROUP BY `purchase_invoice_master`.`id`

                                        HAVING  (purchase_invoice_master.`purchase_invoice_date` BETWEEN '" . date("Y-m-d", strtotime($session['startdate'])) . "' AND '" . date("Y-m-d", strtotime($session['enddate'])) . "') 
					" . $vendorClause . " 
					AND `purchase_invoice_master`.`year_id` = " . $session['pryear'] . " 
					AND `purchase_invoice_master`.`company_id` = " . $session['prcom'];


        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
                $data[] = $rows;
            }


            return $data;
        }
    }
    
      /*Date:11-01-2016
     * model:purchasedetails
     * author:Mithilesh
     *
     *  */
    function getPurchaseRegister($value) {
      $data = array();
        
        $vendorClause = "";
        if ($value['vendorId'] != 0) {
            $vendorClause = " AND purchase_invoice_master.vendor_id='" . $value['vendorId'] . "'";
        }
        
         $saleNo = "";
        if ($value['saleNumber'] != 0) {
           $saleNo = " AND purchase_invoice_master.sale_number='" . $value['saleNumber'] . "'";
        }
        
          $PurchaseArea = "";
        if ($value['area'] != 0) {
            $PurchaseArea = " AND purchase_invoice_master.auctionareaid='" . $value['area'] . "'";
        }
      
        $sql = "SELECT purchase_invoice_master.`id`,
					purchase_invoice_master.`purchase_invoice_number`,
					purchase_invoice_master.`purchase_invoice_date`,
					purchase_invoice_master.`sale_number`,
                                        SUM(`purchase_bag_details`.`no_of_bags`) AS totalbags,
                                        SUM(`purchase_bag_details`.`net` * `purchase_bag_details`.`no_of_bags`) AS totalkgs,

					DATE_FORMAT(purchase_invoice_master.`sale_date`,'%d-%m-%Y') AS saledate,
					DATE_FORMAT(purchase_invoice_master.`promt_date`,'%d-%m-%Y') AS prompt_date,
					purchase_invoice_master.`tea_value`,
					purchase_invoice_master.`brokerage`,
					purchase_invoice_master.`service_tax`,
					IF(purchase_invoice_master.`total_vat`<>0.00,purchase_invoice_master.`total_vat`,purchase_invoice_master.`total_cst`) AS tax,
					IF(purchase_invoice_master.`total_vat`<>0.00,'VAT','CST') AS tax_type,
					purchase_invoice_master.`stamp`,
					purchase_invoice_master.`total`,
					`purchase_invoice_master`.`from_where`,
					`vendor`.`vendor_name`,
                                        `purchase_invoice_master`.`year_id`,
                                        `purchase_invoice_master`.`company_id`,
                                        `purchase_invoice_master`.`vendor_id`,
                                        `purchase_invoice_master`.`auctionareaid`
                                       
					FROM `purchase_invoice_master` 
					INNER JOIN vendor ON `purchase_invoice_master`.`vendor_id` = `vendor`.`id` 
                                        INNER JOIN `purchase_invoice_detail` ON `purchase_invoice_detail`.`purchase_master_id`= `purchase_invoice_master`.`id`
                                        INNER JOIN `purchase_bag_details` ON `purchase_bag_details`.`purchasedtlid`=`purchase_invoice_detail`.`id`
                                        LEFT JOIN `auctionareamaster` ON `auctionareamaster`.`id`=`purchase_invoice_master`.`auctionareaid`
                                        GROUP BY `purchase_invoice_master`.`id`
					HAVING  (`purchase_invoice_master`.`purchase_invoice_date` BETWEEN '" . date("Y-m-d", strtotime($value['startDate'])) . "' AND '" . date("Y-m-d", strtotime($value['endDate'])) . "')
					" . $vendorClause . " 
                                        ".  $saleNo ."   
                                        ". $PurchaseArea ."
					AND (`purchase_invoice_master`.`from_where`='". $value['purType'] ."')";
					
					 


        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
                $data[] = $rows;
            }
            return $data;
        }
    }


    public function getPurchaselistingdetaildata($id, $year, $company) {

        $sql = " SELECT
		  purchase_invoice_detail.`id`, purchase_invoice_detail.`purchase_master_id`,
		  purchase_invoice_detail.`lot`,  purchase_invoice_detail.`doRealisationDate`,
		  purchase_invoice_detail.`do`,  purchase_invoice_detail.`invoice_number`,  purchase_invoice_detail.`garden_id`,
		  purchase_invoice_detail.`grade_id`,  purchase_invoice_detail.`warehouse_id`,  purchase_invoice_detail.`gp_number`,
		  purchase_invoice_detail.`date`,  purchase_invoice_detail.`stamp`,  purchase_invoice_detail.`gross`,
		  purchase_invoice_detail.`brokerage`,  purchase_invoice_detail.`total_weight`,  purchase_invoice_detail.`rate_type_value`,
		  purchase_invoice_detail.`price`,  purchase_invoice_detail.`service_tax`,  purchase_invoice_detail.`total_value`,
		  purchase_invoice_detail.`value_cost`,  purchase_invoice_detail.`rate_type`,  purchase_invoice_detail.`rate_type_id`,
		  purchase_invoice_detail.`service_tax_id`,  purchase_invoice_detail.`teagroup_master_id`,
		  `garden_master`.`garden_name`,
		  `grade_master`.`grade`,
		  `warehouse`.`name`,
		  GROUP_CONCAT(DISTINCT purchase_bag_details.`id` ORDER BY  purchase_bag_details.`id` ASC SEPARATOR '/') AS BagDTlID,
		  GROUP_CONCAT(DISTINCT purchase_bag_details.no_of_bags ORDER BY purchase_bag_details.id ASC SEPARATOR '/')AS NumbersOfBags,
		  GROUP_CONCAT(DISTINCT purchase_bag_details.net ORDER BY purchase_bag_details.id ASC SEPARATOR '/')AS BgKgs,
		  GROUP_CONCAT(bagtypemaster.bagtype ORDER BY purchase_bag_details.id ASC SEPARATOR '/')AS BagTypes
	FROM `purchase_invoice_detail`
		INNER JOIN `purchase_invoice_master` ON `purchase_invoice_master`.`id`=`purchase_invoice_detail`.`purchase_master_id`
		INNER JOIN `purchase_bag_details` ON `purchase_invoice_detail`.`id` = `purchase_bag_details`.`purchasedtlid` 
		LEFT JOIN `garden_master` ON `purchase_invoice_detail`.`garden_id` = `garden_master`.`id` 
		LEFT JOIN `warehouse` ON `purchase_invoice_detail`.`warehouse_id` = `warehouse`.`id` 
		LEFT JOIN `grade_master` ON `purchase_invoice_detail`.`grade_id` = `grade_master`.`id` 
		INNER JOIN `bagtypemaster` ON purchase_bag_details.`bagtypeid` =bagtypemaster.`id`
		WHERE `purchase_invoice_detail`.`purchase_master_id` = " . $id . "
		AND `purchase_invoice_master`.`year_id` = " . $year . "
		AND `purchase_invoice_master`.`company_id` =" . $company . "
	GROUP BY purchase_invoice_detail.`id`";


        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
                $data[] = $rows;
            }

            return $data;
        } else {
            return "no record found";
        }
    }

    function editdata($id) {

        $sql = "  SELECT 
				`purchase_invoice_master`.`id` AS masterid ,
				`purchase_invoice_master`.`purchase_invoice_number`,
				`purchase_invoice_master`.`purchase_invoice_date`,
				`purchase_invoice_master`.`auctionareaid`,
				`purchase_invoice_master`.`vendor_id`,
				`purchase_invoice_master`.`sale_number`,
				`purchase_invoice_master`.`sale_date`,
				`purchase_invoice_master`.`promt_date`,
				`purchase_invoice_master`.`tea_value`,
				`purchase_invoice_master`.`brokerage` as tbrokerage,
				`purchase_invoice_master`.`service_tax` as tservice_tax,
				`purchase_invoice_master`.`total_cst`,
				`purchase_invoice_master`.`total_vat`,
				`purchase_invoice_master`.`chestage_allowance`,
				`purchase_invoice_master`.`stamp` as masterstamp,
				`purchase_invoice_master`.`total`,
				`purchase_invoice_master`.`voucher_master_id`,
                `purchase_invoice_master`.`from_where`,
				 purchase_invoice_detail.*,
                 IF(purchase_invoice_detail.`doRealisationDate`IS NOT NULL OR purchase_invoice_detail.`doRealisationDate` <>'','N','Y')AS IS_EDIT,
                IF( do_to_transporter.is_sent IS NULL  OR do_to_transporter.is_sent='N','N','Y')  as sent_trans,
				`garden_master`.`garden_name`,
				`grade_master`.`grade`,
				`warehouse`.`name`, 
                `location`.`id` as locationid,
                `location`.`location` as location,
				`teagroup_master`.`id` as teagroupid,
				`teagroup_master`.`group_code` as teagroupcode,
				  GROUP_CONCAT(DISTINCT purchase_bag_details.`id` ORDER BY  purchase_bag_details.`id` ASC SEPARATOR ',') AS BagDTlID,
				  GROUP_CONCAT(purchase_bag_details.actual_bags ORDER BY purchase_bag_details.id ASC SEPARATOR ',')AS NumbersOfBags,
				  GROUP_CONCAT(purchase_bag_details.net ORDER BY purchase_bag_details.id ASC SEPARATOR ',')AS BgKgs,
				  GROUP_CONCAT(IF (purchase_bag_details.chestSerial ='', NULL, purchase_bag_details.chestSerial) ORDER BY purchase_bag_details.id ASC SEPARATOR '~')AS chest,
				  GROUP_CONCAT(bagtypemaster.bagtype ORDER BY purchase_bag_details.id ASC SEPARATOR ',')AS BagTypes,
				  GROUP_CONCAT(purchase_bag_details.bagtypeid ORDER BY  purchase_bag_details.`id` ASC SEPARATOR ',') AS selectedBagId
				 FROM `purchase_invoice_master` 
				 LEFT JOIN `purchase_invoice_detail` ON `purchase_invoice_master`.id = `purchase_invoice_detail`.`purchase_master_id` 
				 INNER JOIN `purchase_bag_details` ON `purchase_invoice_detail`.`id` = `purchase_bag_details`.`purchasedtlid` 
				 LEFT JOIN `do_to_transporter` ON `purchase_invoice_detail`.id = `do_to_transporter`.`purchase_inv_dtlid`
				 LEFT JOIN `garden_master` ON `purchase_invoice_detail`.`garden_id` = `garden_master`.`id` 
				 LEFT JOIN `warehouse` ON `purchase_invoice_detail`.`warehouse_id` = `warehouse`.`id` 
				 LEFT JOIN `grade_master` ON `purchase_invoice_detail`.`grade_id` = `grade_master`.`id` 
                                 LEFT JOIN `location` ON `do_to_transporter`.`locationId` = `location`.`id` 
				 LEFT JOIN `teagroup_master` ON `purchase_invoice_detail`.`teagroup_master_id` = `teagroup_master`.`id`
				 INNER JOIN `bagtypemaster` ON purchase_bag_details.`bagtypeid` =bagtypemaster.`id`
				 WHERE `purchase_invoice_master`.id = " . $id . " 
				 GROUP BY purchase_invoice_detail.id ";

        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
                //print_r($rows);

                $data[] = $rows;
            }


            return $data;
        } else {
            return "no record found";
        }
    }

    function updateVoucherid($voucherid, $invoiceid) {

        $value = array('voucher_master_id' => $voucherid);
        $this->db->where('id', $invoiceid);
        $this->db->update('purchase_invoice_master', $value);
    }

    function updatedateVoucherMaster($voucherdate, $voucherid) {
        $value = array('voucher_date' => $voucherdate);
        $this->db->where('id', $voucherid);
        $this->db->update('voucher_master', $value);
    }

    function updatedateBillMaster($id, $rate) {
        /* $value=array('bill_amount'=>$rate);
          $this->db->where('id',$id);
          $this->db->update('party_bill_master',$value); */
        $sql = "UPDATE  `vendor_bill_master` SET `bill_amount` = " . $rate . ", `due_amount` = " . $rate . " WHERE `voucher_id`= " . $id;
        $query = $this->db->query($sql);
    }

    function updateInvoicemaster($value) {

        if (isset($value['id'])) {
            $this->db->trans_begin();


            $this->db->where('id', $value['id']);
            $this->db->update('purchase_invoice_master', $value);


            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
            } else {
                $this->db->trans_commit();
            }
        }
    }

    public function deleteInvoicemaster($value) {


        $this->db->where('bill_id', $value);
        $this->db->where('from_where', "SB");
        $this->db->delete('item_master');
    }

    /**
     * @method deleteBagDetails
     * @param type $value
     */
    public function deleteBagDetails($value, $deleteFlag) {
        if ($deleteFlag != 'Y') {
            $this->db->where('purchasedtlid', $value);
            $this->db->delete('purchase_bag_details');
            return 1;
        } else {
            return 0;
        }
    }

    function deleteInvoicedetail($value) {
        $this->db->where('id', $value);
        $this->db->delete('purchase_invoice_detail');

        $sql = "DELETE `item_master` FROM `item_master`INNER JOIN saler_to_buyer_detail ON bill_id = purchase_invoice_master_id WHERE saler_to_buyer_detail.id = " . $value . " AND 			item_master.`invoice_number` = " . $invoice . " AND from_where = 'PR'";
        $query = $this->db->query($sql);
    }

    function deleteVoucherdetail($value) {
        //$this->db->where('voucher_master_id', $value);
        //$this->db->delete('voucher_detail'); 
        $sql = "DELETE FROM `voucher_detail` WHERE `voucher_master_id`= " . $value;
        $query = $this->db->query($sql);
    }

    function deleteRecord($parentId) {


        $this->db->select('voucher_master_id');
        $this->db->from('purchase_invoice_master');
        $this->db->where('id', $parentId);
        $query1 = $this->db->get();
        $voucherId = $query1->result[0]->voucher_master_id;


        $this->db->where('bill_id', $parentId);
        $this->db->where('from_where', "PR");
        $query_result = $this->db->delete('vendor_bill_master');

        $this->db->where('purchase_invoice_master_id', $parentId);
        $query_result = $this->db->delete('unreleaseddo');


        $sql2 = 'DELETE `voucher_detail`,`voucher_master` 
				FROM `voucher_master` 
				INNER JOIN `voucher_detail` ON `voucher_master`.`id` = `voucher_detail`.`voucher_master_id` 
				WHERE `voucher_master`.`id` = ' . $voucherId;
        $query3 = $this->db->query($sql2);

        $sql3 = 'DELETE `purchase_invoice_sample`,`item_master` 
				FROM `purchase_invoice_master` 
				LEFT JOIN `purchase_invoice_detail` ON `purchase_invoice_master`.id = `purchase_invoice_detail`.`purchase_master_id` 
				LEFT JOIN `purchase_invoice_sample` ON `purchase_invoice_detail`.`id` = `purchase_invoice_sample`.`purchase_invoice_detail_id` 
				LEFT JOIN `item_master` ON `purchase_invoice_detail`.id = `item_master`.`bill_id` 
				WHERE `purchase_invoice_master`.`id`= ' . $parentId . '
				OR `item_master`.`from_where` = "PR" ';
        $query4 = $this->db->query($sql3);

        $this->db->where('purchase_master_id', $parentId);
        $query_result = $this->db->delete('purchase_invoice_detail');

        $sql1 = 'DELETE `purchase_invoice_sample`,`purchase_invoice_detail`,`item_master` 
				FROM `purchase_invoice_master` 
				LEFT JOIN `purchase_invoice_detail` ON `purchase_invoice_master`.id = `purchase_invoice_detail`.`purchase_master_id` 
				LEFT JOIN `purchase_invoice_sample` ON `purchase_invoice_detail`.`id` = `purchase_invoice_sample`.`purchase_invoice_detail_id` 
				LEFT JOIN `item_master` ON `purchase_invoice_detail`.id = `item_master`.`bill_id` 
				WHERE `purchase_invoice_master`.`id`= ' . $parentId . ' 
				OR `item_master`.`from_where` = "PR" ';
        $query2 = $this->db->query($sql1);

        $this->db->where('id', $parentId);
        $query_result2 = $this->db->delete('purchase_invoice_master');

        //echo $errorno = $this->db->_error_message();
    }

    /**
     * @method saveStockForSB
     * @method for Seller to Buyer direct stock update.
     */
    public function saveStockForSB($value) {
        $this->db->trans_begin();
        $this->db->insert('do_to_transporter', $value);
        $insertid = $this->db->insert_id();

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();

            return false;
        } else {
            $this->db->trans_commit();
            return $insertid;
        }
    }

    /**
     * @method updateStockForSB
     * @param type $purchaseDtlId
     * @param type $values
     */
    public function updateStockForSB($purchaseDtlId, $values) {

        $this->db->trans_begin();
        $this->db->where('purchase_inv_dtlid', $purchaseDtlId);
        $this->db->update('do_to_transporter', $values);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
        } else {
            $this->db->trans_commit();
        }
        return 0;
    }

    public function getGrandTotalWeight($purchaseMasterId)
    {
        $sql="SELECT SUM(`purchase_invoice_detail`.`total_weight`) AS grandWeight FROM  `purchase_invoice_detail` WHERE `purchase_invoice_detail`.`purchase_master_id`=".$purchaseMasterId;
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $row = $query->row();
            return $row->grandWeight;
        }else{
            return '';
        }
    }
       public function getTotalBagNo($purchaseMasterId)
    {
        $sql="SELECT 
            SUM(`purchase_bag_details`.`no_of_bags`) AS totalBag,purchase_invoice_master.`id`
            FROM purchase_bag_details
            INNER JOIN purchase_invoice_detail ON purchase_bag_details.`purchasedtlid`=`purchase_invoice_detail`.`id`
            INNER JOIN purchase_invoice_master ON `purchase_invoice_detail`.`purchase_master_id`=purchase_invoice_master.`id`
            GROUP BY
            purchase_invoice_master.`id`
            HAVING 
            purchase_invoice_master.`id`=".$purchaseMasterId;
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $row = $query->row();
            return $row->totalBag;
        }else{
            return '';
        }
    } 
    

    
    
    public function getTotalBrokerageFromDetail($purchaseMasterId)
    {
        $sql="SELECT SUM(purchase_invoice_detail.brokerage) AS grandBrokerage FROM  purchase_invoice_detail WHERE `purchase_invoice_detail`.`purchase_master_id`=".$purchaseMasterId;
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $row = $query->row();
            return $row->grandBrokerage;
        }else{
            return '';
        }
        
    }

    public function getTotalServiceTaxFromDetail($purchaseMasterId)
    {
        $sql="SELECT SUM(purchase_invoice_detail.service_tax) AS grandServiceTax FROM  purchase_invoice_detail WHERE `purchase_invoice_detail`.`purchase_master_id`=".$purchaseMasterId;
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $row = $query->row();
            return $row->grandServiceTax;
        }else{
            return '';
        }
        
    }
    
    
}
