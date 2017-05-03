
<div class="container">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <div class="panel-title text-center">Alteração de senha</div>
        </div>
        <div class="panel-body">
            <form action="<?= site_url('usuario/changepass') ?>" method="post">
                <div class="col-md-3">
                    <label>Senha Anterior</label>
                    <input type="password" name="senha" class="form-control" />
                </div>
                <div class="col-md-3">
                    <label>Nova Senha</label>
                    <input type="password" name="senha2" class="form-control" />
                </div>
                <div class="col-md-3">
                    <label>Confirme a Nova Senha</label>
                    <input type="password" name="senha3" class="form-control" />
                </div>
                <div class="col-md-3">
                    <br>
                    <button type="submit" class="btn btn-success col-md-12">Alterar</button>
                </div>
            </form>
        </div>
    </div>
</div>


