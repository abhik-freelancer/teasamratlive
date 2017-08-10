<?php

class rawmaterialmodel extends CI_Model{
 
    /*@method InserMasterModel()
     * @param $data
     * @date 18.02.2016
     * @author Mithilesh
     */
      public function insertRawmaterialMaster($data){
       
         try {
             $masterData=array(
                 "unitid"=>$data["unitid"],
                 "purchase_rate"=>$data["purchase_rate"],
                 "product_description"=>$data["product_description"],
                 "type"=>$data["type"]
             );
             
            $this->db->trans_begin();
            $this->db->insert('raw_material_master',$masterData);
            $lastInsertId = $this->db->insert_id();
             $opening=array(
                    "opening"=>$data["opening"],
                    "rawmaterialId"=>$lastInsertId,
                    "yearid"=>$data["yearid"],
                    "companyid"=>$data["companyid"]
                );
             $this->InsertRawMaterialOpening($opening,$lastInsertId);
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
    
    /**
     * @method InsertRawMaterialOpening
     * @date 29/12/2016
     * @Desc Insert opening of raw material
     */
    private function InsertRawMaterialOpening($data,$lastInsertId){
       
        $sql = "DELETE FROM raw_material_opening WHERE".
                " rawmaterialId=".$lastInsertId." AND yearid=".$data['yearid']." AND companyid=".$data['companyid'];
        $this->db->query($sql);
        $this->db->insert('raw_material_opening',$data);
        
        
    }
    
    
    /*@method UpdateData()
     * @param $unitMaster
     * @date 18.02.2016
     * @author Mithilesh
     */
    
     public function UpdateRawmaterialMaster($rawMatUpd,$rawmaterialOpening){
        $rawId =  $rawMatUpd['id'] ;
        
         try {
             $this->db->where('id',$rawId);
             $this->db->update('raw_material_master',$rawMatUpd);
            // echo($this->db->last_query());exit;
             $this->InsertRawMaterialOpening($rawmaterialOpening,$rawId);
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
  
    
    /*@method unitlisting()
     * @param 
     * @date 18.02.2016
     * @author Mithilesh
     */
    
      public function rawmaterialMasterList($companyId=NULL,$yearid=NULL){
        $sql = "SELECT 
            `raw_material_master`.`id`,
            `raw_material_master`.`purchase_rate`,
            `raw_material_master`.`product_description`,
            `unitmaster`.`unitName`
             FROM `raw_material_master`
            LEFT JOIN `unitmaster`
            ON `raw_material_master`.`unitid`=`unitmaster`.`unitid`";
        
        $query =$this->db->query($sql);
        if($query->num_rows()> 0){
            foreach ($query->result() as $rows){
                $data[]=array(
                    "id"=>$rows->id,
                   "product_description"=>$rows->product_description,
                    "purchase_rate"=>$rows->purchase_rate,
                    "unitName"=>$rows->unitName,
                    "opening"=>  $this->getOpeningStock($companyId,$yearid,$rows->id)
                );
            }

          return $data;
        }
        else{
            return $data=array();
        }
        
    }
    
    private function getOpeningStock($companyId=NULL,$yearid=NULL,$rawmatId=NULL){
        $opening=0;
     $sql="SELECT
            raw_material_opening.`opening`
            FROM `raw_material_master`
            LEFT JOIN `raw_material_opening` 
            ON `raw_material_opening`.`rawmaterialId` = `raw_material_master`.`id`
            AND `raw_material_opening`.`companyid` ='".$companyId."' AND `raw_material_opening`.`yearid`='".$yearid.
           "' WHERE `raw_material_master`.`id` ='".$rawmatId."'";
      $query =$this->db->query($sql);
        if($query->num_rows()> 0){
            $ret = $query->row();
            $opening=$ret->opening;
        }
        return $opening;
        
     
    }
    
     /*@method getUnitMasterData()
     * @param $unitId
     * @date 18.02.2016
     * @author Mithilesh
     */
    
     public function getUnitMasterData($rawId) {

        $sql = "SELECT * FROM raw_material_master WHERE `raw_material_master`.`id`='".$rawId."'";
        $query = $this->db->query($sql);

      /*  if ($query->num_rows() > 0) {
            $rows = $query->row();
            return $rows;
        } else {
            return FALSE;
        }*/
           
        if($query->num_rows()> 0){
            foreach ($query->result() as $rows){
                $data=array(
                    "id"=>$rows->id,
                    "unitid"=>$rows->unitid,
                    "purchase_rate"=>$rows->purchase_rate,
                    "product_description"=>$rows->product_description
                );
            }

          return $data;
        }
        else{
            return $data=array();
        }
    }
    /**
     * @method getRawmaterial 
     * @param type $company
     * @param type $year
     * @param type $rawmaterialId
     * @date  29/12/2016
     */
    public function getRawmaterial($company,$year,$rawmaterialId){
        $data=array();
        $sql="SELECT
                    raw_material_master. `id`,
                    raw_material_master. `product_description`,
                     raw_material_master.`purchase_rate`,
                     raw_material_master.`unitid`,
                     raw_material_opening.`opening`,
                     raw_material_master.type
                FROM `raw_material_master`
                LEFT JOIN `raw_material_opening` 
                ON `raw_material_opening`.`rawmaterialId` = `raw_material_master`.`id`
                AND `raw_material_opening`.`companyid` =".$company." AND `raw_material_opening`.`yearid`=".$year.
                " WHERE `raw_material_master`.`id` =".$rawmaterialId;
        $query = $this->db->query($sql);
         if($query->num_rows()> 0){
             $ret = $query->row();
             $data = array(
                            "product_description"=>$ret->product_description,
                            "purchase_rate"=>$ret->purchase_rate,
                            "unitid"=>$ret->unitid,
                            "opening"=>$ret->opening,
                            "type"=>$ret->type
                            
             );
             
         }
        
         return $data;
    }

    
    
    public function getRawmaterialdetailbyId($rawmaterialid){
        $data=array();
        $sql="SELECT `raw_material_master`.`id`,`raw_material_master`.`unitid`,`unitmaster`.`unitName`
              FROM 
              `raw_material_master`
              LEFT JOIN
             `unitmaster` ON `raw_material_master`.`unitid` = `unitmaster`.`unitid`
              WHERE `raw_material_master`.`id`=".$rawmaterialid;
        $query = $this->db->query($sql);
         if($query->num_rows()> 0){
             $ret = $query->row();
             $data = array(
                            "Unit"=>$ret->unitName,
                            "unitid"=>$ret->unitid
                            
             );
             
         }
        
         return $data;
    }
}
?>