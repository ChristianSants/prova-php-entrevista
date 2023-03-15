<?php
    require_once '../autoload.inc.php';
    extract($_POST);

    $objUser = new User(null, $edtName, $edtEmail);
    $idInserido = $objUser->insert();
    if($idInserido){

        // inserindo cores
        if(!empty($selectColors)){
            foreach($selectColors as $oneColor){
                $objUserColor = new UserColor($idInserido, $oneColor);
                $objUserColor->insert();
            }
        }

        echo '<script>
            alert("Inserido com Sucesso")
            $(".modal").modal("hide")
            lista()
        </script>';
    }else{
        echo '<script>alert("Algum erro ocorreu!")</script>';
    }