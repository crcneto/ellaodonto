<?php $user = $this->session->userdata('usuario');?>
<!DOCTYPE html>
<html lang="br">
    <head>
        <title>.: Ella Odonto :.</title>
        <link rel="stylesheet" href="<?= site_url('public/css/bootstrap.min.css') ?>" />
        <link rel="stylesheet" href="<?= site_url('public/css/style.css') ?>" />
        <link rel="shortcut icon" href="<?= site_url('public/img/dente1.ico') ?>" />
        <link rel="stylesheet" href="<?= site_url('public/css/bootstrap-select.min.css')?>">
        <meta charset="utf-8">
        <script src="<?= site_url('public/js/jquery-3.1.1.min.js') ?>"></script>
        <script src="<?= site_url('public/js/bootstrap.js') ?>"></script>
        <script src="<?= site_url('public/js/jquery.maskMoney.min.js') ?>"></script>
        <script src="<?= site_url('public/js/bootstrap-datepicker.js') ?>"></script>
        <script src="<?= site_url('public/js/bootstrap-select.min.js')?>"></script>
        <script>
            $(document).ready(function () {
                $(".datepicker").datepicker({format: 'dd/mm/yyyy'});
                $(".money").maskMoney({'thousands': ''});
                $('.selectpicker').selectpicker();
            });
        </script>
    </head>
    <body role="document">
        <nav class="navbar navbar-inverse navbar-fixed-top">
            <div class="container-fluid">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">

                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="<?= site_url() ?>"><span><img src="<?= site_url() ?>public/img/dente1.ico" height="20" width="20"/></span>&nbsp;<span>EllaOdonto</span></a>
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">
                        <li class="active"><a href="<?= base_url() ?>">Inicial <span class="sr-only"></span></a></li>
                        <!--li><a href="#">Link</a></li-->
                        <?php if ($this->session->userdata('usuario') != null) { ?>
                            <?php if (true) { ?>
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Consulta <span class="caret"></span></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="<?= base_url()?>">Nova Consulta</a></li>

                                    </ul>
                                </li>
                            <?php } ?>
                            <?php if (true) { ?>
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Cadastros <span class="caret"></span></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="<?= site_url('usuario') ?>">Usuário</a></li>
                                        <li><a href="<?= site_url('paciente') ?>">Paciente</a></li>
                                        <li><a href="<?= site_url('profissional') ?>">Profissional</a></li>
                                        <li><a href="<?= site_url('area') ?>">Área</a></li>
                                        <li><a href="<?= site_url('especialidade') ?>">Especialidade</a></li>
                                        <li role="separator" class="divider"></li>
                                        <li class="dropdown-header text-center">Configurações</li>
                                        <li role="separator" class="divider"></li>
                                        <li><a href="#">Config</a></li>
                                    </ul>
                                </li>
                            <?php } ?>
                        <?php } ?>
                    </ul>

                    <!--Se usuário não estiver autenticado, exibe formulário de login-->
                    <?php if(!$this->session->userdata('usuario')){ ?>
                    <div class="navbar-form navbar-right">
                        <!--div class="form-group">
                            <input type="text" name="login" class="form-control" size="8" placeholder="Usuário">
                        </div>
                        <div class="form-group">
                            <input type="password" name="senha" class="form-control" size="8" placeholder="Senha">
                        </div>
                        <button type="submit" class="btn btn-success">Entrar</button-->
                        <a href="<?= site_url('autenticacao') ?>" class="btn btn-success">Entrar</a>
                    </div>
                    <?php } ?>
                    <!-- Se usuário autenticado, exibe opções de usuário -->
                    <?php if ($this->session->userdata('usuario') != NULL) { ?>
                        <ul class="nav navbar-nav navbar-right">
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?= $this->session->userdata('nome') ?>&nbsp;&nbsp;<i class="glyphicon glyphicon-user"></i>&nbsp;<?=$user['nome']?> <span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <li><a href="#">Perfil</a></li>
                                    <li><a href="<?= site_url('usuario/alterarsenha') ?>">Alterar senha</a></li>
                                    <li><a href="#">Mensageiro</a></li>
                                    <li role="separator" class="divider"></li>
                                    <li><a href="<?= site_url('autenticacao/logout') ?>">Sair</a></li>
                                </ul>
                            </li>
                        </ul>
                    <?php } ?>
                </div><!-- /.navbar-collapse -->
            </div><!-- /.container-fluid -->
        </nav>
        <div class="row">
            <br>
            <br>
            <br>
        </div>
        <div class="container">
            <?php if ($this->session->userdata('erro_mensagem') != NULL) { ?>
                <div class="panel panel-danger">
                    <div class="panel-heading alert-danger">
                        <div class="panel-title alert-danger text-center">
                            <?php echo $this->session->userdata('erro_mensagem'); ?>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <?php if ($this->session->userdata('sucesso_mensagem') != NULL) { ?>
                <div class="panel panel-success">
                    <div class="panel-heading alert-success">
                        <div class="panel-title alert-success text-center">
                            <?php echo $this->session->userdata('sucesso_mensagem'); ?>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>