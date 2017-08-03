<div class="container-fluid">
    <div class="panel panel-default">
        <h3 class="h3 text-center">Agenda</h3>
        <hr>
        <div class="panel-body">
            <a href="#">Novo compromisso</a>



            <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bs-example-modal-lg">Large modal</button>

            <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
                <div class="modal-dialog modal-lg panel panel-primary" role="document">
                    <div class="modal-content">
                        <div class="panel panel-default">
                            <h3>Titulo</h3>
                            <div class="panel-body">
                                Teste 
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $('.modal_full').on('shown.bs.modal', function () {
        $('#myInput').focus();
    });


    $('.modal_compact').on('shown.bs.modal', function () {
        $('#myInput').focus();
    });
</script>