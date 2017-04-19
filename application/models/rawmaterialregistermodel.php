<?php

class rawmaterialregistermodel extends CI_Model {

   public  function populateVendorList() {
        $sql = "SELECT `id`,`vendor_name` FROM `vendor`";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
                $data[] = $rows;
            }
       
            return $data;
        }
    }
    
   public function getRawMaterialRegisterList($value){
       
       if($value['vendorId']=="0"){
      
          $sql = "SELECT 
               `rawmaterial_purchase_master`.`id` AS rawMatMastId,
              `rawmaterial_purchase_master`.`invoice_no`,
               DATE_FORMAT(`rawmaterial_purchase_master`.`invoice_date`,'%d-%m-%Y') AS invoiceDt,
               `rawmaterial_purchase_master`.`taxrateType`,
               `rawmaterial_purchase_master`.`taxamount`,
               `rawmaterial_purchase_master`.`excise_amount`,
               `rawmaterial_purchase_master`.`item_amount`,
               `rawmaterial_purchase_master`.`invoice_value`,
               `vendor`.`vendor_name`
               FROM `rawmaterial_purchase_master`
               INNER JOIN `vendor`
               ON `vendor`.`id`=`rawmaterial_purchase_master`.`vendor_id` 
               WHERE (`rawmaterial_purchase_master`.`invoice_date` BETWEEN '" . date("Y-m-d", strtotime($value['startDate'])) . "' AND '" . date("Y-m-d", strtotime($value['endDate'])) . "')"; 
        
       }
       else{
            $sql = "SELECT 
               `rawmaterial_purchase_master`.`id` AS rawMatMastId,
              `rawmaterial_purchase_master`.`invoice_no`,
               DATE_FORMAT(`rawmaterial_purchase_master`.`invoice_date`,'%d-%m-%Y') AS invoiceDt,
               `rawmaterial_purchase_master`.`taxrateType`,
               `rawmaterial_purchase_master`.`taxamount`,
               `rawmaterial_purchase_master`.`excise_amount`,
               `rawmaterial_purchase_master`.`item_amount`,
               `rawmaterial_purchase_master`.`invoice_value`,
               `vendor`.`vendor_name`
               FROM `rawmaterial_purchase_master`
               INNER JOIN `vendor`
               ON `vendor`.`id`=`rawmaterial_purchase_master`.`vendor_id` 
               WHERE `rawmaterial_purchase_master`.`vendor_id`=".$value['vendorId']." AND
                (`rawmaterial_purchase_master`.`invoice_date` BETWEEN '" . date("Y-m-d", strtotime($value['startDate'])) . "' AND '" . date("Y-m-d", strtotime($value['endDate'])) . "')"; 
           
       }
       
         $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
                $data[] = array(
                    "rawMatMastId"=>$rows->rawMatMastId,
                    "invoice_no" => $rows->invoice_no,
                    "invoiceDt"=>$rows->invoiceDt,
                    "taxrateType"=>$rows->taxrateType,
                    "taxamount"=>$rows->taxamount,
                    "excise_amount"=>$rows->excise_amount,
                    "item_amount" =>$rows->item_amount,
                    "invoice_value"=>$rows->invoice_value,
                    "vendor_name"=>$rows->vendor_name,
                    "rawMtPurchaseDtl"=>$this->getRawMatPurchaseDetail($rows->rawMatMastId)
                );
            }

            return $data;
        } else {
            return $data = array();
        }
    }
    
   public function getRawMatPurchaseDetail($id){
       $sql = "SELECT 
             `raw_material_master`.`product_description`,
             `rawmaterial_purchasedetail`.`id` AS rawmatpurchDtlId,
             `rawmaterial_purchasedetail`.`amount`,
             `rawmaterial_purchasedetail`.`quantity`,
             `rawmaterial_purchasedetail`.`rate`
              FROM `rawmaterial_purchasedetail`
              INNER JOIN `raw_material_master`
              ON `raw_material_master`.id=`rawmaterial_purchasedetail`.`productid`
              WHERE `rawmaterial_purchasedetail`.`rawmat_purchase_masterId`=".$id;
       
         $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
                $data[] = array(
                    "product_description" => $rows->product_description,
                    "rawmatpurchDtlId"=>$rows->rawmatpurchDtlId,
                    "amount"=>$rows->amount,
                    "quantity"=>$rows->quantity,
                    "rate"=>$rows->rate
                    
                );
            }

            return $data;
        } else {
            return $data = array();
        }
       
   }
      
}
?>