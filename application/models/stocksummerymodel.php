<?php

class stocksummerymodel extends CI_Model {
    
    private function getFiscalStartDate($yearId){
        $sql="SELECT financialyear.start_date FROM financialyear WHERE financialyear.id =".$yearId;
        $fiscalStartDate="";
        $query=$this->db->query($sql);
        if($query->num_rows()>0){
            $rows= $query->row();
            $fiscalStartDate = $rows->start_date;
        }
        return $fiscalStartDate;
    }

    public function getStock($groupId,$frmPrice,$toPrice,$companyId,$toDate,$yearId) {
        $data = array();
        $whereClause = '';
        $fiscalStartDate = $this->getFiscalStartDate($yearId);
         
        if ($groupId == 0) {
            
            $call_procedure = "CALL sp_GetStockWithoutGroupAndCost(" . $companyId . ",'".$fiscalStartDate."','".$toDate."')";
            
          
        }
        if($groupId!=0 && $frmPrice=="" && $toPrice==""){
          
            $call_procedure = "CALL sp_GetStockWithGroupWise(".$groupId.",".$companyId.",'".$fiscalStartDate."','".$toDate."')";
        }
        if($groupId==0 && $frmPrice!="" && $toPrice!=""){
         
            $call_procedure = "CALL sp_GetStockWithCostRangeWise(".$frmPrice.",".$toPrice.",".$companyId.",'".$fiscalStartDate."','".$toDate."')";
          
        }
        if($groupId!=0 && $frmPrice!="" && $toPrice!=""){
       
            
            $call_procedure = "CALL sp_GetStockWithGroupAndCost(".$groupId.",".$frmPrice.",".$toPrice.",".$companyId.",'".$fiscalStartDate."','".$toDate."')";
        }
        
        /*else {
            $call_procedure = "CALL sp_groupwise_stock(" . $groupId . ")";
        }*/
        //echo($call_procedure);
               // exit();
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

    public function getStockGroup($groupId,$cmpny) {
        $data = array();
        $Having = '';
         if ($groupId == 0) {
            $call_procedure = "CALL sp_GetAllGroupSumStock(" .$cmpny. ")";
          //  $call_procedure = "CALL sp_allgroup_sum_stock";
        } else {
            $call_procedure = "CALL sp_GetGroupWiseSumStock(".$groupId.",".$cmpny.")";
           // $call_procedure = "CALL sp_groupwise_sum_stock(" . $groupId . ")";
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
