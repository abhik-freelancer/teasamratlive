<div style="text-align:center;text-shadow:2px 2px 8px #262626"><h1><font face="Impact" size="9" color="white" >Welcome to <?php echo $companyname;?> </font></h1></div>
        
   <link href="<?php echo base_url(); ?>application/assets/css/jquery.bxslider.css" rel="stylesheet" type="text/css"  /> 
   <link href="<?php echo base_url(); ?>application/assets/css/welcom-view.css" rel="stylesheet" type="text/css"  /> 
   <script src="<?php echo base_url(); ?>application/assets/js/jquery.bxslider.js" type="text/javascript"></script>
   <script src="<?php echo base_url(); ?>application/assets/js/jquery.bxslider.min.js" type="text/javascript"></script>
   
   <script type="text/javascript">
       /* $(function() {

			$('.bxslider').bxSlider({
			  auto: true,
			  autoControls: true,
			  adaptiveHeight: true,
			});
					});*/
   </script>
   <!-- 
    <ul class="bxslider" style="text-align:center">
 		
      <li style="text-align:left;"><img src="<?php echo base_url(); ?>application/assets/images/merry-christmas.png" /></li>
      <li style="text-align:center;"><img src="<?php echo base_url(); ?>application/assets/images/hill_trees.jpg" /></li>
      <li style="text-align:center;"><img src="<?php echo base_url(); ?>application/assets/images/teagarden2.jpg" /></li>
    </ul>-->
	
	
	<?php
	/*
		echo "<pre>";
		print_r($bodycontent['sitemapMenu1']);
		echo "</pre>"; 

	*/
	?>
   <div class="container">
  
		<div id="home-container">
			<div id="site-map-overview">
				<p>Sitemap </p>
				<div class="row" style="margin-top: -10px;padding-top:1%;">
				
				
					<div class="col-md-4 sitemapMenuBlock" id="siteMapPanel1" >
						<ul>
							<?php 
							foreach($bodycontent['sitemapGetReady'] as $sitemap_menu){ ?>
								<li class="parent-li" id="parent-first" ><span class="glyphicon glyphicon-hand-right"></span><a href="<?php if($sitemap_menu['menu_link']=="#"){echo "javascript:void(0)";}else{echo base_url().$sitemap_menu['menu_link'];}?>"><?php echo $sitemap_menu['menu_name']; ?></a></li>
								
							<?php	
								if(sizeof($sitemap_menu['secondLevelMenu'])>0)
								{ 
									
									
								?>
									<ul>
										<?php 
										foreach($sitemap_menu['secondLevelMenu'] as $second_lvel){ 
										
										$class = "";
										$third_lvl = sizeof($second_lvel['thirdLevelMenu']);
										if($third_lvl>0)
										{
											$class = "child-li";
										}
										else
										{
											$class = "";
										}
										
										?>
										<li class="<?php echo $class; ?>"><span class="glyphicon glyphicon-chevron-right"></span><a href="<?php if($second_lvel['second_menu_link']=="#"){echo "javascript:void(0)";}else{echo $second_lvel['second_menu_link'];}?>"><?php echo $second_lvel['second_menu_name']; ?></a>
											<?php if($second_lvel['is_new']=="Y"){?>
											<img src="<?php echo base_url();?>application/assets/images/new-blink.gif" width="30" />
											<?php } ?>
										</li>
										
										<?php if(sizeof($second_lvel['thirdLevelMenu'])>0){ ?>
											<ul>
											<?php
											foreach($second_lvel['thirdLevelMenu'] as $third_level){
											?>
												<li><span class="glyphicon glyphicon-star-empty"></span><a href="<?php if($third_level['third_menu_link']=="#"){echo "javascript:void(0)";}else{echo $third_level['third_menu_link'];}?>"><?php echo $third_level['third_menu_name']; ?></a>
													<?php if($third_level['is_new']=="Y"){?>
													<img src="<?php echo base_url();?>application/assets/images/new-blink.gif" width="30" />
													<?php } ?>
												</li>
											
											<?php }?>
											</ul>
										
										<?php } ?>
										
										<?php } ?>
									</ul>
							<?php	}
								else
								{echo "";}
							}
							?>								 
						</ul>
					</div> <!-- END OF COL-MD-4----->
					
					
					<div class="col-md-4 sitemapMenuBlock" id="siteMapPanel2" >
					
					
						<ul>
							<?php 
							foreach($bodycontent['sitemapPurchase'] as $sitemap_menu){ ?>
								<li class="parent-li"  ><span class="glyphicon glyphicon-hand-right"></span><a href="<?php if($sitemap_menu['menu_link']=="#"){echo "javascript:void(0)";}else{echo $sitemap_menu['menu_link'];}?>"><?php echo $sitemap_menu['menu_name']; ?></a></li>
								
							<?php	
								if(sizeof($sitemap_menu['secondLevelMenu'])>0)
								{ ?>
									<ul>
										<?php 
										foreach($sitemap_menu['secondLevelMenu'] as $second_lvel){ 
										
										$class = "";
										$third_lvl = sizeof($second_lvel['thirdLevelMenu']);
										if($third_lvl>0)
										{
											$class = "child-li";
										}
										else
										{
											$class = "";
										}
										
										?>
										<li class="<?php echo $class; ?>"><span class="glyphicon glyphicon-chevron-right"></span><a href="<?php if($second_lvel['second_menu_link']=="#"){echo "javascript:void(0)";}else{echo $second_lvel['second_menu_link'];}?>"><?php echo $second_lvel['second_menu_name']; ?></a>
											<?php if($second_lvel['is_new']=="Y"){?>
											<img src="<?php echo base_url();?>application/assets/images/new-blink.gif" width="30" />
											<?php } ?>
										</li>
										
										<?php if(sizeof($second_lvel['thirdLevelMenu'])>0){ ?>
											<ul>
											<?php
											foreach($second_lvel['thirdLevelMenu'] as $third_level){
											?>
												<li><span class="glyphicon glyphicon-star-empty"></span><a href="<?php if($third_level['third_menu_link']=="#"){echo "javascript:void(0)";}else{echo $third_level['third_menu_link'];}?>"><?php echo $third_level['third_menu_name']; ?></a> 
												<?php if($third_level['is_new']=="Y"){?>
												<img src="<?php echo base_url();?>application/assets/images/new-blink.gif" width="30" />
												<?php } ?>
												
												</li>
											
											<?php }?>
											</ul>
										
										<?php } ?>
										
										<?php } ?>
									</ul>
							<?php	}
								else
								{echo "";}
							}
							?>								 
						</ul>
						
						
						<ul>
							<?php 
							foreach($bodycontent['sitemapBlenAndOthr'] as $sitemap_menu){ ?>
								<li class="parent-li"  ><span class="glyphicon glyphicon-hand-right"></span><a href="<?php if($sitemap_menu['menu_link']=="#"){echo "javascript:void(0)";}else{echo $sitemap_menu['menu_link'];}?>"><?php echo $sitemap_menu['menu_name']; ?></a></li>
								
							<?php	
								if(sizeof($sitemap_menu['secondLevelMenu'])>0)
								{ ?>
									<ul>
										<?php 
										foreach($sitemap_menu['secondLevelMenu'] as $second_lvel){ 
										
										$class = "";
										$third_lvl = sizeof($second_lvel['thirdLevelMenu']);
										if($third_lvl>0)
										{
											$class = "child-li";
										}
										else
										{
											$class = "";
										}
										
										?>
										<li class="<?php echo $class; ?>"><span class="glyphicon glyphicon-chevron-right"></span><a href="<?php if($second_lvel['second_menu_link']=="#"){echo "javascript:void(0)";}else{echo $second_lvel['second_menu_link'];}?>"><?php echo $second_lvel['second_menu_name']; ?></a>
											<?php if($second_lvel['is_new']=="Y"){?>
											<img src="<?php echo base_url();?>application/assets/images/new-blink.gif" width="30" />
											<?php } ?>
										</li>
										
										<?php if(sizeof($second_lvel['thirdLevelMenu'])>0){ ?>
											<ul>
											<?php
											foreach($second_lvel['thirdLevelMenu'] as $third_level){
											?>
												<li><span class="glyphicon glyphicon-star-empty"></span><a href="<?php if($third_level['third_menu_link']=="#"){echo "javascript:void(0)";}else{echo $third_level['third_menu_link'];}?>"><?php echo $third_level['third_menu_name']; ?></a>
												<?php if($third_level['is_new']=="Y"){?>
												<img src="<?php echo base_url();?>application/assets/images/new-blink.gif" width="30" />
												<?php } ?>
												</li>
											
											<?php }?>
											</ul>
										
										<?php } ?>
										
										<?php } ?>
									</ul>
							<?php	}
								else
								{echo "";}
							}
							?>								 
						</ul>
						
						
						
						
						<ul>
							<?php 
							foreach($bodycontent['sitemapStock'] as $sitemap_menu){ ?>
								<li class="parent-li"  ><span class="glyphicon glyphicon-hand-right"></span><a href="<?php if($sitemap_menu['menu_link']=="#"){echo "javascript:void(0)";}else{echo $sitemap_menu['menu_link'];}?>"><?php echo $sitemap_menu['menu_name']; ?></a></li>
								
							<?php	
								if(sizeof($sitemap_menu['secondLevelMenu'])>0)
								{ ?>
									<ul>
										<?php 
										foreach($sitemap_menu['secondLevelMenu'] as $second_lvel){

										$class = "";
										$third_lvl = sizeof($second_lvel['thirdLevelMenu']);
										if($third_lvl>0)
										{
											$class = "child-li";
										}
										else
										{
											$class = "";
										}
										
										?>
										<li class="<?php echo $class; ?>"><span class="glyphicon glyphicon-chevron-right"></span><a href="<?php if($second_lvel['second_menu_link']=="#"){echo "javascript:void(0)";}else{echo $second_lvel['second_menu_link'];}?>"><?php echo $second_lvel['second_menu_name']; ?></a>
											<?php if($second_lvel['is_new']=="Y"){?>
											<img src="<?php echo base_url();?>application/assets/images/new-blink.gif" width="30" />
											<?php } ?>
										</li>
										
										<?php if(sizeof($second_lvel['thirdLevelMenu'])>0){ ?>
											<ul>
											<?php
											foreach($second_lvel['thirdLevelMenu'] as $third_level){
											?>
												<li><span class="glyphicon glyphicon-star-empty"></span><a href="<?php if($third_level['third_menu_link']=="#"){echo "javascript:void(0)";}else{echo $third_level['third_menu_link'];}?>"><?php echo $third_level['third_menu_name']; ?></a>
													<?php if($third_level['is_new']=="Y"){?>
													<img src="<?php echo base_url();?>application/assets/images/new-blink.gif" width="30" />
													<?php } ?>
												</li>
											
											<?php }?>
											</ul>
										
										<?php } ?>
										
										<?php } ?>
									</ul>
							<?php	}
								else
								{echo "";}
							}
							?>								 
						</ul>
						
						
						
						
					</div> <!-- END OF COL-MD-4----->
					
					
					
					<div class="col-md-4 sitemapMenuBlock" id="siteMapPanel3" >
						<ul>
							<?php 
							foreach($bodycontent['sitemapSale'] as $sitemap_menu){ ?>
								<li class="parent-li"  ><span class="glyphicon glyphicon-hand-right"></span><a href="<?php if($sitemap_menu['menu_link']=="#"){echo "javascript:void(0)";}else{echo $sitemap_menu['menu_link'];}?>"><?php echo $sitemap_menu['menu_name']; ?></a></li>
								
							<?php	
								if(sizeof($sitemap_menu['secondLevelMenu'])>0)
								{ ?>
									<ul>
										<?php 
										foreach($sitemap_menu['secondLevelMenu'] as $second_lvel){ 
										
										$class = "";
										$third_lvl = sizeof($second_lvel['thirdLevelMenu']);
										if($third_lvl>0)
										{
											$class = "child-li";
										}
										else
										{
											$class = "";
										}
										
										
										?>
										<li class="<?php echo $class; ?>"><span class="glyphicon glyphicon-chevron-right"></span><a href="<?php if($second_lvel['second_menu_link']=="#"){echo "javascript:void(0)";}else{echo $second_lvel['second_menu_link'];}?>"><?php echo $second_lvel['second_menu_name']; ?></a>
											<?php if($second_lvel['is_new']=="Y"){?>
											<img src="<?php echo base_url();?>application/assets/images/new-blink.gif" width="30" />
											<?php } ?>
										</li>
										
										<?php if(sizeof($second_lvel['thirdLevelMenu'])>0){ ?>
											<ul>
											<?php
											foreach($second_lvel['thirdLevelMenu'] as $third_level){
											?>
												<li><span class="glyphicon glyphicon-star-empty"></span><a href="<?php if($third_level['third_menu_link']=="#"){echo "javascript:void(0)";}else{echo $third_level['third_menu_link'];}?>"><?php echo $third_level['third_menu_name']; ?></a>
													<?php if($third_level['is_new']=="Y"){?>
													<img src="<?php echo base_url();?>application/assets/images/new-blink.gif" width="30" />
													<?php } ?>
												</li>
											
											<?php }?>
											</ul>
										
										<?php } ?>
										
										<?php } ?>
									</ul>
							<?php	}
								else
								{echo "";}
							}
							?>								 
						</ul>
						
						
						<ul>
							<?php 
							foreach($bodycontent['sitemapAccount'] as $sitemap_menu){ ?>
								<li class="parent-li"  ><span class="glyphicon glyphicon-hand-right"></span><a href="<?php if($sitemap_menu['menu_link']=="#"){echo "javascript:void(0)";}else{echo $sitemap_menu['menu_link'];}?>"><?php echo $sitemap_menu['menu_name']; ?></a></li>
								
							<?php	
								if(sizeof($sitemap_menu['secondLevelMenu'])>0)
								{ ?>
									<ul>
										<?php 
										foreach($sitemap_menu['secondLevelMenu'] as $second_lvel){
										
										$class = "";
										$third_lvl = sizeof($second_lvel['thirdLevelMenu']);
										if($third_lvl>0)
										{
											$class = "child-li";
										}
										else
										{
											$class = "";
										}
			
										?>
										<li class="<?php echo $class; ?>"><span class="glyphicon glyphicon-chevron-right"></span><a href="<?php if($second_lvel['second_menu_link']=="#"){echo "javascript:void(0)";}else{echo $second_lvel['second_menu_link'];}?>"><?php echo $second_lvel['second_menu_name']; ?></a>
											<?php if($second_lvel['is_new']=="Y"){?>
											<img src="<?php echo base_url();?>application/assets/images/new-blink.gif" width="30" />
											<?php } ?>
										</li>
										
										<?php if(sizeof($second_lvel['thirdLevelMenu'])>0){ ?>
											<ul>
											<?php
											foreach($second_lvel['thirdLevelMenu'] as $third_level){
											?>
												<li><span class="glyphicon glyphicon-star-empty"></span><a href="<?php if($third_level['third_menu_link']=="#"){echo "javascript:void(0)";}else{echo $third_level['third_menu_link'];}?>"><?php echo $third_level['third_menu_name']; ?></a>
													<?php if($third_level['is_new']=="Y"){?>
													<img src="<?php echo base_url();?>application/assets/images/new-blink.gif" width="30" />
													<?php } ?>
												</li>
											
											<?php }?>
											</ul>
										
										<?php } ?>
										
										<?php } ?>
									</ul>
							<?php	}
								else
								{echo "";}
							}
							?>								 
						</ul>
						
						
						<ul>
							<?php 
							foreach($bodycontent['sitemapMIS'] as $sitemap_menu){ ?>
								<li class="parent-li"  ><span class="glyphicon glyphicon-hand-right"></span><a href="<?php if($sitemap_menu['menu_link']=="#"){echo "javascript:void(0)";}else{echo $sitemap_menu['menu_link'];}?>"><?php echo $sitemap_menu['menu_name']; ?></a></li>
								
							<?php	
								if(sizeof($sitemap_menu['secondLevelMenu'])>0)
								{ ?>
									<ul>
										<?php 
										foreach($sitemap_menu['secondLevelMenu'] as $second_lvel){ 
										
										$class = "";
										$third_lvl = sizeof($second_lvel['thirdLevelMenu']);
										if($third_lvl>0)
										{
											$class = "child-li";
										}
										else
										{
											$class = "";
										}
										
										?>
										<li class="<?php echo $class; ?>"><span class="glyphicon glyphicon-chevron-right"></span><a href="<?php if($second_lvel['second_menu_link']=="#"){echo "javascript:void(0)";}else{echo $second_lvel['second_menu_link'];}?>"><?php echo $second_lvel['second_menu_name']; ?></a>
											<?php if($second_lvel['is_new']=="Y"){?>
											<img src="<?php echo base_url();?>application/assets/images/new-blink.gif" width="30" />
											<?php } ?>
										</li>
										
										<?php if(sizeof($second_lvel['thirdLevelMenu'])>0){ ?>
											<ul>
											<?php
											foreach($second_lvel['thirdLevelMenu'] as $third_level){
											?>
												<li><span class="glyphicon glyphicon-star-empty"></span><a href="<?php if($third_level['third_menu_link']=="#"){echo "javascript:void(0)";}else{echo $third_level['third_menu_link'];}?>"><?php echo $third_level['third_menu_name']; ?></a>
													<?php if($third_level['is_new']=="Y"){?>
													<img src="<?php echo base_url();?>application/assets/images/new-blink.gif" width="30" />
													<?php } ?>
												</li>
											
											<?php }?>
											</ul>
										
										<?php } ?>
										
										<?php } ?>
									</ul>
							<?php	}
								else
								{echo "";}
							}
							?>								 
						</ul>
						
						<ul>
							<?php 
							foreach($bodycontent['sitemapUtility'] as $sitemap_menu){ ?>
								<li class="parent-li"  ><span class="glyphicon glyphicon-hand-right"></span><a href="<?php if($sitemap_menu['menu_link']=="#"){echo "javascript:void(0)";}else{echo $sitemap_menu['menu_link'];}?>"><?php echo $sitemap_menu['menu_name']; ?></a></li>
								
							<?php	
								if(sizeof($sitemap_menu['secondLevelMenu'])>0)
								{ ?>
									<ul>
										<?php 
										foreach($sitemap_menu['secondLevelMenu'] as $second_lvel){ 
										$class = "";
										$third_lvl = sizeof($second_lvel['thirdLevelMenu']);
										if($third_lvl>0)
										{
											$class = "child-li";
										}
										else
										{
											$class = "";
										}
										?>
										<li class="<?php echo $class; ?>"><span class="glyphicon glyphicon-chevron-right"></span><a href="<?php if($second_lvel['second_menu_link']=="#"){echo "javascript:void(0)";}else{echo $second_lvel['second_menu_link'];}?>"><?php echo $second_lvel['second_menu_name']; ?></a>
											<?php if($second_lvel['is_new']=="Y"){?>
											<img src="<?php echo base_url();?>application/assets/images/new-blink.gif" width="30" />
											<?php } ?>
										</li>
										
										<?php if(sizeof($second_lvel['thirdLevelMenu'])>0){ ?>
											<ul>
											<?php
											foreach($second_lvel['thirdLevelMenu'] as $third_level){
											?>
												<li><span class="glyphicon glyphicon-star-empty"></span><a href="<?php if($third_level['third_menu_link']=="#"){echo "javascript:void(0)";}else{echo $third_level['third_menu_link'];}?>"><?php echo $third_level['third_menu_name']; ?></a>
													<?php if($third_level['is_new']=="Y"){?>
													<img src="<?php echo base_url();?>application/assets/images/new-blink.gif" width="30" />
													<?php } ?>
												</li>
											
											<?php }?>
											</ul>
										
										<?php } ?>
										
										<?php } ?>
									</ul>
							<?php	}
								else
								{echo "";}
							}
							?>								 
						</ul>
						
					</div> <!-- END OF COL-MD-4----->
					
					
					
					
					

					

					
				</div> <!---- END ROW------->
				
			</div>
		</div>
   </div>