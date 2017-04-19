<script src="<?php echo base_url(); ?>application/assets/js/unitmaster.js"></script> 


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
</style>


<h2><font color="#5cb85c">Unit Master</font></h2>


<form role="form" method="post" name="UnitMaster" id="UnitMaster">
    
  <section id="loginBox" style="width:350px;">
      <input type="hidden" id="txtModeOfoperation" name="txtModeOfoperation" value="<?php echo($header['mode']); ?>"/>
        <input type="hidden" id="unitId" name="unitId" value="<?php echo($header['unitId']); ?>"/>
          <label>Unit Name: &nbsp;
              <input type="text" id="unitmaster" name="unitmaster" value="<?php echo $bodycontent['unitmaster']->unitName;?>" style="border:1px solid green;border-radius:5px;"/> 
  </section>


    <br><br>
    <div id="saveUnit"> <span class="buttondiv"><div class="save" id="saveUnitMaster" align="center">Save</div></span></div>
</form>

<div id="unit_save_dilg"  style="display:none" title="unitmaster">
    <span>Data successfully save.</span>
</div>
<div id="unit_validate_error" style="display:none" title="unitmaster">
    <span>Validation failed</span>
</div>









