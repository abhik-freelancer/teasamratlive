<?php

class saletaxregistermodel extends CI_Model {
    
    public function getSaleTaxregisterData($frmdt,$todate,$compnyId){
       /* $sql="SELECT `rawteasale_master`.`taxrateTypeId`,
                `vat`.vat_rate
                FROM `rawteasale_master`
                LEFT JOIN `vat`
                ON rawteasale_master.`taxrateTypeId`=vat.id
                WHERE `rawteasale_master`.`taxrateType`='V'
                UNION
                SELECT `sale_bill_master`.`taxrateTypeId`,`vat`.vat_rate 
                FROM `sale_bill_master` 
                LEFT JOIN `vat`
                ON sale_bill_master.`taxrateTypeId`=vat.id
                WHERE `sale_bill_master`.`taxrateType`='V'
                ";*/
        $session = sessiondata_method();
         $sql ="SELECT `rawteasale_master`.`taxrateTypeId`,
                `vat`.vat_rate
                FROM `rawteasale_master`
                LEFT JOIN `vat`
                ON rawteasale_master.`taxrateTypeId`=vat.id
                WHERE `rawteasale_master`.`taxrateType`='V' 
                AND rawteasale_master.company_id=".$session['company']." AND rawteasale_master.year_id =".$session['yearid']."
                UNION
                SELECT `sale_bill_master`.`taxrateTypeId`,`vat`.vat_rate 
                FROM `sale_bill_master` 
                LEFT JOIN `vat`
                ON sale_bill_master.`taxrateTypeId`=vat.id
                WHERE `sale_bill_master`.`taxrateType`='V' 
                AND sale_bill_master.companyid=".$session['company']." AND sale_bill_master.yearid =".$session['yearid'];
         $query =$this->db->query($sql);
        if($query->num_rows()> 0){
            foreach ($query->result() as $rows){
                
                $data[]=array(
                   "taxratetypeId"=>$rows->taxrateTypeId,
                    "vatrate"=>$rows->vat_rate,
                    "salebillData"=>$this->getSalebillData($rows->taxrateTypeId,$frmdt,$todate,$compnyId),
                    "rawteasaleData"=>$this->getRawteaSaleData($rows->taxrateTypeId,$frmdt,$todate,$compnyId)
                );
            }
           
          return $data;
            
          
        }
        else{
            return $data=array();
        }
    }
 
    
    
    public function getSalebillData($taxratetypeid,$fromDt,$todate,$compnyId){
        $session = sessiondata_method();
        $sql = "SELECT
		SUM(sale_bill_master.`grandtotal`) as grandtotal,
                SUM(sale_bill_master.`totalamount`) AS GrossSale,
                SUM(sale_bill_master.`discountAmount`) AS totalDicountAmt,
                SUM(sale_bill_master.`deliverychgs`) AS totalDeliverChrg,
                SUM(sale_bill_master.`taxamount`) AS totalTaxAmt,
                SUM(`sale_bill_master`.`roundoff`) AS totalroundOff,
                `vat`.vat_rate
                FROM `sale_bill_master`
                INNER JOIN vat
                ON sale_bill_master.`taxrateTypeId`=vat.id
                WHERE sale_bill_master.`taxrateTypeId`=".$taxratetypeid." AND `sale_bill_master`.`salebilldate` BETWEEN '".$fromDt."' AND '".$todate."' "
                . " AND sale_bill_master.`companyid`=".$compnyId." AND sale_bill_master.yearid =".$session['yearid'];
        
         $query =$this->db->query($sql);
        if($query->num_rows()> 0){
            foreach ($query->result() as $rows){
                $data=array(
                   //"GrossSale"=>$rows->grandtotal,
				   "GrossSale"=>($rows->GrossSale - $rows->totalDicountAmt + $rows->totalDeliverChrg + $rows->totalTaxAmt)+($rows->totalroundOff),
                   "taxable"=>($rows->GrossSale - $rows->totalDicountAmt + $rows->totalDeliverChrg),
                   "taxamount"=>$rows->totalTaxAmt,
                   "withTax"=>($rows->GrossSale - $rows->totalDicountAmt + $rows->totalDeliverChrg + $rows->totalTaxAmt),
                   "roundOff"=>$rows->totalroundOff
                );
            }
           
          return $data;
        }
        else{
            return $data=array();
        }
    }
    
    public function getRawteaSaleData($taxratetypeid,$fromdate,$todate,$compnyId){
        $session = sessiondata_method();
        $sql="SELECT 
			SUM(rawteasale_master.`grandtotal`) AS grandtotal,
            SUM(rawteasale_master.`totalamount`) AS rawGrossSale,
            SUM(rawteasale_master.`discountAmount`) AS rawtotalDicountAmt,
            SUM(rawteasale_master.`deliverychgs`) AS rawtotalDeliverChrg,
            SUM(rawteasale_master.`taxamount`) AS rawtotalTaxAmt,
            SUM(`rawteasale_master`.`roundoff`) AS rawtotalroundOff,
            `vat`.vat_rate
            FROM `rawteasale_master`
            LEFT JOIN vat
            ON rawteasale_master.`taxrateTypeId`=vat.id
            WHERE rawteasale_master.`taxrateTypeId`=".$taxratetypeid ." AND `rawteasale_master`.`sale_date` BETWEEN '".$fromdate."' AND '".$todate."' "
                . " AND rawteasale_master.company_id=".$compnyId." AND rawteasale_master.year_id =".$session['yearid'];
        
          $query =$this->db->query($sql);
        if($query->num_rows()> 0){
            foreach ($query->result() as $rows){
                $data=array(
                   "rawGrossSale"=>$rows->grandtotal,
                   "rawtaxable"=>($rows->rawGrossSale-$rows->rawtotalDicountAmt+$rows->rawtotalDeliverChrg),
                   "rawtaxamount"=>$rows->rawtotalTaxAmt,
                   "rawwithTax"=>($rows->rawGrossSale-$rows->rawtotalDicountAmt+$rows->rawtotalDeliverChrg+$rows->rawtotalTaxAmt),
                    "rawroundOff"=>$rows->rawtotalroundOff
                );
            }
           
          return $data;
        }
        else{
            return $data=array();
        }
         
        
    }
    
    
   public function getInputTaxregisterData($frmdt,$todate,$compnyId){
       $sql="SELECT `purchase_invoice_detail`.`rate_type_id` AS rateTypeId,
            `vat`.`vat_rate`
            FROM `purchase_invoice_detail` 
            INNER JOIN vat
            ON vat.`id`=purchase_invoice_detail.`rate_type_id`
            WHERE `purchase_invoice_detail`.`rate_type`='V' AND vat.`is_active` ='Y'
            UNION
            SELECT `rawmaterial_purchase_master`.`taxrateTypeId` AS rateTypeId,`vat`.`vat_rate`
            FROM `rawmaterial_purchase_master`
            INNER JOIN vat
            ON vat.`id`=`rawmaterial_purchase_master`.`taxrateTypeId`
            WHERE `rawmaterial_purchase_master`.`taxrateType`='V' AND vat.`is_active` ='Y'";
       
        $query =$this->db->query($sql);
        if($query->num_rows()> 0){
            foreach ($query->result() as $rows){
                $data[]=array(
                   "taxratetypeId"=>$rows->rateTypeId,
                    "vatrate"=>$rows->vat_rate,
                    "purchaseInvoiceInput"=>$this->getPurchaseinvTaxData($rows->rateTypeId,$frmdt,$todate,$compnyId),
                    "rawpurchMaterialInput"=>$this->getRawPurchasematerialData($rows->rateTypeId,$frmdt,$todate,$compnyId)
                );
            }
           
          return $data;
            
          
        }
        else{
            return $data=array();
        }
       
   } 
   
   
   public function getPurchaseinvTaxData($vatId,$fromDt,$todate,$compnyId){
       $session = sessiondata_method();
       $sql ="SELECT 
			  SUM(`purchase_invoice_master`.`total`) AS grandtotal,
			  SUM(`purchase_invoice_master`.`tea_value`) AS teaValue,
			  SUM(`purchase_invoice_master`.`brokerage`) AS brokerages,
			  SUM(`purchase_invoice_master`.`service_tax`) AS serviceTaxAmt,
			  SUM(`purchase_invoice_master`.`total_vat`) AS totalTaxAmt,
			  SUM(`purchase_invoice_master`.`stamp`) AS totalStamp,
			  SUM(`purchase_invoice_master`.`round_off`) AS tRoundOff,
			  SUM(purchase_invoice_master.`totalTbCharges`) AS totalTBcharges,
			  SUM(`purchase_invoice_master`.`other_charges`) AS totaOthrs
			FROM
			   purchase_invoice_master 
			INNER JOIN
			purchase_invoice_detail
			ON purchase_invoice_master.id = purchase_invoice_detail.purchase_master_id
			WHERE 
                        purchase_invoice_master.year_id =".$session['yearid'].
                        " AND `purchase_invoice_master`.`from_where` <> 'OP' AND `purchase_invoice_master`.`from_where` <> 'STI'
			AND `purchase_invoice_master`.`purchase_invoice_date` 
			BETWEEN '".$fromDt."' AND '".$todate."' AND purchase_invoice_master.`company_id`=".$compnyId." 
			 AND `purchase_invoice_detail`.`rate_type_id`=".$vatId." GROUP BY  
			`purchase_invoice_detail`.`rate_type_id`" ;
	   
	 
         $query =$this->db->query($sql);
        if($query->num_rows()> 0){
            foreach ($query->result() as $rows){
                $data=array(
                   "purchseInvGross"=>$rows->grandtotal,
                   "purchTaxable"=>($rows->teaValue + $rows->brokerages + $rows->totalStamp),
                   "purTaxamount"=>$rows->totalTaxAmt,
                   "purchaseWithTax"=>($rows->teaValue + $rows->brokerages + $rows->totalStamp + $rows->totalTaxAmt),
                    "purchaseOthers"=>($rows->serviceTaxAmt + $rows->tRoundOff + $rows->totaOthrs+$rows->totalTBcharges)
                );
            }
           
          return $data;
        }
        else{
            return $data=array();
        }
   }
   
   public function getRawPurchasematerialData($vatId,$fromDt,$todate,$compnyId){
       $session = sessiondata_method();
         $sql = "SELECT 
				 SUM(`rawmaterial_purchase_master`.`invoice_value`) AS grandTotal ,	
                SUM(`rawmaterial_purchase_master`.`item_amount`) AS rawGrossPurch ,
                SUM(`rawmaterial_purchase_master`.`excise_amount`) AS totalExciseAmt,
                SUM(`rawmaterial_purchase_master`.`taxamount`) AS totaltaxAmt,
                SUM(`rawmaterial_purchase_master`.`round_off`) AS totalRoundOff
                FROM `rawmaterial_purchase_master`
                WHERE rawmaterial_purchase_master.`taxrateTypeId`=".$vatId." AND rawmaterial_purchase_master.yearid=".$session['yearid']
                 . " AND `rawmaterial_purchase_master`.`invoice_date` BETWEEN '".$fromDt."' AND '".$todate."' "
                . " AND rawmaterial_purchase_master.companyid=".$compnyId;
       
         $query =$this->db->query($sql);
        if($query->num_rows()> 0){
            foreach ($query->result() as $rows){
                $data=array(
                   "rawmaterailGross"=>$rows->grandTotal,
                   "rawMaterialTaxable"=>($rows->rawGrossPurch + $rows->totalExciseAmt),
                   "rawMaterialTaxamount"=>$rows->totaltaxAmt,
                   "purchaseWithTax"=>($rows->rawGrossPurch + $rows->totalExciseAmt + $rows->totaltaxAmt),
                   "purchaseOthers"=>($rows->totalRoundOff)
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