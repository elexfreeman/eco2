<div class="container">
    <ol class="breadcrumb">
        <li><a href="/eco2">�� �������</a></li>

        <li class="active">�������������</li>
    </ol>
    <div class="panel  panel-primary AddPanel">
        <div class="panel-heading">
            <h3 class="panel-title">�������������� �����������</h3>
        </div>
        <div class="panel-body">
            <form id="add" name="add" method="post">
                <input type="hidden" name="action" value="update">
                <input type="hidden" name="id" value="<?php echo $id; ?>">
                <div class="row">
                    <div class="col-sm-12">
                        <h4>���</h4>
                        <?php
                        foreach ($eco_lpu as $lpu)
                        {
                            ?>
                            <div class="radio">
                                <label>
                                    <input type="radio" name="lpuZ" <?php if($dir->lpucode==$lpu['counter']) echo "checked"; ?>  value="<?php echo $lpu['counter'] ?>" required>
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

                        <h4>��� ��������������</h4>
                        <?php
                        foreach ($funding as $f)
                        {
                            ?>
                            <div class="radio">
                                <label>
                                    <input type="radio"
                                        <?php if($dir->funding_counter==$f['coutner']) echo "checked"; ?>
                                           name="fundingI"  value="<?php echo $f['coutner'] ?>" required>
                                    <?php echo $f['funding'] ?>
                                </label>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                    <div class="col-sm-6">
                        <h4>��� ���������</h4>
                        <?php
                        foreach ($type_obr as $obr)
                        {
                            ?>
                            <div class="radio">
                                <label>
                                    <input type="radio" name="obr"
                                        <?php if($dir->typeObr==$obr['coutner']) echo "checked"; ?>
                                           value="<?php echo $obr['coutner'] ?>" required>
                                    <?php echo $obr['obr'] ?>
                                </label>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </div>
                <hr>
                <h4>��</h4>
                <div class="radio">
                    <label>
                        <input type="radio" name="do1"  value="1" required <?php if((int)$dir->do==1) echo "checked "; ?> >
                        ��
                    </label>
                </div>
                <div class="radio">
                    <label>
                        <input type="radio" name="do1"  value="0" required <?php if((int)$dir->do==0) echo "checked "; ?> >
                        ���
                    </label>
                </div>

                <hr>
                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="surname">�������</label>
                            <input type="text" class="form-control"
                                   name="surname" id="surname"
                                   autocomplete="off" required
                                   value="<?php echo $dir->surname; ?>">
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="name">���</label>
                            <input type="text"
                                   value="<?php echo $dir->name; ?>"
                                   class="form-control" name="name" id="name" autocomplete="off" required>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="secname">��������</label>
                            <input type="text" class="form-control"
                                   value="<?php echo $dir->secname; ?>"
                                   name="secname" id="secname" autocomplete="off" required>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="polis">�����</label>
                            <input type="text"
                                   value="<?php echo $dir->polis; ?>"
                                   class="form-control" name="polis" id="polis" autocomplete="off" required>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="snils">�����</label>
                            <input type="text"
                                   value="<?php echo $dir->snils; ?>"
                                   class="form-control" name="snils" id="snils" autocomplete="off" required>
                        </div>
                    </div>
                    <div class="col-sm-4">

                        <div class="form-group">
                            <label for="mkb">��� �������� �� ���</label>
                            <input type="text"
                                   value="<?php echo $dir->mkb; ?>"
                                   class="form-control" name="mkb" id="mkb" autocomplete="off" required>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="form-group">
                    <label for="adress">����� �����������</label>
                    <input type="text" class="form-control"
                           value="<?php echo $dir->adress; ?>"
                           name="adress" id="adress" autocomplete="off" required>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="phone">������� ��������</label>
                            <input type="text"
                                   value="<?php echo $dir->phone; ?>"
                                   class="form-control" name="phone" id="phone" autocomplete="off" required>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="email">email</label>
                            <input type="text"
                                   value="<?php echo $dir->email; ?>"
                                   class="form-control" name="email" id="email" autocomplete="off" required>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="birth">��� ��������</label>
                            <input type="number"
                                   value="<?php echo $dir->birth; ?>"
                                   class="form-control" name="birth" id="birth" autocomplete="off" required>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="date">���� ���������</label>
                            <input type="date"
                                   value="<?php echo $dir->date; ?>"
                                   class="form-control" name="date" id="date" autocomplete="off" value="<?print date('Y-m-d')?>" required>
                        </div>
                    </div>
                    <div class="col-sm-4">

                        <div class="form-group">
                            <label for="dateBirth">���� ��������</label>
                            <input type="date"
                                   value="<?php echo $dir->dateBirth; ?>"
                                   class="form-control" name="dateBirth" id="dateBirth" autocomplete="off" required>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="form-group">
                    <label for="docMan">��������, �������������� ��������</label>
                    <input type="text"
                           value="<?php echo $dir->docMan; ?>"
                           class="form-control" name="docMan" id="docMan" autocomplete="off" required>
                </div>
                <hr>
                <div class="form-group">
                    <label for="protocol">��������</label>
                    <textarea class="form-control" rows="3" name="protocol" id="protocol" required><?php echo $dir->protocol; ?></textarea>
                </div>

                <hr>
                <div class="form-group">
                    <label for="comment">����������</label>
                    <textarea class="form-control" rows="3" name="comment" id="comment" required><?php echo $dir->comment; ?></textarea>
                </div>

                <button type="submit" class="btn btn-success">��������</button>
            </form>
        </div>
    </div>
</div>

