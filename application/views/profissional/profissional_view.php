<div class="container">
    <div class="row">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="panel-title text-center">Profissionais</div>
            </div>
            <div class="panel-body">
                <table class="table table-bordered table-hover table-striped">
                    <thead>
                        <tr>
                            <th>Opção</th>
                            <th>Usuário</th>
                            <th>E-mail</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(isset($usuarios)){ ?>
                        <?php if(count($usuarios)>0){ ?>
                        <?php foreach($usuarios as $k=>$v){ ?>
                        <tr>
                            <td class="col-md-1 text-center">
                                <?php if($v['id'] != $operador){ ?>
                                <?php if(isset($profs[$v['id']])){ ?>
                                <form action="<?= site_url('profissional/unset_prof')?>" method="post">
                                    <input type="hidden" name="id" value="<?=$v['id']?>" />
                                    <button type="submit" class="btn btn-warning" title="Retirar privilégios" data-toggle="tooltip"><?= gly("pawn")?></button>
                                </form>
                                <?php } else { ?>
                                <form action="<?= site_url('profissional/set_prof')?>" method="post">
                                    <input type="hidden" name="id" value="<?=$v['id']?>" />
                                    <button type="submit" class="btn btn-success" title="Definir como profisiional" data-toggle="tooltip"><?= gly("knight")?></button>
                                </form>
                                <?php } ?>
                                <?php } ?>
                                
                            </td>
                            <td><?=$v['nome']?></td>
                            <td><?=$v['email']?></td>
                            
                        </tr>
                        <?php } ?>
                        <?php } ?>
                        <?php } ?>
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
