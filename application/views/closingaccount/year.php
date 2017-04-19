<script src="<?php echo base_url(); ?>application/assets/js/closingtransfer.js"></script>
<div class="stats">
   <p class="stat">
        <a href="#">
            <img src="<?php echo base_url(); ?>application/assets/images/home.jpg" hieght="30" width="30"/>
        </a>
    </p>
</div>


<h2><font color="#5cb85c">Account closing balance transfer</font></h2>
<section id="loginBox" style="height: 70px;">
  <table width="70%" >
  <tr>
  
    <td>Current year.&nbsp;</td>
    <td><input type="text" name="txtCurrentyear" id="txtCurrentyear" class="" disabled="disables"  
               value="<?php echo($bodycontent["year"]); ?>" placeholder=""/>
        <input type="hidden" id="currentyearid" value="<?php echo($bodycontent["currentyearid"]); ?>" />     
    </td>
    <td>Next year&nbsp;</td>
    <td>
        <input type="text" name="txtNextYear" id="txtNextYear" class="" disabled="disables"  value="<?php echo($bodycontent["next_year"]["nextYear"]); ?>"/>
        <input type="hidden" id="nextyearid" value="<?php echo($bodycontent["next_year"]["nextId"]); ?>" />
    </td>
    <td>
        <?php if($bodycontent["next_year"]["nextId"]!=""){ ?>
        <img src="<?php echo base_url(); ?>application/assets/images/folder_arrow_right_move_send.png " id="transfer" style="cursor: pointer;"/>
        <?php } ?>
    </td>
    <td>&nbsp;</td>
  </tr>
  
</table>
</section>
<div class="container" id="datadiv">
    <img src="<?php echo base_url(); ?>application/assets/images/loading.gif" id="loader" style="display: none;padding-left:450px;"/>
</div>


