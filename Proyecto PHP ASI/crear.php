<?php
	session_start();

/* 	Comprueba el rol que estamos utilizando, de no ser 
	el rol 1 o 3 no dejará continuar negando el acceso 	*/
	if(isset($_SESSION["aut"])){
		if(stristr($_SESSION["rol"],'1')||stristr($_SESSION["rol"],'3')){
			$error="";
		}else{
			$error="si";
		}
	}else{
		$error="si";
	}

	if($error=="si"){
		header("location: denegaracceso.php?error=si");
	}

?>

<html>
	<head>
		<title>Formulario de art&iacuteculos</title>
	</head>
	<body style="background-color: #2A363B;">
		<h1 style="color: #E84A5F;">Formulario de art&iacuteculos</h1>
		<?php 
			if(isset($_GET["error"])){
				if($_GET["error"]=="si"){
		?>
		<font color="red">Los campos marcados con * son obligatorios. </font>
		<?php
				}
			}
			if(isset($_GET["errorfoto"])){
				if($_GET["errorfoto"]=="si"){
		?>		
		<font color="red">El archivo no se ha subido correctamente o el formato no era correcto.</font>
		<?php
				}
			}
	
		?>
		<form enctype="multipart/form-data" action="cont.php" method="POST">
			<fieldset style="width:30%; background: #99B898;">
				<font color="red">*</font>Título:
				<input type="text" name="titulo" size="51"/>
				<br/>
				<br/>
				<font color="red">*</font>Texto:
				<br/>
				<textarea id="texto" name="texto" cols="60" rows="10"></textarea>
				<br/>
				<br/>
				Imagen:
				<br/>
				<input type="file" name="foto"/>
				<br/>
				<br/>
				Posici&oacuten
				<select name="layout">
					<option value="1" selected='selected'>--Seleccione Posici&oacuten de la Imagen--</option>
					<option value="2">Izquierda</option>
					<option value="3">Derecha</option>
				</select>
			</fieldset>
			<br/>
			<fieldset style="width:250px; background: #99B898;">
				<input type="radio" name="clasificacion" value="0" checked="checked">P&uacuteblico</input>
				<br/>
				<input type="radio" name="clasificacion" value="1">Registrado</input>
				<br/>
				<input type="radio" name="clasificacion" value="2">Lector</input>
			</fieldset>
			<br/>
			<input style="width: 280px; height: 50px;" type="submit" name="enviar" value="Enviar"/>
		</form>
		<br/>
		<h3><a href="index.php">Salir</a></h3>
	</body>
</html>