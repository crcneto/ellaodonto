<div class="container">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <div class="panel-title text-center">Cadastro de Especialidade</div>
        </div>
        <div class="panel-body">
            <form action="<?= site_url('especialidade/insert')?>" method="post">
                <?php if(isset($esp)){?>
                <input type="hidden" name="id" value="<?=$esp['id']?>" />
                <?php } ?>
                <div class="col-md-4">
                    <label>Especialidade</label>
                    <input type="text" name="nome" class="form-control" required="" value="<?php if(isset($esp)){echo $esp['nome'];}?>" />
                
                    <label>Área</label>
                    <select name="area" class="form-control">
                        <?php foreach ($areas as $ka => $va) { ?>
                        <option value="<?=$va['id']?>" <?php if(isset($esp)){if($esp['area']==$va['id']){echo "selected";}} ?>><?=$va['nome']?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label>Observações</label>
                    <textarea name="obs" class="form-control" rows="4" style="resize: none;"><?php if(isset($esp)){echo $esp['obs'];}?></textarea>
                </div>
                <div class="col-md-4">
                    <label>Status</label>
                    <select name="status" class="form-control">
                        <option value="2" <?php if(isset($esp)){if($esp['status']==2){echo "selected";}}?>>Ativo</option>
                        <option value="0" <?php if(isset($esp)){if($esp['status']==0){echo "selected";}}?>>Desativado</option>
                    </select>
                    <br>
                    <button type="submit" class="btn btn-success col-md-12"><?php if(isset($esp)){echo "Alterar";}else{echo "Cadastrar";}?></button>
                </div>
            </form>
        </div>
    </div>
    <div class="panel panel-primary">
        <div class="panel-heading">
            <div class="panel-title text-center">Especialidades Cadastradas</div>
        </div>
        <div class="panel-body">
            <table class="table table-striped table-hover table-bordered">
                <thead>
                    <tr>
                        <th class="text-center">Área</th>
                        <th class="text-center">Nome</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Editar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($especialidades as $ke => $ve) {?>
                    <tr>
                        <td><?=$areas[$ve['area']]['nome']?></td>
                        <td><?=$ve['nome']?>&nbsp;<i class="glyphicon glyphicon-question-sign" title="<?=$ve['obs']?>" data-toggle="tooltip" data-placement="top"></i></td>
                        <td class="text-center"><?php if($ve['status']==2){echo 'Ativo';}else{echo 'Desativado';}?></td>
                        <td class="text-center">
                            <form action="<?= site_url('especialidade')?>" method="post">
                                <input type="hidden" name="id" value="<?=$ve['id']?>" />
                                <button type="submit" class="btn btn-warning"><i class="glyphicon glyphicon-edit"></i></button>
                            </form>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>