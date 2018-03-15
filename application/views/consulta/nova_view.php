<!--
id serial unique not null primary key,
    profissional integer references usuario(id),
    paciente integer references paciente(id),
    data date,
    hora time,
    queixa text,
    lembrete date,
    ajustavel integer default 0, /*qtd de dias para adequação*/
    obs text,
    operador integer references usuario(id),
    ts timestamp default now(),
    status integer default 1, /*0-cancelada, 1-pendente, 2-confirmada, 3-atendida em tratamento, 4-atendida, 5-finalizada*/
    cancelamento timestamp default null,
    cancelador integer references usuario(id),
-->

<div class="container">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <div class="panel-title text-center">Nova consulta</div>
        </div>
        <form action="" method="post">
            <div class="panel-body">
                <div class="col-md-3">
                    <label>Selecione o profissional</label>
                    <select name="profissional" class="selectpicker" data-live-search="true">
                        <?php if (isset($profs)) { ?>
                            <?php if (count($profs) > 0) { ?>
                                <?php foreach ($profs as $k => $v) { ?>
                                    <option value="<?= $k ?>"><?= $v['nome'] ?></option>
                                <?php } ?>
                            <?php } ?>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label>Selecione o paciente</label>
                    <select name="paciente" class="selectpicker" data-live-search="true">
                        <?php if (isset($pacs)) { ?>
                            <?php if (count($pacs) > 0) { ?>
                                <?php foreach ($pacs as $k => $v) { ?>
                                    <option value="<?= $k ?>" <?php if($v['status']<1){echo "disabled=''";}?>><?= $v['nome'] ?></option>
                                <?php } ?>
                            <?php } ?>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <label>Data</label>
                    <input type="text" name="data" class="form-control datepicker" value="<?= $data ?>" />
                </div>
                <div class="col-md-2">
                    <label>Horário</label>
                    <select name="horario" class="form-control selectpicker">
                        <?php foreach ($horarios as $k1 => $v1) { ?>
                            <option value="<?= $v1 ?>"><?= $v1 ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <label>Dias para adequação</label>
                    <input type="text" name="ajustavel" class="form-control" value="0" />
                </div>
                <div class="col-md-3">
                    <label>Queixa</label>
                    <textarea name="queixa" rows="2" class="form-control" style="resize: none;"></textarea>
                </div>
                <div class="col-md-3">
                    <label>Observações</label>
                    <textarea name="obs" rows="2" class="form-control" style="resize: none;"></textarea>
                </div>
            </div>
        </form>
    </div>
    <div class="panel panel-primary">
        <div class="panel-heading">
            <div class="panel-title text-center">Suas consultas</div>
        </div>
        <div class="panel-body">
            corpo
        </div>
    </div>
</div>