<aside class="contenedor-proyectos">
        <div class="panel crear-proyecto">
            <a href="#" class="boton">New Project <i class="fas fa-plus"></i> </a>
        </div>
    
        <div class="panel lista-proyectos">
            <h2>Projects</h2>
            <ul id="proyectos">
                <?php
                    $projects = getProjects();

                    if($projects){
                        foreach ($projects as $project){ ?>
                            <li>
                            <a href="index.php?project_id=<?php echo $project['id'] ?>" id="proyecto:<?php echo $project['id'] ?>">
                                <?php echo $project['nombre'] ?>
                            </a>
                            </li>
                <?php  } 
                    }
                ?>
            </ul>
        </div>
</aside>