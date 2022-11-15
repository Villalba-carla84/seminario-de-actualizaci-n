<?php

   include_once("control-access-component\connection\connection.php");
   
   $json_body = file_get_contents('php://input');
    $object = json_decode($json_body);
    
    $name = $object->name;
    $descripcion = $object->descripcion;
    
    try
    {
        //Todo tipo de validación de información, debe ser realizada aquí de manera obligatoria
        //ANTES de enviar el comando SQL al motor de base de datos.
    
        $SQLStatement = $connection->prepare("CALL `create_group`( :name, :descripcion)");
      
        $SQLStatement->bindParam( ':name', $name );
        $SQLStatement->bindParam( ':descripcion', $descripcion );
        $SQLStatement->execute();
    
        $status = array( status=>'ok', description=>'Grupo Creado Satisfactoriamente!' );
    
        echo json_encode($status);
    }
    catch( PDOException $connectionException )
    {
        $status = array( status=>'db-error (createGroup.php', description=>$connectionException->getMessage() );
        echo json_encode($status);
        die();
    }
    
    ?>