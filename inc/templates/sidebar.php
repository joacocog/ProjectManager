<aside class="contenedor-proyectos">
        <div class="panel crear-proyecto">
            <a href="#" class="boton">New Project <i class="fas fa-plus"></i> </a>
        </div>
    
        <div class="panel lista-proyectos">
            <h2>Projects</h2>
            <ul id="proyectos" class="proyectos">
                <?php
                    $projects = getProjects($user_id);

                    if($projects){
                        foreach ($projects as $project){ ?>
                            <li id="proyecto:<?php echo $project['id'] ?>">
                            <a href="index.php?user_id=<?php echo $user_id?>&project_id=<?php echo $project['id'] ?>" id="proyecto:<?php echo $project['id'] ?>">
                                <?php echo $project['nombre'] ?>
                            </a>
                            <i class="fas fa-trash delete" ></i>
                            </li>
                <?php  } 
                    }
                ?>
            </ul>
        </div>
</aside>