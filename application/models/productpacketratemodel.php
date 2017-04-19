<?php

class productpacketratemodel extends CI_Model {

    /**
     * 
     */
    public function UpdateData($productPacketId, $data) {

        try {
            $this->db->where('id', $productPacketId);
            $this->db->update('product_packet', $data);

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

    public function getProductList() {

        $data = array();

        $sql = " SELECT product_packet.`id`, CONCAT(`product`.`product`,'',`packet`.`packet`) AS products "
                . "FROM `product_packet`
			 INNER JOIN
			`product` ON `product_packet`.`productid` = `product`.`id`
			 INNER JOIN `packet` ON `product_packet`.`packetid` = `packet`.`id`
			 ORDER BY product.`product`";

        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {

            foreach ($query->result() as $row) {

                $data[] = array(
                    "productid" => $row->id,
                    "products" => $row->products
                );
            }
        }
        return $data;
    }

}
