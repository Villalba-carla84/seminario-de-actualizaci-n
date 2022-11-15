<?php

    require_once("control-access-component\connection\connection.php");
    
    $json_body = file_get_contents('php://input');
    $object = json_decode($json_body);
    
    $id = $object->id;
    
    
    try
    {
        //Todo tipo de validación de información, debe ser realizada aquí de manera obligatoria
        //ANTES de enviar el comando SQL al motor de base de datos.
    
        $SQLStatement = $connection->prepare("CALL `delete_user`(:id)");
        $SQLStatement->bindParam( ':id' );
        $SQLStatement->execute();
    
       
	$status = array( 'status'=>'ok', 'description'=>'Usuario eliminado Satisfactoriamente!' );

    echo json_encode($status);
}
catch( PDOException $connectionException )
{
    $status = array( 'status'=>'db-error (deleteUser.php', 'description'=>$connectionException->getMessage() );
    echo json_encode($status);
    die();
}

?>