<div class="container">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <div class="panel-title text-center">Cadastro de Local de Atendimento &nbsp; <a href="<?= site_url('local') ?>"><?= gly("plus-sign", "Limpar formulário/Cadastrar Novo", "top") ?></a></div>
        </div>
        <div class="panel-body">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <form action="<?= site_url('local/insert') ?>" method="post">
                    <?php if (isset($lo['id'])) { ?>
                        <input type="hidden" name="id" value="<?= $lo['id'] ?>">
                    <?php } ?>
                    <div class="col-md-12">
                        <label>Nome do local</label>
                        <input type="text" name="nome" class="form-control" value="<?php if (isset($lo['nome'])) {
                        echo $lo['nome'];
                    } ?>" required=""/>
                    </div>
                    <div class="col-md-3">
                        <label>Tipo</label>
                        <select name="tp_log" class="form-control">
                            <?php if (isset($tipos)) { ?>
                                <?php if (count($tipos) > 0) { ?>
                                    <?php foreach ($tipos as $k => $v) { ?>
                                        <option value="<?= $k ?>" <?php if (isset($lo['tipo'])) {
                                if ($lo['tipo'] == $k) {
                                    echo "selected=''";
                                }
                            } ?>><?= $v ?></option>
        <?php } ?>
    <?php } ?>
<?php } ?>
                        </select>
                    </div>
                    <div class="col-md-7">
                        <label>Logradouro</label>
                        <input type="text" name="logradouro" class="form-control" value="<?php if (isset($lo['logradouro'])) {
    echo $lo['logradouro'];
} ?>" required=""/>
                    </div>
                    <div class="col-md-2">
                        <label>Nº</label>
                        <input type="text" name="nro" class="form-control" value="<?php if (isset($lo['nro'])) {
    echo $lo['nro'];
} ?>" />
                    </div>
                    <div class="col-md-5">
                        <label>Bairro</label>
                        <input type="text" name="bairro" class="form-control" value="<?php if (isset($lo['bairro'])) {
    echo $lo['bairro'];
} ?>" />
                    </div>
                    <div class="col-md-5">
                        <label>Cidade</label>
                        <input type="text" name="cidade" class="form-control" value="<?php if (isset($lo['cidade'])) {
    echo $lo['cidade'];
} ?>" />
                    </div>
                    <div class="col-md-2">
                        <label>UF</label>
                        <input type="text" name="uf" class="form-control" value="<?php if (isset($lo['uf'])) {
    echo $lo['uf'];
} ?>" />
                    </div>
                    <div class="col-md-6">
                        <label>CEP</label>
                        <input type="text" name="cep" class="form-control" value="<?php if (isset($lo['cep'])) {
    echo $lo['cep'];
} ?>" />
                    </div>
                    <div class="col-md-6">
                        <label>Complemento</label>
                        <input type="text" name="complemento" class="form-control" value="<?php if (isset($lo['complemento'])) {
                            echo $lo['complemento'];
                        } ?>"/>
                    </div>
                    <div class="col-md-6">
                        <label>Telefone</label>
                        <input type="text" name="tel" class="form-control" value="<?php if (isset($lo['tel'])) {
                            echo $lo['tel'];
                        } ?>" />
                    </div>
                    <div class="col-md-6">
                        <label>Celular</label>
                        <input type="text" name="cel" class="form-control" value="<?php if (isset($lo['cel'])) {
                            echo $lo['cel'];
                        } ?>" />
                    </div>

                    <br>&nbsp;
                    <br>
                    <div class="col-md-12 text-center">
<?php if (isset($lo['id'])) { ?>
    <?= btn(gly("edit") . " Editar", "warning", 'lg', "Alterar") ?>
<?php } else { ?>
    <?= btn(gly("ok") . " Cadastrar", "success", 'lg', "Cadastrar") ?>
<?php } ?>
                    </div>
                </form>
            </div>
            <div class="col-md-3"></div>
        </div>
    </div>
    <div class="panel panel-primary">
        <div class="panel-heading">
            <div class="panel-title text-center">Locais de Atendimento Cadastrados</div>
        </div>
        <div class="panel-body">
            <table class="table table-striped table-hover table-bordered">
                <thead>
                    <tr>
                        <th class="text-center">Nome</th>
                        <th class="text-center">Logradouro</th>
                        <th class="text-center">Complemento</th>
                        <th class="text-center">Bairro</th>
                        <th class="text-center">Cidade</th>
                        <th class="text-center">UF</th>
                        <th class="text-center">Telefone</th>
                        <th class="text-center">Celular</th>
                        <th class="text-center">Operações</th>
                    </tr>
                </thead>
                <tbody> 
                                <?php if (isset($locais)) { ?>
    <?php if (count($locais) > 0) { ?>
        <?php foreach ($locais as $k => $v) { ?>
                                <tr>
                                    <td><?= $v['nome'] ?></td>
                                    <td><?= get_tipo_logradouro($v['tp_log']) ?>&nbsp;<?= $v['logradouro'] ?>, <?= $v['nro'] ?></td>
                                    <td><?= $v['complemento'] ?></td>
                                    <td><?= $v['bairro'] ?></td>
                                    <td><?= $v['cidade'] ?></td>
                                    <td><?= $v['uf'] ?></td>
                                    <td><?= $v['tel'] ?></td>
                                    <td><?= $v['cel'] ?></td>
                                    <td>
                                        <div class="col-md-4">
                                            <?php if($v['status']==2){ ?>
                                            <form action="<?= site_url('local/desativar')?>" method="post">
                                                <input type="hidden" name="id" value="<?=$v['id']?>">
                                                <?= btn(gly("ban-circle"), "danger", "sm", "Desativar") ?>
                                            </form>
                                            <?php } else { ?>
                                            <form action="<?= site_url('local/ativar')?>" method="post">
                                                <input type="hidden" name="id" value="<?=$v['id']?>">
                                                <?= btn(gly("ok-circle"), "success", "sm", "Ativar") ?>
                                            </form>
                                            <?php } ?>
                                        </div>
                                        <div class="col-md-4">
                                            <form action="<?= site_url('local/edit')?>" method="post">
                                                <input type="hidden" name="id" value="<?=$v['id']?>">
                                                <?= btn(gly("edit"), "warning", "sm", "Editar") ?>
                                            </form>
                                        </div>
                                        <div class="col-md-4">
                                            <form action="<?= site_url('local/delete')?>" method="post">
                                                <input type="hidden" name="id" value="<?=$v['id']?>">
                                                <?= btn(gly("trash"), "danger", "sm", "Excluir") ?>
                                            </form>
                                        </div>

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