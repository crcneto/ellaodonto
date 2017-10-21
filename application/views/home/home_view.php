<?php if (!$this->session->userdata('usuario')) { ?>
    <div class="jumbotron">
        <div class="container">
            <h1>Bem-vindo (a) ao sistema EllaOdonto!</h1>
            <p>Organização, transparência e confiabilidade. Atendendo do Administrador ao Cliente.</p>
            <p><a class="btn btn-primary btn-lg" href="#" role="button">Saiba mais</a></p>
        </div>
    </div>
<?php } else { ?>
    <div class="container">
        <br>
        <div class="col-md-2"></div>
        
        <?php
        if (isset($calendar)) {
            echo $calendar;
        }
        ?>
        <div class="col-md-2"></div>
    </div>
<?php } ?>
