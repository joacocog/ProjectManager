<?php

$action = $_POST['action'];
$project = $_POST['project']; 
$user_id = (int)$_POST['user_id'];
$project_id = (int)$_POST['id'];

if($action === 'crear'){
    // create project


    // import connection
    include '../functions/conn.php';

    try{
        // request to db
        $stmt = $conn->prepare("INSERT INTO proyectos (nombre, id_usuario) VALUES (?, ?)");
        $stmt->bind_param('si', $project, $user_id);
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

if($action === 'delete'){

    // import connection
    include '../functions/conn.php';

    try{
        // request to db
        $stmt = $conn->prepare("DELETE from tareas WHERE id_proyecto = ?");
        $stmt->bind_param('i', $project_id);
        $stmt->execute();

        $stmt1 = $conn->prepare("DELETE from proyectos WHERE id = ?");
        $stmt1->bind_param('i', $project_id);
        $stmt1->execute();

        if($stmt->affected_rows > 0 && $stmt1->affected_rows > 0){

            $answer = array(
                'answer' => 'successfull'
            );
    
        }else{
            $answer = array(
                'answer' => 'error'
            );
        }

        
        $stmt->close();
        $stmt1->close();
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