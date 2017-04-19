<?php

class stocksummerymodel extends CI_Model {

    public function getStock($groupId,$frmPrice,$toPrice,$companyId) {
        $data = array();
        $whereClause = '';
         
        if ($groupId == 0) {
            
            $call_procedure = "CALL sp_GetStockWithoutGroupAndCost(" . $companyId . ")";
          
        }
        if($groupId!=0 && $frmPrice=="" && $toPrice==""){
          
            $call_procedure = "CALL sp_GetStockWithGroupWise(".$groupId.",".$companyId.")";
        }
        if($groupId==0 && $frmPrice!="" && $toPrice!=""){
         
            $call_procedure = "CALL sp_GetStockWithCostRangeWise(".$frmPrice.",".$toPrice.",".$companyId.")";
          
        }
        if($groupId!=0 && $frmPrice!="" && $toPrice!=""){
       
            
            $call_procedure = "CALL sp_GetStockWithGroupAndCost(".$groupId.",".$frmPrice.",".$toPrice.",".$companyId.")";
        }
        
        /*else {
            $call_procedure = "CALL sp_groupwise_stock(" . $groupId . ")";
        }*/

        $query = $this->db->query($call_procedure);
        
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
                                /* if ($rows->NumberOfStockBag != 0) {
                                     $data[] = array(
                                         "PbagDtlId" => $rows->purchaseBagDtlId,
                                         "Garden" => $rows->garden_name,
                                         "Invoice" => $rows->invoice_number,
                                         "lot" => $rows->lot,
                                         "Group" => $rows->group_code,
                                         "Grade" => $rows->grade,
                                         "SaleNo" => $rows->sale_number,
                                         "Location" => $rows->location,
                                         "Numberofbags" => $rows->NumberOfStockBag,
                                         "NetBags" => $rows->StockBagQty,
                                        // "Qty" => ($rows->NumberOfStockBag * $rows->StockBagQty),
                                         "NetKg" => $rows->net,
                                         "Rate" => $rows->price,
                                         "costOfTea" =>$rows->cost_of_tea,
                                        // "amount" => ($rows->price) * ($rows->NumberOfStockBag * $rows->StockBagQty)
                                        // "amount" => ($rows->price *  $rows->StockBagQty)
                                         "amount" => ($rows->cost_of_tea *  $rows->StockBagQty)
                                     );
                                 }*/
                
                if($rows->NumberOfStockBag!=0){
                    $data[] = array(
                        "pInvDtlId" => $rows->purchaseInvoiceDetailId,
                        "Garden" => $rows->garden_name,
                        "Invoice" => $rows->invoice_number,
                        "lot" => $rows->lot,
                        "Group" => $rows->group_code,
                        "Grade" => $rows->grade,
                        "SaleNo" => $rows->sale_number,
                        "Location" => $rows->location,
                        "Numberofbags" => $rows->NumberOfStockBag,
                        "NetBags" => $rows->StockBagQty,
                        "NetKg" => $rows->netKgs,
                        "Rate" => $rows->rate,
                        "costOfTea" => $rows->cost_of_tea,
                        "amount" => ($rows->cost_of_tea * $rows->StockBagQty)
                     );
                }
                
            }
           
           
            return $data;
        } 
        
        else {
            return $data;
        }
    }
    
    /**
     * ABHIK
     * temporay stock table call
     * @param type $groupId
     * @return type
     */
    public function getTempStockTable(){
        $data=array();
         $call_procedure = "CALL sp_Stock()";
         $query = $this->db->query($call_procedure);
         
         //echo $sql="SELECT * FROM StockTable";
        // $query1 = $this->db->query($sql);
         
          if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
                $data[] = array( 
                                 "purchaseBagDtlId" => $rows->belendedBag,
                                 "purchasedBag"=>$rows->blendkg,
                                 "purchasedKg"=> $rows->purchasedKg,
                                 "blendedBag"=>$rows->blendedBag
                        );
            }
            
       print_r($data);
            //return $data;
        } else {
            return $data;
        }
                 
    }

    public function getStockGroup($groupId) {
        $data = array();
        $Having = '';
         if ($groupId == 0) {
            $call_procedure = "CALL sp_allgroup_sum_stock";
        } else {
            $call_procedure = "CALL sp_groupwise_sum_stock(" . $groupId . ")";
        }

       




        $query = $this->db->query($call_procedure);

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
                $data[] = array( 
                                 "teagroup_master_id" => $rows->teagroup_master_id,
                                 "group_code"=>$rows->group_code,
                                 "noOfBaginStock"=> $rows->NumberOfStockBag,
                                 "StockBagQty"=>$rows->StockBagQty
                        );
            }
            
       
            return $data;
        } else {
            return $data;
        }
    }

}
