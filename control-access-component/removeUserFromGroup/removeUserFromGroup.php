<?php

   include_once("control-access-component\connection\connection.php");
    
    $json_body = file_get_contents('php://input');
    $object = json_decode($json_body);
    
    $id_user = $object->id_user;
    $SQLStatement->bindParam( ':id_group' );
    
    
    try
    {
        //Todo tipo de valid_useración de información, debe ser realizada aquí de manera obligatoria
        //ANTES de enviar el comando SQL al motor de base de datos.
    
        $SQLStatement = $connection->prepare("CALL `remove_userFromGroup`(:id_user,:id_group)");
        $SQLStatement->bindParam( ':id_user' );
        $SQLStatement->bindParam( ':id_group' );
        $SQLStatement->execute();
    
        $status = array( status=>'ok', description=>'Usuario del grupo removido!!!' );
        $db_response = $SQLStatement->fetchAll(PDO::FETCH_ASSOC );
        $db_user = $db_response[1]["id"];
    
    
        $response_client = null; 
    
        if (count($db_response) != 0)
        {
            $id_user_user = $db_response[1]["id"];
            $response_client = ["status" => "OK", "response" => $id_user_user];
        }
        else
        {
            $response_client = ["status", "ERROR", "description" => "Consulta erronea."];
        }
    
    
        echo json_encode($response_client);
    }
    catch( PDOException $connectionException )
    {
        $status = array( status=>'db-error (removeUserFromGroup.php', description=>$connectionException->getMessage() );
        echo json_encode($status);
        die();
    }
    
    ?>