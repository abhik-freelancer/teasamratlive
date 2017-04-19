<script src="<?php echo base_url(); ?>application/assets/js/subledger.js"></script> 


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
        #saveledger{
        width:350px;
        cursor:pointer;
        margin:0 auto;
        padding:0;
    }
    section#loginBox{
        margin-bottom:-8px;
    }
</style>


<h2><font color="#5cb85c">Subledger</font></h2>


<form role="form" method="post" name="subledger" id="subledger">
    
  <section id="loginBox" style="width:350px;">
      <input type="hidden" id="txtModeOfoperation" name="txtModeOfoperation" value="<?php echo($header['mode']); ?>"/>
        <input type="hidden" id="subLedgerId" name="subLedgerId" value="<?php echo($header['subLedgerId']); ?>"/>
          <label>Subledger: &nbsp;
            <input type="text" id="subLedger" name="subLedger" value="<?php echo $bodycontent['subledgerdata']->subledger;?>" style="border:1px solid green;border-radius:5px;"/> 
  </section>


    <br><br>
    <div id="saveledger"><span class="buttondiv"><div class="save" id="saveSubLedger" align="center">Save</div></span></div>
</form>

<div id="ledger_save_dilg"  style="display:none" title="subledger">
    <span>Data successfully save.</span>
</div>
<div id="ledger_validate_error" style="display:none" title="subledger">
    <span>Validation failed</span>
</div>







