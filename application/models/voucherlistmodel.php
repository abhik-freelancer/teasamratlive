<?php

class voucherlistmodel extends CI_Model {
    
    public function getVoucherList($vdata){
        $fromdt = $vdata['from_date'];
        $todt = $vdata['to_date'];
        $ptype = $vdata['ptype'];
        $session = sessiondata_method();
        if($ptype=="ALL"){
        $whereClause = " WHERE `voucher_master`.`voucher_date` BETWEEN '".$fromdt."' AND '".$todt."' AND voucher_master.company_id=".$session['company'];
        }else{
             $whereClause = " WHERE 
                        `voucher_master`.`transaction_type`='".$ptype."'
                        AND `voucher_master`.`voucher_date` BETWEEN '".$fromdt."' AND '".$todt."' AND voucher_master.company_id=".$session['company'];
        }
        
           $sql = " SELECT 
                `voucher_master`.id,
                `voucher_master`.`voucher_number`,
                 DATE_FORMAT(`voucher_master`.`voucher_date`,'%d-%m-%Y') AS VoucherDate,
                `voucher_master`.`narration`,
                `voucher_master`.`transaction_type`
                 FROM `voucher_master`".$whereClause." ORDER BY `voucher_master`.`voucher_date` DESC";
                
        
        
        $query =$this->db->query($sql);
        if($query->num_rows()> 0){
            foreach ($query->result() as $rows){
                $data[]=array(
                   "id"=>$rows->id,
                   // "voucherDtlId"=>$rows->voucherDtlId,
                    "voucher_number"=>$rows->voucher_number,
                    "VoucherDate"=>$rows->VoucherDate,
                    "narration"=>$rows->narration,
                    "transaction_type"=>$rows->transaction_type,
                    "voucherDtl"=>$this->getVoucherDetaildata($rows->id)
                    
                );
            }

          return $data;
        }
        else{
            return $data=array();
        }
    }
    
    
     public function getVoucherDetaildata($vouchmastId){
        $sql="SELECT 
            `account_master`.`account_name`,
            `voucher_detail`.`voucher_amount`,
            `voucher_detail`.`is_debit` AS drCr
             FROM `voucher_detail`
             INNER JOIN `account_master`
             ON `account_master`.`id`=`voucher_detail`.`account_master_id`
             WHERE `voucher_detail`.`voucher_master_id`='".$vouchmastId."'";
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