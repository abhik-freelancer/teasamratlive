<?php

class productmodel extends CI_Model{
 
    /**
     * returns a list of articles
     * @return array 
     */
    public function productlist()
	{
            $this -> db -> select   ('product.id AS IdProduct,
                                        product.product,
                                        product.productdesc,
                                        packet.id AS packetId,
                                        packet.packet,
                                        packet.PacketQty,
                                        product_packet.id AS productPacketId');
	   $this -> db -> from('product');
	   $this->db->join('product_packet', 'product.id=product_packet.productid','LEFT');
           $this->db->join('packet', 'packet.id=product_packet.packetid','LEFT');
           $this->db->order_by("product.insertiondate", "desc"); 
	  
     
	
	   $query = $this -> db -> get();
	
	
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
    /**
     * @method IsProductExist
     * @param type $productName
     */
    public function IsProductExist($productName=""){
        $sql="SELECT id,product FROM product WHERE product='".trim($productName)."'";
        $query = $this->db->query($sql);
         if($query -> num_rows() > 0)
	   {
	     return 1;
	   }
	   else
	   {
		 return 0;
	   }
    }

	
	public function add($value,$packets)
	{
			$pkts = array();
                        $paket_product=array();
			$this->db->trans_begin();
			$this->db->insert('product', $value);
			$insertid = $this->db->insert_id();
                        if($packets!=''){
                            $pkts = explode('~', $packets);
                        }
                        else{
                            $pkts = array();
                        }
                        foreach ($pkts as $values) {
                            if($values!=""){
                                $paket_product["productid"]=$insertid;
                                $paket_product["packetid"]=$values;
                                $this->db->insert('product_packet', $paket_product);
                            }
                        }
			
			if ($this->db->trans_status() === FALSE)
			{
				$this->db->trans_rollback();
                                return false;
			}
			else
			{
				$this->db->trans_commit();
                                return $insertid;
			}
			
		
	}
	
	public function modify($value)
	{
	 if (isset($value['id'])) {
		 
		 
		
			$this->db->trans_begin();
			$this->db->where('id', $value['id']);
			$this->db->update('location',$value); 
			if ($this->db->trans_status() === FALSE)
			{
				$this->db->trans_rollback();
			}
			else
			{
				$this->db->trans_commit();
			}
			return 0;
		
   	 }
	}
	
	public function delete($value)
 	 {
		$this->db->trans_begin();
		  $this->db->where('id', $value);
		  $this->db->delete('location'); 
		if ($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();
		}
		else
		{
			$this->db->trans_commit();
		}
		
		$errorno = $this->db->_error_number();
		if($errorno > 0)
		{
			return 0;	
		}
		else
		{
			return 1;	
		}
 	 }
	
}
?>