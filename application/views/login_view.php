<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset="UTF-8">
<title>Login</title>
 
 


 <link href="<?php echo base_url(); ?>application/assets/css/login.css" rel="stylesheet" type="text/css"  />
</head>
    <body >
  
     <section id="loginBox">
     
      
        <h2 style="text-align:center;">Login </h2>
        <hr style="margin:0; padding:0; background-color: #61b055; border: 0; height:5px;">
      
        <?php if(validation_errors()): ?>
        <div style="color: #D8000C;text-align:center;"><?php echo validation_errors(); ?></div>
        <?php endif; ?>
       <?php echo form_open('verifylogin',array('class' => 'minimal')); ?>
            <label for="username">
                User Name:
                <input type="text" id="username" name="username" required="required" value="<?php echo set_value('username');?>"/>
            </label>
            <label for="password">
                Password:
               <!-- <input type="password"id="passowrd" name="password" pattern="^[a-zA-Z][0-9]{1,6}$" required="required" />-->
                <input type="password"id="passowrd" name="password"  required="required" />
            </label>
            <div style="text-align:center;" ><button type="submit" class="btn-minimal">Sign in</button></div>
        </form>
    </section>
  
    </body>
</html>