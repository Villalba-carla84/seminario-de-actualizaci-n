<?php

    include_once("control-access-component\connection\connection.php");

    $json_body = file_get_contents('php://input');
    $object = json_decode($json_body);
    
  
   
    $id = $object->id;
    $name = $object->name;
    $password = $object->password;
    
    try
    {
        //Todo tipo de validación de información, debe ser realizada aquí de manera obligatoria
        //ANTES de enviar el comando SQL al motor de base de datos.
    
        $SQLStatement = $connection->prepare("CALL `get_user`( :name, :id, :password)");
       
        
        $SQLStatement->bindParam( ':id', $id );
        $SQLStatement->bindParam( ':name', $name );
        $SQLStatement->bindParam( ':password', $password );
        $SQLStatement->execute();
    
        $status = array( status=>'ok', description=>'Mostrando usuarios!' );
    
        echo json_encode($status);
    }
    catch( PDOException $connectionException )
    {
        $status = array( status=>'db-error (getUser.php', description=>$connectionException->getMessage() );
        echo json_encode($status);
        die();
    }
    
    ?>