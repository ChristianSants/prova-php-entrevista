<?php
    require_once '../autoload.inc.php';
    extract($_POST);

    $objUser = new User($id);
    if($objUser->delete()){
        echo '<script>
            alert("Deletado com Sucesso")
            lista()
        </script>';
    }else{
        echo '<script>alert("Algum erro ocorreu!")</script>';
    }