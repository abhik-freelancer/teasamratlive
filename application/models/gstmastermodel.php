<?php

class gstmastermodel extends CI_Model {

    public function getGstList($companyid, $yearId) {
        $data = array();
        $sql = "SELECT 
                id,
                gstDescription,
                gstType,
                rate,
                accountId,
                companyid,
                yearId,
                usedfor
            FROM gstmaster WHERE gstmaster.companyid=" . $companyid . " AND gstmaster.yearId=" . $yearId;

        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
                $data[] = array(
                    "id" => $rows->id,
                    "gstDescription" => $rows->gstDescription,
                    "gstType" => $rows->gstType,
                    "rate" => $rows->rate,
                    "accountId" => $rows->accountId,
                    "companyid" => $rows->companyid,
                    "yearId" => $rows->yearId,
                    "usedfor" => $rows->usedfor
                );
            }
            return $data;
        }  else {
            return $data;
        }
    }
/**
 * @author amiabhik@gmail.com
 * @date 28/06/2017
 * @desc Insert GST master data
 * */
    public function GSTinsert($data_insert){
        try {
            $this->db->trans_begin();
            $this->db->insert('gstmaster', $data_insert);
            $insertid = $this->db->insert_id();
            

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                return 0;
            } else {
                $this->db->trans_commit();
                return 1;
            }
        } catch (Exception $e) {
            echo ($e->getMessage());
        }
    }
    /**
     * @author amiabhik@gmail.com
     * @date 28/06/2017
     * @param type $data_insert
     */
    public function GSTupdate($id,$data_insert){
        try {
            $this->db->trans_begin();
            $this->db->where("id",$id);
            $this->db->update('gstmaster', $data_insert);
           
            

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                return 0;
            } else {
                $this->db->trans_commit();
                return 1;
            }
        } catch (Exception $e) {
            echo ($e->getMessage());
        }
        
    }
    
    public function getGSTById($id){
        $data=array();
        $sql="SELECT
            id,
            gstDescription,
            gstType,
            rate,
            accountId,
            companyid,
            yearId,
            usedfor
          FROM gstmaster
          WHERE gstmaster.id = ".$id;
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            $ret = $query->row();
            $data=array(
                "id"=>$ret->id,
                "gstDescription"=>$ret->gstDescription,
                "gstType"=>$ret->gstType,
                "rate"=>$ret->rate,
                "accountId"=>$ret->accountId,
                "usedfor"=>$ret->usedfor
            );
        }
        return $data;
        
    }
    
    
    
}

?>