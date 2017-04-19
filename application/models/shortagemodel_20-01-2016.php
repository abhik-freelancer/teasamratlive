<?php

class shortagemodel extends CI_Model {

    /**
     * @mehod getDoLists
     * @param type $purchaseInvoiceID
     * @return boolean
     * @description List of 'do' received
     */
    public function getBagDetails($purchaseMasterId, $transporterId) {

        $data =array();

        $sql = "SELECT purchase_invoice_master.`id` AS pMstId,purchase_invoice_detail.`id` AS pDtlId,purchase_bag_details.`id` AS pBagDtlId,
                    `purchase_invoice_detail`.`do`, purchase_invoice_detail.`invoice_number`,
                    purchase_bag_details.`bagtypeid`,bagtypemaster.`bagtype`,purchase_bag_details.`no_of_bags`,
                    purchase_bag_details.`net`,purchase_bag_details.`actual_bags`,purchase_bag_details.`parent_bag_id`,purchase_bag_details.shortkg
                    FROM
                    `purchase_invoice_master` INNER JOIN `purchase_invoice_detail` ON
                    `purchase_invoice_master`.`id`=`purchase_invoice_detail`.`purchase_master_id` 
                    INNER JOIN `purchase_bag_details` ON `purchase_invoice_detail`.`id`=`purchase_bag_details`.`purchasedtlid`
                    INNER JOIN `do_to_transporter` ON `do_to_transporter`.`purchase_inv_dtlid` = `purchase_invoice_detail`.`id`
                    INNER JOIN bagtypemaster ON bagtypemaster.`id` =`purchase_bag_details`.`bagtypeid`
                    WHERE `purchase_invoice_master`.id='" . $purchaseMasterId . "' AND `do_to_transporter`.`transporterId`='" . $transporterId . "' AND 
                        `do_to_transporter`.`in_Stock` ='Y'  ORDER BY `purchase_invoice_detail`.`id`";

        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
                $data[] = $rows;
            }




            return $data;
        } else {
            return $data;
        }
    }

    public function getPurchaseInvoice() {
        $sql = "SELECT purchase_invoice_number ,id  FROM purchase_invoice_master ORDER BY purchase_invoice_date ";
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
    
    public function getParentActualBag($id){
        
        $this->db->select('actual_bags');
        $this->db->from('purchase_bag_details');
        $this->db->where('id',$id);
        
        $query = $this->db->get();
        if ($query->num_rows() > 0)
        {
            $row = $query->row(); 
            return $row->actual_bags;
        }

        return null;
    }
    
     public function getParentBagNet($id){
        
        $this->db->select('net');
        $this->db->from('purchase_bag_details');
        $this->db->where('id',$id);
        
        $query = $this->db->get();
        if ($query->num_rows() > 0)
        {
            $row = $query->row(); 
            return $row->net;
        }

        return null;
    }
    
    
    
    

    public function InsertShortage($PurchaseBagDetailIds, $Shortdata, $parentbagdata) {



        try {
            $this->db->trans_begin();

            $this->db->where('id', $PurchaseBagDetailIds);
            $this->db->update('purchase_bag_details', $parentbagdata);



            $this->db->insert('purchase_bag_details', $Shortdata);
            $insertid = $this->db->insert_id();



            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                return false;
            } else {
                $this->db->trans_commit();
                return true;
            }
        } catch (Exception $e) {
            echo ($e->getMessage());
        }
    }

    
    
    public function update($PurchaseBagDetailIds,$Shortdata,$parentbagdata,$parentId){
        
         try {
            $this->db->trans_begin();

            $this->db->where('id', $parentId);
            $this->db->update('purchase_bag_details', $parentbagdata);



            $this->db->where('id', $PurchaseBagDetailIds);
            $this->db->update('purchase_bag_details', $Shortdata);



            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                return false;
            } else {
                $this->db->trans_commit();
                return true;
            }
        } catch (Exception $e) {
            echo ($e->getMessage());
        }
    }
    
    public function deleteShortBag($purchaseBagDetailId,$parentBagId,$dataOfPbag){
        
        try {
            $this->db->trans_begin();

            $this->db->where('id', $parentBagId);
            $this->db->update('purchase_bag_details', $dataOfPbag);



            $this->db->where('id', $purchaseBagDetailId);
            $this->db->delete('purchase_bag_details');
           



            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                return false;
            } else {
                $this->db->trans_commit();
                return true;
            }
        } catch (Exception $e) {
            echo ($e->getMessage());
        }
        
    }
    
}
