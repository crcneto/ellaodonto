<div class="container">
    <div class="panel panel-default">
        <h3 class="h3 text-center">Definir os dias de atendimento&nbsp;<small style="font-style: italic;">(Configuração da agenda)</small></h3>

        <div class="panel-body">
            <div class="col-md-2"></div>
            <div class="col-md-3 panel panel-default">
                <h4 class="text-center">Selecione os dias</h4>
                <div class="input-group date">
                    <input type="text" class="form-control datepicker" id="dt"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                </div>
                <br>&nbsp;
                <br>
            </div>
            <div class="col-md-1"></div>
            <div class="col-md-3 panel panel-default">
                <h4 class="text-center">Horário de atendimento</h4>
                <form class="form-group-sm form-inline" action="<?= site_url('agenda/dias_atendimento') ?>" method="post">
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
                </form>
            </div>
        </div>
    </div>
    <div class="panel panel-default">
        <h4>Datas configuradas</h4>

    </div>
    <script>
        $('#dt').datepicker({
            language: "pt-BR",
            multidate: true
        });
    </script>
</div>