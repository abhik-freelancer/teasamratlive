<?php
/* 
echo "<pre>";
	print_r($leftmenu);
echo "</pre>"; */

?>

<?php 
/*
foreach($leftmenu as $firstlevel){
	echo $firstlevel['menu_name']."<br>";
}
*/
?>
<div class="navbar navbar-default " role="navigation">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">
				<img src="<?php echo base_url();?>application/assets/images/cup-tea.png" id="icon-img"/>&nbsp;
				<span id="compnyHeading"><?php echo " ".$companyname;?>&nbsp;(&nbsp;<?php echo $startyear; ?>&nbsp;-&nbsp;<?php echo $endyear; ?>&nbsp;)&nbsp;</span>
			</a>
        </div>
        <div class="collapse navbar-collapse">
           <ul class="nav navbar-nav navbar-right">
            <li class="dropdown hidden-xs">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <span class="glyphicon glyphicon-user padding-right-small" style="position:relative;top: 3px;"></span> <?php echo  $username; ?>
                    <i class="fa fa-caret-down"></i>
                </a>

              <ul class="dropdown-menu">
				<li><a tabindex="-1" href="<?php echo base_url();?>home/logout">Logout</a></li>
              </ul>
            </li>
            </ul>
			
            <ul class="nav navbar-nav">
				<li><a href="<?php echo base_url(); ?>home"><span class="glyphicon glyphicon-home"></span></a></li>
				<?php 
				
				if(sizeof($leftmenu)>0){
					foreach($leftmenu as $firstlevel)
					{
					if(sizeof($firstlevel['secondLevelMenu'])>0){
					?>
				<li>
				
				<a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $firstlevel['menu_name']; ?><b class="caret"></b></a>
				
				<!--------/**************SECOND LEVEL MENU**************/-------->
					
					<ul class="dropdown-menu multi-level">
					
						<?php 
							foreach($firstlevel['secondLevelMenu'] as $second_lvl){
							if(sizeof($second_lvl['thirdLevelMenu'])>0){	
						?>
						<!--------/**************THIRD LEVEL MENU**************/-------->	
						<li class="dropdown-submenu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $second_lvl['second_menu_name']; ?></a>
                            <ul class="dropdown-menu">
                               <?php foreach($second_lvl['thirdLevelMenu'] as $third_lvl){?>
									<li><a href="<?php echo base_url().$third_lvl['third_menu_link']; ?>"><?php echo $third_lvl['third_menu_name']; ?></a></li>
								<?php } ?>
                            </ul>
                        </li>
							
							
						<?php }
						else{ ?>
							<li><a href="<?php echo base_url().$second_lvl['second_menu_link']; ?>"><?php echo $second_lvl['second_menu_name']; ?></a></li>
						<?php 		 
							}
						?>
						
						<?php } ?>
					</ul>
					
				</li>
				<?php } 
					else{ ?>
						<li><a href="<?php echo base_url().$firstlevel['menu_link'];?>" ><?php echo $firstlevel['menu_name']; ?></a>
				<?php
						}
					} 
				}
				?>
				
			</ul>
		</div><!--/.nav-collapse -->
    </div>
</div>






