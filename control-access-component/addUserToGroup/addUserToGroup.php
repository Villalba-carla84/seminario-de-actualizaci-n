<?php

include_once( "control-access-component\connection\connection.php");


$json_body = file_get_contents('php://input');
$object = json_decode($json_body);

$id_user = $object->id_user;
$id_group = $object->id_group;

try
{
	//Todo tipo de validación de información, debe ser realizada aquí de manera obligatoria
	//ANTES de enviar el comando SQL al motor de base de datos.

	$SQLCode = "CALL `createUser`('$id_group', '$id_user')";
	
	$connection->query($SQLCode);

	$status = array( status=>'ok', description=>'Usuario agregado al grupo Satisfactoriamente!' );
	
    echo json_encode($status);
}
catch( PDOException $connectionException )
{
    $status = array( status=>'db-error (addUserToGroup.php', description=>$connectionException->getMessage() );
    echo json_encode($status);
    die();
}

?>