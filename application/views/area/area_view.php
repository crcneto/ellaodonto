<div class="container">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <div class="panel-title text-center">Cadastro de Área &nbsp;<a href="<?= site_url('area')?>"><?= gly("plus-sign", "Cadastrar nova Área")?></a></div>
        </div>
        <div class="panel-body">
            <form action="<?= site_url('area/insert')?>" method="post">
                <div class="col-md-4">
                    <label>Área</label>
                    <input type="text" name="nome" class="form-control" value="<?php if(isset($area)){echo $area['nome'];}?>" />
                    <?php if(isset($area)){ ?>
                    <input type="hidden" name="id" value="<?=$area['id']?>" />
                    <?php } ?>
                </div>
                <div class="col-md-4">
                    <label>Status</label>
                    <select name="status" class="form-control">
                        <option value="2" <?php if(isset($area['status']) && $area['status']!=null){if($area['status']==2){echo "selected";}}?>>Ativo</option>
                        <option value="0" <?php if(isset($area['status']) && $area['status']!=null){if($area['status']==0){echo "selected";}}?>>Desativado</option>
                        
                    </select>
                </div>
                <div class="col-md-4">
                    <br>
                    <?php if(isset($area)){ ?>
                    <button type="submit" class="btn btn-warning">Alterar</button>
                    <?php } else { ?>
                    <button type="submit" class="btn btn-success">Cadastrar</button>
                    <?php }?>
                </div>
                <div class="col-md-3"></div>
            </form>
        </div>
    </div>
    <div class="panel panel-primary">
        <div class="panel-heading">
            <div class="panel-title text-center">Áreas Cadastradas</div>
        </div>
        <div class="panel-body">
            <table class="table table-striped table-hover table-bordered">
                <thead>
                    <tr>
                        <th class="text-center">Área</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Editar</th>
                        <th class="text-center">Excluir</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(isset($areas)&& count($areas)>0){ ?>
                    <?php foreach ($areas as $ka => $va) {?>
                    <tr>
                        <td><?=$va['nome']?></td>
                        <td><?php if($va['status']==2){echo "Ativo";}else{echo "Desativado";}?></td>
                        <td class="text-center">
                            <form action="<?= site_url('area')?>" method="post">
                                <input type="hidden" name="id" value="<?=$va['id']?>" />
                                <button type="submit" class="btn btn-warning"><i class="glyphicon glyphicon-edit"></i></button>
                            </form>
                        </td>
                        <td class="text-center">
                            <form action="<?= site_url('area/delete')?>" method="post" onsubmit="return confirm('Excluir definitivamente o registro?')">
                                <input type="hidden" name="id" value="<?=$va['id']?>" />
                                <button type="submit" class="btn btn-danger"><i class="glyphicon glyphicon-remove"></i></button>
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
