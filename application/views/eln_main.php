<script src="/eco2/js/main.js"></script>
<div class="container">
    <div class="panel  panel-primary search-nark-form">
        <div class="panel-heading">
            <h3 class="panel-title">�����</h3>
        </div>
        <div class="panel-body">
            <form class="form-inline" id="SearchForm">
                <div class="form-group">
                    <label for="exampleInputName2">�������</label>
                    <input onkeyup="eco.Search()" type="text" name="filterSurname" class="form-control"  placeholder="�������� ������">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail2">����� ���������</label>
                    <input onkeyup="eco.Search()" type="text" name="filterNumberZ" class="form-control"  placeholder="">
                </div>

                <div class="form-group">
                    <label for="exampleInputEmail2">����� �����������</label>
                    <input onkeyup="eco.Search()" type="text" name="filterNumberN" class="form-control"  placeholder="">
                </div>

            </form>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-body">
            <a class="btn btn-default" href="search/add" role="button">��������</a>
            <a class="btn btn-default" href="#" role="button">� Excel</a>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div id="loader" style="display: none;">
        <img src="images/loader.GIF" style="display: block;width: 100px;margin: 0 auto;">
    </div>
            <h3>���� �������� ���</h3>
        <div class="panel-body results-area "></div>

</div>


