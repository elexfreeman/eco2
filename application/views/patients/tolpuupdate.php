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
                <input type="hidden" name="action" value="tolpuedit">
                <input type="hidden" name="counterList" value="<?php echo $dir->counter; ?>">
                <p>ФИО: <strong id="fioDir"><?php echo $dir->surname; ?> <?php echo $dir->name; ?> <?php echo $dir->secname; ?></strong></p>
                <p>Номер заявления: <strong id="counterMan"><?php echo $dir->counter; ?></strong></p>
                <hr>
                <div class="form-group">
                    <label for="surname">Дата:</label>
                    <input type="date" class="form-control"
                           id="dateDir" name="dateDir"
                           autocomplete="off" required
                           value="<? echo $tolpu->date;?>">
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <h4>ЛПУ</h4>
                        <?php
                        foreach ($eco_lpu as $lpu)
                        {
                            ?>
                            <div class="radio">
                                <label>
                                    <input type="radio" name="lpu"
                                           <?php if($tolpu->lpucode==$lpu['counter']) echo " checked "; ?>
                                           value="<?php echo $lpu['counter'] ?>" required>
                                    <?php echo $lpu['NAME'] ?>
                                </label>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </div>


                <button type="submit" class="btn btn-success">Выписать</button>
            </form>
        </div>
    </div>
</div>

