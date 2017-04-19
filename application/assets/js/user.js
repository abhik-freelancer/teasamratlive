/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
 $( document ).ready(function(){
               var basepath =  $("#basepath").val();
	
               //menu active
		$( ".legal-menu"+$('#mastermenu').val() ).addClass( " collapse in " );
		$( ".user").addClass( "active" );
                
                
                
               //add div open 
                $("#user_add_img").on("click", function()
                {
                    $('#add_user').show('slow', function() {  });
                    $("#login").val('');
                    $("#password").val('');
                    $("#firstname").val('');
                    $("#lastname").val('');
                    $("#email").val('');
                    $("#address").val('');
                    $("#contact").val('');
                });
                
                //keydown event handle
                $("#login").keydown(function(){
                         $("#login").removeClass('glowing-border');
                });
                
                //user save jquery
                 $("#save_user").click(function () {
                         var login= $("#login").val();
                         var pwd = $("#password").val();
                         var firstname = $("#firstname").val();
                         var lastname = $("#lastname").val();
                         var email=$("#email").val();
                         var address = $("#address").val();
                         var contact =$("#contact").val();
                         var role = $('#role').val();
                         var error = 0;
                         
                         if(login==''){
                             error=1;
                             $("#login").addClass('glowing-border');
                         }
                         if(pwd==''){
                              error=1;
                              $("#password").addClass('glowing-border');
                         }
                         if(firstname==''){
                             error =1;
                              $("#firstname").addClass('glowing-border');
                               
                         }
                         if(lastname==''){
                             error =1;
                              $("#lastname").addClass('glowing-border');
                        }
                        
                         if(email==''){
                             error =1;
                              $("#email").addClass('glowing-border');
                        }
                        if(error==0){
                            $.ajax({
                                type: "POST",
                                url:  basepath+"User/save",
                                data:{},
                                data: {login: login, pwd:pwd , firstname:firstname , lastname: lastname, email: email, address:address,
                                       contact:contact,role:role },
                                        success: function(data)
                                        {
                                                window.location.href = basepath+'User';
                                        }

                                });
                        }
                         
                 });
                 
	//ready function end
	});

