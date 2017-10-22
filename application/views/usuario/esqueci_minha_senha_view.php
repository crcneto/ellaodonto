<div class="container">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <div class="panel-title text-center">Redefinir Minha Senha </div>
        </div>
        <div class="panel-body">
            <div class="col-md-4"></div>
            <div class="col-md-4">
                <h4 class="text-center">Preencha seus dados para que possamos redefinir sua senha</h4>
                <form action="<?= site_url('usuario/redefinir_senha')?>" method="post">
                    
                    <div class="">
                        <label>E-mail</label>
                        <input type="text" name="email" class="form-control" />
                    </div>
                    <div class="">
                        <label>Sua data de nascimento</label>
                        <input type="text" name="dn" class="form-control" placeholder="dd/mm/aaaa" />
                    </div>
                    <br>
                    <div class="text-center">
                        <button type="submit" class="btn btn-success">Redefinir minha senha</button>
                    </div>
                </form>
            </div>
            <div class="col-md-4"></div>
        </div>
    </div>
    
</div>