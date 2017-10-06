<div class="container">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <div class="panel-title text-center">Definindo Meus Assistentes</div>
        </div>
        <div class="panel-body">
            <div class="col-md-3"></div>
            <div class="col-md-6 text-center">
                <form action="<?= site_url('assistente/add')?>" method="post">
                <label>Selecione o usuário para defini-lo como seu assistente</label>
                <select name="assistente" class="form-control selectpicker" data-live-search="true">
                    <?php if(isset($usuarios)){ ?>
                    <?php if(count($usuarios)>0){ ?>
                    <?php foreach($usuarios as $k=>$v){ ?>
                    <option value="<?=$v['id']?>"><?=$v['nome']?></option>
                    <?php } ?>
                    <?php } ?>
                    <?php } ?>
                </select>
                <br>
                <br>
                <?=btn(gly("plus-sign")."&nbsp;Adicionar", "success")?>
                </form>
            </div>
            <div class="col-md-3"></div>
        </div>
    </div>
    <div class="panel panel-primary">
        <div class="panel-heading">
            <div class="panel-title text-center">Meus Assistentes</div>
        </div>
        <div class="panel-body">
            <table class="table table-bordered table-hover table-striped">
                <thead>
                    <tr>
                        <th class="col-md-10">Nome do Assistente</th>
                        <th class="col-md-2">Excluir</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(isset($assistentes)){ ?>
                    <?php if(count($assistentes)>0){ ?>
                    <?php foreach($assistentes as $k=>$v){ ?>
                    <tr>
                        <td><?=$users[$v['assistente']]['nome']?></td>
                        <td class="text-center">
                            <form action="<?= site_url('assistente/delete')?>" method="post" onsubmit="return confirm('Deseja realmente excluir este assistente?\n Este usuário não terá mais acesso aos seus compromissos ou cadastros');">
                                <input type="hidden" name="assistente" value="<?=$v['assistente']?>" />
                                <?= btn(gly("remove"), "danger", "sm")?>
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
</div>