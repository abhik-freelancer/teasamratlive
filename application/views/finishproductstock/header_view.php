<script src="<?php echo base_url(); ?>application/assets/js/finishproductStock.js"></script>



<h1 style="font-size:26px;"><font color="#5cb85c">Finish Product - Stock</font></h1>
<div id="adddiv">
   <form id="frmFinishPrdStock" name="frmFinishPrdStock" method="post" action="<?php echo base_url(); ?>finishproductstock/getFinishPrdStock"  target="_blank">
<section id="loginBox" style="width:650px;">
    <table cellspacing="" cellpadding="0" class="tablespace" >
        <tr>
            <td scope="row" >Start Date <span style="color:red;">*</span></td>
            <td><input type="text" class="" id="startdate" name="startdate" value="<?php echo date('d-m-Y',strtotime($header['startDt']));?>" readonly /></td>
            <td scope="row" >End Date <span style="color:red;">*</span> </td>
            <td><input type="text" class="datepicker" id="enddate" name="enddate" value="<?php echo date("d-m-Y");?>"/></td>
        </tr>
        
    </table>
    <br/>
    <span class="buttondiv"><div class="save" id="finish_prd_btn_pdf" align="center" style="cursor:pointer;">Pdf</div></span>
</section>
    </form>
</div>
  

