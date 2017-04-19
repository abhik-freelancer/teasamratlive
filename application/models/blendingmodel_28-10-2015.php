<?php

class blendingmodel extends CI_Model {

    public function getTeaStock($garden = "", $invoice = "", $lotnumber = "", $grade = "") {
        $data = array();
//        $sql = "SELECT 
//            PID.`id` AS purchaseDtl,
//            PBD.`id` AS purchaseBagDtlId,
//            `blending_details`.`id`,
//            PID.`teagroup_master_id`,
//            PID.`invoice_number`,
//            PID.`lot`,garden_master.`garden_name`,
//            PID.`garden_id`, grade_master.`grade`,PID.`grade_id`,
//            location.`location`,teagroup_master.`group_code`,
//            PID.`price`,PBD.`actual_bags`,PBD.`net`,PBD.`shortkg`,
//            `blending_details`.`number_of_blended_bag`,
//            `blending_details`.`qty_of_bag`,
//            (IF(PBD.`actual_bags` IS NULL, 0,PBD.`actual_bags`) -
//             IF(`blending_details`.`number_of_blended_bag` IS NULL,0,`blending_details`.`number_of_blended_bag`)) AS NumberOfStockBag,
//            ((
//            IF(PBD.`actual_bags`IS NULL,0,PBD.`actual_bags`)* IF(PBD.net IS NULL,0,PBD.net))-
//            (IF(`blending_details`.`number_of_blended_bag`IS NULL,0,`blending_details`.`number_of_blended_bag`)*
//            IF(`blending_details`.`qty_of_bag`IS NULL,0,`blending_details`.`qty_of_bag`))) AS StockBagQty
//            FROM `purchase_invoice_detail` PID 
//            INNER JOIN 
//            `purchase_bag_details` PBD ON PID.`id` =PBD.`purchasedtlid`
//            INNER JOIN 
//            do_to_transporter DOT ON PID.`id`= DOT.`purchase_inv_dtlid` AND DOT.`in_Stock`='Y'
//            LEFT JOIN `blending_details` ON PBD.`id` = `blending_details`.`purchasebag_id`
//            INNER JOIN garden_master ON PID.`garden_id` = garden_master.`id`
//            INNER JOIN grade_master ON PID.`grade_id` = grade_master.`id`
//            INNER JOIN `location` ON DOT.`locationId`=`location`.`id`  
//            INNER JOIN `teagroup_master` ON PID.`teagroup_master_id` = `teagroup_master`.`id`
//            WHERE PID.`garden_id`='".$garden."' AND PID.`invoice_number`='".$invoice."' AND PID.`lot`='".$lotnumber."' AND PID.`grade_id`='".$grade."'";
      
       $sql ="SELECT 
                        PID.`id` AS purchaseDtl,
                        PBD.`id` AS purchaseBagDtlId,
                        PID.`teagroup_master_id`,
                        PID.`invoice_number`,
                        PID.`lot`,garden_master.`garden_name`,
                        PID.`garden_id`, grade_master.`grade`,PID.`grade_id`,
                        location.`location`,teagroup_master.`group_code`,
                        PID.`price`,PBD.`actual_bags`,
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
                
                $NumberOfStockBag =($rows->actual_bags -  $this->getBlendedBag($rows->purchaseBagDtlId));
                
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
                        "Numberofbags" =>($rows->actual_bags - $this->getBlendedBag($rows->purchaseBagDtlId)),//$rows->NumberOfStockBag,
                        "kgperbag" => $rows->net,
                        "NetBags" =>($rows->actual_bags - $this->getBlendedBag($rows->purchaseBagDtlId))*($rows->net),                //$rows->StockBagQty,
                        "blendedBag" => $this->getBlendedBag($rows->purchaseBagDtlId),                            //$rows->number_of_blended_bag,
                        "blendedKgs" => number_format($rows->net * $this->getBlendedBag($rows->purchaseBagDtlId), 2)
                    );
                }
            }
//            echo('<pre>');
//            print_r($data);
//            echo('</pre>');

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
/**
 * @method getBlendedData
 * @param int $blendedId Description
 * @date 11-10-2015
 * @description fetching blending data for edit
 * against blendId.
 */
public function getBlendedData($blendId){
     $sql="SELECT `blending_details`.`blending_master_id`,
                    `blending_details`.`id`,
                    `blending_details`.`number_of_blended_bag`,
                    `blending_details`.`qty_of_bag`,
                    `blending_details`.`purchasebag_id`,
                    `blending_details`.`purchase_dtl_id`,
                    PID.`id` AS purchaseDtl,
                    PID.`teagroup_master_id`,
                    PID.`invoice_number`,
                    PID.`lot`,garden_master.`garden_name`,
                    PID.`garden_id`, grade_master.`grade`,PID.`grade_id`,
                    location.`location`,teagroup_master.`group_code`
            FROM
                    `blending_details`
                    INNER JOIN
                    `purchase_invoice_detail` PID
                    ON `blending_details`.`purchase_dtl_id`=PID.`id`
                    INNER JOIN 
                    do_to_transporter DOT ON PID.`id`= DOT.`purchase_inv_dtlid` AND DOT.`in_Stock`='Y'
                    INNER JOIN garden_master ON PID.`garden_id` = garden_master.`id`
                    INNER JOIN grade_master ON PID.`grade_id` = grade_master.`id`
                    INNER JOIN `location` ON DOT.`locationId`=`location`.`id`  
                    INNER JOIN `teagroup_master` ON PID.`teagroup_master_id` = `teagroup_master`.`id`
                    WHERE `blending_details`.`blending_master_id`='".$blendId."'";
     $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
                    
                $stockBag = ($this->getPurchasedBag($rows->purchasebag_id) - $this->getBlendedBag($rows->purchasebag_id));
                $data[] = array(
                    "purchaseDtl" => $rows->purchase_dtl_id,
                    "PbagDtlId" => $rows->purchasebag_id,
                    "BagNet" => $rows->qty_of_bag,
                    "Garden" => $rows->garden_name,
                    "Invoice" => $rows->invoice_number,
                    "Group" => $rows->group_code,
                    "Grade" => $rows->grade,
                    "Location" => $rows->location,
                    "Numberofbags" => $stockBag,//($this->getPurchasedBag($rows->purchasebag_id) - $this->getBlendedBag($rows->purchasebag_id)),//$rows->NumberOfStockBag,
                    "kgperbag" => $rows->qty_of_bag,
                    "NetBags" => ($stockBag * $rows->qty_of_bag), //$rows->StockBagQty,
                    "blendedBag" => $rows->number_of_blended_bag,
                    "blendedKgs" => number_format($rows->qty_of_bag * $rows->number_of_blended_bag, 2)
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
 * @method getStock
 * @return type
 */
public function getStock() {
        $data = array();
        $whereClause = '';

        $call_procedure = "CALL sp_allgroup_stock";

        $query = $this->db->query($call_procedure);
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
                if ($rows->NumberOfStockBag != 0) {
                    $data[] = array(
                        "purchaseDtl" => $rows->purchaseDtl,
                        "PbagDtlId" => $rows->purchaseBagDtlId,
                        "BagNet" => $rows->net,
                        "Garden" => $rows->garden_name,
                        "Invoice" => $rows->invoice_number,
                        "Group" => $rows->group_code,
                        "Grade" => $rows->grade,
                        "Location" => $rows->location,
                        "Numberofbags" => $rows->NumberOfStockBag,
                        "kgperbag" => $rows->net,
                        "NetBags" => $rows->StockBagQty,
                        "blendedBag" => $rows->number_of_blended_bag,
                        "blendedKgs" => number_format($rows->net * $rows->number_of_blended_bag, 2)
                    );
                }
            }


            return $data;
        } else {
            return $data;
        }
    }

    /**
     * @method getStockWithBlend
     * @description getting Stock with Blend Bag
     */
    public function getStockWithBlend() {
        $data = array();
        $whereClause = '';
        //$sql =""

        $call_procedure = "CALL sp_allgroup_stock";

        $query = $this->db->query($call_procedure);
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {

                $data[] = array(
                    "purchaseDtl" => $rows->purchaseDtl,
                    "PbagDtlId" => $rows->purchaseBagDtlId,
                    "BagNet" => $rows->net,
                    "Garden" => $rows->garden_name,
                    "Invoice" => $rows->invoice_number,
                    "Group" => $rows->group_code,
                    "Grade" => $rows->grade,
                    "Location" => $rows->location,
                    "Numberofbags" => $rows->NumberOfStockBag,
                    "kgperbag" => $rows->net,
                    "NetBags" => $rows->StockBagQty,
                    "blendedBag" => $rows->number_of_blended_bag,
                    "blendedKgs" => number_format($rows->net * $rows->number_of_blended_bag, 2)
                );
            }


            return $data;
        } else {
            return $data;
        }
    }
    /**
     * @method getBlendedStock
     * @param type $Id
     * @return type
     */
    public function getBlendedStock(){
        
        $data=array();
        
        $sql="SELECT
                blending_details.`id`,
                blending_details.`blending_master_id`,
                blending_details.`purchase_dtl_id`,
                blending_details.`purchasebag_id`,
                blending_details.`number_of_blended_bag`,
                blending_details.`qty_of_bag`,
               `purchase_bag_details`.`actual_bags`,
               (`purchase_bag_details`.`actual_bags` - blending_details.`number_of_blended_bag`) AS bag_in_stock
              FROM 
                `blending_master`
              INNER JOIN 
                `blending_details` ON blending_master.`id`= blending_details.`blending_master_id` 
              INNER JOIN 
                `purchase_bag_details` ON
                `blending_details`.`purchasebag_id`=`purchase_bag_details`.`id`
              WHERE blending_details.`blending_master_id` = 5";
        
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {

                $data[] = array(
                    "purchaseDtl" => $rows->purchaseDtl,
                    "PbagDtlId" => $rows->purchaseBagDtlId,
                    "BagNet" => $rows->net,
                    "Garden" => $rows->garden_name,
                    "Invoice" => $rows->invoice_number,
                    "Group" => $rows->group_code,
                    "Grade" => $rows->grade,
                    "Location" => $rows->location,
                    "Numberofbags" => $rows->NumberOfStockBag,
                    "kgperbag" => $rows->net,
                    "NetBags" => $rows->StockBagQty,
                    "blendedBag" => $rows->number_of_blended_bag,
                    "blendedKgs" => number_format($rows->net * $rows->number_of_blended_bag, 2)
                );
            }


            return $data;
        } else {
            return $data;
        }
        
        
    }

    /**
     * 
     * @param type $Id
     * @return type
     */
    public function getBlendingMasterData($Id) {
        $data = array();



        $this->db->select('blending_master.id ,
                            blending_master.blending_number ,
                            blending_master.blending_ref ,
                            blending_master.blending_date ,
                            blending_master.warehouseid ,
                            blending_master.companyid ,
                            blending_master.yearid ,
                            blending_master.productid ');
        $this->db->from('blending_master');
        $this->db->where('blending_master.id', $Id);

        $query = $this->db->get();
        //echo( $this->db->last_query());


        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
                $data = array(
                    "bMasterId" => $rows->id,
                    "blendNum" => $rows->blending_number,
                    "blendRef" => $rows->blending_ref,
                    "blendDate" => date('d-m-Y', strtotime($rows->blending_date)),
                    "warehouseId" => $rows->warehouseid,
                    "productId" => $rows->productid,
                    "yearId" => $rows->yearid,
                    "companyId" => $rows->companyid
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
            $this->db->insert('blending_master', $master);
            $blendingMstId = $this->db->insert_id();
            $this->insertBlndDtl($blendingMstId, $sercharr);

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
    public function insertBlndDtl($masterId, $dtlArr) {
        $blendingDtl = array();
        $numberOfDtl = count($dtlArr['txtBagDtlId']);
        for ($i = 0; $i < $numberOfDtl; $i++) {
            $blendingDtl['blending_master_id'] = $masterId;
            $blendingDtl['purchase_dtl_id'] = $dtlArr['txtpurchaseDtl'][$i];
            $blendingDtl['purchasebag_id'] = $dtlArr['txtBagDtlId'][$i];
            $blendingDtl['number_of_blended_bag'] = ($dtlArr['txtused'][$i]==""?0:$dtlArr['txtused'][$i]);
            $blendingDtl['qty_of_bag'] = $dtlArr['txtnetinBag'][$i];

           // if ($dtlArr['txtused'][$i] != 0) {
                $this->db->insert('blending_details', $blendingDtl);
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
    public function blendingUpdate($blendingId, $masterData = array(), $detail = array()) {
        if ($blendingId != '') {
            try {
                $this->db->trans_begin();
                $this->db->where('id', $blendingId);
                $this->db->update('blending_master', $masterData);
                /*                 * details delete** */
                $this->db->delete('blending_details', array('blending_master_id' => $blendingId));
                /*                 * details delete** */
                $this->insertBlndDtl($blendingId, $detail);

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
    public function getBlendingList() {
        $data = array();
        $sql = "SELECT
                    blending_master.`id`,
                    blending_master.`blending_number`,
                    blending_master.`blending_ref`,
                    DATE_FORMAT(blending_master.`blending_date`,'%d-%m-%Y') AS blending_date,
                    warehouse.`name`,
                    blending_master.`companyid`,
                    blending_master.`yearid`,
                    product.`product`,
                    SUM(blending_details.`number_of_blended_bag`*blending_details.`qty_of_bag`) AS blendKgs
                FROM `blending_master`
                INNER JOIN `blending_details`
                 ON blending_master.`id` = blending_details.`blending_master_id`
                INNER JOIN 
                `product` ON  blending_master.`productid` = product.`id`
                INNER JOIN
                `warehouse` ON blending_master.`warehouseid` = `warehouse`.`id`
                GROUP BY  blending_master.`id` ORDER BY blending_master.`blending_date` DESC";

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

    public function getBlendDtlView($blendId) {

        $sql = "SELECT `blending_details`.`blending_master_id`,`blending_details`.`purchasebag_id`,
                `blending_details`.`qty_of_bag`,`blending_details`.`number_of_blended_bag`,
                `purchase_bag_details`.`purchasedtlid`,`purchase_invoice_detail`.`invoice_number`,
                `purchase_invoice_detail`.`garden_id`,`purchase_invoice_detail`.`grade_id`,`purchase_invoice_detail`.`teagroup_master_id`,
                `grade_master`.`grade`,`garden_master`.`garden_name`,`teagroup_master`.`group_code`
                FROM
                `blending_details`
                INNER JOIN
                `purchase_bag_details` ON `blending_details`.`purchasebag_id` = `purchase_bag_details`.`id`
                INNER JOIN
                `purchase_invoice_detail` ON `purchase_bag_details`.`purchasedtlid`=`purchase_invoice_detail`.`id`
                INNER JOIN
                `grade_master` ON `purchase_invoice_detail`.`grade_id` = `grade_master`.`id`
                INNER JOIN 
                `garden_master` ON `purchase_invoice_detail`.`garden_id` = `garden_master`.`id`
                INNER JOIN `teagroup_master` ON `purchase_invoice_detail`.`teagroup_master_id` = `teagroup_master`.`id`
                WHERE 
                `blending_details`.`blending_master_id`='" . $blendId . "'";

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
     * 
     * @param type $blendId
     * @return type
     */
    public function blendSheetDtlPrint($blendId) {
        $sql = "SELECT 
                garden_master.garden_name,
                grade_master.grade,
                purchase_invoice_detail.invoice_number,
                purchase_invoice_detail.lot,
                teagroup_master.group_code,
                location.location,
                blending_details.number_of_blended_bag,
                blending_details.qty_of_bag ,
                (blending_details.number_of_blended_bag * blending_details.qty_of_bag ) AS blndQty,
                'KG' AS unit
        FROM
                blending_details 
                INNER JOIN purchase_bag_details 
                  ON blending_details.purchasebag_id = purchase_bag_details.id 
                INNER JOIN purchase_invoice_detail 
                  ON purchase_bag_details.purchasedtlid = purchase_invoice_detail.id 
                INNER JOIN grade_master 
                  ON purchase_invoice_detail.grade_id = grade_master.id 
                INNER JOIN garden_master 
                  ON purchase_invoice_detail.garden_id = garden_master.id 
                INNER JOIN teagroup_master 
                  ON purchase_invoice_detail.teagroup_master_id = teagroup_master.id 
                INNER JOIN do_to_transporter 
                  ON do_to_transporter.purchase_inv_dtlid = purchase_invoice_detail.id 
                INNER JOIN location 
                  ON do_to_transporter.locationId = location.id 
        WHERE blending_details.blending_master_id = '" . $blendId . "'";


        $query = $this->db->query($sql);
        $count = 1;
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {

                $data[] = array(
                    "SL" => $count++,
                    "Garden" => $rows->garden_name,
                    "Grade" => $rows->grade,
                    "Invoice" => $rows->invoice_number,
                    "Lot" => $rows->lot,
                    "Group" => $rows->group_code,
                    "Location" => $rows->location,
                    "PackingBag" => $rows->number_of_blended_bag,
                    "QtyKgs" => $rows->qty_of_bag,
                    "BlendQty" => $rows->blndQty,
                    "Unit" => $rows->unit
                );
            }


            return $data;
        } else {
            return $data;
        }
    }

    /**
     * 
     * @param type $bId
     * @return type
     */
    public function blendSheetMstPrint($bId) {
        $sql = "SELECT 
                blending_master.id,
                blending_master.blending_number,
                blending_master.blending_ref,
                DATE_FORMAT(blending_master.blending_date,'%d-%m-%Y') AS blending_date,
                product.product,
                company.company_name,
                company.location 
            FROM
                blending_master 
                INNER JOIN product 
                  ON blending_master.productid = product.id 
                INNER JOIN company 
                  ON blending_master.companyid = company.id 
              WHERE blending_master.id = '" . $bId . "'";

        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
                $data = array(
                    "bMasterId" => $rows->id,
                    "blendNum" => $rows->blending_number,
                    "blendRef" => $rows->blending_ref,
                    "blendDate" => $rows->blending_date,
                    "product" => $rows->product,
                    "Company" => $rows->company_name,
                    "CompanyLoc" => $rows->location
                );
            }

            return $data;
        } else {
            return $data;
        }
    }

    /**
     * 
     * @param type $blendId
     */
    public function getTotalBlendedPacket($blendId) {
        $sql = "SELECT SUM(`blending_details`.`number_of_blended_bag`) AS totalPacket 
                 FROM blending_details
                 GROUP BY blending_details.`blending_master_id` 
                 HAVING blending_details.`blending_master_id` ='" . $blendId . "'";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $ret = $query->row();
            //return $ret->totalPacket;
            return number_format((float) $ret->totalPacket, 2, '.', '');
        } else {
            return 0;
        }
    }

    /**
     * 
     * @param type $blendId
     * @return int
     */
    public function getTotalBlendedKgs($blendId) {
        $sql = "SELECT 
            SUM(`blending_details`.`number_of_blended_bag`*`blending_details`.`qty_of_bag`) AS totalBlendedKgs 
            FROM blending_details
            GROUP BY blending_details.`blending_master_id` 
            HAVING blending_details.`blending_master_id` ='" . $blendId . "'";

        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $ret = $query->row();

            return number_format((float) $ret->totalBlendedKgs, 2, '.', '');
        } else {
            return 0;
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

}
