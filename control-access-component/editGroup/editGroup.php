<?php

    include_once("control-access-component\connection\connection.php");
    $json_body = file_get_contents('php://input');
    $object = json_decode($json_body);
    
    $id = $object->id;
    $name = $object->name;
    $descripcion = $object->descripcion;
    
    try
    {
        //Todo tipo de validación de información, debe ser realizada aquí de manera obligatoria
        //ANTES de enviar el comando SQL al motor de base de datos.
    
        $SQLStatement = $connection->prepare("CALL `edit_group`(:id, :name, :descripcion)");
        $SQLStatement->bindParam( ':id', $id );
        $SQLStatement->bindParam( ':name', $name );
        $SQLStatement->bindParam( ':descripcion', $descripcion );
        $SQLStatement->execute();
    
        $status = array( status=>'ok', description=>'Grupo Modificado Satisfactoriamente!' );
    
        echo json_encode($status);
    }
    catch( PDOException $connectionException )
    {
        $status = array( status=>'db-error (editGroup.php', description=>$connectionException->getMessage() );
        echo json_encode($status);
        die();
    }
    
    ?>