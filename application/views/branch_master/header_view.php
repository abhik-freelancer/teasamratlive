<script src="<?php echo base_url(); ?>application/assets/js/branchmaster.js"></script> 


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
#address{
    resize:none;
}
#saveBranch{
    width:40%;
    margin:0 auto;
    cursor:pointer;
    
}
</style>


<?php if($header['mode']=="Add"){?>
<h2><font color="#5cb85c">Add Branch master</font></h2>
<?php }else{?>
<h2><font color="#5cb85c">Edit Branch master</font></h2>
<?php }?>


<form role="form" method="post" name="branchMaster" id="branchMaster">
    
  <section id="loginBox" style="width:450px;">
      <input type="hidden" id="txtModeOfoperation" name="txtModeOfoperation" value="<?php echo($header['mode']); ?>"/>
        <input type="hidden" id="branchmasterid" name="branchmasterid" value="<?php echo($header['branchmastId']); ?>"/>
      
        <table width="100%">
          <tr>
                <td>Branch Name: </td>
                <td>:&nbsp;&nbsp;</td>
                <td><input type="text" id="branchname" name="branchname" class="textStyle" value="<?php echo $bodycontent['branchMaster']['branch'];?>"/>
                </td>
            </tr>
           
             <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>Address:</td>
                 <td>:&nbsp;&nbsp;</td>
                <td><textarea id="address" name="address" class="textStyle"><?php echo $bodycontent['branchMaster']['branch_address']; ?></textarea> </td>
            </tr>
            
            
        </table>
  </section>


    <br><br>
    <div id="saveBranch"> <span class="buttondiv"><div class="save" id="saveBranchmaster" align="center">Save</div></span></div>
</form>

<div id="branch_save_dilg"  style="display:none" title="Branch">
    <span>Data successfully save.</span>
</div>
<div id="branch_validate_error" style="display:none" title="Branch">
    <span>Validation failed</span>
</div>









