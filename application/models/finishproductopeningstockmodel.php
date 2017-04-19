<?php

class finishproductopeningstockmodel extends CI_Model{
    
    
    
    public function getFinishedPrdOPStockList($cmpy,$year){
        
        $sql="SELECT 
            `finished_product_op_stock`.`id`,
            `finished_product_op_stock`.`finished_product_id`,
            `finished_product_op_stock`.`opening_balance`,
            `product_packet`.id AS prdctPacktId,
            CONCAT(`product`.`product`,'-',`packet`.`packet`) AS finalProduct
            FROM `finished_product_op_stock`
            INNER JOIN `product_packet`
            ON `finished_product_op_stock`.`finished_product_id`=`product_packet`.`id`
            INNER JOIN `product` ON `product`.`id`=`product_packet`.`productid`
            INNER JOIN  `packet` ON `product_packet`.`packetid`= `packet`.`id`
            WHERE `finished_product_op_stock`.`company_id`=".$cmpy." AND `finished_product_op_stock`.`year_id`=".$year;
            
        
         $query =$this->db->query($sql);
        if($query->num_rows()> 0){
            foreach ($query->result() as $rows){
                $data[]=array(
                   "id"=>$rows->id,
                   "finalProduct"=>$rows->finalProduct,
                    "opening_balance"=>$rows->opening_balance
                   
                );
            }

          return $data;
        }
        else{
            return $data=array();
        }
    }
    
 
      public function insrtFinishOpStock($data){
       
         try {
            $this->db->trans_begin();
            $this->db->insert('finished_product_op_stock',$data);
            
            //  echo($this->db->last_query());exit;

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
    
    
    
      public function checkExistingFinishedPrd($value){
         $sql = $this->db->select('id')->from('finished_product_op_stock')->where($value)->get();
          if ($sql->num_rows() > 0) {
           
            return TRUE;
        }
        else{
            return FALSE;
        }

      
  }
    
    
    
    /*@method UpdateData()
     * @param $unitMaster
     * @date 18.02.2016
     * @author Mithilesh
     */
    
     public function UpdateFinishedPrdOPStock($rawMatUpd){
        $rawId =  $rawMatUpd['id'] ;
       
         try {
             $this->db->where('id',$rawId);
             $this->db->update('finished_product_op_stock',$rawMatUpd);
            // echo($this->db->last_query());exit;

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
  
    
    /*@method unitlisting()
     * @param 
     * @date 04.04.2016
     * @author Mithilesh
     */
    
      public function ProductPacketList(){
        $sql = "SELECT 
               `product_packet`.id AS prdctPacktId,
                CONCAT(`product`.`product`,'-',`packet`.`packet`) AS product_packet
                FROM `product_packet`
                INNER JOIN `product` ON `product`.`id`=`product_packet`.`productid`
                INNER JOIN  `packet` ON `product_packet`.`packetid`= `packet`.`id`";
        
        $query =$this->db->query($sql);
        if($query->num_rows()> 0){
            foreach ($query->result() as $rows){
                $data[]=array(
                    "prdctPacktId"=>$rows->prdctPacktId,
                   "product_packet"=>$rows->product_packet
                    
                );
            }

          return $data;
        }
        else{
            return $data=array();
        }
        
    }
    
     /*@method getUnitMasterData()
     * @param $unitId
     * @date 18.02.2016
     * @author Mithilesh
     */
    
     public function getFinishdPrdOPstockData($rawId) {

        $sql = "SELECT 
                `finished_product_op_stock`.`finished_product_id`,
                `finished_product_op_stock`.`opening_balance`
               FROM `finished_product_op_stock`
                
                WHERE `finished_product_op_stock`.`id`=".$rawId;
                 $query = $this->db->query($sql);

           
        if($query->num_rows()> 0){
            foreach ($query->result() as $rows){
                $data=array(
                    "finished_product_id"=>$rows->finished_product_id,
                    
                    "opening_balance"=>$rows->opening_balance
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