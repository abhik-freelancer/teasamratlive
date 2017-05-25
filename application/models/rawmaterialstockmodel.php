<?php

class rawmaterialstockmodel extends CI_Model{
 
   public function getRawmaterialStockList($fdate,$tdtae,$companyId,$yearId){
       
			$data=array();
		//	$call_procedure = "CALL sp_rawmaterialStockCalcultion(".$companyId.",".$yearId.")";
			$call_procedure = "CALL RawMaterialStock('".$fdate."','".$tdtae."',".$companyId.",".$yearId.")";
			$query = $this->db->query($call_procedure);
         
        
         
          if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
				/*
                $data[] = array( 
                                "rawmaterialId" => $rows->rawmaterialId,
                                "rawmaterial"=>$rows->rawmaterial,
								"unit"=>$rows->unitofmeasurement,	
                                "StockIn"=> $rows->StockIn,
                                "StockOut"=>$rows->StockOut,
								"CuurentStock"=>$rows->CuurentStock
                        );*/
				
				$data[]=array(
					"rawmaterialId" => $rows->rawMaterialID,
                    "rawmaterial"=>$rows->rawMatDesc,
					"unit"=>$rows->rawMatUnit,	
					"opStock"=>$rows->rawMaterialOpening,	
					"purchaseStock"=>$rows->rawMaterialPurchase,	
                    "StockIn"=> $rows->totalStockIN,
                    "StockOut"=>$rows->totalStockOut,
					"CuurentStock"=>$rows->balanceStock
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