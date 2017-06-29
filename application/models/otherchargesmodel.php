<?php

class otherchargesmodel extends CI_Model {

    public function getGstList($companyid, $yearId) {
        $data = array();
        $sql = "SELECT othercharges.id,
othercharges.code,othercharges.description,othercharges.companyid,
othercharges.yearid,othercharges.accountid,
 account_master.account_name
FROM othercharges 
LEFT JOIN
account_master ON othercharges.accountid = account_master.id
WHERE  othercharges.companyid=".$companyid." AND othercharges.yearid=".$yearId.
 " ORDER BY othercharges.description";

        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
                $data[] = array(
                    "id" => $rows->id,
                    "description" => $rows->description,
                    "code" => $rows->code,
                    "accountid" => $rows->accountid,
                    "account_name"=>$rows->account_name,
                    "companyid" => $rows->companyid,
                    "yearid" => $rows->yearid,
                    
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
            $this->db->update('othercharges', $data_insert);
           
            

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
                description,
                code,
                accountid,
                companyid,
                yearid
              FROM othercharges WHERE
              othercharges.id =".$id;
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            $ret = $query->row();
            $data=array(
                "id"=>$ret->id,
                "description"=>$ret->description,
                "code"=>$ret->code,
                "accountid"=>$ret->accountid,
                
            );
        }
        return $data;
        
    }
    
    
    
}

?>