<?php
//--Primero conectaremos con la base de datos mediante conexion.php
	session_start();
	require('conexion.php');
	
	$titulo="";
	$texto="";
	$layout="";
	$clasificacion="";






//--El siguiente paso es que segun nuestro rol nos deje o no editar 
	if(isset($_SESSION["aut"])){
		if(stristr($_SESSION["rol"],'1')){
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






//--Para poder editar el articulo entero, debera por id enseñarnos todos sus campos
	if(!empty($_GET["artid"])){
		$id=$_GET["artid"];
		$conexion=mysqli_connect($servidor, $user, $pw, $bd) or die("No se ha establecido conexion");
		$instr="SELECT artTit, artTxt, artClas, artImx, artLayout 
		FROM articulos 
		WHERE artID=$id";	

		$query=mysqli_query($conexion, $instr);
		$res=mysqli_fetch_assoc($query);
		$titulo=$res["artTit"];
		$texto=$res["artTxt"];
		$imagen="<img src=\"".$res["artImx"]."\" class=\"thumb\"/>";
		$layout=$res["artLayout"];
		$clasificacion=$res["artClas"];
	}
	
?>

<html>
	<head>
		<title>Editar art&iacuteculos</title>
		<style type="text/css">
			.thumb{
				max-height: 100px;
				max-width: 100px;
				margin: 10px 5px;
			}
		</style>
	</head>
	<body  style="background-color: #2A363B;">
		<h1 style="color: #E84A5F;">Editar art&iacuteculos</h1>

		<form enctype="multipart/form-data" action="guardar.php" method="POST">
			<fieldset style="width:40%; background: #99B898;">
				<font color="red">*</font>Título:
				<input type="hidden" name="artid" value='<?php echo $id;?>' />
				<input type="text" name="titulo" size="51" value='<?php echo $titulo; ?>' />
				<br/>
				<font color="red">*</font>Texto:
				<br/>
				<textarea id="texto" name="texto" cols="60" rows="10"><?php echo $texto; ?></textarea>
				<br/>
				<br/>
				Imagen:
				<br/>
				<?php echo $imagen;
					echo " ".$res["artImx"];?>
				<br/>
				<input type="file" name="foto"/>
				<br/>
				<br/>
				Posici&oacuten
				<select name="layout">
					<option value="1" <?php if($layout==1|| $layout==""){?> selected='selected' <?php } ?>>--Seleccione Posici&oacuten de la Imagen--</option>
					<option value="2" <?php if($layout==2){?> selected='selected' <?php } ?>>Izquierda</option>
					<option value="3" <?php if($layout==3){?> selected='selected' <?php } ?>>Derecha</option>
				</select>
			</fieldset>
			<br/>
			<fieldset style="width:250px; background: #99B898;">
				<input type="radio" name="clasificacion" value="0" <?php if($clasificacion==0) {echo "checked='checked'";} ?> >P&uacuteblico</input><br>
				<input type="radio" name="clasificacion" value="1" <?php if($clasificacion==1) {echo "checked='checked'";} ?> >Registrado</input><br>
				<input type="radio" name="clasificacion" value="2" <?php if($clasificacion==2) {echo "checked='checked'";} ?> >Lector</input><br>
			</fieldset>
			<br/>
			<input style="width: 280px; height: 50px;" type="submit" name="enviar" value="Enviar"/>
		</form>
		<br/>
		<h3><a href="index.php">Salir</a></h3>
	</body>
</html>