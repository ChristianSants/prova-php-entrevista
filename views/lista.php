<?php
    require_once '../autoload.inc.php';
    $objUser = new User();

    $arrayUsers = $objUser->list();

    $conteudo = '
        <table class="table tabela-lista table-bordered responsive pt-3 mb-0 px-0 w-100">
            <thead>
                <tr>
                    <th class="align-middle text-center">#</th>
                    <th class="align-middle text-center desktop">Nome</th>
                    <th class="align-middle text-center desktop">E-mail</th>
                    <th class="align-middle text-center desktop">Cores</th>
                    <th class="align-middle text-center desktop">Ações</th>
                </tr>
            </thead>
            <tbody>
    ';

    foreach($arrayUsers as $umUser){
        $cores = 'Nenhuma';
        if(!empty($umUser->getColors())){
            $cores = '<ul class="mb-0">';
            foreach($umUser->getColors() as $oneColor){
                $cores .= '<li>'.$oneColor->getName().'</li>';
            }
            $cores .= '<ul>';
        }

        $conteudo .= '
            <tr userId="'.$umUser->getId().'">
                <td class="align-middle text-center boldish">'.$umUser->getId().'</td>
                <td class="align-middle text-left">'.$umUser->getName().'</td>
                <td class="align-middle text-left">'.$umUser->getEmail().'</td>
                <td class="align-middle text-left">'.$cores.'</td>
                <td class="align-middle text-center">
                    <a href="#" class="editar mx-auto me-3">Editar</a>
                    <a href="#" class="excluir mx-auto">Excluir</a>
                </td>
            </tr>
        ';
    }

    $conteudo .= '</tbody></table>';

    echo $conteudo;