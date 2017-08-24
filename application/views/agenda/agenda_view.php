<div class="container">
    <div class="panel panel-default">
        <h3 class="h3 text-center">Definir Dias de Atendimento</h3>
        <hr>
        <div class="panel-body">
            <div class="col-md-3 panel panel-default">
                <h4 class="text-center">Selecione o ano e mês a definir</h4>
                <form action="<?= site_url('agenda')?>" method="post">
                <label class="">Selecione o ano</label>
                <select name="ano" class="form-control">
                    <option value="2017" <?php if(isset($ano)&&$ano==2017){echo "selected";}?>>2017</option>
                    <option value="2018" <?php if(isset($ano)&&$ano==2018){echo "selected";}?>>2018</option>
                    <option value="2019" <?php if(isset($ano)&&$ano==2019){echo "selected";}?>>2019</option>
                    <option value="2020" <?php if(isset($ano)&&$ano==2020){echo "selected";}?>>2020</option>
                    <option value="2021" <?php if(isset($ano)&&$ano==2021){echo "selected";}?>>2021</option>
                    <option value="2022" <?php if(isset($ano)&&$ano==2022){echo "selected";}?>>2022</option>
                    <option value="2023" <?php if(isset($ano)&&$ano==2023){echo "selected";}?>>2023</option>
                    <option value="2024" <?php if(isset($ano)&&$ano==2024){echo "selected";}?>>2024</option>
                    <option value="2025" <?php if(isset($ano)&&$ano==2025){echo "selected";}?>>2025</option>
                    <option value="2026" <?php if(isset($ano)&&$ano==2026){echo "selected";}?>>2026</option>
                    <option value="2027" <?php if(isset($ano)&&$ano==2027){echo "selected";}?>>2027</option>
                    <option value="2028" <?php if(isset($ano)&&$ano==2028){echo "selected";}?>>2028</option>
                </select>
                <label class="">Selecione o mês</label>
                <select name="mes" class="form-control">
                    <option value="1" <?php if(isset($mes)&&$mes==1){echo "selected";}?>>Janeiro</option>
                    <option value="2" <?php if(isset($mes)&&$mes==2){echo "selected";}?>>Fevereiro</option>
                    <option value="3" <?php if(isset($mes)&&$mes==3){echo "selected";}?>>Março</option>
                    <option value="4" <?php if(isset($mes)&&$mes==4){echo "selected";}?>>Abril</option>
                    <option value="5" <?php if(isset($mes)&&$mes==5){echo "selected";}?>>Maio</option>
                    <option value="6" <?php if(isset($mes)&&$mes==6){echo "selected";}?>>Junho</option>
                    <option value="7" <?php if(isset($mes)&&$mes==7){echo "selected";}?>>Julho</option>
                    <option value="8" <?php if(isset($mes)&&$mes==8){echo "selected";}?>>Agosto</option>
                    <option value="9" <?php if(isset($mes)&&$mes==9){echo "selected";}?>>Setembro</option>
                    <option value="10" <?php if(isset($mes)&&$mes==10){echo "selected";}?>>Outubro</option>
                    <option value="11" <?php if(isset($mes)&&$mes==11){echo "selected";}?>>Novembro</option>
                    <option value="12" <?php if(isset($mes)&&$mes==12){echo "selected";}?>>Dezembro</option>
                </select>
                <br>
                <div class="text-center">
                <?= btn("Carregar", "info", "sm", "Carregar")?>
                </div>
                </form>
            </div>
            <div class="col-md-1"></div>
            <div class="col-md-3 panel panel-default" style="font-size: 0.8em;">
                <?=$cal?>
            </div>
            <div class="col-md-1"></div>
            <div class="col-md-3">
                <?=$tds?>
            </div>
        </div>
    </div>
</div>