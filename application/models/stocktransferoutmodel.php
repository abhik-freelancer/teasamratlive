<?php

class stocktransferoutmodel extends CI_Model {

    public function getTeaStock($garden = "", $invoice = "", $lotnumber = "", $grade = "") {
        $data = array();
        $sql ="SELECT 
                        PID.`id` AS purchaseDtl,
                        PBD.`id` AS purchaseBagDtlId,
                        PID.`teagroup_master_id`,
                        PID.`invoice_number`,
                        PID.`lot`,garden_master.`garden_name`,
                        PID.`garden_id`, grade_master.`grade`,PID.`grade_id`,
                        location.`location`,teagroup_master.`group_code`,
                        PID.`price`,PID.`cost_of_tea`,
                        PBD.`actual_bags`,
                        PBD.`net`,
                        PBD.`shortkg`
                        FROM `purchase_invoice_detail` PID 
                INNER JOIN 
                        `purchase_bag_details` PBD ON PID.`id` =PBD.`purchasedtlid`
                INNER JOIN 
                        do_to_transporter DOT ON PID.`id`= DOT.`purchase_inv_dtlid` AND DOT.`in_Stock`='Y'
                INNER JOIN garden_master ON PID.`garden_id` = garden_master.`id`
                INNER JOIN grade_master ON PID.`grade_id` = grade_master.`id`
                INNER JOIN `location` ON DOT.`locationId`=`location`.`id`  
                INNER JOIN `teagroup_master` ON PID.`teagroup_master_id` = `teagroup_master`.`id`
             WHERE PID.`garden_id`='".$garden."' AND PID.`invoice_number`='".$invoice."' AND PID.`lot`='".$lotnumber."' AND PID.`grade_id`='".$grade."'";

        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
                
                $NumberOfStockBag =($rows->actual_bags -  ($this->getstockOutBag($rows->purchaseBagDtlId)+$this->getBlendedBag($rows->purchaseBagDtlId)+$this->getsaleOutBag($rows->purchaseBagDtlId)));
                
                if ($NumberOfStockBag != 0) {
                    $data[] = array(
                        "purchaseDtl" => $rows->purchaseDtl,
                        "PbagDtlId" => $rows->purchaseBagDtlId,
                        "BagNet" => $rows->net,//purchased bag net
                        "Garden" => $rows->garden_name,
                        "Invoice" => $rows->invoice_number,
                        "Group" => $rows->group_code,
                        "Grade" => $rows->grade,
                        "Location" => $rows->location,
                        "Numberofbags" =>$NumberOfStockBag,//($rows->actual_bags - $this->getstockOutBag($rows->purchaseBagDtlId))
                        "kgperbag" => $rows->net,
                        //"pricePerBag"=>$rows->price,
                        "pricePerBag"=>$rows->cost_of_tea,
                        //"NetBags" =>($rows->actual_bags - $this->getstockOutBag($rows->purchaseBagDtlId))*($rows->net),                //$rows->StockBagQty,
                        "NetBags" =>$NumberOfStockBag*($rows->net),                //$rows->StockBagQty,
                        "blendedBag" => $this->getstockOutBag($rows->purchaseBagDtlId),                            //$rows->number_of_blended_bag,
                        "blendedKgs" => number_format($rows->net * $this->getstockOutBag($rows->purchaseBagDtlId), 2)
                    );
                }
            }
          

            return $data;
        } else {
            return $data;
        }
    }
/**
 * @method getBlendedBag
 * @param type $bagDtlId
 * @return int
 */
public function getstockOutBag($bagDtlId){
     $sql = "SELECT `stocktransfer_out_detail`.`purchase_bag_id`,
                SUM(`stocktransfer_out_detail`.`num_of_stockout_bag`) AS stock_bag
            FROM `stocktransfer_out_detail` 
            GROUP BY `stocktransfer_out_detail`.`purchase_bag_id`
            HAVING `stocktransfer_out_detail`.`purchase_bag_id`='".$bagDtlId."'";
    
    $query = $this->db->query($sql);
    if ($query->num_rows() > 0) {
                $row = $query->row(); 
                return $row->stock_bag;
        } else {
                return 0;
        }
}

/* @method getBlendedbag
 * @param type $bagDtlId
 */

public function getBlendedBag($bagDtlId){
     $sql = "SELECT `blending_details`.`purchasebag_id`,
                SUM(`blending_details`.`number_of_blended_bag`) AS blended_bag
            FROM `blending_details` 
            GROUP BY `blending_details`.`purchasebag_id`
            HAVING `blending_details`.`purchasebag_id`='".$bagDtlId."'";
    
    $query = $this->db->query($sql);
    if ($query->num_rows() > 0) {
                $row = $query->row(); 
                return $row->blended_bag;
        } else {
                return 0;
        }
}


public function getsaleOutBag($bagDtlId){
     $sql = "SELECT `rawteasale_detail`.`purchase_bag_id`,
                SUM(`rawteasale_detail`.`num_of_sale_bag`) AS sale_bag
            FROM `rawteasale_detail` 
            GROUP BY `rawteasale_detail`.`purchase_bag_id`
            HAVING `rawteasale_detail`.`purchase_bag_id`='".$bagDtlId."'";
    
    $query = $this->db->query($sql);
    if ($query->num_rows() > 0) {
                $row = $query->row(); 
                return $row->sale_bag;
        } else {
                return 0;
        }
}

/**
 * @method getStockOutDtlData
 * @param int $blendedId Description
 * @date 26-05-2016
 * @description fetching blending data for edit
 * against blendId.
 */
public function getStockOutDtlData($stockoutId){
     $sql="SELECT 
            `stocktransfer_out_detail`.`stocktransfer_out_master_id`,
            `stocktransfer_out_detail`.`id`,
            `stocktransfer_out_detail`.`num_of_stockout_bag`,
            `stocktransfer_out_detail`.`qty_stockout_kg`,
            `stocktransfer_out_detail`.`purchase_bag_id`,
            `stocktransfer_out_detail`.`purchase_detail_id`,
            PID.`id` AS purchaseDtl,
            PID.`teagroup_master_id`,
            PID.`invoice_number`,
            PID.`price`,
            PID.`cost_of_tea`,
            PID.`lot`,
            PID.`garden_id`, 
            PID.`grade_id`,
            garden_master.`garden_name`,
            grade_master.`grade`,
            location.`location`,
            `teagroup_master`.`group_code`
            FROM
            `stocktransfer_out_detail`
            INNER JOIN
            `purchase_invoice_detail` AS PID
            ON `stocktransfer_out_detail`.`purchase_detail_id`=PID.`id`
            INNER JOIN garden_master ON PID.`garden_id` = garden_master.`id`
            INNER JOIN grade_master ON PID.`grade_id` = grade_master.`id`
            INNER JOIN 
             do_to_transporter DOT ON PID.`id`= DOT.`purchase_inv_dtlid` AND DOT.`in_Stock`='Y'
            INNER JOIN `location` ON DOT.`locationId`=`location`.`id` 
            INNER JOIN `teagroup_master` ON PID.`teagroup_master_id` = `teagroup_master`.`id`
            WHERE `stocktransfer_out_detail`.`stocktransfer_out_master_id`='".$stockoutId."'";
     
     
     
     
     $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
                    
                $stockBag = ($this->getPurchasedBag($rows->purchase_bag_id) - ($this->getstockOutBag($rows->purchase_bag_id)+$this->getBlendedBag($rows->purchase_bag_id)+$this->getsaleOutBag($rows->purchase_bag_id)));
                $data[] = array(
                    "purchaseDtl" => $rows->purchase_detail_id,
                    "PbagDtlId" => $rows->purchase_bag_id,
                    "BagNet" => $rows->qty_stockout_kg,
                    "Garden" => $rows->garden_name,
                    "Invoice" => $rows->invoice_number,
                    "Group" => $rows->group_code,
                    "Grade" => $rows->grade,
                    "Location" => $rows->location,
                    "Numberofbags" => $stockBag,//($this->getPurchasedBag($rows->purchasebag_id) - $this->getBlendedBag($rows->purchasebag_id)),//$rows->NumberOfStockBag,
                    "kgperbag" => $rows->qty_stockout_kg,
                   // "pricePerBag"=>$rows->price,
                    "pricePerBag"=>$rows->cost_of_tea,
                    "NetBags" => ($stockBag * $rows->qty_stockout_kg), //$rows->StockBagQty,
                    "blendedBag" => $rows->num_of_stockout_bag,
                    "blendedCost" =>($rows->num_of_stockout_bag * $rows->cost_of_tea ),
                    "blendedKgs" => number_format($rows->qty_stockout_kg * $rows->num_of_stockout_bag, 2)
                );
            }


            return $data;
        } else {
            return $data;
        }
    
}
/**
 * @name getPurchasedBag
 * @param type $bagDtlId
 * @return int
 * @description get purchased bag from purchase_bag_details actual_bags
 */
public function getPurchasedBag($bagDtlId){
    $sql="SELECT `purchase_bag_details`.`id`,`purchase_bag_details`.`actual_bags`
            FROM `purchase_bag_details` WHERE `purchase_bag_details`.`id`='".$bagDtlId."'";
    
    $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
                $row = $query->row(); 
                return $row->actual_bags;
        } else {
                return 0;
        }
    
}




    

    /**
     * 
     * @param type $Id
     * @return type
     */
    public function getStockOutMasterData($Id) {
        $data = array();



       $this->db->select('`stocktransfer_out_master`.`id` ,
                            `stocktransfer_out_master`.`refrence_number` ,
                            `stocktransfer_out_master`.`transfer_date`,
                            `stocktransfer_out_master`.`cn_no`,
                            `stocktransfer_out_master`.`vendor_id` ,
                           `stocktransfer_out_master`.`stock_outBags`,
                           `stocktransfer_out_master`.`stock_outPrice`,
                           `stocktransfer_out_master`.`stock_outKgs`');
              $this->db->from('stocktransfer_out_master');
             $this->db->where('stocktransfer_out_master.id', $Id);

             $query = $this->db->get();
        //echo( $this->db->last_query());
        
     if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
                $data = array(
                    "stckoutMastId" => $rows->stockTransmastId,
                    "refrence_number" => $rows->refrence_number,
                    "transferDt" => date('d-m-Y', strtotime($rows->transfer_date)),
                    "cn_no" =>$rows->cn_no,
                    "vendorid" => $rows->vendor_id,
                    "stock_outBags"=>$rows->stock_outBags,
                    "stock_outKgs"=>$rows->stock_outKgs,
                    "stock_outPrice"=>$rows->stock_outPrice
                );
            }


            return $data;
        } else {
            return $data;
        }
    }

    /**
     * 
     * @param type $master
     * @param type $sercharr
     */
    public function insertData($master, $sercharr) {

        try {
            $this->db->trans_begin();
            $this->db->insert('stocktransfer_out_master', $master);
           /* echo $this->db->last_query();
            exit;*/
            $stockoutMstId = $this->db->insert_id();
            $this->insertStockOutDtl($stockoutMstId, $sercharr);

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
     * 
     * @param type $masterId
     * @param type $dtlArr
     */
    public function insertStockOutDtl($masterId, $dtlArr) {
        $stockOutDtl = array();
        $numberOfDtl = count($dtlArr['txtBagDtlId']);
        for ($i = 0; $i < $numberOfDtl; $i++) {
            $stockOutDtl['stocktransfer_out_master_id'] = $masterId;
            $stockOutDtl['purchase_detail_id'] = $dtlArr['txtpurchaseDtl'][$i];
            $stockOutDtl['purchase_bag_id'] = $dtlArr['txtBagDtlId'][$i];
            $stockOutDtl['num_of_stockout_bag'] = ($dtlArr['txtused'][$i]==""?0:$dtlArr['txtused'][$i]);
            $stockOutDtl['qty_stockout_kg'] = $dtlArr['txtnetinBag'][$i];

           // if ($dtlArr['txtused'][$i] != 0) {
                $this->db->insert('stocktransfer_out_detail', $stockOutDtl);
            //}
        }
    }

    /**
     * @method blendingUpdate
     * @param type $blendingId
     * @param type $masterData
     * @param type $detail
     * @return boolean
     */
    public function stocktransferOutUpd($stockOutMid, $masterData = array(), $detail = array()) {
        if ($stockOutMid != '') {
            try {
                $this->db->trans_begin();
                $this->db->where('id', $stockOutMid);
                $this->db->update('stocktransfer_out_master', $masterData);
               
                /*                 * details delete** */
                $this->db->delete('stocktransfer_out_detail', array('stocktransfer_out_master_id' => $stockOutMid));
                /*                 * details delete** */
                $this->insertStockOutDtl($stockOutMid, $detail);

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
        } else {
            return false;
        }
    }

    /**
     * @method getBlendingList
     * @param void 
     * @return array blend list
     */
    public function getStockOutList() {
        $data = array();
        $sql = "SELECT 
                `stocktransfer_out_master`.id AS StockOutmastId,
                `stocktransfer_out_master`.`refrence_number`,
                 `stocktransfer_out_master`.`stock_outBags`,
                DATE_FORMAT(`stocktransfer_out_master`.`transfer_date`,'%d-%m-%Y') AS TransferDt,
                `vendor`.`vendor_name`,
                SUM(`stocktransfer_out_detail`.`num_of_stockout_bag`*`stocktransfer_out_detail`.`qty_stockout_kg`) AS totalStockOutKgs 
                FROM `stocktransfer_out_master`
                INNER JOIN `vendor`
                ON `vendor`.`id`=`stocktransfer_out_master`.`vendor_id`
                INNER JOIN `stocktransfer_out_detail`
                ON `stocktransfer_out_detail`.`stocktransfer_out_master_id`=`stocktransfer_out_master`.id
                GROUP BY `stocktransfer_out_master`.id ORDER BY stocktransfer_out_master.`transfer_date` DESC";

        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {

                $data[] = $rows;
            }


            return $data;
        } else {
            return $data;
        }
    }

   
   
  
   
   

    /**
     * @method getInvoice
     * @param type $gardenId
     * @return type
     */
    public function getInvoice($gardenId) {
        $data = array();
        $sql = "SELECT `purchase_invoice_detail`.`id`,`purchase_invoice_detail`.`invoice_number` FROM `purchase_invoice_detail`
                WHERE `purchase_invoice_detail`.`garden_id`='" . $gardenId . "'";

        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
                $data[] = array(
                    "pdtlId" => $rows->id,
                    "invoice" => $rows->invoice_number,
                );
            }

            return $data;
        } else {
            return $data;
        }
    }

    /**
     * @method getLotNumber
     * @param type $gardenId
     * @param type $invoice
     */
    public function getLotNumber($gardenId, $invoice) {
        $data = array();
        $sql = "SELECT `purchase_invoice_detail`.`id`,`purchase_invoice_detail`.`invoice_number`,`purchase_invoice_detail`.`lot`
                FROM `purchase_invoice_detail`
              WHERE `purchase_invoice_detail`.`garden_id`='" . $gardenId . "' AND `purchase_invoice_detail`.`invoice_number`='" . $invoice . "'";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
                $data[] = array(
                    "lot" => $rows->lot,
                    "lotnumber" => $rows->lot,
                );
            }

            return $data;
        } else {
            return $data;
        }
    }

    /**
     * @method getGradeNumber
     * @param type $garde Description
     * 
     */
    public function getGradeNumber($garden, $invoice, $lot) {
        $data = array();
        $sql = "SELECT `purchase_invoice_detail`.`id`,
                    `purchase_invoice_detail`.`invoice_number`,
                    `purchase_invoice_detail`.`lot`,
                    `purchase_invoice_detail`.`grade_id`,
                    `grade_master`.`grade`
              FROM `purchase_invoice_detail`
                    INNER JOIN `grade_master` ON `grade_master`.`id`=`purchase_invoice_detail`.`grade_id`
              WHERE `purchase_invoice_detail`.`garden_id`='" . $garden . "'  
                AND `purchase_invoice_detail`.`invoice_number`='" . $invoice . "' AND `purchase_invoice_detail`.`lot`='" . $lot . "'";

        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
                $data[] = array(
                    "gradeid" => $rows->grade_id,
                    "grade" => $rows->grade,
                );
            }

            return $data;
        } else {
            return $data;
        }
    }
    
    public  function getPurchaseExist($garden,$invoice,$lot,$grade){
        $sql="SELECT DISTINCT `purchase_invoice_detail`.`id`
                FROM purchase_invoice_detail 
              WHERE `garden_id`='".$garden."' AND `invoice_number`='".$invoice."' AND `lot`='".$lot."' AND `grade_id`='".$grade."'";
        
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
                $row = $query->row(); 
                
                return $row->id;
            
        } else {
                return 0;
        }
        
        
        
    }
    
    
     public function deleteData($pmasterId)
     {
       //$pinvDtlId= $this->getPinvoiceDtlId($pmasterId);
       
        
       $this->deleteStockTransferOutDtl($pmasterId);
       $this->deleteStockTransfermaster($pmasterId);
       
    
        
    }
    public function deleteStockTransferOutDtl($stckOutMastId){
        
            $this->db->where('stocktransfer_out_master_id', $stckOutMastId);
          $this->db->delete('stocktransfer_out_detail');  
          if($this->db->delete('stocktransfer_out_detail')){
              return true;
          }
          else{
              return false;
          }
         
    }
    public function deleteStockTransfermaster($stckOutMastId){
        
          $this->db->where('id', $stckOutMastId);
          $this->db->delete('stocktransfer_out_master');  
          if($this->db->delete('stocktransfer_out_master')){
              return true;
          }
          else{
              return false;
          }
         
    }
    
    

}
