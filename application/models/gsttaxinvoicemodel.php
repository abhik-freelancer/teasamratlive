<?php

class gsttaxinvoicemodel extends CI_Model {

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
                    sale_bill_master.totalpacket,sale_bill_master.totalquantity,sale_bill_master.totalamount,
                    sale_bill_master.roundoff,sale_bill_master.grandtotal,sale_bill_master.yearid,
                    sale_bill_master.companyid,sale_bill_master.creationdate,sale_bill_master.userid,
                    `customer`.`customer_name`
                    FROM `sale_bill_master`
                INNER JOIN 
                `customer` ON `sale_bill_master`.`customerId` = `customer`.`id`
                WHERE 
                sale_bill_master.companyid=".$cid." AND sale_bill_master.yearid=".$yid." 
			 AND sale_bill_master.IsGST ='Y'	
                ORDER BY sale_bill_master.salebillno,sale_bill_master.salebilldate DESC";
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
    /**
     * @method getGSTrate
     * @param type $companyId
     * @param type $yearId
     * @param type $type
     * @param type $usedfor
     * @return type gstData
     */
     public function getGSTrate($companyId,$yearId,$type=NULL,$usedfor=NULL){
         $gstData=array();
         $sql="SELECT gstmaster.*
                FROM gstmaster WHERE
                gstmaster.gstType ='".$type."' AND gstmaster.usedfor='".$usedfor."'
                AND gstmaster.companyid=".$companyId." AND gstmaster.yearId=".$yearId;
         $query = $this->db->query($sql);
         if($query->num_rows()>0){
             foreach ($query->result() as $rows) {
                 $gstData[]=array(
                     "id"=>$rows->id,
                     "gstDescription"=>$rows->gstDescription,
                     "gstType"=>$rows->gstType,
                     "rate"=>$rows->rate,
                     "accountId"=>$rows->accountId,
                     "companyid"=>$rows->companyid,
                     "yearId"=>$rows->yearId,
                     "usedfor"=>$rows->usedfor
                 );
             }
         }
        return $gstData;
         
     }
     
     public function getRate($id,$type){
         $rate=0;
          $sql = "SELECT gstmaster.rate
                FROM gstmaster WHERE gstmaster.id='".$id."' AND gstmaster.gstType='".$type."'";
         $query = $this->db->query($sql);
          if($query->num_rows()>0){
              $rows=$query->row();
              $rate =$rows->rate;
          }
          return $rate;
     }
    
    public function SaleBillDetailsPrint($masterId){
        //echo($masterId);
        
        $data = array();
    /*    $sql ="SELECT
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
            WHERE `sale_bill_details`.`salebillmasterid` = '".$masterId."'"; */
			
		
		$sql = "SELECT
				 sale_bill_details.id,
				 sale_bill_details.salebillmasterid,
				 sale_bill_details.`HSN`,
				 sale_bill_details.productpacketid,
				 ROUND(sale_bill_details.packingbox) AS PackingBox,
				 sale_bill_details.packingnet,
				 sale_bill_details.quantity,
				 sale_bill_details.rate,
				 sale_bill_details.amount,
				 sale_bill_details.`discount`,
				 sale_bill_details.taxableamount,
				 sale_bill_details.`cgstamount`,
				 sale_bill_details.`cgstrateid`,
				 sale_bill_details.`sgstamount`,
				 sale_bill_details.`sgstrateid`,
				 sale_bill_details.`igstamount`,
				 sale_bill_details.`igstrateid`,
				 CONCAT(`product`.`product`,'-',`packet`.`packet`) AS productDescription 
				 FROM sale_bill_details
				 INNER JOIN
				 `product_packet` ON `sale_bill_details`.`productpacketid` = `product_packet`.`id`
				 INNER JOIN
				 `product` ON `product_packet`.`productid` = `product`.`id`
				 INNER JOIN
				 `packet` ON `product_packet`.`packetid` = `packet`.`id`
				WHERE `sale_bill_details`.`salebillmasterid` =".$masterId;
	
      
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
                $data[] = array(
                    "ProductDescription" => $rows->productDescription,
                    "HSN" => $rows->HSN,
                    "Packet" => $rows->PackingBox,
                    "PacketNet"=>$rows->packingnet,
                    "Quantity"=>$rows->quantity,
                    "Rate"=>$rows->rate,
                    "Amount"=>$rows->amount,
					"Discount"=>$rows->discount,
					"Taxableamount"=>$rows->taxableamount,
					"cgstamount"=>$rows->cgstamount,
					"sgstamount"=>$rows->sgstamount,
					"igstamount"=>$rows->igstamount,
					"cgstRate" =>$this->getRate($rows->cgstrateid,'CGST'),
					"sgstRate" =>$this->getRate($rows->sgstrateid,'SGST'),
					"igstRate" =>$this->getRate($rows->igstrateid,'IGST')
                );
            }


            return $data;
        } else {
            return $data;
        }
        
    }
	
    public function SaleBillMasterPrint($masterId){
        $data = array();
        $sql="SELECT 
				  sale_bill_master.id,
				  sale_bill_master.salebillno,
				  DATE_FORMAT(sale_bill_master.salebilldate,'%d-%m-%Y' ) AS salebilldate,
				  sale_bill_master.customerId,
				  sale_bill_master.taxinvoiceno,
				  DATE_FORMAT(sale_bill_master.taxinvoicedate,'%d-%m-%Y') AS taxinvoicedate,
				  DATE_FORMAT(sale_bill_master.duedate,'%d-%m-%Y') AS duedate,
				  sale_bill_master.vehichleno,
				  sale_bill_master.totalpacket,
				  sale_bill_master.totalquantity,
				  sale_bill_master.totalamount,
				  sale_bill_master.grandtotal,
				  sale_bill_master.yearid,
				  sale_bill_master.companyid,
				  sale_bill_master.creationdate,
				  sale_bill_master.userid,
				  sale_bill_master.GST_placeofsupply,
				  customer.customer_name,
				  customer.`address`,
				  customer.`GST_Number` as customerGSTNo,
				  customer.`tin_number`,
				  customer.`pin_number`,
				  customer.`telephone`,
				  `company`.`company_name`,
				  `company`.`location`,
				   company.`gst_number` AS GSTNumber,
				   state_master.`state_name`,
				   transport.`name` AS transporterName,
				   transport.`address` AS transporterAddrs
				 FROM
					`sale_bill_master` 
					INNER JOIN `customer` 
					ON `sale_bill_master`.`customerId` = `customer`.`id` 
					INNER JOIN `company` 
					ON `sale_bill_master`.`companyid` = `company`.`id` 
					LEFT JOIN state_master
					ON customer.`state_id` = state_master.`id`
					LEFT JOIN transport
					ON transport.`id`=sale_bill_master.`transporterId`
				WHERE `sale_bill_master`.`id`=".$masterId;
     
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
                $data = array(
                    "SaleBillNo" => $rows->salebillno,
                    "SaleBillDate" => $rows->salebilldate,
                    "TaxInvoiceNumber"=>$rows->taxinvoiceno,
                    "TaxInvoiceDate"=>$rows->taxinvoicedate,
                    "DueDate"=>$rows->duedate,
                    "vehichleno"=>$rows->vehichleno,
                    "Customer"=>$rows->customer_name,
                    "CustomerAddress"=>$rows->address,
                    "TotalPacket"=>$rows->totalpacket,
                    "TotalQty"=>$rows->totalquantity,
                    "TotalAmount"=>$rows->totalamount,
                    "GrandTotal"=>$rows->grandtotal,
                    "Company"=>$rows->company_name, 
                    "CompanyLocation"=>$rows->location, 
					"CompanyGSTIN" => $rows->GSTNumber,
                    "TinNumber"=>$rows->tin_number,
                    "PinNumber"=>$rows->pin_number,
                    "telephone"=>$rows->telephone,
                    "customerGSTNo"=>$rows->customerGSTNo,
					"custStatename" => $rows->state_name,
					"transporterName" => $rows->transporterName,
					"transporterAddrs" => $rows->transporterAddrs,
					"GST_placeofsupply" => $rows->GST_placeofsupply
                );
            }


            return $data;
        } else {
            return $data;
        }
        
    }
    
    
    /*@method checkExistingSalebillNumb
     *@date 17-06-2016
     * @by Mithilesh 
     */
    
   
     public function checkExistingSalebillNumb($salebillno,$cmpny,$yrid){
         
         $data=array(
             "salebillno"=>$salebillno,
             "companyid"=> $cmpny,
             "yearid"=> $yrid
         );
         
         $sql = $this->db->select('id')->from('sale_bill_master')->where($data)->get();
          if ($sql->num_rows() > 0) {
           
            return TRUE;
        }
        else{
            return FALSE;
        }

      
  }
  
  /*@method getlastSaleBillNo
   *@date 17-06-2016
   * @by Mithilesh 
   */
  public function getlastSaleBillNo($compy,$yearid){
      $data = array();
      $sql = "SELECT sale_bill_master.`salebillno` AS LastsaleBillNo FROM sale_bill_master  
              WHERE `sale_bill_master`.`companyid`=".$compy." AND `sale_bill_master`.`yearid`=".$yearid." 
              ORDER BY SUBSTR(sale_bill_master.salebillno, 4, 5) DESC LIMIT 1";
      
        
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
                $data = array(
                    "lastsalebillno" => $rows->LastsaleBillNo
                   
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
                      INNER JOIN  `packet` ON `product_packet`.`packetid`= `packet`.`id` ORDER BY product";

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
        $session_data = sessiondata_method();
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
        $this->db->where('account_master.company_id', $session_data['company']);
        $this->db->order_by("customer_name", "asc");



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
  /*  public function getCurrentvatrate($startYear, $endYear) {
        $sql = "SELECT id, vat_rate FROM vat WHERE from_date BETWEEN '" . $startYear . "' AND '" . $endYear . "'";
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
                $data[] = $rows;
            }

            return $data;
        }
        
    }*/
    
    public function getCurrentvatrate() {
        $sql = "SELECT id, vat_rate FROM vat WHERE vat.is_active='Y' ORDER BY vat_rate";
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
   /*public  function getCurrentcstrate($startYear, $endYear) {
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
       
    }*/
    
    public  function getCurrentcstrate() {
        $sql = "SELECT id, cst_rate FROM cst WHERE cst.is_active='Y' ORDER BY cst_rate";
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
     
 $sql= "SELECT
            id,  srl_no,  salebillno,GST_placeofsupply,
            DATE_FORMAT(salebilldate,'%d-%m-%Y') as salebilldate,
            customerId,  taxinvoiceno,  
            DATE_FORMAT(taxinvoicedate,'%d-%m-%Y') AS taxinvoicedate,
            voucher_master_id,  vehichleno,transporterId,
            DATE_FORMAT(duedate,'%d-%m-%Y') AS duedate,
            taxrateType,  taxrateTypeId,  taxamount,
            discountRate,  discountAmount,  deliverychgs,
            totalpacket,  totalquantity,  totalamount,
            roundoff,  grandtotal,  yearid,
            companyid,  creationdate,
            userid,  GST_Discountamount,  GST_Taxableamount,
            GST_Totalgstincluded,  GST_Freightamount,
            GST_Insuranceamount,  GST_PFamount,
            totalCGST,  totalSGST,  totalIGST,  IsGST
            FROM sale_bill_master WHERE sale_bill_master.id=".$saleBillId." AND sale_bill_master.IsGST ='Y'";
       
       
       
       
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
                $data = array(
                    "saleBillId" => $rows->id,
                    "saleBillNo" => $rows->salebillno,
                    "salebilldate" => $rows->salebilldate,
                    "customerid"=>$rows->customerId,
                    "voucher_master_id"=>$rows->voucher_master_id,
                    "taxinvoice"=>$rows->taxinvoiceno,
                    "taxinvoicedate"=>$rows->taxinvoicedate,
                    "duedate"=>$rows->duedate,
                    "vehichleno"=>$rows->vehichleno,
					"transporterId" => $rows->transporterId,
                    "GST_placeofsupply" =>$rows->GST_placeofsupply,
                    "totalpacket"=>$rows->totalpacket,
                    "totalquantity"=>$rows->totalquantity,
                    "totalamount"=>$rows->totalamount,
                    "roundoff"=>$rows->roundoff,
                    "grandtotal"=>$rows->grandtotal,
                    "GST_Discountamount"=>$rows->GST_Discountamount,
                    "GST_Taxableamount"=>$rows->GST_Taxableamount,
                    "GST_Totalgstincluded"=>$rows->GST_Totalgstincluded,
                    "GST_Freightamount"=>$rows->GST_Freightamount,
                    "GST_Insuranceamount"=>$rows->GST_Insuranceamount,
                    "GST_PFamount"=>$rows->GST_PFamount,
                    "totalCGST"=>$rows->totalCGST,
                    "totalSGST"=>$rows->totalSGST,
                    "totalIGST"=>$rows->totalIGST
                    
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
                HSN,
                productpacketid,
                packingbox,
                packingnet,
                quantity,
                rate,
                amount,
                discount,
                taxableamount,
                cgstrateid,
                cgstamount,
                sgstrateid,
                sgstamount,
                igstrateid,
                igstamount
            FROM sale_bill_details WHERE sale_bill_details.salebillmasterid =".$sBillid;
        
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
                $data[] = array(
                    "saleBillDetailId" => $rows->id,
                    "salebillmasterid" => $rows->salebillmasterid,
                    "HSN"=>$rows->HSN,
                    "productpacketid" => $rows->productpacketid,
                    "packingbox"=>$rows->packingbox,
                    "packingnet"=>$rows->packingnet,
                    "quantity"=>$rows->quantity,
                    "rate"=>$rows->rate,
                    "amount"=>$rows->amount,
                    "discount"=>$rows->discount,
                    "taxableamount"=>$rows->taxableamount,
                    "cgstrateid"=>$rows->cgstrateid,
                    "cgstamount"=>$rows->cgstamount,
                    "sgstrateid"=>$rows->sgstrateid,
                    "sgstamount"=>$rows->sgstamount,
                    "igstrateid"=>$rows->igstrateid,
                    "igstamount"=>$rows->igstamount
                    
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
    public function insertData($voucherMast,$searcharray ,$srl_no){
         try {
                
                  $session = sessiondata_method();
                  $this->db->trans_begin();
                  
                  $voucherMast['voucher_number'] =  $this->getSerialNumber($session['company'], $session['yearid']);
                  $salebillno = $voucherMast['voucher_number'];
                  
                  $this->db->insert('voucher_master', $voucherMast);
                  $vMastId = $this->db->insert_id();
                  $this->insertintoVouchrDtl($vMastId,$searcharray);
            
                  $this->insertintoSaleBillMaster($searcharray,$vMastId,$srl_no,$salebillno);
                    
                    
                    $newSaleId = $this->db->insert_id();
                    $this->updateSaleBillDetails($newSaleId, $searcharray);
                    $this->insertBillMaster($newSaleId, $searcharray);
					

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
    private function getSerialNumber($company,$year){
        $lastnumber = (int)(0);
        $tag = "";
        $noofpaddingdigit = (int)(0);
        $autoSaleNo="";
        $yeartag ="";
        $sql="SELECT
                id,
                SERIAL,
                moduleTag,
                lastnumber,
                noofpaddingdigit,
                module,
                companyid,
                yearid,
                yeartag
            FROM serialmaster
            WHERE companyid=".$company." AND yearid=".$year." AND module='SLGST' LOCK IN SHARE MODE";
        
                  $query = $this->db->query($sql);
		  if ($query->num_rows() > 0) {
			  $row = $query->row(); 
			  $lastnumber = $row->lastnumber;
                          $tag = $row->moduleTag;
                          $noofpaddingdigit = $row->noofpaddingdigit;
                          $yeartag = $row->yeartag;
                          
                          
		  }
          $digit = (int)(log($lastnumber,10)+1) ;  
          if($digit==5){
              $autoSaleNo = $tag."/".$lastnumber."/".$yeartag;
          }elseif ($digit==4) {
              $autoSaleNo = $tag."/0".$lastnumber."/".$yeartag;
            
        }elseif($digit==3){
            $autoSaleNo = $tag."/00".$lastnumber."/".$yeartag;
        }elseif($digit==2){
            $autoSaleNo = $tag."/000".$lastnumber."/".$yeartag;
        }elseif($digit==1){
            $autoSaleNo = $tag."/0000".$lastnumber."/".$yeartag;
        }
        $lastnumber = $lastnumber + 1;
        
        //update
        $data = array(
        'SERIAL' => $lastnumber,
        'lastnumber' => $lastnumber
        );
        $array = array('companyid' => $company, 'yearid' => $year, 'module' => "SLGST");
        $this->db->where($array); 
        $this->db->update('serialmaster', $data);
        
        return $autoSaleNo;
        
    }
    
    
    public function insertBillMaster($newSaleId, $searcharray){
        
        $session = sessiondata_method();
        $billMasterArray["billdate"]=date("Y-m-d", strtotime($searcharray['saleBillDate']));
        $billMasterArray["billamount"]=$searcharray['txtGrandTotal'];
        $billMasterArray["invoicemasterid"]=$newSaleId;
        $billMasterArray["saletype"]="T";
        $billMasterArray["customeraccountid"]=  $this->getCustomerAccId($searcharray['customer'], $session['company']);
        $billMasterArray["companyid"]=$session['company'];
        $billMasterArray["yearid"]=$session['yearid'];
        $this->db->insert('customerbillmaster', $billMasterArray);
        
    }
    
    
    /*@method insertintoSaleBillMaster
     * @date 01-06-2016
     * By Mithilesh
     */
     public function insertintoSaleBillMaster($searcharray,$vMastId,$slno,$salebillno){
            $session = sessiondata_method();
           $saleBillMaster = array();
         
            $saleBillMaster['srl_no'] = 1;
            $saleBillMaster['salebillno'] = $salebillno;
            $saleBillMaster['salebilldate'] = date("Y-m-d", strtotime($searcharray['saleBillDate']));
            $saleBillMaster['voucher_master_id'] = $vMastId;
            $saleBillMaster["GST_placeofsupply"]=$searcharray["placeofsupply"];
            $saleBillMaster['customerId'] = $searcharray['customer'];
            $saleBillMaster['taxinvoiceno'] =  $salebillno;
            $saleBillMaster['taxinvoicedate'] = date("Y-m-d", strtotime($searcharray['saleBillDate']));
            $saleBillMaster['duedate'] = date("Y-m-d", strtotime($searcharray['txtDueDate']));
            $saleBillMaster['vehichleno'] = $searcharray['vehichleno'];
            $saleBillMaster['transporterId'] = $searcharray['transporter'];
            
            
			$saleBillMaster['GST_Taxableamount'] = $searcharray['txtTaxableAmount'];
            $saleBillMaster['GST_Discountamount'] = $searcharray['txtDiscountAmount'];
            $saleBillMaster['totalpacket'] = $searcharray['txtTotalPacket'];
            $saleBillMaster['totalquantity'] = $searcharray['txtTotalQty'];
            $saleBillMaster['totalamount'] = $searcharray['txtTotalAmount'];
            $saleBillMaster['GST_Totalgstincluded']= $searcharray['txtTotalIncldTaxAmt'];
            $saleBillMaster['GST_Freightamount']= $searcharray['txtFreight'];
            $saleBillMaster['GST_Insuranceamount']= $searcharray['txtInsurance'];
            $saleBillMaster['GST_PFamount']= $searcharray['txtPckFrw'];
            $saleBillMaster['totalCGST']= $searcharray['txtTotalCGST'];
            $saleBillMaster['totalSGST']= $searcharray['txtTotalSGST'];
            $saleBillMaster['totalIGST']= $searcharray['txtTotalIGST'];
            $saleBillMaster['roundoff']=$searcharray['txtRoundOff'];
            $saleBillMaster['grandtotal'] = $searcharray['txtGrandTotal'];
            
            $saleBillMaster['yearid'] = $session['yearid'];
            $saleBillMaster['companyid'] = $session['company'];
            $saleBillMaster['creationdate'] = date("Y-m-d");
            $saleBillMaster['userid'] = $session['user_id'];
            $saleBillMaster['IsGST']='Y';
            
            $this->db->insert('sale_bill_master', $saleBillMaster);
     }
    
    
    /*@method insertintoVouchrDtl
     * @date 01-06-2016
     * @By Mithilesh
     */
        public function insertintoVouchrDtl($vMastId,$searcharray){
            
            $this->deleteVoucherDetailData($vMastId);
            
       $session = sessiondata_method();
       $vouchrDtlCus = array();
       $vouchrDtlSale =array();
       $vouchrDtlVat = array();
          
       $cusAccId = $this->getCustomerAccId($searcharray['customer'],$session['company']);
       $saleAccId = $this->getSaleAccId($session['company']);
       $vatAccId = $this->getVatAccId($session['company']);
       
       $totalAmt =$searcharray['txtGrandTotal']; // For Cuss acc Debt
       
       $saleAmt = $searcharray['txtTaxableAmount']+ $searcharray["txtRoundOff"];
       //$saleAmt = $sAmount - $searcharray['txtDiscountAmount']; // for sale
//       $vatAmt = $searcharray['txtTaxAmount']; // for vat
       
       
       
       //For Customer Acc
       $vouchrDtlCus['voucher_master_id'] = $vMastId;
       $vouchrDtlCus['account_master_id'] = $cusAccId;
       $vouchrDtlCus['voucher_amount'] = $totalAmt;
       $vouchrDtlCus['is_debit'] ='Y' ;
       $vouchrDtlCus['account_id_for_trial'] = NULL;
       $vouchrDtlCus['subledger_id'] = NULL;
       $vouchrDtlCus['is_master'] = NULL;
       $this->db->insert('voucher_detail', $vouchrDtlCus);
       
        //For Sale Acc
       $vouchrDtlSale['voucher_master_id'] = $vMastId;
       $vouchrDtlSale['account_master_id'] = $saleAccId;
       $vouchrDtlSale['voucher_amount'] = $saleAmt;
       $vouchrDtlSale['is_debit'] ='N' ;
       $vouchrDtlSale['account_id_for_trial'] = NULL;
       $vouchrDtlSale['subledger_id'] = NULL;
       $vouchrDtlSale['is_master'] = NULL;
       $this->db->insert('voucher_detail', $vouchrDtlSale);
       
       //for freight
       $sql="SELECT othercharges.accountid 
             FROM othercharges
             WHERE  othercharges.description ='Freight'
             AND othercharges.companyid = ".$session['company'];
       $frghtAccid = $this->db->query($sql)->row()->accountid;
       
       $vouchrDtlSale['voucher_master_id'] = $vMastId;
       $vouchrDtlSale['account_master_id'] = $frghtAccid;
       $vouchrDtlSale['voucher_amount'] =$searcharray['txtFreight'];
       $vouchrDtlSale['is_debit'] ='N' ;
       $vouchrDtlSale['account_id_for_trial'] = NULL;
       $vouchrDtlSale['subledger_id'] = NULL;
       $vouchrDtlSale['is_master'] = NULL;
       if($searcharray['txtFreight']!=""){
       $this->db->insert('voucher_detail', $vouchrDtlSale);
       }
       
       
       //for Insurance
       $sql="SELECT othercharges.accountid 
             FROM othercharges
             WHERE  othercharges.description ='Insurance'
             AND othercharges.companyid = ".$session['company'];
       $inscrAccid = $this->db->query($sql)->row()->accountid;
       
       $vouchrDtlSale['voucher_master_id'] = $vMastId;
       $vouchrDtlSale['account_master_id'] = $inscrAccid;
       $vouchrDtlSale['voucher_amount'] =$searcharray['txtInsurance'];
       $vouchrDtlSale['is_debit'] ='N' ;
       $vouchrDtlSale['account_id_for_trial'] = NULL;
       $vouchrDtlSale['subledger_id'] = NULL;
       $vouchrDtlSale['is_master'] = NULL;
       if($searcharray['txtInsurance']!=""){
       $this->db->insert('voucher_detail', $vouchrDtlSale);
       }
       
       //for P&F
       $sql="SELECT othercharges.accountid 
             FROM othercharges
             WHERE  othercharges.description ='Packing and Forwarding'
             AND othercharges.companyid = ".$session['company'];
       $PFAccid = $this->db->query($sql)->row()->accountid;
       
       $vouchrDtlSale['voucher_master_id'] = $vMastId;
       $vouchrDtlSale['account_master_id'] = $PFAccid;
       $vouchrDtlSale['voucher_amount'] =$searcharray['txtPckFrw'];
       $vouchrDtlSale['is_debit'] ='N' ;
       $vouchrDtlSale['account_id_for_trial'] = NULL;
       $vouchrDtlSale['subledger_id'] = NULL;
       $vouchrDtlSale['is_master'] = NULL;
       if($searcharray['txtPckFrw']!=""){
       $this->db->insert('voucher_detail', $vouchrDtlSale);
       }
     
       
       
       
       
       // for GST(cgst+sgst+igst)
       $numberofDetails = count($searcharray['txtDetailPacket']);
       $cgstarray=array();
       $sgstarray =array();
       $igstarray =array();
       for ($i = 0; $i < $numberofDetails; $i++) {
            $cgstarray[] =array("id"=>$searcharray['cgst'][$i],"cgstamount"=>$searcharray['cgstAmt'][$i]);
            $sgstarray[] = array("id"=>$searcharray['sgst'][$i],"sgstamount"=>$searcharray['sgstAmt'][$i]);
            $igstarray[] = array("id"=>$searcharray['igst'][$i],"igstamount"=>$searcharray['igstAmt'][$i]);
       }
       //*************************************//
    $groups = array();
    $key = 0;
    foreach ($cgstarray as $item) {
        $key = $item['id'];
        if (!array_key_exists($key, $groups)) {
            $groups[$key] = array(
                'id' => $item['id'],
                'cgstamount' => $item['cgstamount']
                
            );
        } else {
           
            $groups[$key]['cgstamount'] = $groups[$key]['cgstamount'] + $item['cgstamount'];
        }
        $key++;
    }
    foreach ($groups as $value) {
       // echo ($value["id"]."||".$value["cgstamount"] );
        $this->GSTinsertionOnVoucherDetails($vMastId, $value["id"], $value["cgstamount"], "CGST");
    }
    /*******************SGST******************************/
     $groups = array();
     $key = 0;
    foreach ($sgstarray as $item) {
        $key = $item['id'];
        if (!array_key_exists($key, $groups)) {
            $groups[$key] = array(
                'id' => $item['id'],
                'sgstamount' => $item['sgstamount']
                
            );
        } else {
           
            $groups[$key]['sgstamount'] = $groups[$key]['sgstamount'] + $item['sgstamount'];
        }
        $key++;
    }
     foreach ($groups as $value) {
       // echo ($value["id"]."||".$value["cgstamount"] );
        $this->GSTinsertionOnVoucherDetails($vMastId, $value["id"], $value["sgstamount"], "SGST");
    }
    /**************************IGST***********************/
     $groups = array();
     $key = 0;
    foreach ($igstarray as $item) {
        $key = $item['id'];
        if (!array_key_exists($key, $groups)) {
            $groups[$key] = array(
                'id' => $item['id'],
                'igstamount' => $item['igstamount']
                
            );
        } else {
           
            $groups[$key]['igstamount'] = $groups[$key]['igstamount'] + $item['igstamount'];
        }
        $key++;
    }
     foreach ($groups as $value) {
       // echo ($value["id"]."||".$value["cgstamount"] );
        $this->GSTinsertionOnVoucherDetails($vMastId, $value["id"], $value["igstamount"], "IGST");
    }
      // exit();
   }
   private function GSTinsertionOnVoucherDetails($vouchermasterId,$gstId,$gstAmount,$gstType){
       $sql="SELECT gstmaster.accountId
                FROM gstmaster
             WHERE gstmaster.id =".$gstId." AND gstmaster.gstType ='".$gstType."'";
       if($gstId!=0){
        $accountId = $this->db->query($sql)->row()->accountId;
       }
       if($gstId!=0){
                $vouchrDtlVat['voucher_master_id'] = $vouchermasterId;
                $vouchrDtlVat['account_master_id'] = $accountId;
                $vouchrDtlVat['voucher_amount'] = $gstAmount;
                $vouchrDtlVat['is_debit'] ='N' ;
                $vouchrDtlVat['account_id_for_trial'] = NULL;
                $vouchrDtlVat['subledger_id'] = NULL;
                $vouchrDtlVat['is_master'] = NULL;
                $this->db->insert('voucher_detail', $vouchrDtlVat);
       }
   }
        
public function deleteVoucherDetailData($voucherId){
        
         $this->db->where('voucher_master_id', $voucherId);
         $this->db->delete('voucher_detail');
    }
    
    /* Mithilesh on 31-05-2016 */
function getCustomerAccId($cus_id,$compny){
      $sql = " SELECT  `account_master`.`id` FROM `account_master` INNER JOIN customer ON 
	  `account_master`.`id` = customer.account_master_id "
              . " WHERE customer.id=".$cus_id." AND account_master.`company_id`=".$compny;
       return $this->db->query($sql)->row()->id;
  }
   function getSaleAccId($compny){
      $sql="SELECT account_master.`id` FROM account_master WHERE account_master.`account_name`='Sale A/C' AND account_master.`company_id`=".$compny;
       return $this->db->query($sql)->row()->id;
      
  }
   function getVatAccId($compny){
      $sql="SELECT account_master.`id` FROM account_master WHERE account_master.`account_name`='VAT(Output)' AND account_master.`company_id`=".$compny;
    return $this->db->query($sql)->row()->id;
  }
  
  public function getCreditDays($cusId){
      $data = array();
      $sql = "SELECT `customer`.`credit_days` FROM `customer` WHERE `customer`.id=".$cusId;
       $query = $this->db->query($sql);
          if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
                $data = array(
                    "credit_days" => $rows->credit_days
                    
                );
            }

            return $data;
        } else {
            return $data;
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
            $saleBillDetails['HSN']=$dtlArr['txtHSNNumber'][$i];
            $saleBillDetails['productpacketid'] = $dtlArr['finalproduct'][$i];
            $saleBillDetails['packingbox'] = $dtlArr['txtDetailPacket'][$i];
            $saleBillDetails['packingnet'] = ($dtlArr['txtDetailNet'][$i] == "" ? 0 : $dtlArr['txtDetailNet'][$i]);
            $saleBillDetails['quantity'] = ($dtlArr['txtDetailQuantity'][$i] == "" ? 0 : $dtlArr['txtDetailQuantity'][$i]);
            $saleBillDetails['rate'] = ($dtlArr['txtDetailRate'][$i] == "" ? 0 : $dtlArr['txtDetailRate'][$i]);
            $saleBillDetails['amount'] = ($dtlArr['txtDetailAmount'][$i] == "" ? 0 : $dtlArr['txtDetailAmount'][$i]);

        //discount
            $saleBillDetails['discount'] = ($dtlArr['txtDiscount'][$i] == "" ? 0 : $dtlArr['txtDiscount'][$i]);
            $saleBillDetails['taxableamount'] = ($dtlArr['txtTaxableAmt'][$i] == "" ? 0 : $dtlArr['txtTaxableAmt'][$i]);
            
            $saleBillDetails['cgstrateid'] = ($dtlArr['cgst'][$i] == 0 ? NULL : $dtlArr['cgst'][$i]);
            $saleBillDetails['cgstamount'] = ($dtlArr['cgstAmt'][$i] == "" ? NULL : $dtlArr['cgstAmt'][$i]);
            
            $saleBillDetails['sgstrateid'] = ($dtlArr['sgst'][$i] == 0 ? NULL : $dtlArr['sgst'][$i]);
            $saleBillDetails['sgstamount'] = ($dtlArr['sgstAmt'][$i] == "" ? NULL : $dtlArr['sgstAmt'][$i]);
            
            $saleBillDetails['igstrateid'] = ($dtlArr['igst'][$i] == 0 ? NULL : $dtlArr['igst'][$i]);
            $saleBillDetails['igstamount'] = ($dtlArr['igstAmt'][$i] == "" ? NULL : $dtlArr['igstAmt'][$i]);

            
            
            //if ($dtlArr['txtpacket'][$i] != 0) {
                $this->db->insert('sale_bill_details', $saleBillDetails);
            //}//
        }
    }
    
    
   /* public function UpdateData($saleBillMaster,$searcharray){
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
    }*/
    
    
    
    public function UpdateData($voucherMastId,$taxinvoiceId,$voucherUpd, $searcharray){
        $SaleBillId = $taxinvoiceId;
       // unset($saleBillMaster['id']);
  
        try {
             $this->db->where('id', $voucherMastId);
             $this->db->update('voucher_master' ,$voucherUpd);
             $this->insertintoVouchrDtl($voucherMastId,$searcharray);
             $this->updateSalebillMaster($SaleBillId,$searcharray);
           //  echo $this->db->last_query();
             $this->updateSaleBillDetails($SaleBillId, $searcharray);
             $this->updateBillMaster($taxinvoiceId, $searcharray);
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
    
    private  function updateBillMaster($taxinvoiceId,$searcharray){
        $session = sessiondata_method();
        $updatearr = array("invoicemasterid"=>$taxinvoiceId,
            "saletype"=>'T');
       
        $billMasterArray["billdate"]=date("Y-m-d", strtotime($searcharray['saleBillDate']));
        $billMasterArray["billamount"]=$searcharray['txtGrandTotal'];
        $billMasterArray["customeraccountid"]=  $this->getCustomerAccId($searcharray['customer'], $session['company']);
        $this->db->where($updatearr);
        $this->db->update("customerbillmaster",$billMasterArray);
        //echo $this->db->last_query();
    }




    public function updateSalebillMaster($taxinvoiceId,$searcharray){
        $session = sessiondata_method();
        $saleBillMaster = array();
        
         $saleBillMaster['id'] = $taxinvoiceId;
         $saleBillMaster['taxinvoiceno'] = $searcharray['txtSaleBillNo'];
         $saleBillMaster['salebilldate'] = date("Y-m-d", strtotime($searcharray['saleBillDate']));
         $saleBillMaster["GST_placeofsupply"]=$searcharray["placeofsupply"];
         $saleBillMaster['customerId'] = $searcharray['customer'];
         $saleBillMaster['taxinvoicedate'] = date("Y-m-d", strtotime($searcharray['saleBillDate']));
         $saleBillMaster['duedate'] = date("Y-m-d", strtotime($searcharray['txtDueDate']));
         $saleBillMaster['vehichleno'] = $searcharray['vehichleno'];
         $saleBillMaster['transporterId'] = $searcharray['transporter'];
         
         
        
        
        
        /*************************************************************/
            $saleBillMaster['GST_Taxableamount'] = $searcharray['txtTaxableAmount'];
            $saleBillMaster['GST_Discountamount'] = $searcharray['txtDiscountAmount'];
            $saleBillMaster['totalpacket'] = $searcharray['txtTotalPacket'];
            $saleBillMaster['totalquantity'] = $searcharray['txtTotalQty'];
            $saleBillMaster['totalamount'] = $searcharray['txtTotalAmount'];
            $saleBillMaster['GST_Totalgstincluded']= $searcharray['txtTotalIncldTaxAmt'];
            $saleBillMaster['GST_Freightamount']= $searcharray['txtFreight'];
            $saleBillMaster['GST_Insuranceamount']= $searcharray['txtInsurance'];
            $saleBillMaster['GST_PFamount']= $searcharray['txtPckFrw'];
            $saleBillMaster['totalCGST']= $searcharray['txtTotalCGST'];
            $saleBillMaster['totalSGST']= $searcharray['txtTotalSGST'];
            $saleBillMaster['totalIGST']= $searcharray['txtTotalIGST'];
            $saleBillMaster['roundoff']=$searcharray['txtRoundOff'];
            $saleBillMaster['grandtotal'] = $searcharray['txtGrandTotal'];
            
            $saleBillMaster['yearid'] = $session['yearid'];
            $saleBillMaster['companyid'] = $session['company'];
            $saleBillMaster['creationdate'] = date("Y-m-d");
            $saleBillMaster['userid'] = $session['user_id'];
            $saleBillMaster['IsGST']='Y';
        
        $saleBillMaster['yearid'] = $session['yearid'];
        $saleBillMaster['companyid'] = $session['company'];
        $saleBillMaster['creationdate'] = date("Y-m-d");
        $saleBillMaster['userid'] = $session['user_id'];
        
        
        
        
        $this->db->where('id', $taxinvoiceId);
        $this->db->update('sale_bill_master' ,$saleBillMaster);
        
        
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
        
        
        //Mithilesh on 01-06-2016
        /* function getserialnumber($comapny, $year) {
        $sql = "SELECT `serial_number` FROM `voucher_master` WHERE  `company_id`= " . $comapny . " AND `year_id`=" . $year . " ORDER BY id DESC LIMIT 0,1";
        $query = $this->db->query($sql);
        return ($query->result());
    }*/
/*
* @name getRealprojectCustomerCompanyId
* @date 31/03/2017
* @desc finish product purchase for Samarat Realproject Private Ltd. 
* get company Id by Samarat Realproject Private Ltd
*/
 private function getRealprojectCustomerCompanyId($customerid){
		  
		  $companyId=0;
		  $sql = "SELECT 
					IFNULL(customer.companyId,0 ) AS companyId
				 FROM
					customer WHERE customer.id ='".$customerid."'";
		  $query = $this->db->query($sql);
		  if ($query->num_rows() > 0) {
			  $row = $query->row(); 
			  $companyId = $row->companyId;
		  } else{
			  
			  return $companyId;
		  }
			return $companyId;
		  
	  }
private function insertFinishProductPurchase($searcharray,$realProjectCompanyId,$samratRealProjectCustomerId){
	
}
private function insertPurchaseVoucherMaster($searcharray,$realProjectCompanyId,$samratRealProjectCustomerId){
	$voucherMst = array(
						"voucher_number"=>$searcharray["txtSaleBillNo"],
						"voucher_date"=>date("Y-m-d", strtotime($searcharray['saleBillDate'])),
						"narration"=>"Finsihproduct purchase from self against ".$searcharray["txtSaleBillNo"]."/".$searcharray['saleBillDate']
						
	);
	return 0;
}	  
/**************************************************/
}
