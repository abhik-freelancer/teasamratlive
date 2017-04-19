<?php

class customermastermodel extends CI_Model {

    /**
     * returns a list of articles
     * @return array 
     */
    public function custoemrlist($session_data) {
        $session = sessiondata_method();
        $sql = "SELECT 
                    customer.id AS vid,
                    customer.customer_name,customer.telephone,
                    customer.address,
                    customer.pin_number,
                    customer.credit_days,
                    state_master.state_name,
                    customer.account_master_id AS amid,
                    account_opening_master.id AS aomid,
                    account_opening_master.opening_balance
                FROM customer
                INNER JOIN account_master 
                ON customer.account_master_id = account_master.id 
                AND account_master.company_id =" . $session['company'] .
                " LEFT  JOIN account_opening_master 
                ON account_master.id = account_opening_master.account_master_id 
                AND account_opening_master.financialyear_id =" . $session['yearid'] . "
                 LEFT  JOIN state_master ON customer.state_id = state_master.id
                ORDER BY customer.customer_name";



        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {

            foreach ($query->result() as $rows) {
                $data[] = $rows;
            }
            return $data;
        } else {
            return false;
        }
    }

    function add($value) {
        $this->db->trans_begin();

        $accountmaster = array('account_name' => $value['customer_name'], 'group_master_id' => 1, 'company_id' => $value['company_id']);
        $this->db->insert('account_master', $accountmaster);
        $insertmaster = $this->db->insert_id();


        $accountopeningmaster = array('account_master_id' => $insertmaster,
            'opening_balance' => $value['opening_balance'],
            'company_id' => $value['company_id'],
            'financialyear_id' => $value['financialyear_id']);
        $this->db->insert('account_opening_master', $accountopeningmaster);
        $insertdetail = $this->db->insert_id();


        $datavendor = array('customer_name' => $value['customer_name'],
            'address' => $value['address'],
            'telephone' => $value['telephone'],
            'account_master_id' => $insertmaster,
            'tin_number' => $value['tin_number'],
            'cst_number' => $value['cst_number'],
            'pan_number' => $value['pan_number'],
            'service_tax_number' => $value['service_tax_number'],
            'GST_Number' => $value['GST_Number'],
            'pin_number' => $value['pin_number'],
            'state_id' => $value['state_id'],
            'credit_days' => $value['credit_days']
        );
        $this->db->insert('customer', $datavendor);
        $insertvendor = $this->db->insert_id();


        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
        } else {
            $this->db->trans_commit();
        }
        return $insertvendor;
    }

    function getStates() {
        $sql = "SELECT * FROM `state_master` ORDER BY state_name ASC ";
        $query = $this->db->query($sql);
        return ($query->result());
    }

    function adddetail($datavendor) {
        $this->db->trans_begin();
        $this->db->insert('party_bill_master', $datavendor);
        $insertvendor = $this->db->insert_id();

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
        } else {
            $this->db->trans_commit();
        }
        return $insertvendor;
    }

    public function modify($value) {
        $session = sessiondata_method();
        if (isset($value['id'])) {
            $this->db->trans_begin();
            $datavendor = array(
                'customer_name' => $value['customer_name'],
                'address' => $value['address'],
                'telephone' => $value['telephone'],
                'account_master_id' => $value['account_master_id'],
                'tin_number' => $value['tin_number'],
                'cst_number' => $value['cst_number'],
                'pan_number' => $value['pan_number'],
                'service_tax_number' => $value['service_tax_number'],
                'GST_Number' => $value['GST_Number'],
                'pin_number' => $value['pin_number'],
                'credit_days' => $value['credit_days'],
                'state_id' => $value['state_id']);
            $this->db->where('id', $value['id']);
            $this->db->update('customer', $datavendor);


            if ($value['opening_balance'] != '') {

                $accountopeningmaster = array(
                    'opening_balance' => $value['opening_balance'],
                    'financialyear_id' => $session['yearid']
                );
                $this->db->where('id', $value['accopenmaster']);
                $this->db->update('account_opening_master', $accountopeningmaster);
            }


            $accountmaster = array('account_name' => $value['customer_name']);
            $this->db->where('id', $value['account_master_id']);
            $this->db->update('account_master', $accountmaster);

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
            } else {
                $this->db->trans_commit();
            }
        }
    }

    function delete($value) {

        $this->db->where('id', $value['am']);
        $this->db->delete('account_master');

        $this->db->where('id', $value['aom']);
        $this->db->delete('account_opening_master');

        $this->db->where('id', $value['id']);
        $this->db->delete('customer');

        $errorno = $this->db->_error_number();
        if ($errorno > 0) {
            return 0;
        } else {
            return 1;
        }
    }

    function vendoropeningbalance($value) {
        $this->db->where('id', $value);
        $this->db->delete('vendor_opening_balance');
        /* $sql = "DELETE FROM `vendor_opening_balance` WHERE `id`= ".$value;	
          $query = $this->db->query($sql); */
    }

    function customerEditdata($id) {

        /* SELECT * FROM `vendor` LEFT JOIN `vendor_opening_balance` ON `vendor`.`id` = `vendor_opening_balance`.`vendor_id` 
          WHERE `vendor`.`id` = 2 */

        $this->db->select('`customer`.*,
							  `account_master`.id as amid,
							  `account_opening_master`.id as accopenmaster,
							  `account_opening_master`.opening_balance as openblnce');
        /*  `vendor_opening_balance`.`id` AS did,
          `vendor_opening_balance`.`bill_amount` AS dba,
          `vendor_opening_balance`.`bill_date` AS dbd,
          `vendor_opening_balance`.`bill_number` AS dbn ,
          `vendor_opening_balance`.`due_amount` AS dda,
          `vendor_opening_balance`.`due_date` AS ddd'); */
        $this->db->from('`customer`');
        /* $this -> db -> join('`vendor_opening_balance`', 'vendor.id = vendor_opening_balance.vendor_id','left'); */
        $this->db->join('`account_master`', 'customer.account_master_id = account_master.id', 'left');
        $this->db->join('account_opening_master', 'account_master.id = account_opening_master.account_master_id', 'LEFT');
        $this->db->where('customer.id', $id);

        $query = $this->db->get();

        if ($query->num_rows() > 0) {

            foreach ($query->result() as $rows) {
                $data[] = $rows;
            }
            return $data;
        } else {
            return false;
        }
    }

    function deleteDetail($value) {

        $this->db->where('vendor_id', $value);
        $this->db->delete('vendor_opening_balance');
    }

    function getVendorBalanceDetail($id) {
        /*
          SELECT `vendor_bill_master`.*
          FROM `vendor_bill_master`
          LEFT JOIN `purchase_invoice_master` ON `vendor_bill_master`.`bill_id` = `purchase_invoice_master`.`id` \
          LEFT JOIN `vendor` ON `purchase_invoice_master`.`vendor_id` = `vendor`.`id`
          WHERE `vendor`.`id` =

         */
        $this->db->select('vendor_bill_master.*,purchase_invoice_master.purchase_invoice_number,`purchase_invoice_master`.`purchase_invoice_date`');
        $this->db->from('vendor_bill_master');
        $this->db->join('purchase_invoice_master', 'vendor_bill_master.bill_id = purchase_invoice_master.id', 'LEFT');
        $this->db->join('vendor', 'purchase_invoice_master.vendor_id = vendor.id', 'LEFT');
        $this->db->where('vendor.id', $id);

        $query = $this->db->get();

        if ($query->num_rows() > 0) {

            foreach ($query->result() as $rows) {
                $data[] = $rows;
            }
            return $data;
        } else {
            return false;
        }
    }

    public function getCustomerAccountId($companyId) {
        $data = array();
        $sql = "SELECT customer.`account_master_id`,account_master.`account_name` 
                    FROM 
                    customer
                    INNER JOIN 
                    account_master ON customer.`account_master_id` = account_master.`id` AND account_master.`company_id`=" . $companyId .
                " ORDER BY account_master.`account_name`";

        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
                $data[] = array(
                    "account_master_id" => $rows->account_master_id,
                    "account_name" => $rows->account_name
                );
            }
            return $data;
        } else {
            return $data;
        }
    }

}

?>