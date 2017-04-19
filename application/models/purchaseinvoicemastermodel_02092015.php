<?php

class purchaseinvoicemastermodel extends CI_Model {
   
    /**
     * @method getPurchaseStepOneData
     * @param type $purchaseInvId
     * @return boolean
     */
    
    public function getPurchaseStepOneData($purchaseInvId=""){
        
        $sql = "SELECT 
                    purchase_invoice_master.`id`,
                    purchase_invoice_master.`from_where`,
                    purchase_invoice_master.`vendor_id`,
                    purchase_invoice_master.`auctionareaid`,
                    purchase_invoice_master.`purchase_invoice_number`,
                    DATE_FORMAT(purchase_invoice_master.`purchase_invoice_date`,'%d-%m-%Y')AS invoicedate,
                    DATE_FORMAT(purchase_invoice_master.`sale_date`,'%d-%m-%Y') AS saledate,
                    `purchase_invoice_master`.`sale_number`,
                    DATE_FORMAT(purchase_invoice_master.`promt_date`,'%d-%m-%Y')as promptDate
                     FROM purchase_invoice_master WHERE purchase_invoice_master.id='".$purchaseInvId."'";
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            $rows = $query->row(); 
            return $rows;
        }else{
            return FALSE;
        }
        
        
    }
                function saveInvoicemaster($value) {
        $this->db->trans_begin();

        $this->db->insert('purchase_invoice_master', $value);
        $insertdetail = $this->db->insert_id();

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
        } else {
            $this->db->trans_commit();
        }
        return $insertdetail;
    }

    function saveInvoicedetail($value) {
        $this->db->trans_begin();

        $this->db->insert('purchase_invoice_detail', $value);
        $insertdetail = $this->db->insert_id();

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
        } else {
            $this->db->trans_commit();
        }
        return $insertdetail;
    }

    function updateInvoicedetail($value, $invoiceid) {

        $this->db->where('id', $invoiceid);
        $this->db->update('purchase_invoice_detail', $value);
       
    }

    function saveItemamster($value) {
        $this->db->trans_begin();

        $this->db->insert('item_master', $value);
        $insertdetail = $this->db->insert_id();

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
        } else {
            $this->db->trans_commit();
        }
        return $insertdetail;
    }

    function insertVoucher($valuevoucher) {
        $this->db->trans_begin();

        $this->db->insert('voucher_master', $valuevoucher);
        $insertdetail = $this->db->insert_id();

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
        } else {
            $this->db->trans_commit();
        }
        return $insertdetail;
    }

    function insertVoucherDetail($value) {
        $this->db->trans_begin();

        $this->db->insert('voucher_detail', $value);
        $insertdetail = $this->db->insert_id();

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
        } else {
            $this->db->trans_commit();
        }
        return $insertdetail;
    }

    function insertVendorBill($value) {
        $this->db->trans_begin();

        $this->db->insert('vendor_bill_master', $value);
        $insertdetail = $this->db->insert_id();

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
        } else {
            $this->db->trans_commit();
        }
        return $insertdetail;
    }

    function getVendorAccount($vendor_id) {
        $sql = " SELECT `account_master`.`id` FROM `account_master` 
				 INNER JOIN vendor ON `account_master`.`account_name` = `vendor`.`vendor_name` 
				  WHERE `vendor`.`id` = " . $vendor_id;
        $query = $this->db->query($sql);
        return ($query->result());
    }

    function lastvoucherid() {
        $sql = "SELECT YEAR(`voucher_date`) as year, `id` FROM `voucher_master` ORDER BY id DESC LIMIT 0,1";
        $query = $this->db->query($sql);
        return ($query->result());
    }

    function getserialnumber($comapny, $year) {
        $sql = "SELECT `serial_number` FROM `voucher_master` WHERE `transaction_type`= 'PR' AND `company_id`= " . $comapny . " AND `year_id`=" . $year . " ORDER BY id DESC LIMIT 0,1";
        $query = $this->db->query($sql);
        return ($query->result());
    }
    
/*
 * @method saveInvoiceBagDetails
 * @param $valus
 * @desc Bagdetails will be save here , normal(1),Sample(2)
 * 
 */
    public function saveInvoiceBagDetails($value) {
        $this->db->trans_begin();

        $this->db->insert('purchase_bag_details', $value);
        $purchaseBagDetlsId= $this->db->insert_id();

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return 0;
        } else {
            $this->db->trans_commit();
            return $purchaseBagDetlsId;
        }
       
    }

    function getCurrentservicetax($startYear, $endYear) {
        $sql = "SELECT id, tax_rate FROM service_tax WHERE from_date BETWEEN '" . $startYear . "' AND '" . $endYear . "'";
        $query = $this->db->query($sql);
        return ($query->result());
    }

    function getCurrentvatrate($startYear, $endYear) {
        $sql = "SELECT id, vat_rate FROM vat WHERE from_date BETWEEN '" . $startYear . "' AND '" . $endYear . "'";
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
                $data[] = $rows;
            }

            return $data;
        }
        //return ($query->result());
    }

    function teagrouplist() {

        $sql = "SELECT `id`,`group_code`,`group_description` FROM teagroup_master";
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
                $data[] = $rows;
            }

            return $data;
        }
    }

    function getCurrentcstrate($startYear, $endYear) {
        $sql = "SELECT id, cst_rate FROM cst WHERE from_date BETWEEN '" . $startYear . "' AND '" . $endYear . "'";
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
                $data[] = $rows;
            }

            return $data;
        }
        //return ($query->result());
    }

    function getVendorlist($session) {
        $sql = "SELECT `id`,`vendor_name`,IF (id = " . $session . ", 'Y', 'N') selected	FROM `vendor`";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
                $data[] = $rows;
            }

            return $data;
        }
    }

    function getPurchaselistingdata($session) {
        
      $vendorClause="";
      if($session['vendor']!=0){
          $vendorClause =" AND purchase_invoice_master.vendor_id='".$session['vendor']."'";
             }
        
        $sql = "SELECT purchase_invoice_master.`id`,
					purchase_invoice_master.`purchase_invoice_number`,
					purchase_invoice_master.`purchase_invoice_date`,
					purchase_invoice_master.`sale_number`,
					DATE_FORMAT(purchase_invoice_master.`sale_date`,'%d-%m-%Y') AS saledate,
					DATE_FORMAT(purchase_invoice_master.`promt_date`,'%d-%m-%Y') AS prompt_date,
					purchase_invoice_master.`tea_value`,
					purchase_invoice_master.`brokerage`,
					purchase_invoice_master.`service_tax`,
					IF(purchase_invoice_master.`total_vat`<>0.00,purchase_invoice_master.`total_vat`,purchase_invoice_master.`total_cst`) AS tax,
					IF(purchase_invoice_master.`total_vat`<>0.00,'VAT','CST') AS tax_type,
					purchase_invoice_master.`stamp`,
					purchase_invoice_master.`total`,
					`vendor`.`vendor_name` 
					FROM `purchase_invoice_master` 
					INNER JOIN vendor ON `purchase_invoice_master`.`vendor_id` = `vendor`.`id` 
					WHERE  (purchase_invoice_date BETWEEN '" . date("Y-m-d", strtotime($session['startdate'])) . "' AND '" . date("Y-m-d", strtotime($session['enddate'])) . "') 
					" . $vendorClause . " 
					AND `purchase_invoice_master`.`year_id` = " . $session['pryear'] . " 
					AND `purchase_invoice_master`.`company_id` = " . $session['prcom'];


        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
                $data[] = $rows;
            }


            return $data;
        }
    }

    public function getPurchaselistingdetaildata($id, $year, $company) {
       
      $sql= " SELECT
		  purchase_invoice_detail.`id`, purchase_invoice_detail.`purchase_master_id`,
		  purchase_invoice_detail.`lot`,  purchase_invoice_detail.`doRealisationDate`,
		  purchase_invoice_detail.`do`,  purchase_invoice_detail.`invoice_number`,  purchase_invoice_detail.`garden_id`,
		  purchase_invoice_detail.`grade_id`,  purchase_invoice_detail.`warehouse_id`,  purchase_invoice_detail.`gp_number`,
		  purchase_invoice_detail.`date`,  purchase_invoice_detail.`stamp`,  purchase_invoice_detail.`gross`,
		  purchase_invoice_detail.`brokerage`,  purchase_invoice_detail.`total_weight`,  purchase_invoice_detail.`rate_type_value`,
		  purchase_invoice_detail.`price`,  purchase_invoice_detail.`service_tax`,  purchase_invoice_detail.`total_value`,
		  purchase_invoice_detail.`value_cost`,  purchase_invoice_detail.`rate_type`,  purchase_invoice_detail.`rate_type_id`,
		  purchase_invoice_detail.`service_tax_id`,  purchase_invoice_detail.`teagroup_master_id`,
		  `garden_master`.`garden_name`,
		  `grade_master`.`grade`,
		  `warehouse`.`name`,
		  GROUP_CONCAT(DISTINCT purchase_bag_details.`id` ORDER BY  purchase_bag_details.`id` ASC SEPARATOR '/') AS BagDTlID,
		  GROUP_CONCAT(DISTINCT purchase_bag_details.no_of_bags ORDER BY purchase_bag_details.id ASC SEPARATOR '/')AS NumbersOfBags,
		  GROUP_CONCAT(DISTINCT purchase_bag_details.net ORDER BY purchase_bag_details.id ASC SEPARATOR '/')AS BgKgs,
		  GROUP_CONCAT(bagtypemaster.bagtype ORDER BY purchase_bag_details.id ASC SEPARATOR '/')AS BagTypes
	FROM `purchase_invoice_detail`
		INNER JOIN `purchase_invoice_master` ON `purchase_invoice_master`.`id`=`purchase_invoice_detail`.`purchase_master_id`
		INNER JOIN `purchase_bag_details` ON `purchase_invoice_detail`.`id` = `purchase_bag_details`.`purchasedtlid` 
		LEFT JOIN `garden_master` ON `purchase_invoice_detail`.`garden_id` = `garden_master`.`id` 
		LEFT JOIN `warehouse` ON `purchase_invoice_detail`.`warehouse_id` = `warehouse`.`id` 
		LEFT JOIN `grade_master` ON `purchase_invoice_detail`.`grade_id` = `grade_master`.`id` 
		INNER JOIN `bagtypemaster` ON purchase_bag_details.`bagtypeid` =bagtypemaster.`id`
		WHERE `purchase_invoice_detail`.`purchase_master_id` = ".$id."
		AND `purchase_invoice_master`.`year_id` = " . $year . "
		AND `purchase_invoice_master`.`company_id` =" . $company . "
	GROUP BY purchase_invoice_detail.`id`"; 


        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
                $data[] = $rows;
            }

            return $data;
        } else {
            return "no record found";
        }
    }

    function editdata($id) {

       $sql = "  SELECT 
				`purchase_invoice_master`.`id` AS masterid ,
				`purchase_invoice_master`.`purchase_invoice_number`,
				`purchase_invoice_master`.`purchase_invoice_date`,
				`purchase_invoice_master`.`auctionareaid`,
				`purchase_invoice_master`.`vendor_id`,
				`purchase_invoice_master`.`sale_number`,
				`purchase_invoice_master`.`sale_date`,
				`purchase_invoice_master`.`promt_date`,
				`purchase_invoice_master`.`tea_value`,
				`purchase_invoice_master`.`brokerage` as tbrokerage,
				`purchase_invoice_master`.`service_tax` as tservice_tax,
				`purchase_invoice_master`.`total_cst`,
				`purchase_invoice_master`.`total_vat`,
				`purchase_invoice_master`.`chestage_allowance`,
				`purchase_invoice_master`.`stamp` as masterstamp,
				`purchase_invoice_master`.`total`,
				`purchase_invoice_master`.`voucher_master_id`,
                `purchase_invoice_master`.`from_where`,
				 purchase_invoice_detail.*,
                 IF(purchase_invoice_detail.`doRealisationDate`IS NOT NULL OR purchase_invoice_detail.`doRealisationDate` <>'','N','Y')AS IS_EDIT,
                IF( do_to_transporter.is_sent IS NULL  OR do_to_transporter.is_sent='N','N','Y')  as sent_trans,
				`garden_master`.`garden_name`,
				`grade_master`.`grade`,
				`warehouse`.`name`, 
                `location`.`id` as locationid,
                `location`.`location` as location,
				`teagroup_master`.`id` as teagroupid,
				`teagroup_master`.`group_code` as teagroupcode,
				  GROUP_CONCAT(DISTINCT purchase_bag_details.`id` ORDER BY  purchase_bag_details.`id` ASC SEPARATOR ',') AS BagDTlID,
				  GROUP_CONCAT(purchase_bag_details.actual_bags ORDER BY purchase_bag_details.id ASC SEPARATOR ',')AS NumbersOfBags,
				  GROUP_CONCAT(purchase_bag_details.net ORDER BY purchase_bag_details.id ASC SEPARATOR ',')AS BgKgs,
				  GROUP_CONCAT(IF (purchase_bag_details.chestSerial ='', NULL, purchase_bag_details.chestSerial) ORDER BY purchase_bag_details.id ASC SEPARATOR '~')AS chest,
				  GROUP_CONCAT(bagtypemaster.bagtype ORDER BY purchase_bag_details.id ASC SEPARATOR ',')AS BagTypes,
				  GROUP_CONCAT(purchase_bag_details.bagtypeid ORDER BY  purchase_bag_details.`id` ASC SEPARATOR ',') AS selectedBagId
				 FROM `purchase_invoice_master` 
				 LEFT JOIN `purchase_invoice_detail` ON `purchase_invoice_master`.id = `purchase_invoice_detail`.`purchase_master_id` 
				 INNER JOIN `purchase_bag_details` ON `purchase_invoice_detail`.`id` = `purchase_bag_details`.`purchasedtlid` 
				 LEFT JOIN `do_to_transporter` ON `purchase_invoice_detail`.id = `do_to_transporter`.`purchase_inv_dtlid`
				 LEFT JOIN `garden_master` ON `purchase_invoice_detail`.`garden_id` = `garden_master`.`id` 
				 LEFT JOIN `warehouse` ON `purchase_invoice_detail`.`warehouse_id` = `warehouse`.`id` 
				 LEFT JOIN `grade_master` ON `purchase_invoice_detail`.`grade_id` = `grade_master`.`id` 
                                 LEFT JOIN `location` ON `do_to_transporter`.`locationId` = `location`.`id` 
				 LEFT JOIN `teagroup_master` ON `purchase_invoice_detail`.`teagroup_master_id` = `teagroup_master`.`id`
				 INNER JOIN `bagtypemaster` ON purchase_bag_details.`bagtypeid` =bagtypemaster.`id`
				 WHERE `purchase_invoice_master`.id = " . $id . " 
				 GROUP BY purchase_invoice_detail.id ";

        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
                //print_r($rows);

                $data[] = $rows;
            }


            return $data;
        } else {
            return "no record found";
        }
    }

    function updateVoucherid($voucherid, $invoiceid) {

        $value = array('voucher_master_id' => $voucherid);
        $this->db->where('id', $invoiceid);
        $this->db->update('purchase_invoice_master', $value);
    }

    function updatedateVoucherMaster($voucherdate, $voucherid) {
        $value = array('voucher_date' => $voucherdate);
        $this->db->where('id', $voucherid);
        $this->db->update('voucher_master', $value);
    }

    function updatedateBillMaster($id, $rate) {
        /* $value=array('bill_amount'=>$rate);
          $this->db->where('id',$id);
          $this->db->update('party_bill_master',$value); */
        $sql = "UPDATE  `vendor_bill_master` SET `bill_amount` = " . $rate . ", `due_amount` = " . $rate . " WHERE `voucher_id`= " . $id;
        $query = $this->db->query($sql);
    }

    function updateInvoicemaster($value) {

        if (isset($value['id'])) {
            $this->db->trans_begin();


            $this->db->where('id', $value['id']);
            $this->db->update('purchase_invoice_master', $value);


            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
            } else {
                $this->db->trans_commit();
            }
        }
    }

    public function deleteInvoicemaster($value) {
       

        $this->db->where('bill_id', $value);
        $this->db->where('from_where', "SB");
        $this->db->delete('item_master');
    }
/**
 * @method deleteBagDetails
 * @param type $value
 */
    public function deleteBagDetails($value,$deleteFlag) {
       if($deleteFlag!='Y') {
         $this->db->where('purchasedtlid', $value);
         $this->db->delete('purchase_bag_details');
         return 1;
       }
       else{
           return 0;
       }
    }

    function deleteInvoicedetail($value) {
        $this->db->where('id', $value);
        $this->db->delete('purchase_invoice_detail');

        $sql = "DELETE `item_master` FROM `item_master`INNER JOIN saler_to_buyer_detail ON bill_id = purchase_invoice_master_id WHERE saler_to_buyer_detail.id = " . $value . " AND 			item_master.`invoice_number` = " . $invoice . " AND from_where = 'PR'";
        $query = $this->db->query($sql);
    }

    function deleteVoucherdetail($value) {
        //$this->db->where('voucher_master_id', $value);
        //$this->db->delete('voucher_detail'); 
        $sql = "DELETE FROM `voucher_detail` WHERE `voucher_master_id`= " . $value;
        $query = $this->db->query($sql);
    }

    function deleteRecord($parentId) {


        $this->db->select('voucher_master_id');
        $this->db->from('purchase_invoice_master');
        $this->db->where('id', $parentId);
        $query1 = $this->db->get();
        $voucherId = $query1->result[0]->voucher_master_id;


        $this->db->where('bill_id', $parentId);
        $this->db->where('from_where', "PR");
        $query_result = $this->db->delete('vendor_bill_master');

        $this->db->where('purchase_invoice_master_id', $parentId);
        $query_result = $this->db->delete('unreleaseddo');


        $sql2 = 'DELETE `voucher_detail`,`voucher_master` 
				FROM `voucher_master` 
				INNER JOIN `voucher_detail` ON `voucher_master`.`id` = `voucher_detail`.`voucher_master_id` 
				WHERE `voucher_master`.`id` = ' . $voucherId;
        $query3 = $this->db->query($sql2);

        $sql3 = 'DELETE `purchase_invoice_sample`,`item_master` 
				FROM `purchase_invoice_master` 
				LEFT JOIN `purchase_invoice_detail` ON `purchase_invoice_master`.id = `purchase_invoice_detail`.`purchase_master_id` 
				LEFT JOIN `purchase_invoice_sample` ON `purchase_invoice_detail`.`id` = `purchase_invoice_sample`.`purchase_invoice_detail_id` 
				LEFT JOIN `item_master` ON `purchase_invoice_detail`.id = `item_master`.`bill_id` 
				WHERE `purchase_invoice_master`.`id`= ' . $parentId . '
				OR `item_master`.`from_where` = "PR" ';
        $query4 = $this->db->query($sql3);

        $this->db->where('purchase_master_id', $parentId);
        $query_result = $this->db->delete('purchase_invoice_detail');

        $sql1 = 'DELETE `purchase_invoice_sample`,`purchase_invoice_detail`,`item_master` 
				FROM `purchase_invoice_master` 
				LEFT JOIN `purchase_invoice_detail` ON `purchase_invoice_master`.id = `purchase_invoice_detail`.`purchase_master_id` 
				LEFT JOIN `purchase_invoice_sample` ON `purchase_invoice_detail`.`id` = `purchase_invoice_sample`.`purchase_invoice_detail_id` 
				LEFT JOIN `item_master` ON `purchase_invoice_detail`.id = `item_master`.`bill_id` 
				WHERE `purchase_invoice_master`.`id`= ' . $parentId . ' 
				OR `item_master`.`from_where` = "PR" ';
        $query2 = $this->db->query($sql1);

        $this->db->where('id', $parentId);
        $query_result2 = $this->db->delete('purchase_invoice_master');

        //echo $errorno = $this->db->_error_message();
    }

    /**
     * @method saveStockForSB
     * @method for Seller to Buyer direct stock update.
     */
    public function saveStockForSB($value) {
        $this->db->trans_begin();
        $this->db->insert('do_to_transporter', $value);
        $insertid = $this->db->insert_id();

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();

            return false;
        } else {
            $this->db->trans_commit();
            return $insertid;
        }
    }

    /**
     * @method updateStockForSB
     * @param type $purchaseDtlId
     * @param type $values
     */
    public function updateStockForSB($purchaseDtlId, $values) {

        $this->db->trans_begin();
        $this->db->where('purchase_inv_dtlid', $purchaseDtlId);
        $this->db->update('do_to_transporter', $values);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
        } else {
            $this->db->trans_commit();
        }
        return 0;
    }

}
