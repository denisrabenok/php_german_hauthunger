$(document).ready(function()
{
  settings = {
	  tl: { radius: 10 },
	  tr: { radius: 10 },
	  bl: { radius: 10 },
	  br: { radius: 10 },
	  antiAlias: true,
	  autoPad: true,
	  validTags: ["div"]
  }
  var myBoxObject = new curvyCorners(settings, "login-content");
  myBoxObject.applyCornersToAll();
});

$(document).ready(function()
{
	$("#frmForgotPassword").submit(function()
	{
		//Remove all the class add the messagebox classes and start fading
		$("#login-indicator-msg").removeClass().addClass('login-msg-process').text('Validating...').fadeIn(1000);
		//Check the "username" if exists or not from ajax
		$.post("components/forgotpassword-process.php",{ email:$('#email').val(),rand:Math.random() } ,function(data)
        {
		  if(data=='yes') //if correct login detail
		  {
		  	$("#login-indicator-msg").fadeTo(200,0.1,function()  { //start fading the messagebox
			  	//Add message and change the class of the box and start fading
			  	$(this).html('Sending...').addClass('login-msg-valid').fadeTo(900,1,
              	function() { 
			  		//Redirect to secure page
					$("#login-indicator-msg").removeClass()
					//$(this).html('Please check your email for password!').addClass('login-msg-valid').fadeTo(900,1);
				 	document.location='index.php?option=passwordsent';
			  	});			  
			});
		  } else {
			$("#login-indicator-msg").fadeTo(200,0.1,function() { //start fading the messagebox
				$("#login-indicator-msg").removeClass()
			  	//Add message and change the class of the box and start fading
			  	$(this).html('Invalid email address!').addClass('login-msg-error').fadeTo(900,1);
			});		
          }
	
        });		
 		return false; //Not to post the form physically
	});

});