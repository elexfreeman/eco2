<div class="container-fluid login-bg"></div>
<div class="miac-logo"></div>
<div class="container">

    <?php echo form_open("auth/login");?>
    <div class="panel  panel-primary login-form">
        <div class="panel-heading">
            <h3 class="panel-title">Экстракорпоральное оплодотворение</h3>
        </div>

        <div class="panel-body">
            <div class="form-group">
                <label for="exampleInputEmail1">Логин</label>
                <input type="text" class="form-control" id="login" name="username" placeholder="Ваш логин" required>
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Пароль</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Ваш пароль" required>
            </div>

            <button type="submit" class="btn btn-success">Войти</button>
        </div>
    </div>
    </form>
</div>
