<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset="UTF-8">
<title>Login</title>
 
 <link href="<?php echo base_url(); ?>application/assets/css/login.css" rel="stylesheet" type="text/css"  />
<style>
	

}
</style>

</head>
    <body>
  
     <section id="loginBox">
      
        <h2 style="text-align:center;">Company</h2>
      
      	 <?php echo form_open('logindetail',array('class' => 'minimal')); ?>
         <table border="0" width="100%">
         <tr>
         <td>
       
                Company 
               </td>
               <hr style="margin:0; padding:0; background-color: #61b055; border: 0; height:5px;">
                <td>
        <?php 
        	if($company)  :?> 
			<select name="globalcompany" onChange="document.getElementById('text_content_company').value=this.options[this.selectedIndex].text">
             <option value="0">Select company</option>
         <?php foreach ($company as $content) : ?>
                 <option value="<?php echo $content->id; ?>"><?php echo $content->company_name; ?></option>
    	<?php endforeach; ?>
         </select> 
          <?php	 endif;  ?>
           </td>
        <input type="hidden" name="text_content_company" id="text_content_company" value="" />
          </tr>
            
         
         <tr>
         <td>
               Financial Year
              </td> <td>
          <?php if($year)  :?> 
			<select width="100px;" name="globalyear" onChange="document.getElementById('text_content_year').value=this.options[this.selectedIndex].text">
             <option value="0">Select financial year</option>
         <?php foreach ($year as $value) : ?>
                 <option value="<?php echo $value->id; ?>"><?php echo $value->year; ?></option>
    	<?php endforeach; ?>
         </select> 
          <?php	 endif;  ?>
            </td>
            </tr>
            </table>
             <input type="hidden" name="text_content_year" id="text_content_year" value="" />
             <br/>
             <div style="text-align:center;" ><button type="submit" class="btn-minimal">PROCEED</button></div>
        </form>
    </section>
    
    </body>
</html>