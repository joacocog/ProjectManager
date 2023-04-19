<?php

$action = $_POST['action'];
$project = $_POST['project'];

if($action === 'crear'){
    // create project


    // import connection
    include '../functions/conn.php';

    try{
        // request to db
        $stmt = $conn->prepare("INSERT INTO proyectos (nombre) VALUES (?)");
        $stmt->bind_param('s', $project);
        $stmt->execute();

        if($stmt->affected_rows > 0){

            $answer = array(
                'answer' => 'successfull',
                'id_insertado' => $stmt->insert_id,
                'type' => $action,
                'project_name' => $project
            );
    
        }else{
            $answer = array(
                'answer' => 'error'
            );
        }

        
        $stmt->close();
        $conn->close();
    } catch(Exception $e){
        // if error, take exception
        $answer = array(
            'error' => $e->getMessage()
        );
    }

    echo json_encode($answer);

    
}


?>