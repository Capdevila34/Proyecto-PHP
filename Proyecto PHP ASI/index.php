<?php
//--lo primero sera establececer la conexion con la base de datos a partir del archivo de conexion , donde se loguea con nuestra base de datos , si no nos aparecera el mensaje de base de datos no encontrada
	header('charset=UTF-8');
	require ('conexion.php');
	session_start();
	$conexion=mysqli_connect($servidor, $user, $pw, $bd) or die("Base de datos no encontrada");

	$inicio="Hola ";
	$articulo="";
	$crear_articulo="";





	
//-- Ahora tenemos que crear algo que nos permita en base al rol mostrar los articulos que pertenecen a ese rol
	if(isset($_SESSION["aut"])){
		if(stristr($_SESSION["rol"],'1')||stristr($_SESSION["rol"],'2')){
			$inicio.=$_SESSION["nombre"];
			$validar="SELECT artID, DATE_FORMAT(artDatCre, '%d/%m/%Y') AS fecha, artTit, artTxt, artImx, artLayout, perNom, artClas 
			FROM articulos INNER JOIN personas ON personas.perID=articulos.perID 
			ORDER BY artDatCre DESC";
			$query=mysqli_query($conexion, $validar);

			
		}elseif(stristr($_SESSION["rol"],'3')){
			$inicio.=$_SESSION["nombre"];
			$validar="SELECT artID, DATE_FORMAT(artDatCre, '%d/%m/%Y') AS fecha, artTit, artTxt, artImx, artLayout,perNom, artClas 
			FROM articulos INNER JOIN personas ON personas.perID=articulos.perID 
			WHERE artClas IN (0, 1) 
			ORDER BY artDatCre DESC";
			$query=mysqli_query($conexion, $validar);
		}




		//--Y que nos ordene los articulos por su fecha de creacion una vez ejecutado lo anterior
	}else{
		$validar="SELECT artID, DATE_FORMAT(artDatCre, '%d/%m/%Y') AS fecha, artTit, artTxt, artImx, artLayout, perNom, artClas 
		FROM articulos INNER JOIN personas ON personas.perID=articulos.perID 
		WHERE artClas=0 
		ORDER BY artDatCre DESC";
		$query=mysqli_query($conexion, $validar);
	}






//-- Si tu rol es de los que pueden escribir , ya bien sean escrito o administrador , podras crear articulos , si no NO 
	if(isset($_SESSION["aut"])){
		if(stristr($_SESSION["rol"],'1')||stristr($_SESSION["rol"],'3')){
			$crear_articulo="<a href='crear.php'>Crear articulo</a>";			
		}
	}





//--A partir de aqui es el html de la pagina
?>





<html>
<head>
	<meta http-equiv="Content-Type" content="'text/html'; charset='utf-8'"/>
	<style type="text/css">
		.articulo {
			color:#ffffff;
 		    max-width: 650px;
		}
		body {
			width : 1100;
			margin-left : auto;
			margin-right : auto;
			padding : 0px;
		}
		.boton{
			text-decoration: none;
			padding: 10px;
			font-weight: 400;
			font-size: 20px;
			color: #ffffff;
			background-color: #1883ba;
			border-radius: 5px;
			border: 2px solid #00116b0;
		}
		.boton:hover{
			color: #1883ba;
			background-color: #ffffff;
		}
		.boton_cerrar{
			text-decoration: none;
			padding: 10px;
			font-weight: 400;
			font-size: 20px;
			color: #ffffff;
			background-color: #ff0000;
			border-radius: 5px;
			border: 2px solid #00116b0;
		}
		.boton_cerrar:hover{
			color: #ff0000;
			background-color: #ffffff;
		}
		.bienvenido{
			color: #1883ba;
			font-size: 20px;
			font-weight: 400;
		}
	</style>
	<title>Pagina Principal</title>
</head>
<body>

	<br/>

	<?php 
		if(isset($_SESSION["aut"])){ 
			//--segun estemos logueados o no , nos tiene que mostrar un boton para loguearnos o uno para salir
	?>
	
	<div><span style="float: right;"><a class="boton_cerrar" href="salir.php">Salida</a></span><div class="bienvenido"><?php echo $inicio ?></div>		
	
	<?php 
		}else{
	?>	

	<div><span style="float: right;"><a class="boton" href="iniciosesion.php">Logueate</a></span><div class="bienvenido"><?php echo $inicio ?></div></div>
	
	<?php 
		} 
	?>	
	<br/>
	<table style="font-weight:normal">
		<tr style="background-color:#1883ba; color: #ffffff;">
			<th>Fecha</th>
			<th><img src="Images/adjunto.png" style="height:25px; width:25px"/></th>
			<th style="text-align: left; width: 850px">Artículo</th>
		</tr>
<?php
	while($res=mysqli_fetch_assoc($query)){
?>
		<tr style="background-color:#ffffff;">
			<td style="text-align:center"><?php echo $res["fecha"];?></td>
			<td style="vertical-align: center;text-align:center"><?php 
				if(!empty($res["artImx"]) and $res["artLayout"]!=1){
			?>	<img align=center src='Images/adjunto.png' style='height:25px;width:25px'/>
			<?php
				}
			?>
			</td>
			<td><?php
			//--la configuracion que queremos que tenga el articulo para poder verlo y entrar
					$artid=$res["artID"];
					$articulo="<a style='text-decoration:none;overflow:hidden' href='lectura.php?artid=";
					$articulo.=$artid;
					$articulo.="'>";
					$articulo.="<b style='color:black'>".$res["artTit"].". </b> </br>";
					$articulo.="<i class='text'>".substr($res["artTxt"],0,150)."...</i></a>";
					$articulo.="<br/>";
					$articulo.="<b style='color:#FFA07A'>[".$res["perNom"]."]</b>";
					
					echo $articulo;
				 ?>			
			</td>
		</tr>
<?php
	}
?>
	</table>
	<br/>
	<?php echo $crear_articulo; ?>
	
</body>
</html>