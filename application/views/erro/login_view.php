<div class="container">
    <div class="panel panel-info">
        <div class="panel-heading">
            <div class="panel-title">
                <h3 class="text-center">Login</h3>
            </div>
        </div>
        <div class="panel-body">
            <form action="<?= site_url('autenticacao/login')?>" method="post" class="form-inline">
                <div class="form-group-sm">
                    <label>E-mail</label>
                    <input type="text" name="login" class="form-control" />
                </div>
                <div class="form-group-sm">
                    <label>Senha</label>
                    <input type="text" name="senha" class="form-control" />
                </div>
                <div class="form-group-sm">
                    <br>
                    <button type="submit" class="btn btn-success">Entrar</button>
                </div>
            </form>
        </div>
    </div>
</div>
