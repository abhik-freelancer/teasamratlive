<?php

class finishedproductmodel extends CI_Model {

    public function getBlendedData($blendId) {
        $sql = "SELECT `blending_master`.`id`,
                        `blending_master`.`productid`,
                        `blending_master`.`warehouseid`,
                        `product`.`product`,
                        `warehouse`.`name`
            FROM `blending_master`
            INNER JOIN
                        `product` ON `blending_master`.`productid` = `product`.`id`
                        INNER JOIN 
                        `warehouse` ON `blending_master`.`warehouseid`=`warehouse`.`id`
                        WHERE `blending_master`.`id` ='" . $blendId . "'";

        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $row = $query->row();

            return $row;
        } else {
            return 0;
        }
    }
    
    public function getBlendingList() {
        $data = array();
        $sql = "SELECT	`blending_master`.`id`,`blending_master`.`blending_ref`
                FROM `blending_master`" ;
               

        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
               
                if($this->getBlendedKgs($rows->id)>0){ 
                    $data[] = $rows;
               }
            }

            
            return $data;
        } else {
            return $data;
        }
    }
    
    
    
    /**
     * @method getBlendedKgs
     * @param type $id
     * @return int
     */
     public function getBlendedKgs($id) {
        /*$sql = "SELECT 
                        `blending_master`.`id`,
                        `blending_master`.`blendedKgs`,
                        `finished_product`.`consumed_kgs`
            FROM `blending_master` 
            LEFT JOIN `finished_product` ON `blending_master`.`id` = `finished_product`.`blended_id`
            WHERE `blending_master`.`id`='" . $id . "'";*/
        $sql="SELECT 
                    `blending_master`.`id`,
                    `blending_master`.`blendedKgs`,
                     SUM(`finished_product`.`consumed_kgs`) AS consumed,
                    (IF(`blending_master`.`blendedKgs` IS NULL ,0,`blending_master`.`blendedKgs`) - 
                    IF(SUM(`finished_product`.`consumed_kgs`) IS NULL,0,SUM(`finished_product`.`consumed_kgs`))) AS blendedStock
                  FROM `blending_master`
                  LEFT JOIN `finished_product` ON `blending_master`.`id` = `finished_product`.`blended_id`
                  GROUP BY `blending_master`.`id`
                  HAVING `blending_master`.`id`='".$id."'" ;

        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $row = $query->row();
            //$blendedKg = (($row->blendedKgs==NULL or $row->blendedKgs=="")?0:$row->blendedKgs);
           // $consumedkgs = (($row->consumed_kgs==NULL or $row->consumed_kgs=="")?0:$row->consumed_kgs);
            $netBlended = $row->blendedStock;//$blendedKg - $consumedkgs;
            return number_format($netBlended,2);
        } else {
            return 0;
        }
    }

    public function getPaketDetailForBlend($blendId) {
        $data = array();
        $sql = "SELECT `blending_master`.`id`,`blending_master`.`productid`,`packet`.`packet`,`packet`.`PacketQty`,
               `product_packet`.`id` AS productPacketId 
            FROM `blending_master`
                INNER JOIN
                `product_packet` ON `blending_master`.`productid`=`product_packet`.`productid`
                INNER JOIN
                `packet` ON
                `product_packet`.`packetid` = `packet`.`id`
            WHERE `blending_master`.`id` ='" . $blendId . "'";

        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
                $data[] = array(
                    "productPacketId" => $rows->productPacketId,
                    "packet" => $rows->packet,
                    "packetQtyinKg" => $rows->PacketQty,
                    "numberofpacket" => 0
                );
            }


            return $data;
        } else {
            return $data;
        }
    }

    /*
     * 
     */

    public function insertData($master, $sercharr) {
        try {
            $this->db->trans_begin();
            $this->db->insert('finished_product', $master);
            // echo($this->db->last_query());exit;

            $finishproductMstId = $this->db->insert_id();
            $this->insertFinishProductDtl($finishproductMstId, $sercharr);

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
    public function insertFinishProductDtl($masterId, $dtlArr) {
        $fnshProdDtl = array();
        $numberOfDtl = count($dtlArr['hdproductpckt']);
        for ($i = 0; $i < $numberOfDtl; $i++) {
            $fnshProdDtl['finishProductId'] = $masterId;
            $fnshProdDtl['product_packet'] = $dtlArr['hdproductpckt'][$i];
            $fnshProdDtl['numberof_packet'] = $dtlArr['txtpacket'][$i];
            $fnshProdDtl['net_in_packet'] = ($dtlArr['txtPcktKg'][$i] == "" ? 0 : $dtlArr['txtPcktKg'][$i]);


            //if ($dtlArr['txtpacket'][$i] != 0) {
                $this->db->insert('finished_product_dtl', $fnshProdDtl);
            //}//
        }
    }
    
    /**
     * @method updateFinishProduct
     * @return type
     */
    public function  updateFinishProduct($master, $sercharr){
          try {
            $finishProductMasterId = $master['id'];   
            $this->db->trans_begin();
           
            
            $this->db->where('id', $finishProductMasterId);
            $this->db->update('finished_product' ,$master);

           
            $this->updateFinishproductDetails($finishProductMasterId, $sercharr);

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
     * @method updateFinishproductDetails
     * @return type
     */
    public function updateFinishproductDetails($masterId, $dtlArr){
        $this->db->where('finishProductId', $masterId);
        $this->db->delete('finished_product_dtl'); 
        
        $fnshProdDtl = array();
        $numberOfDtl = count($dtlArr['hdproductpckt']);
        for ($i = 0; $i < $numberOfDtl; $i++) {
            $fnshProdDtl['finishProductId'] = $masterId;
            $fnshProdDtl['product_packet'] = $dtlArr['hdproductpckt'][$i];
            $fnshProdDtl['numberof_packet'] = $dtlArr['txtpacket'][$i];
            $fnshProdDtl['net_in_packet'] = ($dtlArr['txtPcktKg'][$i] == "" ? 0 : $dtlArr['txtPcktKg'][$i]);


            //if ($dtlArr['txtpacket'][$i] != 0) {
                $this->db->insert('finished_product_dtl', $fnshProdDtl);
            //}//
        }
        
        
    }







    public function getFinishedProductList() {
        $data = array();

        $sql = "SELECT 
                `finished_product`.`id` as finishproductid,
                `finished_product`.`blended_id`,
                `blending_master`.`blending_ref`,
                DATE_FORMAT(`finished_product`.`packing_date`,'%d-%m-%Y')AS packing_date,
                SUM(`finished_product_dtl`.`net_in_packet`) AS totalPacket,
                SUM(`finished_product_dtl`.`numberof_packet`) AS TotalKg,
                `product`.`id` as productid,
                `product`.`product`
                FROM `finished_product`
                INNER JOIN `finished_product_dtl` ON `finished_product`.`id`=`finished_product_dtl`.`finishProductId`
                INNER JOIN `blending_master` ON `finished_product`.`blended_id` =`blending_master`.`id`
                INNER JOIN `product` ON `finished_product`.`productId`=`product`.`id`
                GROUP BY 
                `finished_product`.`id`";

        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {

                $data[] = array(
                    "finishProdId" => $rows->finishproductid,
                    "product" => $rows->product,
                    "totalPacket" => $rows->totalPacket,
                    "packtotalKg" => $rows->TotalKg,
                    "packingDate" => $rows->packing_date,
                    "blendref"=>$rows->blending_ref
                    
                );
            }


            return $data;
        } else {
            return $data;
        }
    }
    /**
     * @method getFinishProductPacketDetails
     * @param type $finishProductId
     * @return type
     * @desc get details for edit.
     */
    public function getFinishProductPacketDetails($finishProductId){
        $data = array();

        $sql = "SELECT  
                        `finished_product`.`id` as finisproductid,
                        `finished_product_dtl`.`id` as dtlId,
                        `finished_product`.`productId`,
                        `finished_product_dtl`.`product_packet`,
                        `finished_product_dtl`.`net_in_packet`,
                        `finished_product_dtl`.`numberof_packet`,
                        `product_packet`.`packetid`,
                        `product_packet`.`id` as productPacketId,
                        `packet`.`packet`,`packet`.PacketQty
                FROM `finished_product` INNER JOIN `finished_product_dtl` 
                ON `finished_product`.`id` = `finished_product_dtl`.`finishProductId`
                INNER JOIN `product_packet` ON `finished_product_dtl`.`product_packet` = `product_packet`.`id`
                INNER JOIN `packet` ON `product_packet`.`packetid`= `packet`.`id`
                WHERE `finished_product`.`id`='".$finishProductId."'";

        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {

                $data[] = array(
                    "finishProdId" => $rows->finisproductid,
                    "dtlId" => $rows->dtlId,
                    "Packet" => $rows->packet,
                    "productpacketid"=>$rows->productPacketId,
                    "PacketWeight"=>$rows->PacketQty,
                    "numofpkt" => $rows->numberof_packet,
                    "qtyofpkt" => $rows->net_in_packet,
                );
            }


            return $data;
        } else {
            return $data;
        }
    }

    public function getFinishProductMaster($fid){
        
        $data=array();
        $sql="SELECT 
                `finished_product`.`id`,
                `finished_product`.`productId`,
                `finished_product`.`blended_id`,
                DATE_FORMAT(`finished_product`.`packing_date`,'%d-%m-%Y') AS packing_date,
                `finished_product`.`blended_qty_kg`,
                `finished_product`.consumed_kgs,
                `blending_master`.`blending_ref`,
                `product`.`product`,`finished_product`.`warehouse_id`
            FROM 
                `finished_product`
            INNER JOIN
                `blending_master` ON `finished_product`.`blended_id` = `blending_master`.`id`
            INNER JOIN
                 `product` ON `finished_product`.`productId` = `product`.`id`
            WHERE `finished_product`.`id`='".$fid."'";
         $query = $this->db->query($sql);
         
         if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
                $data=array(
                        "finishproductid"=>$rows->id,
                        "packingdate"=>$rows->packing_date,
                        "blendid"=>$rows->blended_id,
                        "blendref" =>$rows->blending_ref,
                        "blendQty"=>$rows->blended_qty_kg,
                        "blendedStock"=>  $this->getPresentBlendQty($fid,$rows->blended_id),
                        "consumedQty"=>$rows->consumed_kgs,
                        "warehouseId"=>$rows->warehouse_id,
                        "mapedproduct"=>$rows->product,
                        "productid"=>$rows->productId
                );
               
            }


            return $data;
        } else {
            return $data;
        }
         

    }
    /**
     * @name  getPresentBlendQty
     * @param type $fid
     * @param type $blendid
     * @return int
     * @desc getting the blended qty on edit finish product.
     */
    public function getPresentBlendQty($fid,$blendid){
         $sql="SELECT 
                    `blending_master`.`id`,
                    `blending_master`.`blendedKgs`,
                     SUM(`finished_product`.`consumed_kgs`) AS consumed,
                    (IF(`blending_master`.`blendedKgs` IS NULL ,0,`blending_master`.`blendedKgs`) - 
                    IF(SUM(`finished_product`.`consumed_kgs`) IS NULL,0,SUM(`finished_product`.`consumed_kgs`))) AS blendedStock
             FROM `blending_master`
                    LEFT JOIN `finished_product` ON `blending_master`.`id` = `finished_product`.`blended_id` AND `finished_product`.`id`<> '".$fid."'"
                    ." GROUP BY `blending_master`.`id`".
                    "HAVING `blending_master`.`id`='".$blendid."'";
        
        
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $row = $query->row();
            $netBlended = $row->blendedStock;
            return number_format($netBlended,2);
        } else {
            return 0;
        }
        
    }
    
    
}
