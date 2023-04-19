

eventListeners();

function eventListeners(){

    document.querySelector('#formulario').addEventListener('submit', validarRegistro);
}

function validarRegistro(e){
    e.preventDefault();

    var usuario = document.querySelector('#usuario').value,
        password = document.querySelector('#password').value,
        type = document.querySelector('#tipo').value;

    if(usuario === '' || password === ''){
        // validate error
        Swal.fire({
            type: 'error',
            title: 'Error!',
            text: 'Both fields are required!'
          })
    }else{
        // execute ajax

        // data for server
        var datos = new FormData();
        datos.append('usuario', usuario);
        datos.append('password', password);
        datos.append('action', type);

        // call ajax
        var xhr = new XMLHttpRequest();

        // open conn
        xhr.open('POST', 'inc/models/admin-model.php', true);

        // data return
        xhr.onload = function(){
            if(this.status === 200){
                var answer = JSON.parse(xhr.responseText);
                console.log(answer);
                // if answer is succesfull
                if(answer.answer === 'successfull'){
                    // new user
                    if(answer.type === 'crear'){
                        Swal.fire({
                            type: 'success',
                            title: 'User Created',
                            text: 'User was created successsfully'
                          });
                    } else if (answer.type === 'login'){
                        Swal.fire({
                            type: 'success',
                            title: 'Login Successfully',
                            text: 'Press OK to see the dashboard'
                        })
                        .then(result =>{
                            if(result.value){
                                window.location.href = 'index.php';
                            }
                        })
                    }
                }else{
                    // there was an error
                    Swal.fire({
                        type: 'error',
                        title: 'Error',
                        text: 'There was an error'
                      });
                }
            }
        }

        // send request
        xhr.send(datos);
    }
}