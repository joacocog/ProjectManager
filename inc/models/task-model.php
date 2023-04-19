<?php

$action = $_POST['action'];
$project_id = (int)$_POST['project_id'];
$task = $_POST['task'];
$state = $_POST['state'];
$task_id = (int)$_POST['id'];

if($action === 'create'){
    // create task


    // import connection
    include '../functions/conn.php';

    try{
        // request to db
        $stmt = $conn->prepare("INSERT INTO tareas (nombre, id_proyecto) VALUES (?, ?)");
        $stmt->bind_param('si', $task, $project_id);
        $stmt->execute();

        if($stmt->affected_rows > 0){

            $answer = array(
                'answer' => 'successfull',
                'id_insertado' => $stmt->insert_id,
                'type' => $action,
                'tarea' => $task
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

if($action === 'update'){

        // import connection
        include '../functions/conn.php';

        try{
            // request to db
            $stmt = $conn->prepare("UPDATE tareas set estado = ? WHERE id = ?");
            $stmt->bind_param('ii', $state, $task_id);
            $stmt->execute();
    
            if($stmt->affected_rows > 0){
    
                $answer = array(
                    'answer' => 'successfull'
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
            $stmt = $conn->prepare("DELETE from tareas WHERE id = ?");
            $stmt->bind_param('i', $task_id);
            $stmt->execute();
    
            if($stmt->affected_rows > 0){
    
                $answer = array(
                    'answer' => 'successfull'
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