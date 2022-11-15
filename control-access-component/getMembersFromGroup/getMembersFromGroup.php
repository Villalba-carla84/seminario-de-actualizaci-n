<?php

    include_once("control-access-component\connection\connection.php");

    $json_body = file_get_contents('php://input');
    $object = json_decode($json_body);
    
  
   
    $id_user = $object->id_user;
    $id_group = $object->id_group;
    
    try
    {
        //Todo tipo de valid_useración de información, debe ser realizada aquí de manera obligatoria
        //ANTES de enviar el comando SQL al motor de base de datos.
    
        $SQLStatement = $connection->prepare("CALL `get_members_FromGroup`( :id_user, :id_group)");
       
        
        $SQLStatement->bindParam( ':id_user', $id_user );
        $SQLStatement->bindParam( ':id_group', $id_group );
        $SQLStatement->execute();
    
        $status = array( status=>'ok', description=>'Mostrando los miembros del grupo!' );
    
        echo json_encode($status);
    }
    catch( PDOException $connectionException )
    {
        $status = array( status=>'db-error (getMembersFromGroup.php', description=>$connectionException->getMessage() );
        echo json_encode($status);
        die();
    }
    
    ?>
