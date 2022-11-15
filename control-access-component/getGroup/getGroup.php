<?php

    include_once(".control-access-component\connection\connection.php");

   
    $json_body = file_get_contents('php://input');
    $object = json_decode($json_body);
    
  
    $name = $object->name;
    $descrpcion = $object->descrpcion;
    
    try
    {
        //Todo tipo de validación de información, debe ser realizada aquí de manera obligatoria
        //ANTES de enviar el comando SQL al motor de base de datos.
    
        $SQLStatement = $connection->prepare("CALL `get_group`( :name, :descrpcion)");
       
        $SQLStatement->bindParam( ':name', $name );
        $SQLStatement->bindParam( ':descrpcion', $descrpcion );
        $SQLStatement->execute();
    
        $status = array( status=>'ok', description=>'Mostrando grupo!' );
    
        echo json_encode($status);
    }
    catch( PDOException $connectionException )
    {
        $status = array( status=>'db-error (getGroup.php', description=>$connectionException->getMessage() );
        echo json_encode($status);
        die();
    }
    
    ?>