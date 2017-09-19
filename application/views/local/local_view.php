<div class="container">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <div class="panel-title text-center">Cadastro de Local de Atendimento &nbsp; <a href="<?= site_url('local')?>"><?= gly("plus-sign", "Limpar formulário/Cadastrar Novo", "top")?></a></div>
        </div>
        <div class="panel-body">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <form action="<?= site_url('local/insert')?>" method="post">
                    <label>Nome do local</label>
                    <input type="text" name="nome" class="form-control" value="<?php if(isset($lo['nome'])){echo $lo['nome'];}?>" required=""/>
                    <label>Endereço</label>
                    <input type="text" name="endereco" class="form-control" value="<?php if(isset($lo['endereco'])){echo $lo['endereco'];}?>" required=""/>
                    <label>Telefone</label>
                    <input type="text" name="telefone" class="form-control" value="<?php if(isset($lo['telefone'])){echo $lo['telefone'];}?>"/>
                    <label>Celular</label>
                    <input type="text" name="celular" class="form-control" value="<?php if(isset($lo['celular'])){echo $lo['celular'];}?>"/>
                    <br>
                    <div class="text-center">
                    <?php if(isset($lo['id'])) { ?>
                        <?= btn(gly("edit")." Editar", "warning", 'lg', "Alterar")?>
                    <?php } else { ?>
                        <?= btn(gly("ok")." Cadastrar", "success", 'lg', "Cadastrar")?>
                    <?php } ?>
                    </div>
                </form>
            </div>
            <div class="col-md-3"></div>
        </div>
    </div>
    <div class="panel panel-primary">
        <div class="panel-heading">
            <div class="panel-title text-center">Locais de Atendimento Cadastrados</div>
        </div>
        <div class="panel-body">
            <table class="table table-striped table-hover table-bordered">
                <thead>
                    <tr>
                        <th class="text-center">Nome</th>
                        <th class="text-center">Endereço</th>
                        <th class="text-center">Telefone Fixo</th>
                        <th class="text-center">Celular</th>
                        <th class="text-center">Opções</th>
                    </tr>
                </thead>
                <tbody> 
                <?php if(isset($locais)){ ?>
                    <?php if(count($locais)>0){ ?>
                        <?php foreach($locais as $k=>$v){ ?>

                        <?php } ?>
                    <?php } ?>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>