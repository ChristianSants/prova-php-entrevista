<?php
    require_once '../autoload.inc.php';
    extract($_POST);

    $objUser = new User($id);
    $objUser->load();

    $objUser->setName($edtName);
    $objUser->setEmail($edtEmail);

    if($objUser->update()){
        // apagando cores
        $objUserColor = new UserColor();
        $objUserColor->deleteByUserId($id);

        // inserindo cores
        if(!empty($selectColors)){
            foreach($selectColors as $oneColor){
                $objUserColor = new UserColor($id, $oneColor);
                $objUserColor->insert();
            }
        }
        
        echo '<script>
            alert("Atualizado com Sucesso")
            $(".modal").modal("hide")
            lista()
        </script>';
    }else{
        echo '<script>alert("Algum erro ocorreu!")</script>';
    }