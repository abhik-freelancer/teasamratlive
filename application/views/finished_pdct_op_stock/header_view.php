<script src="<?php echo base_url(); ?>application/assets/js/finishedproduct_op_stock.js"></script> 


<style type="text/css">
    table.gridtable {
        font-family: verdana,arial,sans-serif;
        font-size:11px;
        color:#003399;
        border-width: 1px;
        border-color: #666666;
        border-collapse: collapse;
    }
    table.gridtable th {
        border-width: 1px;
        padding: 8px;
        border-style: solid;
        border-color: #666666;
        background-color: #dedede;
    }
    table.gridtable td {
        border-width: 1px;
        padding: 8px;
        border-style: solid;
        border-color: #666666;
        background-color: #CCFFCC;
    }
    #saveBtn{
        width:550px;
        cursor:pointer;
        margin:0 auto;
        padding:0;
    }

    section#loginBox{
        margin-bottom:-8px;
    }
  .textStyle{
    border:1px solid green;
    border-radius:5px;
    width:280px;
}
.selectStyle{
    border-top:1px solid green;
    border-left:1px solid green;
    border-bottom:1px solid green;
    border-radius:5px;
}
#product_descript{
    resize:none;
}

</style>


<?php if($header['mode']=="Add"){?>
<h2><font color="#5cb85c">Add Finished Product Opening Stock</font></h2>
<?php }else{?>
<h2><font color="#5cb85c">Edit Finished Product Opening Stock</font></h2>
<?php }?>



<form role="form" method="post" name="finished_prd_op_stck" id="finished_prd_op_stck">
    
  <section id="loginBox" style="width:550px;">
      <input type="hidden" id="txtModeOfoperation" name="txtModeOfoperation" value="<?php echo($header['mode']); ?>"/>
        <input type="hidden" id="finishedPrdOpstockId" name="finishedPrdOpstockId" value="<?php echo($header['finishedPrdOPstockId']); ?>"/>
      
        <table width="100%">
            <tr>
                <td>Select Product</td>
                <td>:&nbsp;&nbsp;</td>
                <td>
                    <select id="product_packet" name="product_packet" class="selectStyle">
                        <option value="0">Select Product</option>
                        <?php foreach($header['productpacket'] as $rows){?>
                            <option value="<?php echo($rows['prdctPacktId'])?>" <?php if($bodycontent['finishedPrdOpStockData']['finished_product_id']== $rows['prdctPacktId']){echo('selected');}else{echo('');} ?>><?php echo($rows['product_packet']); ?></option>
                    <?php } ?>
                        
                    </select>
                </td>
            </tr>
          
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            
                  
            <tr>
                <td>Opening Balance </td>
                <td>:&nbsp;&nbsp;</td>
                <td>
                    <input type="text" id="opening_blnc" name="opening_blnc" value="<?php echo $bodycontent['finishedPrdOpStockData']['opening_balance'];?>" class="textStyle" onkeyup="checkNumeric(this);"/>
                </td>
            </tr>
            
             <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
           
        </table>
  </section>
    
<div id="finished_prd_OP_stock"  style="display:none" title="">
    <span>Data successfully saved.</span>
</div>



    <br><br>
    <div id="saveBtn"> <span class="buttondiv"><div class="save" id="saveFinishedOpStock" align="center">Save</div></span></div>
    
    <div id="dialog-check-finishedprd" title="" style="display:none;">
  <p>This Product Already exist</p>
  
  
</div>
</form>










