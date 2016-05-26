<div class="container">
    <ol class="breadcrumb">
        <li><a href="/eco2">На главную</a></li>

        <li class="active">Добавить</li>
    </ol>
    <div class="panel  panel-primary AddPanel">
        <div class="panel-heading">
            <h3 class="panel-title">Добавить</h3>
        </div>
        <div class="panel-body">
            <form id="add" name="add" method="post">
                <input type="hidden" name="action" value="add">
                <div class="row">
                    <div class="col-sm-12">
                        <h4>ЛПУ</h4>
                        <?php
                        foreach ($eco_lpu as $lpu)
                        {
                            ?>
                            <div class="radio">
                                <label>
                                    <input type="radio" name="lpuZ"  value="<?php echo $lpu['counter'] ?>" >
                                    <?php echo $lpu['NAME'] ?>
                                </label>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </div>
<hr>
                <div class="row">
                    <div class="col-sm-6">

                        <h4>Тип финансирования</h4>
                        <?php
                        foreach ($funding as $f)
                        {
                            ?>
                            <div class="radio">
                                <label>
                                    <input type="radio" name="fundingI"  value="<?php echo $f['coutner'] ?>" >
                                    <?php echo $f['funding'] ?>
                                </label>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                    <div class="col-sm-6">
                        <h4>Тип обращения</h4>
                        <?php
                        foreach ($type_obr as $obr)
                        {
                            ?>
                            <div class="radio">
                                <label>
                                    <input type="radio" name="obr"  value="<?php echo $obr['coutner'] ?>" >
                                    <?php echo $obr['obr'] ?>
                                </label>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </div>
                <hr>
                <h4>ДО</h4>
                <div class="radio">
                    <label>
                        <input type="radio" name="do1"  value="1" >
                        Да
                    </label>
                </div>
                <div class="radio">
                    <label>
                        <input type="radio" name="do1"  value="0"  checked>
                        Нет
                    </label>
                </div>

                <hr>
                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="surname">Фамилия</label>
                            <input type="text" class="form-control" name="surname" id="surname" autocomplete="off" >
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="name">Имя</label>
                            <input type="text" class="form-control" name="name" id="name" autocomplete="off" >
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="secname">Отчество</label>
                            <input type="text" class="form-control" name="secname" id="secname" autocomplete="off" >
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="polis">Полис</label>
                            <input type="text" class="form-control" name="polis" id="polis" autocomplete="off" >
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="snils">Снилс</label>
                            <input type="text" class="form-control" name="snils" id="snils" autocomplete="off" >
                        </div>
                    </div>
                    <div class="col-sm-4">

                        <div class="form-group">
                            <label for="mkb">Код диагноза по МКБ</label>
                            <input type="text" class="form-control" name="mkb" id="mkb" autocomplete="off" >
                        </div>
                    </div>
                </div>
                <hr>
                <div class="form-group">
                    <label for="adress">Адрес регистрации</label>
                    <input type="text" class="form-control" name="adress" id="adress" autocomplete="off" >
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="phone">Телефон Контакта</label>
                            <input type="text" class="form-control" name="phone" id="phone" autocomplete="off" >
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="email">email</label>
                            <input type="text" class="form-control" name="email" id="email" autocomplete="off" >
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="birth">Год рождения</label>
                            <input type="number" class="form-control" name="birth" id="birth" autocomplete="off" >
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="date">Дата заявление</label>
                            <input type="date" class="form-control" name="date" id="date" autocomplete="off" value="<?print date('Y-m-d')?>" >
                        </div>
                    </div>
                    <div class="col-sm-4">

                        <div class="form-group">
                            <label for="dateBirth">Дата рождения</label>
                            <input type="date" class="form-control" name="dateBirth" id="dateBirth" autocomplete="off" >
                        </div>
                    </div>
                </div>
                <hr>
                <div class="form-group">
                    <label for="docMan">Документ, удостоверяющий личность</label>
                    <input type="text" class="form-control" name="docMan" id="docMan" autocomplete="off" >
                </div>
                <hr>
                <div class="form-group">
                    <label for="protocol">Протокол</label>
                    <textarea class="form-control" rows="3" name="protocol" id="protocol" ></textarea>
                </div>

                <hr>
                <div class="form-group">
                    <label for="comment">Примечание</label>
                    <textarea class="form-control" rows="3" name="comment" id="comment" ></textarea>
                </div>

                <button type="submit" class="btn btn-success">Добавить</button>
            </form>
        </div>
    </div>
</div>

