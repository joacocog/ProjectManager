<?php

$action = $_POST['action'];
$password = $_POST['password'];
$user = $_POST['usuario'];


if($action === 'crear'){
    // create users

    // password hash
    $options = array(
        'cost' => 12
    );

    $hash_password = password_hash($password, PASSWORD_BCRYPT, $options);

    // import connection
    include '../functions/conn.php';

    try{
        // request to db
        $stmt = $conn->prepare("INSERT INTO usuarios (usuario, password) VALUES (?, ?)");
        $stmt->bind_param('ss', $user, $hash_password);
        $stmt->execute();

        if($stmt->affected_rows > 0){

            $answer = array(
                'answer' => 'successfull',
                'id_insertado' => $stmt->insert_id,
                'type' => $action
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
            'pass' => $e->getMessage()
        );
    }

    echo json_encode($answer);

    
}

if($action === 'login'){
    // login code

    include '../functions/conn.php';

    try{
        // select user from db

        $stmt = $conn->prepare("SELECT usuario, id, password FROM usuarios WHERE usuario = ?");
        $stmt->bind_param('s', $user);
        $stmt->execute();

        // user login
        $stmt->bind_result($user_name, $user_id, $user_password);
        $stmt->fetch();
        if($user_name){
            // user exists, verify password
            if(password_verify($password, $user_password)){
                // Session init
                session_start();
                $_SESSION['name'] = $user;
                $_SERVER['id'] = $user_id;
                $_SESSION['login'] = true;
                // login successfull
                $answer = array(
                    'answer' => 'successfull',
                    'id' => $user_id,
                    'name' => $user_name,
                    'type' => $action
                );
            }else{
                // login error
                $answer = array(
                    'result' => 'Incorrect Password'
                );
            }
        }else{
            $answer = array(
                'answer' => 'error'
            );
        }


        $stmt->close();
        $conn->close();

    }catch(Exception $e){
        // if error, take exception
        $answer = array(
            'error' => $e->getMessage()
        );
    }

    
    echo json_encode($answer);

}

?>