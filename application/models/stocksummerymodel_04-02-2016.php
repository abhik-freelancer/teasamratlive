<?php

class stocksummerymodel extends CI_Model {

    public function getStock($groupId) {
        $data = array();
        $whereClause = '';
        if ($groupId == 0) {
           //CALL sp_allgroup_stock
            $call_procedure = "CALL sp_allgroup_stock";
        } else {
            $call_procedure = "CALL sp_groupwise_stock(" . $groupId . ")";
        }

        $query = $this->db->query($call_procedure);
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
                if ($rows->NumberOfStockBag != 0) {
                    $data[] = array(
                        "PbagDtlId" => $rows->purchaseBagDtlId,
                        "Garden" => $rows->garden_name,
                        "Invoice" => $rows->invoice_number,
                        "Group" => $rows->group_code,
                        "Grade" => $rows->grade,
                        "SaleNo" => $rows->sale_number,
                        "Location" => $rows->location,
                        "Numberofbags" => $rows->NumberOfStockBag,
                        "NetBags" => $rows->StockBagQty,
                       // "Qty" => ($rows->NumberOfStockBag * $rows->StockBagQty),
                        "NetKg" => $rows->net,
                        "Rate" => $rows->price,
                        "amount" => ($rows->price) * ($rows->NumberOfStockBag * $rows->StockBagQty)
                    );
                }
            }
           
           
            return $data;
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
