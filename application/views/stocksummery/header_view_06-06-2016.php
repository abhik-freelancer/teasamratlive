<script src="<?php echo base_url(); ?>application/assets/js/stocksummery.js"></script> 

 <h1><font color="#5cb85c">Stock  Summary</font></h1>

 <div id="adddiv">
     <form id="frmStock" method="post" action="<?php echo base_url(); ?>stocksummery/getStockPrint"  target="_blank">
  <section id="loginBox" style="width:600px;">
      <table border="0" width="100%">
          <tr>
              <td>Group:</td>
              <td> 
                  <select id="group_code" name="group_code"  style="width: 205px; margin: 10px;select:focus {width:300px;}">
                        <option value="0"> All</option>
                        <?php if($bodycontent["teagrouplist"]){
                              foreach ($bodycontent["teagrouplist"] as $row){
                        ?>
                         <option value="<?php echo($row->id);?>" > <?php echo($row->group_code); ?> </option>
                        <?php 
                            }
                          }
                         ?>
                   </select>
              </td>
          </tr>
          <tr>
              <td>Price Range</td>
              <td>
                  <input type="text" name="fromPrice" id="fromPrice" value="" style="width:100px;" onkeyup="checkNumeric(this);"/> to <input type="text" name="toPrice" id="toPrice" value="" style="width:100px;" onkeyup="checkNumeric(this);"/>
              </td>
          </tr>
      </table>
      <br/>    
     <span class="buttondiv"><div class="save" id="stkreport" align="center"> Show </div></span>
  <br/>
  
  <span class="buttondiv"><div class="save" id="stkreportPrint" align="center"> Print </div></span>
  <br>

  
  
  </section>
         </form>
  
 </div>
 
 <div id="popupdiv"  style="display:none;" title="Detail">
      
     <!--<div  align="center" >
         <img src="<?php echo base_url(); ?>application/assets/images/loading.gif" title="" alt=""/>
     </div>-->

 </div>
  
 