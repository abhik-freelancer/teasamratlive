<?php

class salebillregistermodel extends CI_Model {

   /**
     * @name   getCustomerList
     * @return type
     * @des    getting customer list
     */
   function getCustomerList($session_data)
	{
       $this -> db -> select('customer.id as vid,
							 customer.customer_name,
                                                         customer.telephone,
							 customer.address,
							 customer.pin_number,
							 customer.credit_days,
							 state_master.state_name,
							 customer.account_master_id as amid,
							 account_opening_master.id as aomid,
							 account_opening_master.opening_balance');
	   $this -> db -> from('customer');
	   $this->db->join('account_master', 'customer.account_master_id = account_master.id','INNER');
	   $this->db->join('account_opening_master', 'account_master.id = account_opening_master.account_master_id','LEFT');
	   $this->db->join('state_master', 'customer.state_id = state_master.id','LEFT');
           $this->db->where('account_master.company_id', $session_data['company']);
           $this->db->order_by('customer_name','asc');
	   
	
	   
	   $query = $this -> db -> get();
	   
	    $this->db->last_query();
	
	   if($query -> num_rows() > 0)
	   {
		
		 foreach($query->result() as $rows){
			$data[] = $rows;
		 }
			return $data;
	   }
	   else
	   {
		 return false;
	   }
    }
    
    
    
   /**
     * @name   getSaleBillRegisterList use for getsaleBillRegisterPrint() AND getSalebillRegister()
     * @return type
     * @des    getting saleBill list
     * @date 28.03.2016
     */
    
    
    
    public function getSaleBillRegisterList($value,$compny){
        
        
        if($value['customerId']=="0" && $value['product']=="0"){
             $sql = "SELECT `sale_bill_master`.`id` AS saleBlMastId,
                `sale_bill_master`.`salebillno`,
                DATE_FORMAT(`sale_bill_master`.`salebilldate`,'%d-%m-%Y') AS SaleBlDt,
                DATE_FORMAT(`sale_bill_master`.`duedate`,'%d-%m-%Y') AS DueDt,
                `sale_bill_master`.`taxrateType`,
                `sale_bill_master`.`discountAmount`,
                `sale_bill_master`.`totalamount`,
                `sale_bill_master`.`taxamount`,
                `sale_bill_master`.`grandtotal`,
                `customer`.`customer_name`
                FROM `sale_bill_master`
                INNER JOIN `customer`
                ON `customer`.`id`=`sale_bill_master`.`customerId`
                WHERE (`sale_bill_master`.`salebilldate` BETWEEN '" . date("Y-m-d", strtotime($value['startDate'])) . "' AND '" . date("Y-m-d", strtotime($value['endDate'])) . "') "
                     . "AND  `sale_bill_master`.companyid=".$compny; 
            
        }elseif($value['customerId']=="0" && $value['product']!="0" ){
			
			$sql = "SELECT `sale_bill_master`.`id` AS saleBlMastId,
                `sale_bill_master`.`salebillno`,
                DATE_FORMAT(`sale_bill_master`.`salebilldate`,'%d-%m-%Y') AS SaleBlDt,
                DATE_FORMAT(`sale_bill_master`.`duedate`,'%d-%m-%Y') AS DueDt,
                `sale_bill_master`.`taxrateType`,
                `sale_bill_master`.`discountAmount`,
                `sale_bill_master`.`totalamount`,
                `sale_bill_master`.`taxamount`,
                `sale_bill_master`.`grandtotal`,
                `customer`.`customer_name`
                FROM `sale_bill_master`
				 INNER JOIN
                `sale_bill_details` ON `sale_bill_master`.`id`= `sale_bill_details`.`salebillmasterid`
                INNER JOIN `customer`
                ON `customer`.`id`=`sale_bill_master`.`customerId`
                WHERE (`sale_bill_master`.`salebilldate` BETWEEN '" . date("Y-m-d", strtotime($value['startDate'])) . "' AND '" . date("Y-m-d", strtotime($value['endDate'])) . "') "
                     . " AND  `sale_bill_master`.companyid=".$compny." AND sale_bill_details.`productpacketid`='".$value['product']."'"; 
			
		}
        else if($value['customerId']!="0" && $value['product']=="0"){
             $sql = "SELECT `sale_bill_master`.`id` AS saleBlMastId,
                `sale_bill_master`.`salebillno`,
                DATE_FORMAT(`sale_bill_master`.`salebilldate`,'%d-%m-%Y') AS SaleBlDt,
                 DATE_FORMAT(`sale_bill_master`.`duedate`,'%d-%m-%Y') AS DueDt,
                 `sale_bill_master`.`taxrateType`,
                `sale_bill_master`.`discountAmount`,
                `sale_bill_master`.`totalamount`,
                `sale_bill_master`.`taxamount`,
                `sale_bill_master`.`grandtotal`,
                `customer`.`customer_name`
                FROM `sale_bill_master`
                INNER JOIN `customer`
                ON `customer`.`id`=`sale_bill_master`.`customerId`
                WHERE `sale_bill_master`.`customerId`=".$value['customerId']." AND
                (`sale_bill_master`.`salebilldate` BETWEEN '" . date("Y-m-d", strtotime($value['startDate'])) . "' AND '" . date("Y-m-d", strtotime($value['endDate'])) . "') AND"
                     . " sale_bill_master.companyid=".$compny; 
            
        }else{
			//if both choses.
			
			$custid= $value["customerId"];
			$prodid= $value["product"];
			
			$sql = $sql ="SELECT `sale_bill_master`.`id` AS saleBlMastId,
                `sale_bill_master`.`salebillno`,
                DATE_FORMAT(`sale_bill_master`.`salebilldate`,'%d-%m-%Y') AS SaleBlDt,
                 DATE_FORMAT(`sale_bill_master`.`duedate`,'%d-%m-%Y') AS DueDt,
                 `sale_bill_master`.`taxrateType`,
                `sale_bill_master`.`discountAmount`,
                `sale_bill_master`.`totalamount`,
                `sale_bill_master`.`taxamount`,
                `sale_bill_master`.`grandtotal`,
                `customer`.`customer_name`
                FROM `sale_bill_master` INNER JOIN
                 `sale_bill_details` ON `sale_bill_master`.`id`= `sale_bill_details`.`salebillmasterid`
                INNER JOIN `customer`
                ON `customer`.`id`=`sale_bill_master`.`customerId`
                WHERE `sale_bill_master`.`customerId`=".$value['customerId']." AND
                (`sale_bill_master`.`salebilldate` BETWEEN '" . date("Y-m-d", strtotime($value['startDate'])) . "' AND '" . date("Y-m-d", strtotime($value['endDate'])) . "') AND"
                     . " sale_bill_master.companyid=".$compny." AND sale_bill_details.`productpacketid`='".$prodid."'"; 
		}
        
       
         $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
                $data[] = array(
                    "saleBlMastId" => $rows->saleBlMastId,
                    "salebillno"=>$rows->salebillno,
                    "SaleBlDt"=>$rows->SaleBlDt,
                    "DueDt"=>$rows->DueDt,
                    "customer_name"=>$rows->customer_name,
                    "salebilldetail" => $this->getSalebillDetail($rows->saleBlMastId,$value['product']),
                    "taxrateType"=>$rows->taxrateType,
                    "taxamount"=>$rows->taxamount,
                    "discountAmount"=>$rows->discountAmount,
                    "totalamount"=>$rows->totalamount,
                    "grandtotal"=>$rows->grandtotal
                    
                );
            }

            return $data;
        } else {
            return $data = array();
        }
    }
    
    /*@method getSalebillDetail
     *@param  $id as salebillMasterId
     *@date 28.03.2016
     * 
     */
    
     public function getSalebillDetail($id,$productPacketId=null) {
        $data = array();
        if($productPacketId==0){
		$sql = "SELECT 
         `sale_bill_details`.`id`,
        `sale_bill_details`.`packingbox`,
        `sale_bill_details`.`packingnet`,
        `sale_bill_details`.`quantity`,
        `sale_bill_details`.`rate`,
        `sale_bill_details`.`productpacketid`,
        `product`.`product`,
        `packet`.`packet`,
        CONCAT(`product`.`product`,'-',`packet`.`packet`) AS finalProduct
        FROM `sale_bill_details`
        INNER JOIN `product_packet`
        ON `product_packet`.id=`sale_bill_details`.`productpacketid`
        INNER JOIN `product` ON `product`.`id`=`product_packet`.`productid`
        INNER JOIN  `packet` ON `product_packet`.`packetid`= `packet`.`id`

        WHERE `sale_bill_details`.`salebillmasterid`=".$id;
		}else{
			$sql = "SELECT 
         `sale_bill_details`.`id`,
        `sale_bill_details`.`packingbox`,
        `sale_bill_details`.`packingnet`,
        `sale_bill_details`.`quantity`,
        `sale_bill_details`.`rate`,
        `sale_bill_details`.`productpacketid`,
        `product`.`product`,
        `packet`.`packet`,
        CONCAT(`product`.`product`,'-',`packet`.`packet`) AS finalProduct
        FROM `sale_bill_details`
        INNER JOIN `product_packet`
        ON `product_packet`.id=`sale_bill_details`.`productpacketid`
        INNER JOIN `product` ON `product`.`id`=`product_packet`.`productid`
        INNER JOIN  `packet` ON `product_packet`.`packetid`= `packet`.`id`

        WHERE `sale_bill_details`.`salebillmasterid`=".$id ." AND `sale_bill_details`.`productpacketid`='".$productPacketId."'";
			
		}
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
                $data[] = array(
                    "salebillId" => $rows->id,
                    "packingbox" =>$rows->packingbox,
                    "packingnet" =>$rows->packingnet,
                    "quantity" =>$rows->quantity,
                    "rate" =>$rows->rate,
                    "finalProduct"=>$rows->finalProduct,
                );
            }
            return $data;
        } else {
            return $data;
        }
    }
    
	
	public function getSaleBillRegisterData($fdate,$tdate,$cusid,$compnyId,$yid,$isGST)
	{
		$data = array();
		$sql = "CALL sp_SaleBillRegister('".$fdate."','".$tdate."',".$cusid.",".$compnyId.",".$yid.",'".$isGST."')";
		//echo $sql;
		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
                $data[] = array(
				    "salebillID" => $rows->salebillID,
                    "saleType" => $rows->saleType,
                    "customerName" =>$rows->customerName,
                    "saleBillNo" =>$rows->saleBillNo,
                    "saleBillDate" =>$rows->saleBillDate,
                    "totalQty" =>$rows->totalQty,
                    "taxType"=>$rows->taxType,
                    "taxAmount"=>$rows->taxAmount,
                    "discountAmount"=>$rows->discountAmount,
                    "totalAmount"=>$rows->totalAmount,
                    "grandTotalAmt"=>$rows->grandTotalAmt,
					"gstDiscountAmt"=>$rows->gstDiscountAmt,
					"gstTaxableAmt"=>$rows->gstTaxableAmt,
					"totalIncludedgstAmt"=>$rows->totalIncludedgstAmt,
					"totalCGST"=>$rows->totalCGST,
					"totalSGST"=>$rows->totalSGST,
					"totalIGST"=>$rows->totalIGST,
					"isGST"=>$rows->isGST
				);
            }
		}
		return $data;
	}
    

      
}
?>