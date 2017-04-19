<?php

class openinginvoicemodel extends CI_Model{
    
    
    public function getOpeningMasterDetail($pMastId){
        $sql = 
                "SELECT 
	`purchase_invoice_master`.`id` AS `pMtId`,
	`purchase_invoice_master`.`sale_number`,
	
	`purchase_invoice_detail`.`id` AS pInvDtlId,
	`purchase_invoice_detail`.`price`,
        `purchase_invoice_detail`.`lot`,
	`purchase_invoice_detail`.`invoice_number`,
        `purchase_invoice_detail`.`location_id`,
        `purchase_invoice_detail`.`garden_id`,
        `purchase_invoice_detail`.`teagroup_master_id`,
        `purchase_invoice_detail`.`grade_id`,
        `purchase_bag_details`.`no_of_bags`,
        `purchase_bag_details`.`net`,
        `purchase_bag_details`.`bagtypeid`,
        
	`location`.`location`,
	`garden_master`.`garden_name`,
	`teagroup_master`.`group_code`

        FROM 
        `purchase_invoice_detail`
        INNER JOIN `purchase_invoice_master`
        ON `purchase_invoice_master`.`id`=`purchase_invoice_detail`.`purchase_master_id`
        INNER JOIN `location` 
        ON `location`.`id` = `purchase_invoice_detail`.`location_id`
        INNER JOIN `grade_master` 
        ON `grade_master`.`id`= `purchase_invoice_detail`.`grade_id`
        INNER JOIN `purchase_bag_details`
        ON `purchase_bag_details`.`purchasedtlid`=`purchase_invoice_detail`.`id`
        INNER JOIN `garden_master` 
        ON `purchase_invoice_detail`.`garden_id`=`garden_master`.`id`
        LEFT JOIN `teagroup_master` 
        ON `teagroup_master`.`id`=`purchase_invoice_detail`.`teagroup_master_id`
        WHERE `purchase_invoice_master`.`id`='".$pMastId."' AND `purchase_bag_details`.`bagtypeid`=1";
        
        $query =$this->db->query($sql);
        if($query->num_rows()> 0){
            foreach ($query->result() as $rows){
                $data=array(
                    "pMtId" => $rows->pMtId,
                    "pInvDtlId" => $rows->pInvDtlId,
                    "sale_number" => $rows->sale_number,
                    "price" => $rows->price,
                    "lot" => $rows->lot,
                    "invoice_number" => $rows->invoice_number,
                    "location_id" =>$rows->location_id,
                    "location" => $rows->location,
                    "garden_id" => $rows->garden_id,
                    "grade_id" => $rows->grade_id,
                    "garden_name" => $rows->garden_name,
                    "teagroup_master_id" =>$rows->teagroup_master_id,
                    "group_code" =>$rows->group_code,
                    "no_of_bags" =>$rows->no_of_bags,
                    "net" => $rows->net,
                    "bagtypeid" => $rows->bagtypeid
                    
                );
            }

          return $data;
        }
        else{
            return $data=array();
        }
        
    }
    
    public function getBagOpeningInvoice($pMastId){
        $sql = "SELECT 
         `purchase_bag_details`.`id` AS bgDtlId,
	`purchase_bag_details`.`bagtypeid`,
	`bagtypemaster`.`bagtype`,
	`purchase_bag_details`.`no_of_bags`,
	`purchase_bag_details`.`net`,
	`purchase_bag_details`.`purchasedtlid` AS pInvDtlId,
	`purchase_invoice_detail`.`purchase_master_id` AS pMtId
        
            FROM `purchase_bag_details`
            INNER JOIN `bagtypemaster`
            ON `bagtypemaster`.`id`= `purchase_bag_details`.`bagtypeid`
            INNER JOIN `purchase_invoice_detail`
            ON `purchase_invoice_detail`.`id`=`purchase_bag_details`.`purchasedtlid`
            WHERE `purchase_invoice_detail`.`purchase_master_id`='".$pMastId."' AND `purchase_bag_details`.`bagtypeid`=2";
        
         
        $query =$this->db->query($sql);
        if($query->num_rows()> 0){
            foreach ($query->result() as $rows){
                $data[]=array(
                    "bgDtlId" => $rows->bgDtlId,
                    "pMtId" => $rows->pMtId,
                    "pInvDtlId" => $rows->pInvDtlId,
                    "bagtypeid"=>$rows->bagtypeid,
                    "no_of_bags" =>$rows->no_of_bags,
                    "net"=> $rows->net
                );
            }

          return $data;
        }
        else{
            return $data=array();
        }
        
        
        
    }
    
    public function bagList()
	{
            $sql = "SELECT id as bagid,bagtype FROM `bagtypemaster` WHERE `bagtypemaster`.`id`=2";
            $query =$this->db->query($sql);
            
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
    
    
    public function getOpeningInvoiceBalanceList(){
        $sql="SELECT  
                `purchase_invoice_master`.`id` AS pMastId,
                `purchase_invoice_master`.`sale_number`,
                DATE_FORMAT(`purchase_invoice_master`.`purchase_invoice_date`,'%d-%m-%Y') AS invoice_date,
                `purchase_invoice_detail`.`id` AS pinvDtlId,
                `purchase_invoice_detail`.`invoice_number`,
                `purchase_invoice_detail`.`lot`,
                `purchase_invoice_detail`.`total_weight`,
                `purchase_invoice_detail`.`total_value`,
                `garden_master`.`garden_name`,
                `location`.`location`,
                SUM(`purchase_bag_details`.`no_of_bags`) AS total_bag

                FROM `purchase_bag_details`
                INNER JOIN `purchase_invoice_detail`
                ON `purchase_invoice_detail`.`id`=`purchase_bag_details`.`purchasedtlid`
                INNER JOIN `purchase_invoice_master`
                ON `purchase_invoice_master`.`id`=`purchase_invoice_detail`.`purchase_master_id`
                INNER JOIN `garden_master`
                ON `purchase_invoice_detail`.`garden_id`=`garden_master`.`id`
                INNER JOIN `location`
                ON `purchase_invoice_detail`.`location_id`=`location`.`id`
                WHERE `purchase_invoice_master`.`from_where`='OP'
                GROUP BY `purchase_bag_details`.`purchasedtlid` ";
        
                $query = $this->db->query($sql);
                 if ($query->num_rows() > 0) {
                   foreach ($query->result() as $rows) {
                     $data[] = array(
                       "pMastId"=>$rows->pMastId,
                       "pinvDtlId"=>$rows->pinvDtlId,
                       "sale_number"=>$rows->sale_number,
                       "invoice_date"=>$rows->invoice_date,
                       "invoice_number"=>$rows->invoice_number,
                       "lot"=>$rows->lot,
                       "total_weight"=>$rows->total_weight,
                       "total_value"=>$rows->total_value,
                       "garden_name"=>$rows->garden_name,
                       "location"=>$rows->location,
                       "total_bag"=>$rows->total_bag
                        );
                 }
            return $data;
             } 
        else {
            return $data;
        }
        
    }

   public function insertOpeningInvoice($openingPurInvInsert,$searcharray){
       $purInvMstInsert=array();
       
                $purInvMstInsert['purchase_invoice_number']= $openingPurInvInsert['purchase_invoice_number'];
                $purInvMstInsert['purchase_invoice_date'] =$openingPurInvInsert['purchase_invoice_date'];
                $purInvMstInsert['auctionareaid'] =$openingPurInvInsert['auctionareaid'];
                $purInvMstInsert['vendor_id'] =$openingPurInvInsert['vendor_id'];
                $purInvMstInsert['voucher_master_id'] =$openingPurInvInsert['voucher_master_id'];
                $purInvMstInsert['sale_number'] =$openingPurInvInsert['sale_number'];
                $purInvMstInsert['sale_date'] =$openingPurInvInsert['sale_date'];
                $purInvMstInsert['promt_date'] =$openingPurInvInsert['promt_date'];
              
                $purInvMstInsert['tea_value'] =$openingPurInvInsert['tea_value'];
                
               $purInvMstInsert['brokerage'] =$openingPurInvInsert['brokerage'];
               $purInvMstInsert['service_tax'] =$openingPurInvInsert['service_tax'];
               $purInvMstInsert['total_cst'] =$openingPurInvInsert['total_cst'];
               $purInvMstInsert['total_vat'] =$openingPurInvInsert['total_vat'];
               $purInvMstInsert['chestage_allowance'] =$openingPurInvInsert['chestage_allowance'];
               $purInvMstInsert['stamp'] =$openingPurInvInsert['stamp'];
               $purInvMstInsert['other_charges'] =$openingPurInvInsert['other_charges'];
               $purInvMstInsert['round_off'] =$openingPurInvInsert['round_off'];
              
              $purInvMstInsert['total']  =$openingPurInvInsert['total'];
              $purInvMstInsert['company_id']  =$openingPurInvInsert['company_id'];
              $purInvMstInsert['year_id']  =$openingPurInvInsert['year_id'];
              $purInvMstInsert['from_where']  =$openingPurInvInsert['from_where'];
         try {
            $this->db->trans_begin();
            $this->db->insert('purchase_invoice_master',$purInvMstInsert);
            // echo($this->db->last_query());exit;

             $newDtlId = $this->db->insert_id();
             $this->insertOpeningInvDtl($newDtlId, $openingPurInvInsert);
             
             $new_PurDtlid = $this->db->insert_id();
             $this->insertNormalBagDtl($new_PurDtlid,$searcharray);
             $this->insertsampleBagDtl($new_PurDtlid,$searcharray);
            $this->insertdo_to_transporter($newDtlId,$new_PurDtlid,$openingPurInvInsert);
              // echo($this->db->last_query());exit;

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
    
    
 public function insertOpeningInvDtl($newDtlId,$openingPurInvInsert){
     $purinvDtlInsert=array();
     
               $purinvDtlInsert['purchase_master_id']= $newDtlId;
               $purinvDtlInsert['lot']= $openingPurInvInsert['lot'];
               $purinvDtlInsert['doRealisationDate']=   $openingPurInvInsert['doRealisationDate'];
               $purinvDtlInsert['do']= $openingPurInvInsert['do'];
               $purinvDtlInsert['invoice_number']=  $openingPurInvInsert['invoice_number'];
               $purinvDtlInsert['garden_id']=  $openingPurInvInsert['garden_id'];
               $purinvDtlInsert['grade_id']= $openingPurInvInsert['grade_id'];
               $purinvDtlInsert['location_id']=  $openingPurInvInsert['location_id'];
               $purinvDtlInsert['warehouse_id']=  $openingPurInvInsert['warehouse_id'];
               $purinvDtlInsert['gp_number']=  $openingPurInvInsert['gp_number'];
               $purinvDtlInsert['date']=  $openingPurInvInsert['date'];
               $purinvDtlInsert['package']=  $openingPurInvInsert['package'];
               $purinvDtlInsert['stamp']=$openingPurInvInsert['stamp'];
               $purinvDtlInsert['gross']=  $openingPurInvInsert['gross'];
               $purinvDtlInsert['brokerage']=$openingPurInvInsert['brokerage'];
               $purinvDtlInsert['total_weight']= $openingPurInvInsert['total_weight'];
               $purinvDtlInsert['rate_type_value']=  $openingPurInvInsert['rate_type_value'];
               $purinvDtlInsert['price']= $openingPurInvInsert['rate'];
               $purinvDtlInsert['service_tax']=  $openingPurInvInsert['service_tax'];
               $purinvDtlInsert['total_value']= $openingPurInvInsert['tea_value'];
               $purinvDtlInsert['chest_from']=  $openingPurInvInsert['chest_from'];
               $purinvDtlInsert['chest_to']=  $openingPurInvInsert['chest_to'];
               $purinvDtlInsert['value_cost']= $openingPurInvInsert['value_cost'];
               $purinvDtlInsert['net']='';
               $purinvDtlInsert['rate_type']= $openingPurInvInsert['rate_type'];
               $purinvDtlInsert['rate_type_id']=  $openingPurInvInsert['rate_type_id'];
               $purinvDtlInsert['service_tax_id']= $openingPurInvInsert['service_tax_id'];
               $purinvDtlInsert['teagroup_master_id'] = $openingPurInvInsert['teagroup_master_id'];
     
               
            $this->db->insert('purchase_invoice_detail',$purinvDtlInsert);
               /* echo "<pre>";
                print_r($purinvDtlInsert);
               echo "</pre>";*/
 }


    
  public function insertNormalBagDtl($new_PurDtlid,$searcharray){
      $inserNormalBagDtl=array();
      $inserNormalBagDtl['purchasedtlid']=$new_PurDtlid;
      $inserNormalBagDtl['bagtypeid']=1;
      $inserNormalBagDtl['no_of_bags']=$searcharray['noofNormalBag'];
      $inserNormalBagDtl['net']=$searcharray['net'];
      $inserNormalBagDtl['shortkg']='';
      $inserNormalBagDtl['parent_bag_id']='';
      $inserNormalBagDtl['actual_bags']=$searcharray['noofNormalBag'];
      $inserNormalBagDtl['chestSerial']='';
      $inserNormalBagDtl['challanno']='';
      $inserNormalBagDtl['challandate']='';
       $this->db->insert('purchase_bag_details',$inserNormalBagDtl);
      
     /* echo "<pre>";
        print_r($inserNormalBagDtl);
      echo "</pre>";*/
  }
    
public function insertsampleBagDtl($new_PurDtlid,$dtlArr){
    $insertSampleBgDtl = array();
    
     $numberOfDtl = count($dtlArr['txtnoofbag']);
        for ($i = 0; $i < $numberOfDtl; $i++) {
                $insertSampleBgDtl['purchasedtlid']=$new_PurDtlid;
                $insertSampleBgDtl['bagtypeid'] = $dtlArr['bagtype'][$i];
                $insertSampleBgDtl['no_of_bags'] = $dtlArr['txtnoofbag'][$i];
                $insertSampleBgDtl['net'] =($dtlArr['txtDetailNet'][$i] == "" ? 0 : $dtlArr['txtDetailNet'][$i]);
                $insertSampleBgDtl['shortkg']='';
                $insertSampleBgDtl['parent_bag_id']='';
                $insertSampleBgDtl['actual_bags']=$dtlArr['txtnoofbag'][$i];
                $insertSampleBgDtl['chestSerial']='';
                $insertSampleBgDtl['challanno']='';
                $insertSampleBgDtl['challandate']='';
                
                $this->db->insert('purchase_bag_details',$insertSampleBgDtl);
                
        /*echo "<pre>";
            print_r($insertSampleBgDtl);
        echo "</pre>";*/
           
        }
    
}   
    public function insertdo_to_transporter($newDtlId,$new_PurDtlid,$openingPurInvInsert){
        $insrtDoToTrans = array();
        $insrtDoToTrans['transporterId']=5;
        $insrtDoToTrans['do']='';
        $insrtDoToTrans['purchase_inv_mst_id']=$newDtlId;
        $insrtDoToTrans['purchase_inv_dtlid']=$new_PurDtlid;
        $insrtDoToTrans['transportationdt']='';
        $insrtDoToTrans['chalanNumber']='';
        $insrtDoToTrans['chalanDate']='';
        $insrtDoToTrans['is_sent']='Y';
        $insrtDoToTrans['shortkgs']='';
        $insrtDoToTrans['locationId']=$openingPurInvInsert['location_id'];
        $insrtDoToTrans['in_Stock']='Y';
        $insrtDoToTrans['typeofpurchase']=$openingPurInvInsert['from_where'];
        $insrtDoToTrans['yearid']=$openingPurInvInsert['year_id'];
        $insrtDoToTrans['companyid']=$openingPurInvInsert['company_id'];
            $this->db->insert('do_to_transporter',$insrtDoToTrans);

               /* echo "<pre>";
                    print_r($insrtDoToTrans);
                echo "</pre>";*/
    
    
}
    
   public function UpdateData($openingBlncInvoice,$searcharray){
        $prMastId =  $openingBlncInvoice['id'] ;
        $prInvDtlId = $openingBlncInvoice['prchase_invoice_dtlid'] ;
      //  $prBagDtlId = $openingBlncInvoice[''] ;
        
        $purchInvMaster=array();
        $purchInvMasterId['purchase_invoice_date'] = date('Y-m-d') ;
        $purchInvMasterId['sale_number'] = $openingBlncInvoice['sale_number'] ;
        $purchInvMasterId['tea_value'] = $openingBlncInvoice['tea_value'] ;
        $purchInvMasterId['total'] = $openingBlncInvoice['tea_value'] ;
       
        
        /* echo "<pre>";
            print_r($openingBlncInvoice);
        echo "</pre>";*/
         try {
             $this->db->where('id', $prMastId);
             $this->db->update('purchase_invoice_master' ,$purchInvMasterId);
              $this->UpdateInvoiceDetail($prMastId, $openingBlncInvoice);
              $this->UpdateNormalBagDtl($prInvDtlId,$openingBlncInvoice);
              $this->UpdateSampleBagDetail($prInvDtlId,$searcharray);
             

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
    
   public function UpdateInvoiceDetail($prMastId,$openingBlncInvoice){
           $purMastId=$prMastId;
         $purInvDtl=array();
         $purInvDtl['lot']=$openingBlncInvoice['lot'];
         $purInvDtl['invoice_number']=$openingBlncInvoice['invoice_number'];
         $purInvDtl['garden_id']=$openingBlncInvoice['garden_id'];
         $purInvDtl['grade_id']=$openingBlncInvoice['grade_id'];
         $purInvDtl['location_id']=$openingBlncInvoice['location_id'];
         $purInvDtl['total_weight']=$openingBlncInvoice['total_weight'];
         $purInvDtl['price']=$openingBlncInvoice['rate'];
         $purInvDtl['total_value']=$openingBlncInvoice['tea_value'];
         $purInvDtl['teagroup_master_id']=$openingBlncInvoice['teagroup_master_id'];
         
        /*echo "<pre>";
            print_r($purInvDtl);
        echo "</pre>";*/
         
         $this->db->where('purchase_master_id',$purMastId);
         $this->db->update('purchase_invoice_detail',$purInvDtl); 
    
   }
   
  public function UpdateNormalBagDtl($prInvDtlId,$openingBlncInvoice){
      
      $data=array();
       $data['purchasedtlid']=$prInvDtlId;
       $data['bagtypeid']=1;
       
      $purNormalBag=array();
      $purNormalBag['no_of_bags']=$openingBlncInvoice['no_of_NormalBags'];
      $purNormalBag['net']=$openingBlncInvoice['net'];
      
    /*  echo "<pre>";
        print_r($data);
      echo "</pre>";*/
      
      $this->db->where($data);
      $this->db->update('purchase_bag_details',$purNormalBag);
     
  }
   
 public function UpdateSampleBagDetail($prInvDtlId,$dtlArr){
     

               
       
        $numberOfDtl = count($dtlArr['txtnoofbag']);
        for ($i = 0; $i < $numberOfDtl; $i++) {
              $purBagDtl = array();
                $purBagDtl['id']=$dtlArr['bgDtlId'][$i];
                $purBagDtl['bagtypeid'] = $dtlArr['bagtype'][$i];
                $purBagDtl['no_of_bags'] = $dtlArr['txtnoofbag'][$i];
                $purBagDtl['net'] =($dtlArr['txtDetailNet'][$i] == "" ? 0 : $dtlArr['txtDetailNet'][$i]);
                
                 
                
             $where=array(
                 "id"=> $purBagDtl['id'],
                 "purchasedtlid" =>$prInvDtlId,
                 "bagtypeid" =>$purBagDtl['bagtypeid']
             );  
               $this->db->where($where);
               $this->db->update('purchase_bag_details',$purBagDtl);
               
              if($where['id']==''){
                   $newSmplDtl=array();
                   $newSmplDtl['purchasedtlid']=$prInvDtlId;
                   $newSmplDtl['bagtypeid']=$purBagDtl['bagtypeid'];
                   $newSmplDtl['no_of_bags']=$purBagDtl['no_of_bags'];
                   $newSmplDtl['net']= $purBagDtl['net'];
                   
                      $this->db->insert('purchase_bag_details',$newSmplDtl);
                   }
                  
      /*  
        echo "<pre>";
            print_r($purBagDtl);
        echo "</pre>";*/
           
        }
   }
   public function deleteData($pmasterId)
     {
       $pinvDtlId= $this->getPinvoiceDtlId($pmasterId);
       
        
       $this->deleteBagDetail($pinvDtlId);
       $this->deleteDoToTransporter($pinvDtlId);
       $this->deleteInvoiceDetail($pinvDtlId);
       $this->deleteMasterDetail($pmasterId);
    
        
    }
 public function deleteBagDetail($pinvDtlId){
        
            $this->db->where('purchasedtlid', $pinvDtlId);
          $this->db->delete('purchase_bag_details');  
          if($this->db->delete('purchase_bag_details')){
              return true;
          }
          else{
              return false;
          }
         
    }
    
  public function deleteDoToTransporter($pinvDtlId){
      $this->db->where('purchase_inv_dtlid',$pinvDtlId);
      $this->db->delete('do_to_transporter');
      if($this->db->delete('do_to_transporter')){
          return true;
      }
      else{
          return false;
      }
  }
  
    public function deleteInvoiceDetail($pinvDtlId){
        
         $this->db->where('id', $pinvDtlId);
         $this->db->delete('purchase_invoice_detail');
         if($this->db->delete('purchase_invoice_detail')){
             return true;
         }
         else{
             return false;
         }
    }
    
    public function deleteMasterDetail($pmasterId){
          $this->db->where('id', $pmasterId);
          $this->db->delete('purchase_invoice_master');
            if($this->db->delete('purchase_invoice_master')){
                return true;
            }
            else{
                return false;
            }
    }

  /*  public function deleteDoToTransporter($purInvDtlId){
        // $this->db->where('purchase_inv_mst_id', $purMastId);
         $this->db->where('purchase_inv_dtlid', $purInvDtlId);
         $this->db->delete('do_to_transporter');  
    } */
    
     public function getPinvoiceDtlId($purMastId){
        $sql = "SELECT `purchase_invoice_detail`.`id` AS `purInvDtlId`
                FROM 
                `purchase_invoice_master`
                INNER JOIN `purchase_invoice_detail`
                ON`purchase_invoice_detail`.`purchase_master_id`=`purchase_invoice_master`.`id`
                WHERE `purchase_invoice_master`.`id`='".$purMastId."'";
        
                $query = $this->db->query($sql);
                    if ($query->num_rows() > 0) {
                  $row = $query->row();
                  return $row->purInvDtlId;
                    }else{
                        return '';
                    }
                 
    }
   
    
}
?>