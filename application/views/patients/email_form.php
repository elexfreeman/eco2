<div class="container">

    <ol class="breadcrumb">
        <li><a href="/eco2">На главную</a></li>

        <li class="active">Отправить уведомление</li>
    </ol>
    <div class="panel  panel-primary AddPanel">
        <div class="panel-heading">
            <h3 class="panel-title">Отправить уведомление</h3>
        </div>
        <div class="panel-body">
            <form id="form_email" name="form_email" method="post" action="/eco2/Reports/mz/ajaxPostEmail.php">
                <input type="hidden" name="action" value="email_send">
                <input type="hidden" name="counter" value="<?php echo $direction->counter; ?>">
                <div class="row">
                    <div class="col-sm-12">
                        <h4>Пациент:</h4>
                        <?php echo $direction->surname; ?> <span id="nameEmail"> <?php echo $direction->name; ?>  <?php echo $direction->secname; ?></span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <h4>Номер заявления:</h4>
                        <?php echo $direction->counter; ?>
                    </div>
                </div>
                <hr>
                <div class="row">

                    <div class="col-sm-12">
                        <h4>Уведомление о:</h4>
                        <div class="radio">
                            <label>
                                <input type="radio" name="typeEmail" value='1' onclick="changeTextEmail(this.value)" >
                                постановке в очередь
                            </label>
                        </div>

                        <div class="radio">
                            <label>
                                <input type="radio" name="typeEmail" value='2' onclick="changeTextEmail(this.value)" >
                                выдаче направления
                            </label>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="dataEmailZ">Дата</label>
                            <input type="date" class="form-control" name="dataEmailZ" id="dataEmailZ" autocomplete="off" value="<?print date('Y-m-d')?>" >
                        </div>
                    </div>
                </div>
                <div class="row" id="periodEmailNap">
                    <div class="col-sm-12"><h4>Период получения направления</h4></div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="dataEmailZNap1">С:</label>
                            <input type="date" class="form-control" name="dataEmailZNap1" id="dataEmailZNap1" autocomplete="off" >
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="dataEmailZNap2">По:</label>
                            <input type="date" class="form-control" name="dataEmailZNap2" id="dataEmailZNap2" autocomplete="off" >
                        </div>
                    </div>
                </div>




                <hr>
                <div class="form-group">
                    <label for="comment">Текст письма</label>
                    <textarea class="form-control" rows="3" name="textEmail" id="textEmail" required></textarea>
                </div>

                <button type="submit" class="btn btn-success">Отправить</button>
            </form>
        </div>
    </div>
</div>


<script>

    function changeTextEmail(type){
        var textEmail=document.getElementById('textEmail');
        textEmail.value='';
        var nameEmail=document.getElementById('nameEmail');
        var emailCounter=document.getElementById('emailCounter');
        textEmail.value='Добрый день '+nameEmail.innerHTML+' !\n';

        if (type==1){
            periodEmailNap.style.display='none';
            textEmail.value=textEmail.value+'\nВы зарегистрированы в программе эко.';
            //textEmail.value=textEmail.value+'\nНомер зарегистрированного заявления:'+emailCounter.innerHTML+'.';
            //textEmail.value=textEmail.value+'\nУзнать свой номер в очереди вы можете перейдя на сайт министерства здравоохранения Самарской области (http://minzdrav.samregion.ru) щелкнув по банеру "Эко будущим родителям".';

        }
        else {
            periodEmailNap.style.display='';
            textEmail.value=textEmail.value+'\nВы можете получить направление на эко.';
        }
        textEmail.value=textEmail.value+' Ознакомьтесь с информацией в во вложении.';
        textEmail.value=textEmail.value+'\n\nС уважением,\nСаморукова Наталья Викторовна';
    }
</script>