<?php
/**
 * Created by PhpStorm.
 * User: cod_llo
 * Date: 11.03.16
 * Time: 17:11
 */
/*Модель для поиска по базе*/

class Nrk_model extends CI_Model
{
    /*Спсок таблиц*/
    public $pit_mz_list_directions_lpu;
    public $pit_mz_list_directions;

    public $pit_mz_lpucode;
    public $pit_mz_type_funding_list;
    public $pit_mz_type_obr;


    public function __construct()
    {
        $this->load->database();
        date_default_timezone_set('Europe/London');
        $this->load->helper('url');

        $this->pit_mz_lpucode='[AKTPAK].[dbo].[pit_mz_lpucode]';
        $this->pit_mz_type_obr='[AKTPAK].[dbo].[pit_mz_type_obr]';
        $this->pit_mz_type_funding_list='[AKTPAK].[dbo].[pit_mz_type_funding_list]';

        $this->pit_mz_list_directions='AKTPAK..pit_mz_list_directions_elex';
        $this->pit_mz_list_directions_lpu='AKTPAK..pit_mz_list_directions_lpu_elex';

    }



    public function search($arg)
    {
        foreach ($arg as $key=>$value )
        {
            $arg['$key'] = $this->security->xss_clean($value);
        }


        $sql="SELECT ";
        if (!(ISSET ($arg['filterNumberN']) and $arg['filterNumberN']<>"")){
            $sql.="  top 200 ";
        }

        $sql.="
             list.counter [counter]
             ,list.surname + ' ' + list.name+ ' ' + list.secname [fio]
             ,list.surname[surname]
             ,list.name[name]
             ,list.secname[secname]
             ,list.[date][date]
             ,list.adress [adress]
             ,list.phone [phone]
             ,list.birth[birth]
             ,ISNULL(dir.[counter],0) [dirCounter]
             ,dir.lpucode [lpucode]
             ,dir.[date] [dirDate]
             ,fidd.funding [funding]
             ,fidd.coutner [fcounter]
              ,(SELECT
MIN(counter) as min_counter_2015
FROM ".$this->pit_mz_list_directions_lpu." dir
WHERE
(dir.d_fin is null)
and
(YEAR(date) = '2015')) min_dir_counter_2015

,(SELECT
MIN(counter) as min_counter_2016
FROM ".$this->pit_mz_list_directions_lpu." dir
WHERE
(dir.d_fin is null)
and
(YEAR(date) = '2016')) min_dir_counter_2016

,(SELECT
MIN(counter) as min_counter_2017
FROM ".$this->pit_mz_list_directions_lpu." dir
WHERE
(dir.d_fin is null)
and
(YEAR(date) = '2016')) min_dir_counter_2017
            FROM
                 ".$this->pit_mz_list_directions." list
            LEFT JOIN ".$this->pit_mz_list_directions_lpu." dir on list.counter=dir.counterList
            LEFT JOIN ".$this->pit_mz_type_funding_list." fidd  on fidd.coutner=list.funding_counter
            WHERE list.d_fin is null
                  and dir.d_fin is null
                  and DATALENGTH(surname)>0
            ";
        if (ISSET ($arg['filterSurname']) and $arg['filterSurname']<>""){
            $filterSurname=$arg['filterSurname'];
            $filterSurname= mb_convert_encoding($filterSurname,'windows-1251', 'utf-8');

            $sql.="  and surname like'%".$filterSurname."%'";
        }

        if (ISSET ($arg['filterNumberN']) and $arg['filterNumberN']<>""){

            $filterNumberN=$arg['filterNumberN'];
            if ($filterNumberN<>0){
                $sql.=" and dir.[counter]>0 ";
            }
        }

        if (ISSET ($arg['filterNumberZ']) and $arg['filterNumberZ']<>""){

            $filterNumberZ=$arg['filterNumberZ']+0;
            if ($filterNumberZ<>0){
                $sql.=" and  list.counter=$filterNumberZ ";
            }
        }

        $sql.="ORDER BY list.date DESC, list.counter DESC";

        $query = $this->db->query($sql);

        return $query->result_array();

    }

    public function get_eco_lpu()
    {
        $sql="SELECT counter,LPUCODE,NAME
                            FROM ".$this->pit_mz_lpucode."
                            WHERE D_FIN is null
                            and LPUCODE in (10805,10095,4024,6030)";
        ;
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function get_funding()
    {
        $sql="SELECT coutner, funding FROM ".$this->pit_mz_type_funding_list;
        ;
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function get_type_obr()
    {
        $sql="SELECT [coutner],[obr] FROM ".$this->pit_mz_type_obr." where d_fin is null";
        ;
        $query = $this->db->query($sql);
        return $query->result_array();
    }


    /*Добавляет направление*/
    public function add($arg)
    {
        foreach ($arg as $key=>$value )
        {
            $arg['$key'] = $this->security->xss_clean($value);
        }

        $sql="INSERT INTO ".$this->pit_mz_list_directions."
(surname,
name,
secname,
adress,
phone,
[date],
[birth],
[protocol],
[comment],
[funding_counter] ,
[email] ,
dateBirth,
docMan,
polis,
snils,
mkb,
typeObr,
lpucode,do) values ( ";
        /*конвертируем дату*/

        $arg['date'] = date( 'd.m.Y', strtotime( $arg['date'] ) );

        $arg['dateBirth'] = date( 'd.m.Y', strtotime( $arg['dateBirth'] ) );


        $sql.="'".$arg['surname']
            ."'".",'".$arg['name']
            ."'".",'".$arg['secname']
            ."'".",'".$arg['adress']
            ."'".",'".$arg['phone']
            ."'".",'".$arg['date']
            ."'".",'".$arg['birth']
            ."'".",'".$arg['protocol']
            ."'".",'".$arg['comment']
            ."'".",'".$arg['fundingI']
            ."'".",'".$arg['email']
            ."'".",'".$arg['dateBirth']
            ."'".",'".$arg['docMan']
            ."'".",'".$arg['polis']
            ."'".",'".$arg['snils']
            ."'".",'".$arg['mkb']
            ."'".",'".$arg['obr']
            ."'" .",'".$arg['lpuZ']
            ."'" .",'".$arg['do1']."'" .")";


        $query = $this->db->query($sql);
    }

    public function update($arg)
    {
        $sql="UPDATE ".$this->pit_mz_list_directions;

        $sql.=" SET surname='".$arg['surname']."'".",name='".$arg['name']
            ."'".",secname='".$arg['secname']
            ."'".",adress='".$arg['adress']."'".",phone='".$arg['phone']
            ."'".",[date]='".$arg['date']."'".",[birth]='".$arg['birth']
            ."'". ",[protocol]='".$arg['protocol']
            ."'". ",[comment]='".$arg['comment']
            ."'". ",[funding_counter]='".$arg['fundingI']
            ."'". ",[email]='".$arg['email']."'". ",[dateBirth]='".$arg['dateBirth']
            ."'" . ",[docMan]='".$arg['docMan']."'" . ",[polis]='".$arg['polis']
            ."'" . ",[snils]='".$arg['snils']."'" . ",[mkb]='".$arg['mkb']
            ."'" . ",[typeObr]='".$arg['obr']."'". ",[lpucode]='".$arg['lpuZ']."'";
        $sql.=" where counter=".$arg['id'];
        //echo $sql;
        $query = $this->db->query($sql);
    }

    /*Выдает информацию по направлению*/
    public function get_dir($dir_id)
    {
        $sql="SELECT * FROM ".$this->pit_mz_list_directions." where counter=".$dir_id;
        $query = $this->db->query($sql);

        return $query->row(0);
    }



    public function dir_lpu_insert($arg)
    {
        foreach ($arg as $key=>$value )
        {
            $arg['$key'] = $this->security->xss_clean($value);
        }
        $arg['dateDir'] = date( 'd.m.Y', strtotime( $arg['dateDir'] ) );

        $sql=" INSERT INTO ".$this->pit_mz_list_directions_lpu." (lpucode,[date],counterList)
                        VALUES ('".$arg['lpu']."','".$arg['dateDir']."','".$arg['counterList']."')";
        $this->db->query($sql);
    }

    public function dir_lpu_update($arg)
    {
        foreach ($arg as $key=>$value )
        {
            $arg['$key'] = $this->security->xss_clean($value);
        }
        $arg['dateDir'] = date( 'd.m.Y', strtotime( $arg['dateDir'] ) );
        $sql="UPDATE ".$this->pit_mz_list_directions_lpu." SET lpucode='".$arg['lpu']."', [date]='".$arg['dateDir']."'
        WHERE  counterList=".$arg['counterList'];
        echo $sql;
        $this->db->query($sql);
    }

    public function get_to_lpu($dir_id)
    {
        $sql="SELECT * FROM ".$this->pit_mz_list_directions_lpu." WHERE  counterList=".$this->security->xss_clean($dir_id);
        $query = $this->db->query($sql);

        return $query->row(0);
    }



}