<script src="<?php echo base_url(); ?>application/assets/js/challanwiseReport.js"></script> 
<script src="<?php echo base_url(); ?>application/assets/js/jquery-customselect.js"></script> 
<link rel="stylesheet" href="<?php echo base_url(); ?>application/assets/css/jquery-customselect.css" />

<style type="text/css">

 .custom-select {
    position: relative;
    width: 280px;
    height:25px;
    line-height:10px;
  font-size: 9px;
  border:1px solid green;
  border-radius:5px;
    
 
}
.custom-select a {
  display: block;
  width: 280px;
  height: 25px;
  padding: 8px 6px;
  color: #000;
  text-decoration: none;
  cursor: pointer;
  font-family: "Open Sans",helvetica,arial,sans-serif;
    font-size: 12px;
}
.custom-select div ul li.active {
    display: block;
    cursor: pointer;
    font-size: 12px;
}


.custom-select input {
    width: 260px;
    font-family: "Open Sans",helvetica,arial,sans-serif;
    font-size: 12px;
}
</style>

<select  id="challanno" name="challanno" class='custom-select'>
				<option value="ALL">--Select--</option>
                <?php 
				if($challanno){
				foreach($challanno as $row){?>
								<option value="<?php echo($row['chalanNumber']); ?>"> <?php echo($row['chalanNumber']); ?> </option>
				<?php 
					}
				}
				?>
</select>
