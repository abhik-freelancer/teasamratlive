<?php

class taxinvoicemodel extends CI_Model {

    /**
     * 
     */
     public function getSaleBillList($cid,$yid){
         $data = array();
         $sql = "SELECT
                    sale_bill_master.id,sale_bill_master.salebillno,
                    DATE_FORMAT(sale_bill_master.salebilldate,'%d-%m-%Y') AS salebilldate,
                    sale_bill_master.customerId,sale_bill_master.taxinvoiceno,`customer`.`customer_name`,
                    sale_bill_master.taxinvoicedate,sale_bill_master.duedate,
                    sale_bill_master.taxrateType,sale_bill_master.taxrateTypeId,sale_bill_master.taxamount,
                    sale_bill_master.discountRate,sale_bill_master.discountAmount,
                    sale_bill_master.totalpacket,sale_bill_master.totalquantity,sale_bill_master.totalamount,
                    sale_bill_master.roundoff,sale_bill_master.grandtotal,sale_bill_master.yearid,
                    sale_bill_master.companyid,sale_bill_master.creationdate,sale_bill_master.userid,
                    `customer`.`customer_name`
                    FROM `sale_bill_master`
                INNER JOIN 
                `customer` ON `sale_bill_master`.`customerId` = `customer`.`id`
                where 
                sale_bill_master.companyid=".$cid." and sale_bill_master.yearid=".$yid."";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
                $data[] = array(
                    "saleBillMasterId"=>$rows->id,
                    "customer_name"=>$rows->customer_name,
                    "saleBillNo"=>$rows->salebillno,
                    "saleBillDate"=>$rows->salebilldate,
                    "numberOfpacket"=>$rows->totalpacket,
                    "totalQty"=>$rows->totalquantity,
                    "grandTotal"=>$rows->grandtotal
                );
            }


            return $data;
        } else {
            return $data;
        }
         
         
     }
    
    
    public function SaleBillDetailsPrint($masterId){
        //echo($masterId);
        
        $data = array();
        $sql =" SELECT
                    sale_bill_details.id,
                    sale_bill_details.salebillmasterid,
                    sale_bill_details.productpacketid,
                    round(sale_bill_details.packingbox) AS PackingBox,
                    sale_bill_details.packingnet,
                    sale_bill_details.quantity,
                    sale_bill_details.rate,
                    sale_bill_details.amount,
                    CONCAT(`product`.`product`,'-',`packet`.`packet`) AS productDescription 
            FROM sale_bill_details
            INNER JOIN
            `product_packet` ON `sale_bill_details`.`productpacketid` = `product_packet`.`id`
            INNER JOIN
            `product` ON `product_packet`.`productid` = `product`.`id`
            INNER JOIN
            `packet` ON `product_packet`.`packetid` = `packet`.`id`
            WHERE `sale_bill_details`.`salebillmasterid` = '".$masterId."'";
      
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
                $data[] = array(
                    "ProductDescription" => $rows->productDescription,
                    "Packet" => $rows->PackingBox,
                    "PacketNet"=>$rows->packingnet,
                    "Quantity"=>$rows->quantity,
                    "Rate"=>$rows->rate,
                    "Amount"=>$rows->amount
                );
            }


            return $data;
        } else {
            return $data;
        }
        
    }
    public function SaleBillMasterPrint($masterId){
        $data = array();
        $sql=" SELECT
                    sale_bill_master.id,
                    sale_bill_master.salebillno,
                    DATE_FORMAT(sale_bill_master.salebilldate,'%d-%m-%Y')AS salebilldate,
                    sale_bill_master.customerId,sale_bill_master.taxinvoiceno,
                    DATE_FORMAT(sale_bill_master.taxinvoicedate,'%d-%m-%Y')AS taxinvoicedate,
                    DATE_FORMAT(sale_bill_master.duedate,'%d-%m-%Y') AS duedate,
                    sale_bill_master.taxrateType,sale_bill_master.taxrateTypeId,
                    sale_bill_master.taxamount,sale_bill_master.discountRate,
                    sale_bill_master.discountAmount,sale_bill_master.deliverychgs,sale_bill_master.totalpacket,
                    sale_bill_master.totalquantity,sale_bill_master.totalamount,
                    sale_bill_master.roundoff,sale_bill_master.grandtotal,sale_bill_master.yearid,
                    sale_bill_master.companyid,sale_bill_master.creationdate,sale_bill_master.userid,
                    customer.customer_name,customer.`address`,customer.`cst_number`,customer.`vat_number`,
                    customer.`tin_number`,customer.`pin_number`,customer.`telephone`,
                    
                    `company`.`company_name`,`company`.`location`
                FROM `sale_bill_master`
                INNER JOIN
                `customer` ON `sale_bill_master`.`customerId` = `customer`.`id`
                INNER JOIN
                 `company` ON `sale_bill_master`.`companyid` =`company`.`id`
                WHERE `sale_bill_master`.`id` ='".$masterId."'";
       /* $sql = "SELECT 
                    sale_bill_master.id,
                    sale_bill_master.salebillno,
                    DATE_FORMAT(
                      sale_bill_master.salebilldate,
                      '%d-%m-%Y'
                    ) AS salebilldate,
                    sale_bill_master.customerId,
                    sale_bill_master.taxinvoiceno,
                    DATE_FORMAT(
                      sale_bill_master.taxinvoicedate,
                      '%d-%m-%Y'
                    ) AS taxinvoicedate,
                    DATE_FORMAT(
                      sale_bill_master.duedate,
                      '%d-%m-%Y'
                    ) AS duedate,
                    sale_bill_master.taxrateType,
                    sale_bill_master.taxrateTypeId,
                    sale_bill_master.taxamount,
                    sale_bill_master.discountRate,
                    sale_bill_master.discountAmount,
                    sale_bill_master.deliverychgs,
                    sale_bill_master.totalpacket,
                    sale_bill_master.totalquantity,
                    sale_bill_master.totalamount,
                    sale_bill_master.roundoff,
                    sale_bill_master.grandtotal,
                    sale_bill_master.yearid,
                    sale_bill_master.companyid,
                    sale_bill_master.creationdate,
                    sale_bill_master.userid,
                    customer.customer_name,
                    customer.`address`,
                    customer.`cst_number`,
                    `company`.`company_name`,
                    `company`.`location` 
                  FROM
                    `sale_bill_master` 
                    INNER JOIN `customer` 
                      ON `sale_bill_master`.`customerId` = `customer`.`id` 
                    INNER JOIN `company` 
                      ON `sale_bill_master`.`companyid` = `company`.`id` 
                  WHERE `sale_bill_master`.`id` ='".$masterId."'";*/
        
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
                $data = array(
                    "SaleBillNo" => $rows->salebillno,
                    "SaleBillDate" => $rows->salebilldate,
                    "TaxInvoiceNumber"=>$rows->taxinvoiceno,
                    "TaxInvoiceDate"=>$rows->taxinvoicedate,
                    "DueDate"=>$rows->duedate,
                    "Customer"=>$rows->customer_name,
                    "CustomerAddress"=>$rows->address,
                    "CustomerCST"=>$rows->cst_number,
                    "TotalPacket"=>$rows->totalpacket,
                    "TotalQty"=>$rows->totalquantity,
                    "TotalAmount"=>$rows->totalamount,
                    "TaxRateType"=>$rows->taxrateType,
                    "TaxAmount"=>$rows->taxamount,
                    "DiscountRate"=>$rows->discountRate,
                    "DiscountAmount"=>$rows->discountAmount,
                    "DeliveryChgs"=>$rows->deliverychgs,
                    "RoundOff"=>$rows->roundoff,
                    "GrandTotal"=>$rows->grandtotal,
                    "Company"=>$rows->company_name, 
                    "CompanyLocation"=>$rows->location, 
                    "VatNumber"=>$rows->vat_number,
                    "TinNumber"=>$rows->tin_number,
                    "PinNumber"=>$rows->pin_number,
                    "telephone"=>$rows->telephone
                );
            }


            return $data;
        } else {
            return $data;
        }
        
    }
    
    
    /**
     * @name getPacketProduct
     * @param void
     * @return type array
     * @desc Getting final product
     */
    public function getPacketProduct() {
        $data = array();
        $sql = "SELECT `product_packet`.`id` AS productPacketId,
                     `product`.`product`,
                     `packet`.`packet`,
                      CONCAT(`product`.`product`,'-',`packet`.`packet`) AS finalProduct,
                      `product_packet`.`Sale_rate` AS rate,
                      `product_packet`.`net_kgs` AS nett
              FROM
                     `product`
                      INNER JOIN `product_packet` ON `product`.`id`=`product_packet`.`productid`
                      INNER JOIN  `packet` ON `product_packet`.`packetid`= `packet`.`id`";

        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
                $data[] = array(
                    "productPacketId" => $rows->productPacketId,
                    "finalproduct" => $rows->finalProduct,
                    "rate" => $rows->rate,
                    "net" => $rows->nett,
                );
            }


            return $data;
        } else {
            return $data;
        }
    }
    /**
     * @name   getCustomerList
     * @return type
     * @des    getting customer list
     */

    public function getCustomerList() {
        $data=array();
        $this->db->select('customer.id as customerId,
			    customer.customer_name,
                            customer.telephone,
                            customer.address,
                            customer.pin_number,
                            state_master.state_name,
                            customer.account_master_id as amid,
                            account_opening_master.id as aomid,
                            account_opening_master.opening_balance');
        $this->db->from('customer');
        $this->db->join('account_master', 'customer.account_master_id = account_master.id', 'INNER');
        $this->db->join('account_opening_master', 'account_master.id = account_opening_master.account_master_id', 'LEFT');
        $this->db->join('state_master', 'customer.state_id = state_master.id', 'LEFT');



        $query = $this->db->get();

        if ($query->num_rows() > 0) {

            foreach ($query->result() as $rows) {
                $data[] =array( 
                               "customerId"=> $rows->customerId,
                               "name"=>$rows->customer_name
                    );
            }
            return $data;
        } else {
            return $data;
        }
    }
    /**
     * @name getCurrentvatrate
     * @param type $startYear
     * @param type $endYear
     * @return type
     */
    public function getCurrentvatrate($startYear, $endYear) {
        $sql = "SELECT id, vat_rate FROM vat WHERE from_date BETWEEN '" . $startYear . "' AND '" . $endYear . "'";
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
                $data[] = $rows;
            }

            return $data;
        }
        
    }
    
   /**
    * @name getCurrentcstrate
    * @param type $startYear
    * @param type $endYear
    * @return type
    */ 
   public  function getCurrentcstrate($startYear, $endYear) {
        $sql = "SELECT id, cst_rate FROM cst WHERE from_date BETWEEN '" . $startYear . "' AND '" . $endYear . "'";
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
                $data[] = $rows;
            }

            return $data;
        } else {
            return $data = array();
        }
       
    }
    
    
    /**
     * @name getSaleBillMasterData
     * @param type $saleBillId
     * @return type
     */
    
    public function getSaleBillMasterData($saleBillId){
       $sql="SELECT
                     id,
                        salebillno,
                        DATE_FORMAT(salebilldate, '%d-%m-%Y') AS salebilldate,
                        customerId,
                        taxinvoiceno,
                        DATE_FORMAT(taxinvoicedate,'%d-%m-%Y') AS taxinvoicedate,
                         DATE_FORMAT(duedate,'%d-%m-%Y') AS duedate,
                        taxrateType,
                        taxrateTypeId ,  taxamount ,
                        discountRate , discountAmount ,deliverychgs,
                        totalpacket , totalquantity ,  totalamount , roundoff , 
                        grandtotal ,  yearid , companyid , creationdate ,userid 
            FROM  sale_bill_master WHERE id='".$saleBillId."'";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
                $data = array(
                    "saleBillId" => $rows->id,
                    "saleBillNo" => $rows->salebillno,
                    "salebilldate" => $rows->salebilldate,
                    "customerid"=>$rows->customerId,
                    "taxinvoice"=>$rows->taxinvoiceno,
                    "taxinvoicedate"=>$rows->taxinvoicedate,
                    "duedate"=>$rows->taxinvoicedate,
                    "taxrateType"=>$rows->taxrateType,
                    "taxrateTypeId"=>$rows->taxrateTypeId,
                    "taxamount"=>$rows->taxamount,
                    "discountRate"=>$rows->discountRate,
                    "discountAmount"=>$rows->discountAmount,
                    "deliveryChgs"=>$rows->deliverychgs,
                    "totalpacket"=>$rows->totalpacket,
                    "totalquantity"=>$rows->totalquantity,
                    "totalamount"=>$rows->totalamount,
                    "roundoff"=>$rows->roundoff,
                    "grandtotal"=>$rows->grandtotal
                    
                );
            }


            return $data;
        } else {
            return $data;
        }
        
    }
    
    
    public function getSaleBillDetailData($sBillid){
        $sql="SELECT
                id,
                salebillmasterid,
                productpacketid,
                packingbox,
                packingnet,
                quantity,
                rate,
                amount
                FROM `sale_bill_details`
            WHERE salebillmasterid = '".$sBillid."'";
        
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
                $data[] = array(
                    "saleBillDetailId" => $rows->id,
                    "salebillmasterid" => $rows->salebillmasterid,
                    "productpacketid" => $rows->productpacketid,
                    "packingbox"=>$rows->packingbox,
                    "packingnet"=>$rows->packingnet,
                    "quantity"=>$rows->quantity,
                    "rate"=>$rows->rate,
                    "amount"=>$rows->amount
                    
                );
            }


            return $data;
        } else {
            return $data;
        }
    }
    /**
     * 
     * @param type $saleBillMaster
     * @param type $searcharray
     * @return boolean
     */
    public function insertData($saleBillMaster,$searcharray){
         try {
            $this->db->trans_begin();
            $this->db->insert('sale_bill_master', $saleBillMaster);
            // echo($this->db->last_query());exit;

            $newSaleId = $this->db->insert_id();
            $this->updateSaleBillDetails($newSaleId, $searcharray);

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
    
    public function updateSaleBillDetails($newSaleId,$dtlArr){
        $saleBillDetails = array();
        
        if($dtlArr['txtModeOfoperation']=="Edit"){
            $this->db->where('salebillmasterid', $newSaleId);
            $this->db->delete('sale_bill_details');;
        }
        
        $numberOfDtl = count($dtlArr['txtDetailPacket']);
        for ($i = 0; $i < $numberOfDtl; $i++) {
            $saleBillDetails['salebillmasterid'] = $newSaleId;
            $saleBillDetails['productpacketid'] = $dtlArr['finalproduct'][$i];
            $saleBillDetails['packingbox'] = $dtlArr['txtDetailPacket'][$i];
            $saleBillDetails['packingnet'] = ($dtlArr['txtDetailNet'][$i] == "" ? 0 : $dtlArr['txtDetailNet'][$i]);
            $saleBillDetails['quantity'] = ($dtlArr['txtDetailQuantity'][$i] == "" ? 0 : $dtlArr['txtDetailQuantity'][$i]);
            $saleBillDetails['rate'] = ($dtlArr['txtDetailRate'][$i] == "" ? 0 : $dtlArr['txtDetailRate'][$i]);
            $saleBillDetails['amount'] = ($dtlArr['txtDetailAmount'][$i] == "" ? 0 : $dtlArr['txtDetailAmount'][$i]);

            //if ($dtlArr['txtpacket'][$i] != 0) {
                $this->db->insert('sale_bill_details', $saleBillDetails);
            //}//
        }
    }
    
    
    public function UpdateData($saleBillMaster,$searcharray){
        $SaleBillId = $saleBillMaster['id'];
        unset($saleBillMaster['id']);
  
        try {
             $this->db->where('id', $SaleBillId);
             $this->db->update('sale_bill_master' ,$saleBillMaster);
             $this->updateSaleBillDetails($SaleBillId, $searcharray);

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

	public function get_last_srl_no($cid,$yid)
	{
		$sql="select srl_no from sale_bill_master where companyid=".$cid." and yearid=".$yid." order by srl_no desc limit 1";
		$query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
                $data = array(
                    "saleBilllastsrlno" => $rows->srl_no
                );
            }

            return $data;
        } else {
            return $data;
        }
	}

        public function get_final_product_rate_by_id($fid)
        {
            $data=0;
            $sql="select `product_packet`.`sale_rate`,`product_packet`.`net_kgs` from product_packet where id=".$fid."";
            
	    $query = $this->db->query($sql);
          if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
                $data = array(
                    "sale_rate" => $rows->sale_rate,
                    "net_kgs" => $rows->net_kgs
                );
            }

            return $data;
        } else {
            return $data;
        }
          /*  if ($query->num_rows() > 0)
            {
                $rows=$query->row();
                $data = $rows->sale_rate;

                return $data;
            } else {
                return $data;
            }*/

        }
        
}
