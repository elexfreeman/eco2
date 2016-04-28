<div class="container">
    <ol class="breadcrumb">
        <li><a href="/eco2">На главную</a></li>

        <li class="active">Направить в ЛПУ</li>
    </ol>
    <div class="panel  panel-primary AddPanel">
        <div class="panel-heading">
            <h3 class="panel-title">Направить в ЛПУ</h3>
        </div>
        <div class="panel-body">
            <form id="tolpu" name="tolpu" method="post">
                <input type="hidden" name="action" value="tolpu">
                <p>ФИО: <strong id="fioDir"></strong></p>
                <p>Номер заявленя: <strong id="counterMan"></strong></p>
                <hr>
                <p><label>Дата<br /><input autocomplete="off" value="<?print date('Y-m-d')?>" type="date" id="dateDir" name="dateDir"/></label></p>
                <div class="row">
                    <div class="col-sm-12">
                        <h4>ЛПУ</h4>
                        <?php
                        foreach ($eco_lpu as $lpu)
                        {
                            ?>
                            <div class="radio">
                                <label>
                                    <input type="radio" name="lpu"  value="<?php echo $lpu['counter'] ?>" required>
                                    <?php echo $lpu['NAME'] ?>
                                </label>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </div>


                <button type="submit" class="btn btn-success">Добавить</button>
            </form>
        </div>
    </div>
</div>

