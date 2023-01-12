<?php
//--Lo primero es que a traves del articulo conexion nos conecte con nuestra base de datos ,en caso contrario nos saldra el mensaje de que no ha sido posible
	require('conexion.php');
	$validar="";
	$validar2="";
	$rol="";
	session_start();
	$conexion=mysqli_connect($servidor, $user, $pw, $bd) or die("Base de datos no encontrada");




	//--Ahora lo que deberemos de hacer es que si es capaz de encontrar la base de datos de arriba , al introducir el usuario lo encuentre o no y nos lo notifique en caso contrario

	$validar="SELECT perID, perNom, perAlias, perPW ";
	$validar.="FROM personas WHERE perAlias= '".$_POST['usuario']; 
	$validar.="' AND perPW='".$_POST['password']."'";
	$query=mysqli_query($conexion, $validar) or die ("Usuario no encontrado: ". mysqli_error($conexion));

	//--Ahora en caso de que las dos anteriores se cumplan , que busque si tiene los roles asignados




	$row=mysqli_num_rows($query);
	$assoc=mysqli_fetch_assoc($query);
	$perid=$assoc["perID"];
	$nom_user=$assoc["perNom"];
	if($row==1){
		$validar2="SELECT * FROM persona_rol WHERE perID=$perid";
		$query2=mysqli_query($conexion, $validar2) or die ("No se han encontrado los roles : ". mysqli_error($conexion));
		$_SESSION["rol"]="";
		
		while($res=mysqli_fetch_assoc($query2)){
			$_SESSION["rol"].=$res["rolID"];
		}
		$_SESSION["aut"]="si";
		$_SESSION["usuario"]=$perid;
		$_SESSION["nombre"]=$nom_user;
		header("Location: index.php");
	}elseif($row==0){
		header("Location: login.php?error_user=si");
	}
?>