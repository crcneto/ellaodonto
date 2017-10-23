<?php if (!$this->session->userdata('usuario')) { ?>
    <div class="jumbotron">
        <div class="container">
            <h1>Bem-vindo (a) ao sistema EllaOdonto!</h1>
            <p>Organização, transparência e confiabilidade.</p>
            <p><a class="btn btn-primary btn-lg" href="#" role="button">Saiba mais</a></p>
        </div>
    </div>
<?php } else { ?>
    <?php if (isset($profissional) && $profissional > 0) { ?>
        <div class="container">
            <br>
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active"><a href="#agenda" aria-controls="agenda" role="tab" data-toggle="tab">Agenda</a></li>
                    <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Profile</a></li>
                    <li role="presentation"><a href="#messages" aria-controls="messages" role="tab" data-toggle="tab">Messages</a></li>
                    <li role="presentation"><a href="#settings" aria-controls="settings" role="tab" data-toggle="tab">Settings</a></li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="agenda">
                        <?php
                        if (isset($calendar)) {
                            echo $calendar;
                        }
                        ?>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="profile">profile</div>
                    <!--div role="tabpanel" class="tab-pane" id="messages">messages</div>
                    <div role="tabpanel" class="tab-pane" id="settings">settings</div-->
                </div>
            </div>

            <div class="col-md-2"></div>
        </div>






    <?php } else { ?>

        <div class="jumbotron">
            <div class="container">
                <h1>Bem-vindo (a) ao sistema EllaOdonto!</h1>
                <p>Organização, transparência e confiabilidade.</p>
                <p><a class="btn btn-primary btn-lg" href="#" role="button">Saiba mais</a></p>
            </div>
        </div>
    <?php } ?>
<?php } ?>
