<?php  
//--Lo primero que deberemos de hacer es conectar con la base de datos a traves del archivo conexion
	require ("conexion.php");
	$dir_subida="Images/";
	$fotosubida="";
	$errorfoto="";
	$id=$_POST["artid"];
	$conectar=mysqli_connect($servidor, $user, $pw, $bd)
		or die("<h3>No se ha podido establecer la conexion</h3>");
	$select="SELECT artImx FROM articulos WHERE artID=$id";
	$query=mysqli_query($conectar, $select);
	$res=mysqli_fetch_assoc($query);





//-- Para que ningun campo este vacio
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
			$stat=$_POST["clasificacion"];
		}else{
			$stat=0;
		}





//--Si no subimos foto'error' 4="No se ha subido ningúna foto."

	if($_FILES['foto']['error']==4){
		$errorfoto="";
		$fotosubida=$res["artImx"];
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




//-- Acciones a realizar si alguno de los dos errores ocurren
	if($error=="si"){
		header("location: editar.php?error=si");
	}elseif($errorfoto=="si"){
		header("location: editar.php?errorfoto=si");
	}





//--Para recargar con los datos nuevos ejecutamos un UPDATE

	$update="UPDATE articulos SET artTit='$titulo', artTxt='$texto', artImx='$fotosubida', artLayout=$layout, artClas=$stat WHERE artID=$id";
		
	$query2=mysqli_query($conectar, $update);
	
	header("location:index.php");

?>