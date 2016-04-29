<script src="/eco2/js/main.js"></script>
<div class="container">
    <div class="panel  panel-primary search-nark-form">
        <div class="panel-heading">
            <h3 class="panel-title">Поиск</h3>
        </div>
        <div class="panel-body">
            <form class="form-inline" id="SearchForm">
                <div class="form-group">
                    <label for="exampleInputName2">Фамилия</label>
                    <input onkeyup="eco.Search()" type="text" name="filterSurname" class="form-control"  placeholder="Например Иванов">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail2">Номер заявления</label>
                    <input onkeyup="eco.Search()" type="text" name="filterNumberZ" class="form-control"  placeholder="">
                </div>

                <div class="form-group">
                    <label for="exampleInputEmail2">Номер направления</label>
                    <input onkeyup="eco.Search()" type="text" name="filterNumberN" class="form-control"  placeholder="">
                </div>

            </form>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-body">
            <a class="btn btn-info" href="search/add" role="button">Добавить</a>
            <a class="btn btn-success" href="Reports/mz/listEkoExcel.php" role="button">В Excel</a>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div id="loader" style="display: none;">
        <img src="images/loader.GIF" style="display: block;width: 100px;margin: 0 auto;">
    </div>
            <h3>Лист ожидания ЭКО</h3>
        <div class="panel-body results-area "></div>

</div>



