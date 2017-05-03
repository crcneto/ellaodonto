<?php if (isset($_SESSION['usuario'])) { ?>
    <?php if($_SESSION['usuario']['acesso']>5) { ?>
        <div class="row">
            <div class="col-md-4"></div>
            <div class="col-md-4"></div>
            <div class="col-md-4"></div>
        </div>
    <?php } else { ?>
        <div class="row">
            <div class="col-md-4"></div>
            <div class="col-md-4">
                <h3 class="alert-danger">Desculpe, você não possui acesso a esta página.</h3>
            </div>
            <div class="col-md-4"></div>
        </div>
    <?php } ?>
<?php } else { ?>
    <div class="row">
        <div class="col-md-4"></div>
        <div class="col-md-4">
            <h3 class="alert-danger">Desculpe, é necessário ter sido autenticado para ter acesso a esta página.</h3>
        </div>
        <div class="col-md-4"></div>
    </div>

<?php } ?>