<?php

class stocktransferinmodel extends CI_Model {

    public function getStocktransfreInList($cmpy,$year){
        $sql="SELECT 
              `purchase_invoice_master`.`id` AS purMastId,
              `purchase_invoice_master`.`purchase_invoice_number`,
               DATE_FORMAT(`purchase_invoice_master`.`purchase_invoice_date`,'%d-%m-%Y') AS receiptDt,
               DATE_FORMAT(`purchase_invoice_master`.`transfer_date`,'%d-%m-%Y') AS transferDt,
               SUM(`purchase_bag_details`.`no_of_bags`) AS totalbags,
               SUM(`purchase_bag_details`.`net` * `purchase_bag_details`.`no_of_bags`) AS totalkgs,
              `purchase_invoice_master`.`tea_value`,
              `purchase_invoice_master`.`total`,
              `purchase_invoice_detail`.id AS purDtlId,
               vendor.`vendor_name` 
               FROM purchase_invoice_master 
               INNER JOIN `purchase_invoice_detail`
               ON `purchase_invoice_detail`.`purchase_master_id`=purchase_invoice_master.`id`
               INNER JOIN `purchase_bag_details`
               ON `purchase_bag_details`.`purchasedtlid`=`purchase_invoice_detail`.`id`
               INNER JOIN vendor
               ON vendor.`id`=purchase_invoice_master.`vendor_id`
               WHERE `purchase_invoice_master`.`from_where`='STI'
                AND `purchase_invoice_master`.`company_id`=".$cmpy." AND `purchase_invoice_master`.`year_id`=".$year ."  GROUP BY purchase_invoice_master.`id`";
               
        
                $query = $this->db->query($sql);
                 if ($query->num_rows() > 0) {
                   foreach ($query->result() as $rows) {
                     $data[] = array(
                       "pMastId"=>$rows->purMastId,
                       "refrenceNo"=>$rows->purchase_invoice_number,
                       "receiptDt"=>$rows->receiptDt,
                       "transferDt"=>$rows->transferDt,
                        "vendor_name"=>$rows->vendor_name,
                         "total_bags"=>$rows->totalbags,
                         "totalkgs"=>$rows->totalkgs,
                       "tea_value"=>$rows->tea_value,
                       "totalAmt"=>$rows->total,
                        "purDtlId"=>$rows->purDtlId
                      // "bagdtl"=> $this->getBagDetailsData($rows->purDtlId),
                        );
                 }
            return $data;
             } 
        else {
            return $data;
        }
        
    }
    
    public function getBagDetailsData($prdtlId){
        
        $sql="SELECT 
            `purchase_bag_details`.id AS bagDtlId,
            `purchase_bag_details`.`no_of_bags`,
            `purchase_bag_details`.`net`,
            `bagtypemaster`.bagtype
             FROM 
            `purchase_bag_details`
            INNER JOIN bagtypemaster
            ON bagtypemaster.id=`purchase_bag_details`.`bagtypeid`
             WHERE 
            `purchase_bag_details`.`purchasedtlid`=".$prdtlId;
         $query = $this->db->query($sql);
          if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
                $data[] = array(
                   "badDtlid"=>$rows->bagDtlId,
                    "no_of_bags"=>$rows->no_of_bags,
                    "net"=>$rows->net,
                    "bagtype"=>$rows->bagtype
                 );
            }

            return $data;
        } else {
            return $data = array();
        }
        
    }
    
    /**
     * @method getPurchaseMasterData
     * @param type $purchaseInvId
     * @return boolean
     * @date 13-05-2016
     */
    public function getPurchaseMasterData($purchaseInvId = "") {

        $sql = "SELECT 
                    purchase_invoice_master.`id`,
                    purchase_invoice_master.`from_where`,
                    purchase_invoice_master.`vendor_id`,
                    purchase_invoice_master.`purchase_invoice_number`,
                    DATE_FORMAT(purchase_invoice_master.`purchase_invoice_date`,'%d-%m-%Y')AS receiptDate,
                    DATE_FORMAT(purchase_invoice_master.`transfer_date`,'%d-%m-%Y') AS transferDt,
                    purchase_invoice_master.cn_no,
                    purchase_invoice_master.tea_value,
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
     *@date 13-05-2016
     * 
     */
    public function getPurchaseDetails($masterId = '') {
        $sql ="SELECT 
                purchase_invoice_detail.id,
                purchase_invoice_detail.purchase_master_id,
              /* IF((ISNULL(do_to_transporter.is_sent) OR do_to_transporter.is_sent='N'),'Y','N')AS editable, */
                purchase_invoice_detail.lot,
                DATE_FORMAT(purchase_invoice_detail.doRealisationDate, '%d-%m-%Y') AS doRealisationDate,
                purchase_invoice_detail.do,
                purchase_invoice_detail.invoice_number,
                purchase_invoice_detail.garden_id,
                purchase_invoice_detail.location_id,
                purchase_invoice_detail.grade_id,
                purchase_invoice_detail.warehouse_id,
                purchase_invoice_detail.cost_of_tea,
                purchase_invoice_detail.transportation_cost,
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
                  //  "editable"=>$rows->editable,
                    "garden"=>$rows->garden_name,
                    "cost_of_tea"=>$rows->cost_of_tea,
                    "transportation_cost"=>$rows->transportation_cost
                    
                );
            }

            return $data;
        } else {
            return $data = array();
        }
    }

    /*@method getTotalNumberOfBagInDetails
     * * @param $purchaseInvoiceDetailId
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
     * @date 13-05-2016
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
            
            $mast_id= $pDtl['purchase_master_id'];
            $locationId = $pDtl['location_id'];
            
            $do_to_transporter = array(
                "purchase_inv_mst_id"=>$mast_id,
                "purchase_inv_dtlid"=>$purchaseDetailId,
                "locationId"=>$locationId
            );
            
            //update do to transporter
            $this->db->where('purchase_inv_dtlid',$purchaseDetailId);
            $this->db->update('do_to_transporter',$do_to_transporter);
            
            
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
    public function getPurchaseDataDtls($masterId) {
        $data = array();
        $sql = "SELECT 
            SUM(`purchase_invoice_detail`.value_cost) AS total_tea_value,
            SUM(`purchase_invoice_detail`.`total_value`) AS total_cost
            FROM `purchase_invoice_detail` 
            GROUP BY purchase_invoice_detail.`purchase_master_id`
            HAVING purchase_invoice_detail.`purchase_master_id`='" . $masterId . "'";

        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            $rows = $query->row();

            $data['tea_value'] = $rows->total_tea_value;
            $data['total'] = $rows->total_tea_value;
             
        }
        return $data;
    }
/*@method getOtherCharges
 *@param  $masterId,$totalCost
 */
  /*  public function getOtherCharges($masterId,$totalCost)
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
    }*/
    /**
     * @method updatePurchaseMaster
     * @param type $dataArray
     * @return boolean
     * @description upadate master area on edit mode.
     * @date 13-05-2016
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
     * @date 13/05/2016
     */
    public function insertNewPurchaseDetail($data, $bagData, $NormalbagData) {
        $masterDataforupdt = array();
        $BagData = array();

        try {
            $this->db->trans_begin();
            $this->db->insert('purchase_invoice_detail', $data);
            $insertdetailId = $this->db->insert_id();
            /** masterdata* */
            $masterDataforupdt = $this->getPurchaseDataDtls($data['purchase_master_id']);
            $this->db->where('id', $data['purchase_master_id']);
            $this->db->update('purchase_invoice_master', $masterDataforupdt);
            $this->insertintodoToTransporter($data['purchase_master_id'],$insertdetailId,$data['location_id']);
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
    
    public function insertintodoToTransporter($masterId,$detailId,$loc){
        $session = sessiondata_method();
  
        $data['purchase_inv_mst_id']=$masterId;
        $data['purchase_inv_dtlid']=$detailId;
        $data['is_sent']='Y';
        $data['in_Stock']='Y';
        $data['locationId']=$loc;
        $data['typeofpurchase']='STI';
        $data['yearid']=$session['yearid'];
        $data['companyid']=$session['company'];

        $this->db->insert('do_to_transporter', $data);
      
    }
    
    
   /**
  * @method checkExistingRefrence
  * @param type $purchaseInvoice
  * @author Mithilesh
  * @date 13/05/2016
  */
    public function checkExistingRefrence($refrenceNo,$cmpny,$yearid){
        $check = array(
            "purchase_invoice_number"=>$refrenceNo,
            "company_id"=>$cmpny,
            "year_id"=>$yearid
        );
         $sql = $this->db->select('id')->from('purchase_invoice_master')->where($check)->get();
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
  * @date 13-05-2016
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
        
            $detailsData['gp_number'] = '';
        
            $detailsData['date'] = '';
            $detailsData['package'] = NULL;
         
            $detailsData['stamp'] = 0;
            $detailsData['gross'] = $searcharray['txtGross'][$i];
         
            $detailsData['brokerage'] = 0;
            $detailsData['total_weight'] = $searcharray['DtltotalWeight'][$i];
         
            $detailsData['rate_type_value'] =0; 
            $detailsData['price'] = $searcharray['txtPrice'][$i];
         
            $detailsData['service_tax'] = 0;
            $detailsData['total_value'] = $searcharray['DtltotalValue'][$i];
            $detailsData['chest_from'] = NULL;
            $detailsData['chest_to'] = null;
            $detailsData['value_cost'] = ($searcharray['DtltotalWeight'][$i] * $searcharray['txtPrice'][$i] );//total weight * price==>value_cost//
            $detailsData['net'] = 0;
       
            $detailsData['rate_type'] = '';
            $detailsData['rate_type_id'] = ($searcharray[$rateSeletedTypeIndex][0]=='V'?$searcharray['drpVatRate'][$i]:$searcharray['drpCSTRate'][$i]);
            $detailsData['rate_type_id'] = 0;
            $detailsData['service_tax_id'] = $searcharray['drpServiceTax'][$i];
            $detailsData['service_tax_id'] = 0;
            $detailsData['teagroup_master_id']= $searcharray['drpgroup'][$i];
            $detailsData['cost_of_tea']= $searcharray['DtlteaCost'][$i];
            $detailsData['transportation_cost']= $searcharray['transCost'][$i];
            
           
            $this->db->insert('purchase_invoice_detail', $detailsData);
            $insertdtlId = $this->db->insert_id();
            
           // $locationId=0;
          
            $this->savedoToTransporter($insertId,$insertdtlId,$searcharray['drplocation'][$i]);
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
public function savedoToTransporter($pMasterId,$pdtlId,$locationId){
    $session = sessiondata_method();
  /*  echo "PurchaseMasterId = ".$pMasterId;
   echo "<br>PurchaseDetailId = ".$pdtlId."<br>";*/
   // exit;
    $data['purchase_inv_mst_id']=$pMasterId;
    $data['purchase_inv_dtlid']=$pdtlId;
    $data['is_sent']='Y';
    $data['in_Stock']='Y';
    $data['locationId']=$locationId;
    $data['typeofpurchase']='STI';
    $data['yearid']=$session['yearid'];
    $data['companyid']=$session['company'];
    
    $this->db->insert('do_to_transporter', $data);
    // echo $this->db->last_query();
    
}
/**
 * @method updateOtherCharges
 * @return int success or fail update
 *//*
public function updateOtherCharges($pMasterId,$data){
    try {
        /*echo('<pre>');
        print_r($data);
        echo ('</pre>');
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
    
  /*  function saveInvoicemaster($value) {
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

/*    function saveInvoicedetail($value) {
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

  /*  function updateInvoicedetail($value, $invoiceid) {

        $this->db->where('id', $invoiceid);
        $this->db->update('purchase_invoice_detail', $value);
    }

 /*   function saveItemamster($value) {
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

 /*   function insertVoucher($valuevoucher) {
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

   /* function insertVoucherDetail($value) {
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

   /* function insertVendorBill($value) {
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

   /* function getVendorAccount($vendor_id) {
        $sql = " SELECT `account_master`.`id` FROM `account_master` 
				 INNER JOIN vendor ON `account_master`.`account_name` = `vendor`.`vendor_name` 
				  WHERE `vendor`.`id` = " . $vendor_id;
        $query = $this->db->query($sql);
        return ($query->result());
    }

  /*  function lastvoucherid() {
        $sql = "SELECT YEAR(`voucher_date`) as year, `id` FROM `voucher_master` ORDER BY id DESC LIMIT 0,1";
        $query = $this->db->query($sql);
        return ($query->result());
    }

  /*  function getserialnumber($comapny, $year) {
        $sql = "SELECT `serial_number` FROM `voucher_master` WHERE `transaction_type`= 'PR' AND `company_id`= " . $comapny . " AND `year_id`=" . $year . " ORDER BY id DESC LIMIT 0,1";
        $query = $this->db->query($sql);
        return ($query->result());
    }
*/
    /*
     * @method saveInvoiceBagDetails
     * @param $valus
     * @desc Bagdetails will be save here , normal(1),Sample(2)
     * 
     */

 /*   public function saveInvoiceBagDetails($value) {
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

 /*   public function updateBagDetails($id, $values) {
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
    }*/

    
    function teagrouplist() {

        $sql = "SELECT `id`,`group_code`,`group_description` FROM teagroup_master ORDER BY `group_code` asc";
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
                $data[] = $rows;
            }

            return $data;
        }
    }


  /*  function getVendorlist($session) {
        $sql = "SELECT `id`,`vendor_name`,IF (id = " . $session . ", 'Y', 'N') selected	FROM `vendor`";
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

    
    
    
 

   
    
  /*  function updateInvoicemaster($value) {

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
    }*/

   
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

   
   
  
    /**
     * @method saveStockForSB
     * @method for Seller to Buyer direct stock update.
     */
   /* public function saveStockForSB($value) {
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

   
    /*return grandWeight
     * @date 13-05-2016
     * 
     */
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
      /* public function getTotalBagNo($purchaseMasterId)
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
    */

    
    
    
    
   
    
}
?>