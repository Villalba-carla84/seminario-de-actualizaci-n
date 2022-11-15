<?php

   include_once("control-access-component\connection\connection.php");
   
   
   $json_body = file_get_contents('php://input');
   $object = json_decode($json_body);
   
   $password = $object->password;
   $username = $object->username;
   
   try
   {
       //Todo tipo de validación de información, debe ser realizada aquí de manera obligatoria
       //ANTES de enviar el comando SQL al motor de base de datos.
   
       $SQLCode = "CALL `create_user`('$username', '$password')";
       
       $connection->query($SQLCode);
   
       $status = array( status=>'ok', description=>'Usuario Creado Satisfactoriamente!' );
       
       echo json_encode($status);
   }
   catch( PDOException $connectionException )
   {
       $status = array( status=>'db-error (createUser.php', description=>$connectionException->getMessage() );
       echo json_encode($status);
       die();
   }
   
   ?>