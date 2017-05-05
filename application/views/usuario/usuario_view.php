<?php $this->load->helper('data_helper'); ?>
<div class="container">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <div class="panel-title text-center">Cadastro de Usuário <a href="<?= site_url('usuario')?>" class="btn btn-link"><?=gly('plus-sign', "Limpar/Novo usuário", "bottom")?></a></div>
        </div>
        <div class="panel-body">
            <form action="<?= site_url('usuario/insert') ?>" method="post">
                <div class="row">
                    <div class="col-md-2">
                        <?php if (isset($req['id'])) { ?>
                            <input type="hidden" name="id" value="<?= $req['id'] ?>" />
                        <?php } ?>
                        <label>CPF/CNPJ</label><span class="mandatory_field">*</span>&nbsp;<i class="glyphicon glyphicon-question-sign" data-toggle="tooltip" data-placement="top" title="Campo obrigatório. Somente Números"></i>
                        <input type="text" name="cpfcnpj" class="form-control" value="<?php
                        if (isset($req['cpfcnpj'])) {
                            echo exibe_cpf($req['cpfcnpj']);
                        }
                        ?>" />
                    </div>
                    <div class="col-md-1">
                        <input type="radio" name="tipo" value="1" <?php if (isset($req['cpfcnpj']) && iscpf($req['cpfcnpj'])) {
                            echo "checked";
                        } ?>/>CPF<br>
                        <input type="radio" name="tipo" value="2" <?php if (isset($req['cpfcnpj']) && !iscpf($req['cpfcnpj'])) {
                            echo "checked";
                        } ?>/>CNPJ<br>
                    </div>
                    <div class="col-md-4">
                        <label>Nome Completo</label><span class="mandatory_field">*</span>&nbsp;<i class="glyphicon glyphicon-question-sign" data-toggle="tooltip" data-placement="top" title="Campo obrigatório"></i>
                        <input type="text" name="nome" class="form-control" value="<?php if (isset($req['nome'])) {
                            echo $req['nome'];
                        } ?>" />

                    </div>
                    <div class="col-md-3">
                        <label>Nome de tratamento</label>
                        <input type="text" name="apelido" class="form-control" <?php
                        if (isset($req['apelido'])) {
                            echo "value='" . $req['apelido'] . "'";
                        }
                        ?>/>
                    </div>
                    <div class="col-md-2">
                        <br><br>
                        <input type="checkbox" name="gerar" class="checkbox-inline" value="1"/>&nbsp;Enviar senha
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <label>Telefone Principal</label>
                        <input type="text" name="tel" class="form-control" <?php if (isset($req['tel'])) {
                            echo "value='" . $req['tel'] . "'";
                        } ?>/>
                    </div>
                    <div class="col-md-4">
                        <label>E-mail</label><span class="mandatory_field">*</span>&nbsp;<i class="glyphicon glyphicon-question-sign" data-toggle="tooltip" data-placement="top" title="Necessário e-mail válido, a senha será enviada para este e-mail."></i>
                        <input type="text" name="email" class="form-control" value="<?php if (isset($req['email'])) {
                            echo $req['email'];
                        } ?>" />
                    </div>
                    <div class="col-md-3">
                        <label>Sexo</label>
                        <select name="sexo" class="form-control">
                            <option value="1">Masculino</option>
                            <option value="2">Feminino</option>
                        </select>
                    </div>
                    </div>
                <div class="row">
                    <div class="col-md-3">
                        <label>Data de Nascimento</label>
                        <input type="text" name="dn" value="<?php if (isset($req['datanasc'])) {
                            echo inverte_data($req['datanasc']);
                            } ?>" class="form-control datepicker"/>
                    </div>
                    <div class="col-md-3">
                        <label>Status</label>
                        <select name="status" class="form-control">
                            <?php if(isset($st)) { ?>
                            <?php if(count($st)>0) { ?>
                            <?php foreach($st as $k=>$v) { ?>
                            <option value="<?=$k?>" <?php if(isset($req['status'])) {if($req['status']==$k){echo "selected=''";}}else{if($k==1){echo "selected";}}?>><?=$v?></option>
                            <?php } ?>
                            <?php } ?>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-md-2 text-center">
                        <label>Secretária(o)?</label><br>
                        <input type="checkbox" name="secretaria" value="1" <?php if(isset($req['secretaria'])){if($req['secretaria']>=1){echo "checked";}}?> />Sim
                    </div>
                    <div class="col-md-2 text-center">
                        <label>Profissional?</label><br>
                        <input type="checkbox" name="profissional" value="1" <?php if(isset($req['profissional'])){if($req['profissional']>=1){echo "checked";}}?>  />Sim
                    </div>
                    <?php if($usuario['sysadmin']>=1) { ?>
                    <div class="col-md-2 text-center">
                        <label>Administrador?</label><br>
                        <input type="checkbox" name="sysadmin" value="1"  <?php if(isset($req['sysadmin'])){if($req['sysadmin']>=1){echo "checked";}}?> />Sim
                    </div>
                    <?php } ?>
                    
                </div>
                    <div class="row text-center">
                        <br>
                        <?php if (isset($req['id'])) {?>
                            <?=btn("Alterar usuário", "warning", "lg")?>
                        <?php } else { ?>
                            <?=btn("Cadastrar", "success", "lg")?>
                        <?php } ?>
                    </div>
                


            </form>
        </div>
    </div>
    <div class="panel panel-primary">
        <div class="panel-heading">
            <div class="panel-title">Usuários Cadastrados</div>
        </div>
        <div class="panel-body">
            <table class="table table-striped table-hover table-bordered">
                <thead>
                    <tr>
                        <th class="text-center">Nome</th>
                        <th class="text-center">E-mail</th>
                        <th class="text-center">Acesso</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Ativar/Desativar</th>
                        <th class="text-center">Editar</th>
                        <th class="text-center">Reset Senha</th>
                    </tr>
                </thead>
                <tbody>
<?php if (isset($usuarios) && count($usuarios) > 0) { ?>                    
    <?php foreach ($usuarios as $key => $value) { ?>
                            <tr>
                                <td><?= $value['nome'] ?></td>
                                <td><?= $value['email'] ?></td>
                                <td class="text-center"><?= $acessos[$value['acesso']] ?></td>
                                <td class="text-center"><?= $status[$value['status']] ?></td>
                                <td class="text-center">
        <?php if ($value['status'] != 2) { ?>
                                        <form action="<?= site_url('usuario/ativa') ?>" method="post">
                                            <input type="hidden" name="id" value="<?= $value['id'] ?>">
                                            <button type="submit" class="btn btn-success" title="Ativar" data-toggle="tooltip" data-placement="bottom"><i class="glyphicon glyphicon-ok"></i></button>
                                        </form>
        <?php } else { ?>
                                        <form action="<?= site_url('usuario/desativa') ?>" method="post" onsubmit="return confirm('Deseja realmente desativar este usuário?')">
                                            <input type="hidden" name="id" value="<?= $value['id'] ?>">
                                            <button type="submit" class="btn btn-danger" title="Desativar" data-toggle="tooltip" data-placement="bottom"><i class="glyphicon glyphicon-remove"></i></button>
                                        </form>
        <?php } ?>
                                </td>
                                <td class="text-center">
                                    <form action="<?= site_url('usuario') ?>" method="post">
                                        <input type="hidden" name="id" value="<?= $value['id'] ?>">
                                        <button type="submit" class="btn btn-warning" title="Editar informações do usuário" data-toggle="tooltip" data-placement="bottom"><i class="glyphicon glyphicon-edit"></i></button>
                                    </form>
                                </td>
                                <td class="text-center">
                                    <form action="<?= site_url('usuario/reset') ?>" method="post" onsubmit="return confirm('Deseja realmente redefinir a senha deste usuário?')">
                                        <input type="hidden" name="id" value="<?= $value['id'] ?>">
                                        <button type="submit" class="btn btn-danger" title="Redefinir a senha do Usuário" data-toggle="tooltip" data-placement="bottom"><i class="glyphicon glyphicon-refresh"></i></button>
                                    </form>
                                </td>
                            </tr>
    <?php } ?>
<?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

