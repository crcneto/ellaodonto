<div class="container">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <div class="panel-title text-center">Cadastro de Paciente</div>
        </div>
        <div class="panel-body">
            <div class="col-md-4"></div>
            <div class="col-md-4">
                <form action="<?= site_url('paciente/insert') ?>" method="post" class="form-horizontal" onsubmit="return checkUsuario()">
                    <label>Selecione o usuário responsável</label>
                    <?php if (isset($usuarios)) { ?>
                        <?php if (count($usuarios) > 0) { ?>
                            <select class="form-control selectpicker" name="responsavel" data-live-search="true" id="responsavel">
                                <option value="">Selecione...</option>
                                <?php foreach ($usuarios as $k => $v) { ?>
                                    <option value="<?= $v['id'] ?>"<?php if (isset($paciente)) {
                            if ($paciente['usuario'] == $v['id']) {
                                echo "selected";
                            }
                        } ?>><?= $v['nome'] ?></option>
        <?php } ?>
                            </select>
                        <?php } ?>
                    <?php } ?>
                    <label>Nome do paciente</label> <a href="#" id="nm" class="btn btn-link btn-sm">(Usuário é o paciente)</a>
                    <input type="text" name="nome" id="pac_nome" class="form-control" <?php if (isset($paciente)) {echo $paciente['nome'];} ?>/>
                    <?php if (isset($paciente)) { ?>
                        <input type="hidden" name="id" value="<?= $paciente['id'] ?>" />
                    <?php } ?>
                    <label>Data de Nascimento</label> 
                    <input type="text" name="dn" id="pac_dn" class="form-control datepicker" <?php if (isset($paciente)) {
    echo inverte_data($paciente['dn']);
} ?>/>
                    <label>Sexo</label><br>
                    <input type="radio" name="sexo" value="1" <?php if (isset($paciente)) {
    if ($paciente['sexo'] == 1) {
        echo "checked";
    }
} ?>>Masculino
                    <br>
                    <input type="radio" name="sexo" value="2" <?php if (isset($paciente)) {
    if ($paciente['sexo'] == 2) {
        echo "checked";
    }
} ?>>Feminino
                    <br>
                    <br>
                    <div class="col-md-12 text-center">
                        <button type="submit" class="btn btn-success"><?php if(isset($paciente)){echo "Alterar Cadastro";}else{echo "Cadastrar";}?></button>
                    </div>
                </form>
            </div>
            <div class="col-md-4"></div>
        </div>
    </div>
    <div class="panel panel-primary">
        <div class="panel-heading">
            <div class="panel-title text-center">Pacientes Cadastrados</div>
        </div>
        <div class="panel-body">
            <table class="table table-hover table-striped table-bordered">
                <thead>
                    <tr>
                        <th class="text-center">Responsável</th>
                        <th class="text-center">Nome do Paciente</th>
                        <th class="text-center">Data de Nascimento</th>
                        <th class="text-center">Sexo</th>
                        <th class="text-center">Alterar</th>
                        <th class="text-center">Ativar/Desativar</th>
                    </tr>
                </thead>
                <tbody>
                <?php if (isset($pacientes)) { ?>
                    <?php if (count($pacientes) > 0) { ?>
                        <?php foreach ($pacientes as $k => $v) { ?>
                    <tr>
                        <td><?=$usuarios[$v['usuario']]['nome']?></td>
                        <td><?=$v['nome']?></td>
                        <td class="text-center"><?= inverte_data($v['dn'])?></td>
                        <td class="text-center"><?php if($v['sexo']==1){echo "Masculino";}else{echo "Feminino";}?></td>
                        <td class="text-center">
                            <form action="<?= site_url('paciente')?>" method="post">
                                <input type="hidden" name="id" value="<?=$v['id']?>" />
                                <button type="submit" class="btn btn-info" title="Editar paciente" data-toggle="tooltip" data-placement="top"><i class="glyphicon glyphicon-edit"></i></button>
                            </form>
                        </td>
                        <td class="text-center">
                            <?php if($v['status']==2){ ?>
                            <form action="<?= site_url('paciente/desativar')?>" method="post">
                                <input type="hidden" name="id" value="<?=$v['id']?>" />
                                <button type="submit" class="btn btn-danger" title="Desativar paciente" data-toggle="tooltip" data-placement="top"><i class="glyphicon glyphicon-remove"></i></button>
                            </form>
                            <?php } ?>
                            <?php if($v['status']==0){ ?>
                            <form action="<?= site_url('paciente/ativar')?>" method="post">
                                <input type="hidden" name="id" value="<?=$v['id']?>" />
                                <button type="submit" class="btn btn-success"><i class="glyphicon glyphicon-ok" title="Ativar paciente" data-toggle="tooltip" data-placement="top"></i></button>
                            </form>
                            <?php } ?>
                        </td>
                    </tr>
                        <?php } ?>
                    <?php } ?>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
    $('#nm').click(function () {
        var nome = $("select#responsavel option:checked").text();
        $('#pac_nome').val(nome);
    });
    function checkUsuario() {
        if ($("select#responsavel option:checked").val() == '') {
            alert("Selecione o usuário responsável.");
            return false;
        } else {
            return true;
        }
    }
</script>