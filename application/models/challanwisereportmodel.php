<?php

class challanwisereportmodel extends CI_Model{

	
   public function getchallanNo($transporterId,$compny,$year){
       /*$sql="SELECT 
            DISTINCT(do_to_transporter.`chalanNumber`)
            FROM do_to_transporter
            INNER JOIN purchase_invoice_master
            ON purchase_invoice_master.`id`=do_to_transporter.`purchase_inv_mst_id`
            WHERE do_to_transporter.`transporterId`=".$transporterId." AND purchase_invoice_master.`company_id`=".$compny." AND purchase_invoice_master.`year_id`=".$year." AND
            do_to_transporter.`chalanNumber`<>''
            ORDER BY CONVERT(do_to_transporter.`chalanNumber`,DECIMAL) ASC"; 25/02/2017*/ 
			
		$sql=" SELECT DISTINCT (`do_to_transporter`.`chalanNumber`) AS challan
				FROM `do_to_transporter`
				WHERE `do_to_transporter`.`transporterId` = ".$transporterId." AND  do_to_transporter.`companyid` =".$compny.
				
				" AND `do_to_transporter`.`chalanNumber` IS NOT NULL
				UNION
				SELECT DISTINCT(purchase_bag_details.`challanno`) AS challan
				FROM `purchase_bag_details`
				INNER JOIN
				do_to_transporter ON do_to_transporter.`purchase_inv_dtlid` =  purchase_bag_details.`purchasedtlid`
				AND `do_to_transporter`.`transporterId` = ".$transporterId.
				" AND  do_to_transporter.`companyid` =".$compny.
				" AND purchase_bag_details.`challanno` IS NOT NULL ORDER BY challan DESC";
       
         $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
                $data[] = array(
                    
                    "chalanNumber" => $rows->challan,
                );
            }

            return $data;
        } else {
            return $data;
        }
       
   }
   
   
   /*@method getChallanWiseReport()
    *  This function is used for listchallanwisereport(), getchallanwisereportPdf()
    */
   
    public function getChallanWiseReport($transporterId,$challanno,$company,$yearid){
        
        /*$sql="SELECT 
                        `purchase_invoice_master`.`sale_number`,
                        purchase_invoice_master.from_where,
                        `purchase_invoice_detail`.`id` AS purchaseDTLsId,
                        `do_to_transporter`.id AS doTransIds,
                        `do_to_transporter`.do,
                        `purchase_invoice_detail`.`invoice_number`,
                        `purchase_invoice_detail`.`grade_id`,
                        `grade_master`.`grade`,
                        `purchase_invoice_detail`.`total_weight`,
                        `purchase_invoice_detail`.`price`,
                        `do_to_transporter`.`chalanNumber`,
                         DATE_FORMAT(`do_to_transporter`.`chalanDate`, '%d-%m-%Y') AS chalanDate,
                        `do_to_transporter`.`in_Stock`,
                        do_to_transporter.`locationId`,
                        `garden_master`.`garden_name`,
                        SUM(`purchase_bag_details`.`no_of_bags`) AS totalBags,
                        SUM(`purchase_bag_details`.`net`) AS NetKg,
                       (`purchase_invoice_detail`.`total_weight`*`purchase_invoice_detail`.`price`) AS amount
                     FROM
                        `do_to_transporter`
                        INNER JOIN 
                        `purchase_invoice_detail` ON `purchase_invoice_detail`.`id` = `do_to_transporter`.`purchase_inv_dtlid`
                        INNER JOIN `garden_master` ON `purchase_invoice_detail`.`garden_id`=`garden_master`.`id`
                       
                         INNER JOIN purchase_invoice_master
                         ON `purchase_invoice_master`.`id`=`purchase_invoice_detail`.`purchase_master_id`

                        INNER JOIN `purchase_bag_details` ON `purchase_invoice_detail`.`id`=`purchase_bag_details`.`purchasedtlid`
                        INNER JOIN 
                        `grade_master` ON `purchase_invoice_detail`.`grade_id` = `grade_master`.`id`
                         LEFT JOIN `location`
                         ON
                         do_to_transporter.`locationId`=`location`.`id`
                       WHERE
                        `do_to_transporter`.`transporterId` =".$transporterId." 
                         AND (do_to_transporter.`chalanNumber`='".$challanno."' OR purchase_bag_details.`challanno`= '".challanno."') 
                         AND purchase_invoice_master.from_where <> 'SB' 
                         AND purchase_invoice_master.company_id=".$company." 
                         AND purchase_invoice_master.`year_id`=".$yearid." 
                         GROUP BY `purchase_invoice_detail`.`id`"; 27-02-2017*/
			$sql = "SELECT 
					purchase_bag_details.`id`,
					purchase_bag_details.`purchasedtlid`,
					purchase_invoice_master.`purchase_invoice_number`,
					date_format(purchase_invoice_master.`purchase_invoice_date`,'%d/%m/%Y') as purchase_invoice_date,
					garden_master.`garden_name`,
					purchase_bag_details.`actual_bags`,
					purchase_bag_details.`no_of_bags`,
					purchase_bag_details.`bagtypeid`,
					bagtypemaster.`bagtype`,
					purchase_bag_details.`net`,
					`purchase_invoice_detail`.`invoice_number`,
					`purchase_invoice_detail`.`do`,
					purchase_invoice_master.`company_id`,
					purchase_invoice_master.`year_id`,
					`purchase_bag_details`.`challanno` ,
					 do_to_transporter.`chalanNumber` 
FROM
purchase_bag_details
INNER JOIN
do_to_transporter
ON purchase_bag_details.`purchasedtlid` = do_to_transporter.purchase_inv_dtlid AND do_to_transporter.`in_Stock` ='Y'
INNER JOIN
`bagtypemaster` ON purchase_bag_details.`bagtypeid` = bagtypemaster.`id`
INNER JOIN
`purchase_invoice_detail` ON `purchase_invoice_detail`.`id` = purchase_bag_details.`purchasedtlid`
INNER JOIN `purchase_invoice_master` ON purchase_invoice_detail.`purchase_master_id` = purchase_invoice_master.`id`
INNER JOIN `garden_master` ON purchase_invoice_detail.`garden_id` = garden_master.`id`
WHERE 
do_to_transporter.`transporterId`=".$transporterId." 
AND (do_to_transporter.`chalanNumber`='".$challanno."' OR purchase_bag_details.`challanno`= '".$challanno."')
AND purchase_invoice_master.`company_id`=".$company." AND purchase_invoice_master.`from_where` <>'SB' ORDER BY `purchase_invoice_detail`.`invoice_number`";			 

        
        $query = $this->db->query($sql);
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
   
    
    public function getTransporterName($transporterid){
      $sql="SELECT `transport`.`name` FROM`transport` WHERE `transport`.`id`=".$transporterid;
        $query = $this->db->query($sql);
		 if ($query->num_rows() > 0)
            {
                $rows=$query->row();
                $data = $rows->name;

                return $data;
            } else {
                return $data;
            }
               
    }
   
}

?>