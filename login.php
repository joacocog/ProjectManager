<?php 
        session_start();
        include 'inc/functions/functions.php'; 
        include 'inc/templates/header.php';

        if(isset($_GET['cerrar_sesion'])){
            $_SESSION = array();
        }
?>


    <div class="contenedor-formulario">
        <h1>UpTask</h1>
        <form id="formulario" class="caja-login" method="post">
            <div class="campo">
                <label for="usuario">User: </label>
                <input type="text" name="usuario" id="usuario" placeholder="User">
            </div>
            <div class="campo">
                <label for="password">Password: </label>
                <input type="password" name="password" id="password" placeholder="Password">
            </div>
            <div class="campo enviar">
                <input type="hidden" id="tipo" value="login">
                <input type="submit" class="boton" value="Log In">
            </div>

            <div class="campo">
                <a href="create-user.php">Create a new account</a>
            </div>
        </form>
    </div>

<?php 
    include 'inc/templates/footer.php';  

?>