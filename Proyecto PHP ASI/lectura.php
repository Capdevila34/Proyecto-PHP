<?php
	session_start();



//-- Establecemos conexión con la base de datos por medio de conexion.php como los anteriores archivos
	require('conexion.php');
	$conexion=mysqli_connect($servidor, $user, $pw, $bd) or die("No se ha encontrado la base de datos");
	





//--Para ver un articulo con todas las secciones , lo que debemos hacer es seleccionar todos sus campos 
	$id=$_GET["artid"];
	$select="SELECT artTit, artImx, artTxt, artClas, artLayout, DATE_FORMAT(artDatCre, '%d/%m/%Y') AS fecha, perNom 
	FROM articulos INNER JOIN personas ON personas.perID=articulos.perID 
	WHERE artID=$id";

	$query=mysqli_query($conexion, $select);
	$res=mysqli_fetch_assoc($query);





//-- Comprobamos la clasificación del artículo
	if($res["artClas"]==0){
		$clasificacion="Publico";
	}elseif($res["artClas"]==1){
		$clasificacion="Registrado";
	}else{
		$clasificacion="Privado";
	}






//--Para que nos enseñe la opcion de editar el articulo ,primero comprobara que rol utilizamos , para en base a eso enseñarnos la opcion o no
	if(isset($_SESSION["aut"])){
		if(stristr($_SESSION["rol"],'1')){
			$editar_art="<a class='boton' href='editar.php?artid=";
			$editar_art.=$id;
			$editar_art.="'>Editar</a>";
		}else{
			$editar_art="";
		}
	}else{
		$editar_art="";
	}

	$imagen=$res["artImx"];





//-- Poner la imagen a derecha o izquierda
	if(!empty($imagen)){
		if($res["artLayout"]==2){
			$layout="float:left;";
		}elseif($res["artLayout"]==3){
			$layout="float:right;";
		}elseif ($res["artLayout"]==1){
			$layout="display:none;";
		}
	}else{
		$layout="";
	}

	$imagen="<img src='$imagen' class=\"imagen\" style=\"$layout\"/>";
?>

<html>
	<head>
		<meta http-equiv="Content-Type" content='text/html'; charset='utf-8'/>
		<style type="text/css">
			.contenedor{
				margin: 0px auto;
				width: 600px;
			}
			.imagen{
				max-width: 200px;
				max-height: 200px;
				margin: 15px;
			}
			.boton{
				text-decoration: none;
				padding: 10px;
				font-weight: 400;
				font-size: 15px;
				color: #ffffff;
				background-color: #1883ba;
				border-radius: 5px;
				border: 2px solid #00116b0;
			}
			.boton:hover{
				color: #1883ba;
				background-color: #ffffff;
			}
		</style>
		<title>Art&iacuteculo</title>
	</head>
	<body>
		<div class="contenedor">
			<br>
			<span style="float: right;"><a class="boton" href="index.php">Volver al Inicio</a></span><div><?php echo $editar_art;?></div>
			<h1 style="color: #1883ba;"><?php echo $res["artTit"];?></h1>
			<div>
				<?php echo $imagen;?>
				<?php echo nl2br($res["artTxt"]);?>
			</div>
			<br>
			<h4>Escrito por <b><?php echo $res["perNom"];?></b> el <?php echo $res["fecha"];?></h3>
			<p>Clase: <?php echo $clasificacion;?></p>
		</div>
	</body>

</html>