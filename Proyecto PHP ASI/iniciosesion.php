<html>
	<head>
		<Title>Login</Title>
		<style type="text/css">
			body {
				background: #2A363B;	
			}

			.principal {	
				margin-top: 80px;
  				margin-bottom: 80px;
			}

			.form {
  				max-width: 380px;
  				padding: 15px 35px 45px;
  				margin: 0 auto;
  				background-color: #E84A5F;
  				border: 1px solid rgba(0,0,0,0.1);  
  			}
  			.form-cabezera {
	  			margin-bottom: 30px;
	  			color: #2A363B;
	  			text-align: center;
			}
			.iniciar_sesion{
				text-align:center;
			}
			.form-in {
	  			position: relative;
	  			font-size: 16px;
	  			height: auto;
	  			padding: 10px;
	  			text-align: center;
			}

			input[type="text"] {
	 			margin-bottom: -1px;
	  			border-bottom-left-radius: 0;
	  			border-bottom-right-radius: 0;
	  			text-align: center;
			}

			input[type="password"] {
	  			margin-bottom: 20px;
	  			border-top-left-radius: 0;
	  			border-top-right-radius: 0;
	  			text-align: center;
			}
		</style>
	</head>
	<body>
		<?php
			if(isset($_GET["error_user"])){
				if($_GET["error_user"]=="si"){			
		?>
		<font color="red">El usuario o la contraseña no son correctos</font>
		<br/>
		<?php
				} 
			}
		?>
		<br/>
		<br/>
		<div class="principal">
			<form class="form" action="valida.php" method="POST">
				<h2 class="form-cabezera">Loguearse</h2>
				<div class="iniciar_sesion">
					<h3 class="form-cabezera">Quien eres</h3>
					<input type="text" class="form-in" name="usuario" required="" autofocus="" />
					<br><br>
					<h4 class="form-cabezera">Tu contraseña</h4>
      				<input type="password" class="form-in" name="password" placeholder="Password" required=""/>
      				<br>   
     				<button type="submit" style="width:200px; height:50px">Loguin</button>
      			</div>
			</form>
		</div>
	</body>
</html>