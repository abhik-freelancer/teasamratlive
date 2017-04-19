<?php
    
class productrawmaterialconsumptionmodel extends CI_Model {
    
    
     public function insertData($masterData, $billDetails) {
        
        
        $resultArray=array();
        try {
            $this->db->trans_begin();
            $this->insertDetails($masterData["product_packetId"], $billDetails);

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $result=FALSE;
                return $result;
            } else {
                $this->db->trans_commit();
                 $result=TRUE;
                return $result;
                 
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }
    
    
    private function insertDetails($productPacketId, $billDetails){
        
        $this->db->where("product_packetId",$productPacketId);
        $this->db->delete("product_rawmaterial_consumption");
        
        
           foreach ($billDetails as $row) {
            $data["product_packetId"]= $productPacketId;
            $data["rawmaterialid"] = $row["rawmaterialid"];
            $data["quantity_required"] = $row["quantity_required"];
            $this->db->insert("product_rawmaterial_consumption", $data);
           
          
        }
         
        
    }
    
    public function getRawmaterialConsumption($productPacketId){
        
        $sql ="SELECT 
                `product_rawmaterial_consumption`.`product_packetId`,
                `product_rawmaterial_consumption`.`id`,
                `product_rawmaterial_consumption`.`quantity_required`,
                `product_rawmaterial_consumption`.`rawmaterialid`,
                `raw_material_master`.`product_description`,
                `unitmaster`.`unitName`
              FROM 
                `product_rawmaterial_consumption`
              INNER JOIN
                `raw_material_master` ON `product_rawmaterial_consumption`.`rawmaterialid` = `raw_material_master`.`id`
              LEFT JOIN `unitmaster`
              ON `raw_material_master`.`unitid` = `unitmaster`.`unitid`
              WHERE
              `product_rawmaterial_consumption`.`product_packetId`=".$productPacketId;
        
         $query = $this->db->query($sql);

      
           
        if($query->num_rows()> 0){
            foreach ($query->result() as $rows){
                $data[]=array(
                    "product_packetId"=>$rows->product_packetId,
                    "product_description"=>$rows->product_description,
                    "quantity_required"=>$rows->quantity_required,
                    "unitName"=>$rows->unitName,
                    "rawmaterialid"=>$rows->rawmaterialid
                );
            }

          return $data;
        }
        else{
            return $data=array();
        }
        
    }
    
    
    
    
    
    
  
    
    
}

?>