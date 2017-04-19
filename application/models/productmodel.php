<?php

class productmodel extends CI_Model {

    /**
     * returns a list of articles
     * @return array 
     */
    public function productlist() {
       
        $sql = "SELECT 
                    product.id AS IdProduct,
                    product.product,
                    product.productdesc,
                    GROUP_CONCAT(packet.id) AS packetIds,
                    GROUP_CONCAT(packet.packet SEPARATOR '|') AS pakets,
                    GROUP_CONCAT(packet.PacketQty SEPARATOR '|') AS packetQtys,
                    product_packet.id AS productPacketId 
                    FROM 
                    product
                    LEFT JOIN
                    product_packet ON product.id=product_packet.productid
                    LEFT JOIN
                    packet ON packet.id=product_packet.packetid
                    GROUP BY product_packet.`productid`
                    ORDER BY product.`insertiondate` DESC";
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

    /**
     * @method IsProductExist
     * @param type $productName
     */
    public function IsProductExist($productName = "") {
        $sql = "SELECT id,product FROM product WHERE product='" . trim($productName) . "'";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            return 1;
        } else {
            return 0;
        }
    }

    public function add($value, $packets) {
        $pkts = array();
        $paket_product = array();

        try {
            $this->db->trans_begin();
            $this->db->insert('product', $value);
            $insertid = $this->db->insert_id();
            if ($packets != '') {
                $pkts = explode('~', $packets);
            } else {
                $pkts = array();
            }
            foreach ($pkts as $values) {
                if ($values != "") {
                    $paket_product["productid"] = $insertid;
                    $paket_product["packetid"] = $values;
                    $this->db->insert('product_packet', $paket_product);
                }
            }

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
/**
 * 
 * @param type $value
 * @param type $packets
 * @return int
 */
    public function modify($value,$packets) {
        $paket_product = array();
        $pkts = array();
        
        
       try{ 
        if (isset($value['id'])) {
            $this->db->trans_begin();
            
            //deleteing product_packet
             $this->db->where('productid', $value['id']);
             $this->db->delete('product_packet');
            //inserting product_packet
             if ($packets != '') {
                $pkts = explode('~', $packets);
            } else {
                $pkts = array();
            }
            foreach ($pkts as $values) {
                if ($values != "") {
                    $paket_product["productid"] = $value['id'];
                    $paket_product["packetid"] = $values;
                    $this->db->insert('product_packet', $paket_product);
                }
            }
            //updating product 
            $this->db->where('id', $value['id']);
            $this->db->update('product', $value);
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                 return false;
            } else {
                $this->db->trans_commit();
                return true;
            }
            
        }//if
       }  catch (Exception $e){echo($e->getMessage());}
        
    }

    public function delete($value) {
        $this->db->trans_begin();
        $this->db->where('productid', $value);
        $this->db->delete('product_packet');
        
        $this->db->where('id', $value);
        $this->db->delete('product');
        
        
        
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return 0;
        } else {
            $this->db->trans_commit();
             return 1;
        }

       
    }
    public function getProduct(){
        
        $data=array();
        $sql="SELECT  product.id AS IdProduct,
                    product.product FROM product ORDER BY product.`insertiondate` DESC";
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

}

?>