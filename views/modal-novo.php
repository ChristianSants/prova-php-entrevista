<?php
    require_once '../autoload.inc.php';

    $conteudo = '
        <div class="modal-header">
            <h5 class="modal-title">Adicionar Usuário</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-6 mb-3">
                    <label for="edtName" class="form-label">Nome</label>
                    <input type="text" class="form-control" id="edtName">
                </div>
                <div class="col-6 mb-3">
                    <label for="edtEmail" class="form-label">E-mail</label>
                    <input type="email" class="form-control" id="edtEmail">
                </div>
            </div>

            <div class="row">
                <div class="col-12 mb-3">
                    <label for="selectColors" class="form-label">Cores</label>
                    <select name="selectColors" id="selectColors" class="form-select select2" multiple>';

    $objColor = new Color();
    $arrayColors = $objColor->list();
    foreach($arrayColors as $oneColor){
        $conteudo .= '<option value="'.$oneColor->getId().'">'.$oneColor->getName().'</option>';
    }                    

    $conteudo .= '
                    </select>
                </div>
            </div>


            <div class="msg"></div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
            <button type="button" class="btn btn-primary salvar">Salvar</button>
        </div>
    ';

    echo $conteudo;