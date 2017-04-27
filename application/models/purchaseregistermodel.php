<?php
class purchaseregistermodel extends CI_Model {
	
	
	public function getPurchaseRegister($fromDt,$toDt,$vendor,$compny,$year)
	{
		 $data = array();
		 $call_procedure = "CALL SP_PurchaseRegisterAll('".$fromDt."','".$toDt."',".$vendor.",".$compny.",".$year.")";
		  //echo $call_procedure;
		 $query = $this->db->query($call_procedure);
		 $sql = "SELECT * FROM purchaseRegMaster ORDER BY invoiceDate ASC";
		 $query = $this->db->query($sql);
		 
		  if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
                $data[] = array(
                        "invoiceNumber" => $rows->invoiceNumber,
                        "invoiceDate" => $rows->invoiceDate,
                        "totalAmount" => $rows->totalAmount,
                        "roundOff" => $rows->roundOff,
                        "vendorName" => $rows->vendorName
						
                     );
            }
           
           
            return $data;
        } 
        
        else
		{
            return $data;
        }
	}
	
	public function getPurchaseRegSumData()
	{
		$data = array(
            "toatlVAT" => $this->getTotalVatAmountByVATRate(), // getting vat amount by rate
            "totalCST" => $this->getTotalCSTAmountByCSTRate(),
			"totalBrokerage" => $this->getTotalBrokerageAmt(),
			"totalExciseAmt" => $this->getTotalExciseAmt(),
			"totalDiscAmt" => $this->getTotalDiscountAmt()
            );
        return $data;
        
	}
	
	public function getTotalVatAmountByVATRate()
	{
		$data = array();
		 $sql = "SELECT SUM(taxAmount) AS totalVATAmt ,vat.`vat_rate`
				FROM purchaseRegDetail 
				LEFT JOIN vat
				ON vat.`id` = purchaseRegDetail.rateTypeID AND purchaseRegDetail.rateType='V'
				WHERE purchaseRegDetail.rateType='V'
				GROUP BY purchaseRegDetail.rateTypeID , purchaseRegDetail.rateType='V'";
		 $query = $this->db->query($sql);
		  if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
                $data[] = array(
                        "vatAmount" => $rows->totalVATAmt,
                        "vat_rate" => $rows->vat_rate
                    );
            }
           return $data;
        } 
        else
		{
            return $data;
        }
	}
	
	public function getTotalCSTAmountByCSTRate()
	{
		$data = array();
		$sql = "SELECT SUM(taxAmount) AS totalCSTAmt ,cst.`cst_rate`
				FROM purchaseRegDetail 
				LEFT JOIN cst
				ON cst.`id` = purchaseRegDetail.rateTypeID AND purchaseRegDetail.rateType='C'
				WHERE purchaseRegDetail.rateType='C'
				GROUP BY purchaseRegDetail.rateTypeID , purchaseRegDetail.rateType='C'";
		 $query = $this->db->query($sql);
		  if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
                $data[] = array(
                        "cstAmount" => $rows->totalCSTAmt,
                        "cst_rate" => $rows->cst_rate
                    );
            }
           return $data;
        } 
        else
		{
            return $data;
        }
	}
	
	public function getTotalBrokerageAmt()
	{
		$totalBrokerage = 0;
		$sql = "SELECT SUM(brokerage) AS totalBrokerage
				FROM purchaseRegDetail";
		 $query = $this->db->query($sql);
		  if ($query->num_rows() > 0) 
		  {
			  $row = $query->row();
			  $totalBrokerage = $row->totalBrokerage;
               
          } 
		  return $totalBrokerage;
        
	}
	
	public function getTotalExciseAmt()
	{
		$totalExciseAmount = 0;
		$sql = "SELECT SUM(exciseAmt) AS totalExciseAmt
				FROM purchaseRegDetail";
		 $query = $this->db->query($sql);
		  if ($query->num_rows() > 0) 
		  {
			  $row = $query->row();
			  $totalExciseAmount = $row->totalExciseAmt;
               
          } 
		  return $totalExciseAmount;
        
	}
	
	
	public function getTotalDiscountAmt()
	{
		$totalDiscountAmt = 0;
		$sql = "SELECT SUM(discountAmt) AS totalDiscountAmt
				FROM purchaseRegDetail";
		 $query = $this->db->query($sql);
		  if ($query->num_rows() > 0) 
		  {
			  $row = $query->row();
			  $totalDiscountAmt = $row->totalDiscountAmt;
               
          } 
		  return $totalDiscountAmt;
        
	}
	
	public function getVendorNameByID($vendorID)
	{
		$vendor_name = "";
		$sql = "SELECT vendor.`vendor_name` FROM vendor WHERE vendor.`id`=".$vendorID;
		$query = $this->db->query($sql);
		if($query->num_rows()>0)
		{
			$row = $query->row();
			$vendor_name = $row->vendor_name;
		}
		return $vendor_name;
	}
	
}
	
	
	
	
	
	
	
	
