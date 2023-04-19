<?php

// Get actual page
function getPageName(){
    $file = basename($_SERVER['PHP_SELF']);
    $page = str_replace(".php", "", $file);
    return $page;
}

getPageName();


// Consults

// Get all projects

function getProjects(){
    include 'conn.php';
    try{
        return $conn->query('SELECT id, nombre FROM proyectos');
    }catch(Exception $e){
        echo "Error! :" . $e->getMessage();
        return false;
    }
}

// Get project name

function getProjectName($id = null){
    include 'conn.php';

    try{
        return $conn->query("SELECT nombre FROM proyectos WHERE id = {$id} ");
    }catch(Exception $e){
        echo "Error! :" . $e->getMessage();
        return false;
    }
}

// Get task of project

function getProjectTask($id = null){
    include 'conn.php';

    try{
        return $conn->query("SELECT id, nombre, estado FROM tareas WHERE id_proyecto = {$id} ");
    }catch(Exception $e){
        echo "Error! :" . $e->getMessage();
        return false;
    }
}

