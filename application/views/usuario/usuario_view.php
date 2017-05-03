<?php $this->load->helper('data_helper'); ?>
<div class="container">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <div class="panel-title text-center">Cadastro de Usuário</div>
        </div>
        <div class="panel-body">
            <form action="<?= site_url('usuario/insert') ?>" method="post">
                <div class="row">
                    <div class="col-md-2">
                        <?php if(isset($req['id'])){?>
                        <input type="hidden" name="id" value="<?=$req['id']?>" />
                        <?php } ?>
                        <label>CPF/CNPJ</label><span class="mandatory_field">*</span>&nbsp;<i class="glyphicon glyphicon-question-sign" data-toggle="tooltip" data-placement="top" title="Campo obrigatório. Somente Números"></i>
                        <input type="text" name="cpfcnpj" class="form-control" value="<?php if (isset($req['cpfcnpj'])) {
                            echo $req['cpfcnpj'];
                        } ?>" />
                    </div>
                    <div class="col-md-1">
                        <input type="radio" name="tipo" value="1" <?php if (isset($req['cpfcnpj'])&& iscpf($req['cpfcnpj'])) {echo "checked";}?>/>CPF<br>
                        <input type="radio" name="tipo" value="2" <?php if (isset($req['cpfcnpj'])&& !iscpf($req['cpfcnpj'])) {echo "checked";} ?>/>CNPJ<br>
                    </div>
                    <div class="col-md-3">
                        <label>Nome Completo</label><span class="mandatory_field">*</span>&nbsp;<i class="glyphicon glyphicon-question-sign" data-toggle="tooltip" data-placement="top" title="Campo obrigatório"></i>
                        <input type="text" name="nome" class="form-control" value="<?php if (isset($req['nome'])) {echo $req['nome'];} ?>" />

                    </div>
                    <div class="col-md-4">
                        <label>E-mail</label><span class="mandatory_field">*</span>&nbsp;<i class="glyphicon glyphicon-question-sign" data-toggle="tooltip" data-placement="top" title="Necessário e-mail válido, a senha será enviada para este e-mail."></i>
                        <input type="text" name="email" class="form-control" value="<?php if (isset($req['email'])) {echo $req['email'];} ?>" />
                    </div>
                    <div class="col-md-2">
                        <br><br>
                        <input type="checkbox" name="gerar" class="checkbox-inline" value="1"/>&nbsp;Enviar senha
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2">
                        <label>Telefone Celular</label>
                        <input type="text" name="celular" class="form-control" <?php if (isset($req['celular'])) {echo "value='" . $req['celular'] . "'";} ?>/>
                    </div>
                    <div class="col-md-2">
                        <label>Telefone Fixo</label>
                        <input type="text" name="fixo" class="form-control" <?php if (isset($req['fixo'])) {
                            echo "value='" . $req['fixo'] . "'";
                        } ?>/>
                    </div>
                    <div class="col-md-4">
                        <label>Observações</label>
                        <input type="text" name="obs" class="form-control" <?php if (isset($req['obs'])) {
                            echo "value='" . $req['obs'] . "'";
                        } ?>/>
                    </div>
                    <div class="col-md-2">
                        <label>Status</label>
                        <select name="status" class="form-control">
                            <option value="2">Ativo</option>
                            <option value="0">Desativado</option>
                            <option value="1">Pendente</option>
                            <option value="3">Bloqueado</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <br>
                        <button type="submit" class="btn btn-success btn-lg"><?php if(isset($req['id'])){echo "Novo Usuário"; }else{echo "Alterar";}?></button>
                    </div>
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
<?php if(isset($usuarios)&& count($usuarios)>0){ ?>                    
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

