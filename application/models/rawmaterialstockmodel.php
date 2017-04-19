<?php

class rawmaterialstockmodel extends CI_Model{
 
   public function getRawmaterialStockList($companyId,$yearId){
       
			$data=array();
			$call_procedure = "CALL sp_rawmaterialStockCalcultion(".$companyId.",".$yearId.")";
			$query = $this->db->query($call_procedure);
         
        
         
          if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
                $data[] = array( 
                                 "rawmaterialId" => $rows->rawmaterialId,
                                 "rawmaterial"=>$rows->rawmaterial,
				 "unit"=>$rows->unitofmeasurement,	
                                 "StockIn"=> $rows->StockIn,
                                 "StockOut"=>$rows->StockOut,
				 "CuurentStock"=>$rows->CuurentStock
                        );
            }
            
       //print_r($data);
            return $data;
             $query->free_result();   
        } else {
            return $data;
        }
                 
   
   
   }
}
?>