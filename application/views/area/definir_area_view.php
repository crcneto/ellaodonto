<div class="container">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <div class="panel-title text-center">Definir Minha Área de Atuação</div>
        </div>
        <div class="panel-body">
            <div class="col-md-4"></div>
            <div class="col-md-4">
                <form action="<?= site_url('area/vincular') ?>" method="post" class="form-horizontal">
                    <label>Selecione a área</label>
                    <br>
                    <select name="area" class="selectpicker">
                        <?php if (isset($areas)) { ?>
                            <?php if (count($areas) > 0) { ?>
                                <?php foreach ($areas as $k => $v) { ?>
                                    <?php if($v['status']==2) { ?>
                                    <option value="<?= $v['id'] ?>"><?= $v['nome'] ?></option>
                                    <?php } ?>
                                <?php } ?>
                            <?php } ?>
                        <?php } ?>

                    </select>
                    <?= btn(gly("save"), "success", "sm", "Definir área") ?>

                </form>
            </div>
            <div class="col-md-4"></div>
        </div>
    </div>
    <div class="panel panel-primary">
        <div class="panel-heading">
            <div class="panel-title text-center">Áreas Definidas</div>
        </div>
        <div class="panel-body">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <table class="table table-bordered table-hover table-striped">
                    <thead>
                        <tr>
                            <th>Área</th>
                            <th>Excluir</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (isset($definidas)) { ?>
                            <?php if (count($definidas) > 0) { ?>
                                <?php foreach ($definidas as $k => $v) { ?>
                                    <tr>
                                        <td class=""><?= $areas[$v['area']]['nome'] ?></td>
                                        <td class="text-center">
                                            <form action="<?= site_url('area/desvincular') ?>" method="post">
                                                <input type="hidden" name="area" value="<?= $v['area'] ?>" />
                                                <button type="submit" class="btn btn-danger btn-sm"><?= gly("trash", "Excluir") ?></button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php } ?>
                            <?php } ?>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <div class="col-md-3"></div>
        </div>
    </div>
</div>