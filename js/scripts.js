eventListeners();

// Project list
let projectList = document.querySelector('ul#proyectos');

function eventListeners(){
    // Button to create project
    document.querySelector('.crear-proyecto a').addEventListener('click', newProject);

    //Button to delete projects
    document.querySelector('.proyectos').addEventListener('click', deleteProject);

    // button for a new task
    document.querySelector('.nueva-tarea').addEventListener('click', addTask);

    // Button for task actions
    document.querySelector('.listado-pendientes').addEventListener('click', taskActions);
}

function newProject(e){
    e.preventDefault();

    // create input for the project name
    let newProject = document.createElement('li');
    newProject.innerHTML = '<input type="text" id="nuevo-proyecto">';
    projectList.appendChild(newProject);

    // Select ID with newProject
    let newProjectInput = document.querySelector('#nuevo-proyecto');

    // Press enter to create the project

    newProjectInput.addEventListener('keypress', function(e){
        let key = e.which || e.keyCode;

        if(key === 13){
            saveProjectDB(newProjectInput.value);
            projectList.removeChild(newProject);
        }
    });

}

function saveProjectDB(projectName){
    // create call ajax

    var xhr = new XMLHttpRequest();

    // Send data by formdata
    var data = new FormData();
    data.append('project', projectName);
    data.append('action', 'crear');
    data.append('user_id', document.querySelector('#user').value);

    // Open Conn
    xhr.open('POST', 'inc/models/project-model.php', true);

    // Load
    xhr.onload = function(){
        if(this.status === 200){
            // Get data from answer
            var answer = JSON.parse(xhr.responseText);
            var project = answer.project_name,
                project_id = answer.id_insertado,
                type = answer.type,
                result = answer.answer;

            // Check upload

            if(result === 'successfull'){
                // OK
                if(type === 'crear'){
                    // new project

                    var newProject = document.createElement('li');
                    newProject.innerHTML = `
                        <a href="index.php?project_id=${project_id}" id="proyecto:${project_id}">
                            ${project}
                            <i class="fas fa-trash"></i>
                        </a>
                    `;

                    // add to html

                    projectList.appendChild(newProject);

                    // Redirect
                      window.location.href = 'index.php?user_id=' + document.querySelector('#user').value + '&project_id=' + project_id;
                }else{
                    // update or deleted
                }
            } else {
                // error
                Swal.fire({
                    type: 'error',
                    title: 'Error',
                    text: 'There was an error'
                  });
            }

        }
    }

    // Send Request
    xhr.send(data);
}

function deleteProject(e){

    if(e.target.classList.contains('fa-trash')){
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
          }).then((result) => {
            if (result.value) {
                var deleteProject = e.target.parentElement;
                // Delete from DB
                deleteProjectDB(deleteProject);

                // Delete from html
                deleteProject.remove();

              Swal.fire(
                'Deleted!',
                'Your task has been deleted.',
                'success'
              )

              window.location.href = 'index.php?user_id=' + document.querySelector('#user').value;
            }
          })
    }
}

// Delete task from db

function deleteProjectDB(project){

    var projectId = project.id.split(':');

    // Create call ajax

    var xhr = new XMLHttpRequest();

    // Form data

    var data = new FormData();
    data.append('id', projectId[1]);
    data.append('action', 'delete');

    // Open conn

    xhr.open('POST', 'inc/models/project-model.php', true);

    // on load

    xhr.onload = function(){
        if(this.status === 200){


        }
    }

    xhr.send(data);
}
// Add a new task to the actual project

function addTask(e){
    e.preventDefault();

    var taskName = document.querySelector('.nombre-tarea').value;

    if(taskName === ''){
        Swal.fire({
            type: 'error',
            title: 'Error',
            text: 'Complete the name of the task'
          });
    } else{
        // insert on php

        // create call to ajax

        var xhr = new XMLHttpRequest();

        // create form data

        var data = new FormData();
        data.append('task', taskName);
        data.append('action', 'create');
        data.append('project_id', document.querySelector('#project-id').value);

        // Open Conn

        xhr.open('POST', 'inc/models/task-model.php', true);

        // Execute and answer

        xhr.onload = function(){
            if(this.status === 200){
                // OK
                var answer = JSON.parse(xhr.responseText);
                
                // values

                var result = answer.answer,
                    task = answer.tarea,
                    inserted_id = answer.id_insertado,
                    type = answer.type;

                if(result === 'successfull'){
                    // Added correctly

                    if(type === 'create'){
                        // alert
                        Swal.fire({
                            type: 'success',
                            title: 'Task Created',
                            text: task + ' was created successsfully'
                          });

                        // Select empty list

                        var emptyList = document.querySelectorAll('.lista-vacia');
                        
                        if (typeof emptyList !== 'undefined') {


                          } else {
                            emptyList.remove();
                          }
                        

                        // Insert task
                        
                        var newTask = document.createElement('li');

                        // Add Id

                        newTask.id = 'task:' + inserted_id;

                        // Add class
                        newTask.classList.add('tarea');

                        // Insert on html

                        newTask.innerHTML = `
                          <p>${task}</p>
                          <div class="acciones">
                                <i class="far fa-check-circle"></i>
                                <i class="fas fa-trash"></i>
                          </div>
                        `;
                        

                        // Add to DOM
                        var list = document.querySelector(".listado-pendientes ul");

                        list.appendChild(newTask);

                       

                        // Reset form
                        document.querySelector('.agregar-tarea').reset();
                    }
                } else {
                    // error

                    Swal.fire({
                        type: 'error',
                        title: 'Error',
                        text: 'There was an error'
                      });
                      
                }
            }
        }

        // Send data

        xhr.send(data);
    }
}


// Task actions

function taskActions(e){
    e.preventDefault();

    if(e.target.classList.contains('fa-check-circle')){
        if(e.target.classList.contains('completo')){
            e.target.classList.remove('completo');
            changeTaskStatus(e.target, 0);
        } else{
            e.target.classList.add('completo');
            changeTaskStatus(e.target, 1);
        }
    }

    if(e.target.classList.contains('fa-trash')){
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
          }).then((result) => {
            if (result.value) {
                var deleteTask = e.target.parentElement.parentElement;
                // Delete from DB
                deleteTaskDB(deleteTask);

                // Delete from html
                deleteTask.remove();

              Swal.fire(
                'Deleted!',
                'Your task has been deleted.',
                'success'
              )
            }
          })
    }
}

// change Task Status

function changeTaskStatus(task, state){
    var taskId = task.parentElement.parentElement.id.split(':');
    
    // Create call ajax

    var xhr = new XMLHttpRequest();

    // Form data

    var data = new FormData();
    data.append('id', taskId[1]);
    data.append('action', 'update');
    data.append('state', state)

    // Open conn

    xhr.open('POST', 'inc/models/task-model.php', true);

    // on load

    xhr.onload = function(){
        if(this.status === 200){
        }
    }

    // Send

    xhr.send(data);
}


// Delete task from db

function deleteTaskDB(task){

    var taskId = task.id.split(':');

    // Create call ajax

    var xhr = new XMLHttpRequest();

    // Form data

    var data = new FormData();
    data.append('id', taskId[1]);
    data.append('action', 'delete');

    // Open conn

    xhr.open('POST', 'inc/models/task-model.php', true);

    // on load

    xhr.onload = function(){
        if(this.status === 200){

            // Is there tasks?

            var taskList = document.querySelectorAll('li.tarea');

            if(taskList.length === 0){
                document.querySelector('.listado-pendientes').innerHTML = "<p class='lista-vacia'>There isn't tasks in this project</p>";
            }
        }
    }

    // Send

    xhr.send(data);
}
