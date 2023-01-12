<?php
//--Lo primero sera conectarnos a la base de datos 
	session_start();
	require ("conexion.php");
	$autor=$_SESSION["nombre"];
	$dir_subida="Images/";
	$fotosubida="";
	$errorfoto="";
	$conexion=mysqli_connect($servidor, $user, $pw, $bd)or die("No se ha encontrado la base de datos");






//-- Comprobamos si algun campo de articulo esta vacio
	if (!empty($_POST["titulo"])){
		$titulo=$_POST["titulo"];
		$error="";
	}else{
		$error="si";
	}

	if(!empty($_POST["texto"])){
		$texto=$_POST["texto"];
		$error="";
	}else{
		$error="si";
	}

	if(isset($_POST["layout"])){
		$layout=$_POST["layout"];
	}

	if(isset($_POST["clasificacion"])){
		$clasificacion=$_POST["clasificacion"];
	}else{
		$clasificacion=0;
	}
	






//-- Para subir una foto y que de error si es necesario
	if($_FILES['foto']['error']==4){
		$errorfoto="";
	}else{
		$tipo=$_FILES['foto']['type'];
		$fotosubida=$dir_subida . basename($_FILES['foto']['name']);
		
		if(strpos($tipo, 'jpeg') || strpos($tipo, 'png') || strpos($tipo, 'jpg')){
			if(move_uploaded_file($_FILES['foto']['tmp_name'], $fotosubida)){
					$errorfoto="";
			}else{
					$errorfoto="si";
				}
		}else{
			$errorfoto="si";
		}
	}
	if($error=="si"){
		header("location: crear.php?error=si");
	}elseif($errorfoto=="si"){
		header("location: crear.php?errorfoto=si");
	}






//--Subir los nuevos datos a nuestra base de datos y que se actualicen
	$sql="SELECT perID FROM personas WHERE perNom= '";
	$sql.=$autor."'";
	$query2=mysqli_query($conexion, $sql) or die ("No se ha insertado el elemento porque: ". mysqli_error($conexion));
	$res=mysqli_fetch_assoc($query2);
	$id=$res["perID"];

	$sql2="INSERT INTO articulos (artDatCre, artTit, artTXT, artImx, artLayout, artClas, perID) ";
	$sql2.="VALUES (CURDATE(), '$titulo', '$texto', '$fotosubida', $layout, $clasificacion, $id)";
	$query=mysqli_query($conexion, $sql2) or die ("No se ha insertado el elemento porque: ". mysqli_error($conexion));
	header("Location: index.php");
?>