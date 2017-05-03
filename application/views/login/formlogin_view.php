<div class="row">
<div class="col-md-4"></div>
<div class="container col-md-4">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <div class="panel-title text-center text-capitalize">Entrar no sistema</div>
        </div>
        <div class="panel-body">
            
                <form action="<?= site_url('autenticacao/login')?>" method="post">
                    <div class="form-group">
                        <label>E-mail</label>
                        <input type="text" name="login" class="form-control" />
                    </div>
                    <div class="form-group">
                        <label>Senha</label>
                        <input type="password" name="senha" class="form-control" />
                    </div>
                    <button type="submit" class="btn btn-success">Entrar</button>
                </form>
            
        </div>
    </div>
</div>
<div class="col-md-4"></div>
</div>