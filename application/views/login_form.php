<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon" />  </head>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Login</title>
<?php $this->load->helper('HTML'); echo link_tag('css/stylelog.css')?>
</head>

<body>
<div id="layer01_holder">
  <div id="left"></div>
  <div id="center"></div>
  <div id="right"></div>
</div>

<div id="layer02_holder">
  <div id="left"></div>
  <div id="center"></div>
  <div id="right"></div>
</div>

<div id="layer03_holder">
  <div id="left"></div>
  <div id="center">
  	Login 
   		 <form id="form1" method="post" action="login" accept-charset="utf-8">
				 <div class="err_msg"><?php echo validation_errors(); ?><?php echo $message;?></div>
                  <p>
					<label for="username">Username</label>
					<input name="username" type="text" id="username" placeholder ="Input Username"/>
				  </p>
				  <p>
					<label for="password">Password</label>
					 <input name="password" type="password" id="password" placeholder ="Input Password"/>
				  </p>
				  <p>
					<input name="submit" type="submit" id="form1" value="Login " />
				  </p>
			  
			</form>          
  </div>
  <div id="right"></div>
</div>

<div id="layer04_holder">
  <div id="left"></div>
  <div id="center">
  If you forgot your password, please contact administrator <!--or <a href="#">click here</a>--></div>
  <div id="right"></div>
</div>

<div id="layer05_holder">
  <div align="left">Copyright © 2013, TwinTulipware</div>
</div>
</body>
</html>

