<div class="container">
    
    <div class="panel panel-primary">
        <div class="panel-heading">
            <div class="panel-title text-center">Meus Locais de Atendimento <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal" title="Novo local de Atendimento"><?= gly("plus-sign", "Cadastrar novo local de Atendimento", "bottom")?></button></div>
        </div>
        <div class="panel-body">
            <div class="col-md-4"></div>
            <div class="col-md-4 panel">
                <div class="panel-heading">
                    <div class="panel-title text-center">Adicionar Local de Atendimento</div>
                </div>
                <div class="panel-body">
                    <label>Selecione o local</label>
                    <select class="form-control selectpicker" name="id" data-live-search="true">
                        <?php if(isset($locais)){ ?>
                        <?php if(count($locais)){ ?>
                        <?php foreach($locais as $k=>$v){ ?>
                        <option value="<?=$v['id']?>"><?=$v['nome']?> - <?= get_tipo_logradouro($v['tp_log'])?> &nbsp;<?=$v['logradouro']?>, <?=$v['nro']?> - <?=$v['complemento']?> - <?=$v['bairro']?> - <?=$v['cidade']?>/<?=$v['uf']?></option>
                        <?php } ?>
                        <?php } ?>
                        <?php } ?>
                    </select>
                    <br>
                    <div class="text-center">
                        <br>
                    <?= btn("Adicionar", "success", "lg", "Adicionar aos \"Meus locais de Atendimento\"", "top")?>
                    </div>
                </div>
            </div>
            <div class="col-md-4"></div>
        </div>
    </div>
    <div class="panel panel-primary">
        <div class="panel-heading">
            <div class="panel-title text-center">Meus Locais</div>
        </div>
        <div class="panel-body">
            <table class="table table-bordered table-hover table-striped">
                <thead>
                    <tr>
                        <th class="text-center">Local de Atendimento</th>
                        <th class="text-center">Excluir</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(isset($mlocais)){ ?>
                    <?php if(count($mlocais)){ ?>
                    <?php foreach($mlocais as $k=>$v){ ?>
                    <tr>
                        <td><?=$locais[$v['local']]['nome']?></td>
                        <td>
                            <form action="<?= site_url('local/delete_meu_local')?>" method="post">
                                <input type="hidden" name="id" value="<?=$v['id']?>" />
                                <?= btn(gly("trash"), "danger", "sm", "Excluir Meu Local de Atendimento", "top")?>
                            </form>
                        </td>
                    </tr>
                    <?php } ?>
                    <?php } ?>
                    <?php } ?>
                </tbody>
            </table>
        </div>
</div>
<!--Modal-->
    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h2 class="modal-title text-center" id="myModalLabel">Alerta</h2>
                </div>
                <div class="modal-body">
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Enviar</button>
                </div>
            </div>
        </div>
    </div>
    <!--Fim Modal-->

    <!-- Botão teste modal -->
    <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">
        Teste Modal
    </button>
    <!--FIm botão teste-->
