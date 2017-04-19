<script src="<?php echo base_url(); ?>application/assets/js/rawmaterialconsumption.js"></script>
<script src="<?php echo base_url(); ?>application/assets/js/jquery-customselect.js"></script> 
<link rel="stylesheet" href="<?php echo base_url(); ?>application/assets/css/jquery-customselect.css" />
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
#addnewDtlDiv{
    cursor:pointer;
}
.textStyle{
    border:1px solid green;
    border-radius:5px;
    width:250px;
}
.selectStyle{
    border-top:1px solid green;
    border-left:1px solid green;
    border-bottom:1px solid green;
    border-radius:5px;
}
.textstyleBottom{
     border:1px solid green;
    border-radius:5px;
    width:150px;
}
.custom-select {
    position: relative;
    width: 250px;
    height:25px;
    line-height:10px;
  font-size: 9px;
  border:1px solid green;
  border-radius:5px ;
    
 
}
.custom-select a {
  display: block;
  width: 250px;
  height: 25px;
  padding: 8px 6px;
  color: #000;
  text-decoration: none;
  cursor: pointer;
  font-family: "Open Sans",helvetica,arial,sans-serif;
  font-size: 9px;
}
.custom-select div ul li.active {
    display: block;
    cursor: pointer;
    font-size: 9px;
}
.custom-select div ul li:hover{
    background:#6C8E68;
    transition:.5s;
    color:#fff;
}

.custom-select input {
    width: 235px;
    font-family: "Open Sans",helvetica,arial,sans-serif;
    font-size: 9px;
}
</style>


<h2><font color="#5cb85c">Map Raw Material</font></h2>




    <section id="loginBox" >
        <div class="table-responsive">
        <table class="table">
            <tr>
                <td colspan="3">
                 <select class="form-control" id="product">
                        <option value="" > Select product </option>
                        <?php
                        foreach ($header['productList'] as $rows) {?>
    
                        <option value="<?php echo($rows["productid"]); ?>" >
                                <?php echo($rows["products"]); ?>
                                
                        </option>
                        
                        
                        <?php } ?>
                        
                    </select>
                
                
                </td>
                <td>
                    &nbsp;
                </td>
            </tr>
            <tr>
                <td>
                    <select class="form-control" id="rawmaterial">
                        <option value="" > Select raw material </option>
                        <?php
                        foreach ($header['rawmaterial'] as $rows) {?>
    
                        <option value="<?php echo($rows["id"]); ?>" >
                                <?php echo($rows["product_description"]); ?>
                                
                        </option>
                        
                        
                        <?php } ?>
                        
                    </select>
                </td>
                <td><input type="text" id="txtUnit" placeholder="Unit" disabled="disabled" class="form-control"/></td>
                <td><input type="text" placeholder="Qty" id="txtQty" class="form-control Quantity"/></td>
                <td><button type="button" class="btn btn-success" id="addmatrl">Add material</button></td>
            </tr>
        </table>
        </div>
    </section>
<section id="loginBox" >
    <table id="detail_material" class="table-hover" width="100%">
        
             <thead>
            <tr>
                <th>Raw material</th>
                <th>Unit</th>
                <th>Qty</th>
                <th>Action</th>
            </tr>
             </thead>
             <tbody></tbody>
        
    </table>
</section>
<section id="loginBox">
     <button type="button" class="btn btn-primary btn-block btn_save">Save</button>
</section>


