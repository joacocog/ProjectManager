<?php 
        include 'inc/functions/sessions.php';
        include 'inc/functions/conn.php';
        include 'inc/functions/functions.php'; 
        include 'inc/templates/header.php'; 
        include 'inc/templates/bar.php'; 

        // get id from url
        if(isset($_GET['project_id'])){
            $project_id = $_GET['project_id'];

        } else{
            
        }

        // get user id from url
        if(isset($_GET['user_id'])){
            $user_id = $_GET['user_id'];

        } else{
            header("Location: login.php");
            exit();
        }

?>

<div class="contenedor">

    <input type="hidden" id="user" value="<?php echo $user_id; ?>">

    <?php
        include 'inc/templates/sidebar.php'; 
    ?>
    

    <main class="contenido-principal">

        <?php 
            $project = getProjectName($project_id);

            if($project):
        ?>
        <h1>Actual project:
            <?php

                foreach($project as $name): ?>


                    <span><?php echo $name['nombre']; ?></span>

            <?php endforeach; ?>
        </h1>

        
        
        <?php 
            else:
                // if no selected project
                echo "<h2>Create or Select a project at your left</h2>";
            endif;
        
        ?>

        <form action="#" class="agregar-tarea">
            <div class="campo">
                <label for="tarea">Task:</label>
                <input type="text" placeholder="Task Name" class="nombre-tarea"> 
            </div>
            <div class="campo enviar">
                <input type="hidden" id="project-id" value="<?php echo $project_id; ?>" value="id_proyecto">
                <input type="submit" class="boton nueva-tarea" value="Add">
            </div>
        </form>

        <h2>Task List:</h2>

        <div class="listado-pendientes">
            <ul>

                <?php 

                    // Get task from actual project

                    $tasks = getProjectTask($project_id);
                    if($tasks->num_rows > 0){
                        // There is tasks
                        foreach($tasks as $task):  ?>

                            <li id="tarea:<?php echo $task['id'] ?>" class="tarea">
                                <p><?php echo $task['nombre'] ?></p>
                                <div class="acciones">
                                    <i class="far fa-check-circle <?php echo ($task['estado'] === '1' ? 'completo' : '') ?>"></i>
                                    <i class="fas fa-trash"></i>
                                </div>
                            </li>  

                    <?php    endforeach;
                    } else {
                        echo "<p class='lista-vacia'>There isn't tasks in this project</p>";
                    }


                ?>
            </ul>
        </div>

        

        
    </main>
</div><!--.contenedor-->


<?php 
        include 'inc/templates/footer.php';

?>