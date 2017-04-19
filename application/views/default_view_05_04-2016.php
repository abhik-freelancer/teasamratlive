<!doctype html>
<html lang="en"><head>
    <meta charset="utf-8">
    <title>Tea Samrat</title>
    <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700' rel='stylesheet' type='text/css'>
   
   
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>application/assets/lib/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>application/assets/lib/font-awesome/css/font-awesome.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>application/assets/css/own_style.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>application/assets/css/jquery-ui.css">


    <script src="<?php echo base_url(); ?>application/assets/lib/jquery-1.11.1.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>application/assets/lib/jQuery-Knob/js/jquery.knob.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>application/assets/js/alert_modify.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>application/assets/js/jquery1.11.2-ui.js"></script>
    <link href="<?php echo base_url(); ?>application/assets/css/theme.css" rel="stylesheet" type="text/css"  />
    <link href="<?php echo base_url(); ?>application/assets/css/premium.css" rel="stylesheet" type="text/css"  />

    <!--code goes for multiseletc-->
    <link href="<?php echo base_url(); ?>application/assets/css/multiple-select.css" rel="stylesheet"/>
    
    <script src="<?php echo base_url(); ?>application/assets/lib/jquery.multiple.select.js"></script>

 <!--code goes for multiseletc-->

   

</head>
<body class=" theme-blue" >

    <!-- Demo page code -->

    <script type="text/javascript">
        $(function() {
				   
				   
            var match = document.cookie.match(new RegExp('color=([^;]+)'));
            if(match) var color = match[1];
            if(color) {
                $('body').removeClass(function (index, css) {
                    return (css.match (/\btheme-\S+/g) || []).join(' ')
                })
                $('body').addClass('theme-' + color);
            }

          $('[data-popover="true"]').popover({html: true});
            
        });
    </script>
    <style type="text/css">
        #line-chart {
            height:300px;
            width:800px;
            margin: 0px auto;
            margin-top: 1em;
        }
        .navbar-default .navbar-brand, .navbar-default .navbar-brand:hover { 
            color: #fff;
        }
    </style>

    <script type="text/javascript">
	
	
	
        $(function() {
            var uls = $('.sidebar-nav > ul > *').clone();
            uls.addClass('visible-xs');
            $('#main-menu').append(uls.clone());
        });
    </script>

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- Le fav and touch icons -->
    <link rel="shortcut icon" href="../assets/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="../assets/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="../assets/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="../assets/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="../assets/ico/apple-touch-icon-57-precomposed.png">
  

  <!--[if lt IE 7 ]> <body class="ie ie6"> <![endif]-->
  <!--[if IE 7 ]> <body class="ie ie7 "> <![endif]-->
  <!--[if IE 8 ]> <body class="ie ie8 "> <![endif]-->
  <!--[if IE 9 ]> <body class="ie ie9 "> <![endif]-->
  <!--[if (gt IE 9)|!(IE)]><!--> 
   
  <!--<![endif]-->

    <div class="navbar navbar-default" role="navigation">
        <div >
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="" href="index.html"><span class="navbar-brand"><img width="30" height="30" src="<?php echo base_url();?>application/assets/images/green-tea-cup.jpg"/> Tea Samrat</span></a></div>

        <div class="navbar-collapse collapse" style="height: 1px;">
          <ul id="main-menu" class="nav navbar-nav navbar-right">
            <li class="dropdown hidden-xs">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <span class="glyphicon glyphicon-user padding-right-small" style="position:relative;top: 3px;"></span> <?php echo  $username; ?>
                    
                   
                    
                    <i class="fa fa-caret-down"></i>
                </a>

              <ul class="dropdown-menu">
              <!--  <li><a href="./useraccount">My Account</a></li>
                <li class="divider"></li>
                <li class="dropdown-header">Admin Panel</li>
                <li><a href="./">Users</a></li>
                <li><a href="./">Security</a></li>
                <li><a tabindex="-1" href="./">Payments</a></li>
                <li class="divider"></li>-->
                <li><a tabindex="-1" href="<?php echo base_url();?>home/logout">Logout</a></li>
              </ul>
            </li>
          </ul>

        </div>
      </div>
    </div>
    

    <div class="sidebar-nav">
    <ul>
		<?php $this->load->view($leftmenusidebar); ?>

   

       
    </div>

    <div class="content">
      <?php if($headermenu != '')  : ?>   
        <div class="header">
         
			<?php $this->load->view($headermenu); ?>
        </div>
         <?php    endif;     ?>
         
        <div class="main-content" style="height:100%">
         <input type="hidden" value="<?php echo base_url(); ?>" id="basepath"></input>
        <div id="spinner" style="display:none"></div>
      <?php if($bodyview)  : ?>      
		 <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>application/assets/css/jquery.dataTables.css"> 
          <script src="<?php echo base_url(); ?>application/assets/js/jquery.dataTables.min.js" type="text/javascript"></script> 
         
         <link rel="stylesheet" href="<?php echo base_url(); ?>application/assets/css/jquery-ui.css">
		 <script src="<?php echo base_url(); ?>application/assets/js/jquery-ui.js"></script>
          <script src="<?php echo base_url(); ?>application/assets/js/master.js" type="text/javascript"></script>
         
            <!-- <link rel="stylesheet" href="http://jqueryui.com/resources/demos/style.css">-->
    
 	<script type="text/javascript">
	
	$(document).ready(function() {
    $('#example').dataTable();
	} );
	
	</script>
        	<?php $this->load->view($bodyview); ?>
 <input type="hidden" name="startyear" id="startyear" value="<?php echo $startyear; ?>"/>
  <input type="hidden" name="endyear" id="endyear" value="<?php echo $endyear; ?>"/>
     <?php
    endif; 
    ?>
         <footer>
               
            </footer>
        </div>
    </div>


	 <script src="<?php echo base_url(); ?>application/assets/lib/bootstrap/js/bootstrap.js"></script>
    <script type="text/javascript">
        $("[rel=tooltip]").tooltip();
        $(function() {
            $('.demo-cancel-click').click(function(){return false;});
        });
    </script>
    
  
</body></html>
