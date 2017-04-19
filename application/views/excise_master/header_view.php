<script src="<?php echo base_url(); ?>application/assets/js/exciseMaster.js"></script> 


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
    width:180px;
}
#description{
    resize:none;
}
</style>


<?php if($header['mode']=="Add"){?>
<h2><font color="#5cb85c">Add Excise master</font></h2>
<?php }else{?>
<h2><font color="#5cb85c">Edit Excise master</font></h2>
<?php }?>


<form role="form" method="post" name="ecciseMaster" id="ecciseMaster">
    
  <section id="loginBox" style="width:450px;">
      <input type="hidden" id="txtModeOfoperation" name="txtModeOfoperation" value="<?php echo($header['mode']); ?>"/>
        <input type="hidden" id="excisemasterid" name="excisemasterid" value="<?php echo($header['excisemasterId']); ?>"/>
      
        <table width="100%">
          <tr>
                <td>Description </td>
                <td>:&nbsp;&nbsp;</td>
                <td><input type="text" id="description" name="description" class="textStyle" value="<?php echo $bodycontent['exciseMaster']['description'];?>"/>
                </td>
            </tr>
           
             <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>Rate:</td>
                 <td>:&nbsp;&nbsp;</td>
                <td> <input type="text" id="rate" name="rate" class="rate textStyle" value="<?php echo $bodycontent['exciseMaster']['rate'];?>"/></td>
            </tr>
            
            
        </table>
  </section>


    <br><br>
    <div id="saveUnit"> <span class="buttondiv"><div class="save" id="saveexciseMaster" align="center">Save</div></span></div>
</form>

<div id="unit_save_dilg"  style="display:none" title="excisemaster">
    <span>Data successfully save.</span>
</div>
<div id="unit_validate_error" style="display:none" title="excisemaster">
    <span>Validation failed</span>
</div>









