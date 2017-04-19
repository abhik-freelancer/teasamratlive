<script src="<?php echo base_url(); ?>application/assets/js/rawMaterial.js"></script> 


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
    #saveUnit{
        width:350px;
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
    width:450px;
}
.textStylesmall{
    border:1px solid green;
    border-radius:5px;
    width:200px;
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
<h2><font color="#5cb85c">Add Raw Material</font></h2>
<?php }else{?>
<h2><font color="#5cb85c">Edit Raw Material</font></h2>
<?php }?>
<div class="stats">
  
  <p class="stat"><a href="<?php echo base_url(); ?>rawmaterial" class="showtooltip" title="List"><img src="<?php echo base_url(); ?>application/assets/images/home.jpg" hieght="30" width="30"/></a></p>
    
</div>


<form role="form" method="post" name="rawMaterial" id="rawMaterial">
    
  <section id="loginBox" style="width:780px;">
      <input type="hidden" id="txtModeOfoperation" name="txtModeOfoperation" value="<?php echo($header['mode']); ?>"/>
        <input type="hidden" id="rawmaterialid" name="rawmaterialid" value="<?php echo($header['rawMaterialId']); ?>"/>
      
        <table width="100%">
            <tr>
                <td>Rawmaterial </td>
                 <td>:&nbsp;&nbsp;</td>
                <td>
                    <input type="text" id="product_descript" name="product_descript" class="textStyle" value="<?php echo $bodycontent['rawmaterial']['product_description'];?>"/>
                    
                    </td>
            </tr>
            
             <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>Unit  </td>
                <td>:&nbsp;&nbsp;</td>
                <td>
                    <select name="unitid" id="unitid" style="width:180px;" class="selectStyle">
                        <option value="0">Select</option>
                        <?php foreach($header['unitlist'] as $rows){?>
                <option value="<?php echo($rows['unitid'])?>" <?php if($bodycontent['rawmaterial']['unitid']== $rows['unitid']){echo('selected');}else{echo('');} ?>><?php echo($rows['unitName']); ?></option>
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
                <td>Opening Stock:</td>
                <td>:&nbsp;&nbsp;</td>
                <td> 
                    <input type="text" id="opening" name="opening" class="textStylesmall" value="<?php echo $bodycontent['rawmaterial']['opening'];?>" />
                    <input type="hidden" id="rate" name="rate" value="0.00<?php //echo $bodycontent['rawmaterial']['purchase_rate'];?>" />
                </td>
            </tr>
             <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            
        </table>
  
    <div id="saveUnit"> <span class="buttondiv"><div class="save" id="saveRawmaterial" align="center">Save</div></span></div>
    </section>
</form>


<div id="raw_material_save"  style="display:none" title="Raw Material">
    <span>Data successfully save.</span>
</div>
<div id="rawmaterial_validate_error" style="display:none" title="Raw Material">
    <span>Validation failed</span>
</div>







