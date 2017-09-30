<div class="container">
    <div class="panel panel-default">
        <h3 class="h3 text-center">Definir os dias de atendimento&nbsp;<small style="font-style: italic;">(Configuração da agenda)</small></h3><hr>

        <div class="panel-body">
            <form action="<?= site_url('agenda/set_dates') ?>" method="post">
            <div class="col-md-3 panel panel-default">
                <h4 class="text-center">Selecione os dias</h4><hr>
                <div class="input-group date">
                    <input type="text" name="dts" class="form-control datepicker" id="dt"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                </div>
                <br>&nbsp;
                <br>&nbsp;
                <br>&nbsp;
                <br>&nbsp;
                <br>&nbsp;
                <br>
            </div>
                <div class="col-md-1"></div>
            <div class="col-md-3 panel panel-default">
                <h4 class="text-center">Horário de atendimento&nbsp;<i class="glyphicon glyphicon-exclamation-sign" title="Os dias que já foram salvos e forem selecionados novamente serão sobrescritos" data-toggle="tooltip" style="font-size: 0.6em;color:red;"></i></h4>
                <hr>
                <div class="form-group-sm form-inline">
                    <h5>1º Turno</h5>
                    <label>Das</label>
                    <select name="turnoinicio1" class="">
                        <?php foreach ($horarios as $k1 => $v1) { ?>
                            <option value="<?= $v1 ?>"><?= $v1 ?></option>
                        <?php } ?>
                    </select>&nbsp;<label>às</label>&nbsp;
                    <select name="turnofim1" class="">
                        <?php foreach ($horarios as $k1 => $v1) { ?>
                            <option value="<?= $v1 ?>"><?= $v1 ?></option>
                        <?php } ?>
                    </select>
                    <h5>2º Turno</h5>
                    <label>Das</label>
                    <select name="turnoinicio2" class="">
                        <?php foreach ($horarios as $k1 => $v1) { ?>
                            <option value="<?= $v1 ?>"><?= $v1 ?></option>
                        <?php } ?>
                    </select>&nbsp;<label>às</label>&nbsp;
                    <select name="turnofim2" class="">
                        <?php foreach ($horarios as $k1 => $v1) { ?>
                            <option value="<?= $v1 ?>"><?= $v1 ?></option>
                        <?php } ?>
                    </select>
                    
                    <br><br>&nbsp;
                </div>
            </div>
                <div class="col-md-1"></div>
            <div class="col-md-3 panel panel-default">
                <h4 class="text-center">Selecione o local</h4>
                <hr>
                <select name="local" class="form-control selectpicker" data-live-search="true">
                    <?php if(isset($mlocais)){?>
                    <?php if(count($mlocais)>0){?>
                    <?php foreach ($mlocais as $k=>$v){?>
                    <option value="<?=$k?>"><?=$lcs[$v['local']]['nome']?></option>
                    <?php } ?>
                    <?php } ?>
                    <?php } ?>
                </select>
                <br>&nbsp;<br>
                <br>&nbsp;<br>
                    <div class="text-center">
                        <?= btn("Salvar&nbsp;" . gly("ok", "Enviar"), "success", "sm", "", "top") ?>
                    </div>
                <br>&nbsp;
            </div>
            </form>
        </div>
    </div>
    <div class="panel panel-default">
        <table class="table table-bordered table-hover table-striped">
            <thead>
                <tr>
                    <th colspan="7" class="text-center">Datas definidas</th>
                </tr>
                <tr>
                    <th>Data</th>
                    <th>Local</th>
                    <th>Início Turno 1</th>
                    <th>Fim Turno 1</th>
                    <th>Início Turno 2</th>
                    <th>Fim Turno 2</th>
                    <th>Operações</th>
                </tr>
            </thead>
            <tbody>
                <?php if(isset($dias_marcados)){ ?>
                <?php if(count($dias_marcados)>0){ ?>
                <?php foreach($dias_marcados as $k=>$v){ ?>
                <tr>
                    <td class="text-center"><?=$v['data']?></td>
                    <td><?=$lcs[$v['local']]['nome']?></td>
                    <td class="text-center"><?=$v['ti1']?></td>
                    <td class="text-center"><?=$v['tf1']?></td>
                    <td class="text-center"><?=$v['ti2']?></td>
                    <td class="text-center"><?=$v['tf2']?></td>
                    <td class="text-center">
                        <form action="<?= site_url('agenda/excluir_horario')?>" method="post" onsubmit="return confirm('Deseja realmente excluir este horário?');">
                            <input type="hidden" name="id" value="<?=$v['id']?>" />
                            <button type="submit" class="btn btn-danger btn-sm"><i class="glyphicon glyphicon-trash"></i></button>
                        </form>
                    </td>
                </tr>
                <?php } ?>
                <?php } ?>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <script>
        $('#dt').datepicker({
            language: "pt-BR",
            multidate: true
        });
    </script>
</div>