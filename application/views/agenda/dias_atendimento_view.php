<div class="container">
    <div class="panel panel-default">
        <h3 class="h3 text-center">Definir os dias de atendimento&nbsp;<small style="font-style: italic;">(Configuração da agenda)</small></h3><hr>

        <div class="panel-body">
            <form action="<?= site_url('agenda/set_dates') ?>" method="post">
            <div class="col-md-2"></div>
            <div class="col-md-3 panel panel-default">
                <h4 class="text-center">Selecione os dias</h4><hr>
                <div class="input-group date">
                    <input type="text" name="dts" class="form-control datepicker" id="dt"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                </div>
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
                    <br>&nbsp;<br>
                    <div class="text-center">
                        <?= btn("Salvar&nbsp;" . gly("ok", "Enviar"), "success", "sm", "", "top") ?>
                    </div>
                    <br>
                </div>
            </div>
            </form>
        </div>
    </div>
    <div class="panel panel-default">
        <h4>Datas configuradas</h4>
        <pre><?php print_r($post);?></pre>
    </div>
    <script>
        $('#dt').datepicker({
            language: "pt-BR",
            multidate: true
        });
    </script>
</div>