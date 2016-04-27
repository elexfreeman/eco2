<?php if(count($res)>0){ ?>
<table class="table table-striped table-hover">
        <tr>
            <th>Номер</th>
            <th>Фамилия</th>
            <th>Имя</th>
            <th>Отчество</th>
            <th>Год рождения</th>
            <th>Дата заявления</th>
            <th>Адрес регистрации</th>
            <th>Телефон контакта</th>
            <th>Фин.</th>
            <th>Код ЛПУ</th>
            <th>№ Направ.</th>
            <th>Удаление</th>
            <th>Редактирование</th>
            <th>Заявление</th>
            <th style="width: 151px;">Направление</th>
            <th>Согласие</th>
            <th>Уведомление</th>
        </tr>
    <?php
    foreach($res as $row) {
        /*конвертируем в utf8*/
        foreach($row as $key=>$value)
        {
            $row['$key']= mb_convert_encoding($value,'windows-1251', 'utf-8');
        }
        $row['date'] = date('d.m.Y', strtotime($row['date']));
        $row['birth']=date('d.m.Y', strtotime($row['birth']));
        ?>
        <tr>
            <td><?php echo $row['counter'];  ?></td>
            <td><?php echo $row['surname'];  ?></td>
            <td><?php echo $row['name'];  ?></td>
            <td><?php echo $row['secname'];  ?></td>
            <td><?php echo $row['birth'];  ?></td>
            <td><?php echo $row['date'];  ?></td>
            <td><?php echo $row['adress'];  ?></td>
            <td><?php echo $row['phone'];  ?></td>
            <td><?php echo $row['funding'];  ?></td>
            <?php
            if (0 == $row['dirCounter']) {
                print "<td>&nbsp;-&nbsp;</td>";
                print "<td>&nbsp;-&nbsp;</td>";
            } else {
                print "<td>".$row['lpucode']."</td>";
            //Elex
            /*Тут переситываем оередь*/
            /*последняе в 2016 - 1703*/
            $phpdate = strtotime($row['dirDate']);
            $year = date('Y', $phpdate) + 0;

            $row['dirCounter'] = $row['dirCounter'] + 0;
            if ($year == 2016) {
                $row['dirCounter'] = ($row['dirCounter'] - $row['min_dir_counter_2016'] + 1) . "-2016";
            }

            print "<td>".$row['dirCounter']."</td>";
        }
            ?>
            <td>Удалить</td>
            <td><a href="<?php echo base_url('search/edit')."/".$row['counter'];

                ?>">Редактировать</a>
            <?php
            if (0 <> $row['dirCounter']) {
                print "<br />";
                print "&nbsp;<a class='bluea' id='" . $row['counter'] . "'>Редактировать(н)</a>&nbsp;";
            }
            ?>
            </td>
            <?php




            print "<td>&nbsp;<a class='bluea' href='Reports/mz/zayavDirection.php?counter=".$row['counter']."'>В еxcel</a>&nbsp;</td>";
        if (0 == $row['dirCounter'])
            print "<td>&nbsp;<a class='bluea' id='".$row['counter']."'>Направить в ЛПУ</a>&nbsp;</td>";
        else {
                if (1 == $row['fcounter'])
                    print "<td>&nbsp;<a class='bluea' href='Reports/mz/zayavDirectionDIrOms.php?counter=".$row['counter']."'>В еxcel</a></br>&nbsp;</td>";
            else
                print "<td>&nbsp;<a class='bluea' href='Reports/mz/zayavDirectionDir.php?counter=".$row['counter']."'>В еxcel</a></br>&nbsp;</td>";
            //print "<td>&nbsp;<a class='bluea' href='Reports/mz/zayavDirectionDir.php?counter=$row['counter']'>В еxcel</a></br>&nbsp;</td>";
        }
        print "<td>&nbsp;<a class='bluea' href='Reports/mz/zayavDirectionAgr.php?counter=".$row['counter']."'>В еxcel</a>&nbsp;</td>";
        print "<td>&nbsp;<a class='bluea' id='".$row['counter']."'>Отправить</a>&nbsp;</td>";
        //   print "<td>&nbsp;<a class='bluea' id='$row['counter']' onclick=femail('$row['counter']',2,'$row['surname']|$row['name']|$row['secname']');>Отправить</a>&nbsp;</td>";
        print"</tr>";
            ?>
        </tr>
        <?php



    }
    ?>

    </tbody>
</table>

<?php }else{ ?>
    <div class="alert alert-warning" role="alert">По данному запросу результаты отсутствуют.</div>
<?php }?>
