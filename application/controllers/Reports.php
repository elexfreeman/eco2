<?php
date_default_timezone_set('Europe/London');
defined('BASEPATH') OR exit('No direct script access allowed');
require_once ("Classes/PHPExcel.php");
require_once ("Classes/PHPExcel/styleExcel.php");
class Reports extends CI_Controller
{

    /*переменная для вывода в view*/
    public $data;


    public function __construct()
    {

        parent::__construct();
        /*Загружаем  библиотеку сессий*/
        $this->load->library('session');
        /*Загружаем модели*/
        $this->load->model('auth_model');
        $this->load->model('nrk_model');
        /*Закгружаем хелперы*/
        $this->load->helper('form');
        $this->load->helper('url');

        /*Логоут урл и имя пользователя выводятся из модели*/
        $this->data['logout_url'] = $this->auth_model->GetLogoutUrl();
        $this->data['user_name'] = $this->auth_model->GetloginUser();
    }


    /*Поиск аяксовый*/
    public function index()
    {

        header('Location: ' . base_url('auth'));
        exit;

    }

    public function zayavdirection($counter)
    {
        /*Если залогинен*/
        if ($this->auth_model->IsLogin()) {
            $name_report = "Заявление ЭКО";

            $this->data['eco_lpu'] = $this->nrk_model->get_eco_lpu();
            $this->data['funding'] = $this->nrk_model->get_funding();
            $this->data['type_obr'] = $this->nrk_model->get_type_obr();
            $myrrow = $this->nrk_model->get_dir($counter);

            $yearBirth = $myrrow->birth;
          /*  $myrrow->surname] = iconv('windows-1251', 'utf-8', $myrrow[surname]);
            $myrrow->name] = iconv('windows-1251', 'utf-8', $myrrow[name]);
            $myrrow->secname] = iconv('windows-1251', 'utf-8', $myrrow[secname]);
            $myrrow->phone] = iconv('windows-1251', 'utf-8', $myrrow[phone]);
            $myrrow->adress] = iconv('windows-1251', 'utf-8', $myrrow[adress]);
            $myrrow->data] = iconv('windows-1251', 'utf-8', $myrrow[data]);*/


          /* header('Content-Type: text/html; charset=utf-8');
            header("Content-type: application/vnd.ms-excel");
            header("Content-disposition: attachment; filename=$name_report" . "_(" . $myrrow->surname . ")" . ".xls");
*/
            $objPHPExcel = new PHPExcel();//обычный обьект


            $objPHPExcel->setActiveSheetIndex(0); //устанавливаем активный лист
            $active_sheet = $objPHPExcel->getActiveSheet();//получаем к  активному листу доступ
            $active_sheet->getPageSetup()
                ->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);//Устанавливаем ориентацию страницы ORIENTATION_PORTRAIT - книжная, ORIENTATION_LANDSCAPE - альбомная
            $active_sheet->getPageSetup()
                ->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4); //Устанавливаем размер бумаги PAPERSIZE_A4 - это формат А4
            $active_sheet->SetTitle("Лист №1");//Даем название активному листу. Для русских названий нужно сохранять фаил в кодировки utf-8(без BOM)
            $active_sheet->getDefaultStyle()->GetFont()->setName('Times New Roman');//Задаем шрифт по умолчанию тип и размер
            $active_sheet->getDefaultStyle()->GetFont()->setSize('10');
            $active_sheet->getColumnDimension('L')->setWidth(5);

            $active_sheet->mergeCells('A1:G1'); // Обьеденяем ячейки
            $active_sheet->mergeCells('H1:L1');
            $active_sheet->getRowDimension('1')->setRowHeight(80);//Изменяем высоту первой линии на 40
            $active_sheet->setCellValue('H1', " Руководителю управления \n организации медицинской помощи \n женщинам и детям \n министерства здравоохранения \n Самарской области \n В.А.Пономареву");
            $active_sheet->mergeCells('A2:L2');
            $active_sheet->getRowDimension('2')->setRowHeight(1);
//зона для данных человека из базы -женщина
            $active_sheet->mergeCells('G3:L3');
            $active_sheet->getRowDimension('3')->setRowHeight(30);
            $active_sheet->setCellValue('G3', "ФИО\n".$myrrow->surname." ".$myrrow->name." ".$myrrow->secname."   ".$yearBirth." г.р.");
            $active_sheet->mergeCells('A4:B6');
            $active_sheet->mergeCells('G4:L6');
            $active_sheet->setCellValue('G4', "зарегистрированной по адресу\n".$myrrow->adress);
            $active_sheet->mergeCells('A7:B7');
            $active_sheet->mergeCells('G7:L7');
            $active_sheet->getRowDimension('7')->setRowHeight(25);
            $active_sheet->setCellValue('G7', "телефон контакта\n".$myrrow->phone);

//зона для данных человека заполнения рукой - муж
            $active_sheet->mergeCells('G8:L8');
            $active_sheet->getRowDimension('8')->setRowHeight(30);
            $active_sheet->setCellValue('G8', "ФИО\n                                   ");
            $active_sheet->mergeCells('A9:B11');
            $active_sheet->mergeCells('G9:L11');
            $active_sheet->setCellValue('G9', "зарегистрированной по адресу");
            $active_sheet->mergeCells('A12:B12');
            $active_sheet->mergeCells('G12:L12');
            $active_sheet->getRowDimension('12')->setRowHeight(25);
            $active_sheet->setCellValue('G12', "телефон контакта");


//$active_sheet ->getRowDimension('13')->setRowHeight(1);
            $active_sheet->mergeCells('A13:L13');
            $active_sheet->mergeCells('A14:L15');
            $active_sheet->getRowDimension('15')->setRowHeight(1);
            $active_sheet->setCellValue('A14', "Заявление № ".$myrrow->counter);
            $active_sheet->mergeCells('A16:L16');
            $active_sheet->getRowDimension('16')->setRowHeight(130);
            $active_sheet->setCellValue('A16', "
      Просим рассмотреть наши документы для решения вопроса о направлении на лечение с применением вспомогательных репродуктивных технологий за счет средств областного (федерального) бюджета.
      С Регламентом оказания супружеским парам специализированной медицинской помощи с применением вспомогательных репродуктивных технологий за счет средств областного бюджета ознакомлены.
      На передачу персональных данных согласны.
      О возможности отказа проинформированы.
      Уведомление получено.");

//$active_sheet ->mergeCells('A17:L17');
            $myrrow->date = date('d.m.Y', strtotime($myrrow->date));
            $active_sheet->mergeCells('A17:G18');
            $active_sheet->setCellValue('A17', "Дата    ".$myrrow->date);
            $active_sheet->mergeCells('H17:L18');
            $active_sheet->setCellValue('H17', "Подпись");
            $active_sheet->mergeCells('A19:L19');
            $active_sheet->setCellValue('A19', "------------------------------------------------------------------------------------------------------------------------------------------------------------------------");

            $active_sheet->getRowDimension('21')->setRowHeight(1);
            $active_sheet->getRowDimension('22')->setRowHeight(1);
//Дальше для вставки картинки
            $iDrowing = new PHPExcel_Worksheet_Drawing();
            $iDrowing->setPath('mzLogo.png');
            $iDrowing->setCoordinates('C20');
            $iDrowing->setResizeProportional(false);
            $iDrowing->setWidth(30);
            $iDrowing->setHeight(30);
//$active_sheet = $objPHPExcel ->getActiveSheet();
            $iDrowing->setWorksheet($objPHPExcel->getActiveSheet());
            $active_sheet->mergeCells('A23:E23');
            $active_sheet->getRowDimension('23')->setRowHeight(120);
            $active_sheet->setCellValue('A23', "
МИНИСТЕРСТВО ЗДРАВООХРАНЕНИЯ
САМАРСКОЙ ОБЛАСТИ
(Минздрав Самарской области)
443020, г. Самара, ул. Ленинская, 73
тел. (846) 332-93-09, факс (846) 332-93-30
ИНН 6315800971, КПП 631701001
________________№________________
на №_____________от  ______________
");
            $active_sheet->mergeCells('A24:L25');
            $active_sheet->setCellValue('A24', "УВЕДОМЛЕНИЕ\nО ПРЕДОСТАВЛЕНИИ ГОСУДАРСТВЕННОЙ УСЛУГИ");

            $active_sheet->mergeCells('A26:D26');
            $active_sheet->setCellValue('A26', "ФИО");
            $active_sheet->mergeCells('E26:F26');
            $active_sheet->setCellValue('E26', "Год\nрождения");
            $active_sheet->mergeCells('G26:L26');
            $active_sheet->setCellValue('G26', "Адрес");

            $active_sheet->mergeCells('A27:D28');
            $active_sheet->setCellValue('A27', $myrrow->surname.' '.$myrrow->name.' '.$myrrow->secname);
            $active_sheet->mergeCells('E27:F28');
            $active_sheet->setCellValue('E27', "$yearBirth");
            $active_sheet->mergeCells('G27:L28');
            $active_sheet->setCellValue('G27', $myrrow->adress);

            $active_sheet->mergeCells('A29:L31');
            $active_sheet->setCellValue('A29', "
Внесена в реестр пациентов, ожидающих получение государственной медицинской услуги за № ".$myrrow->counter.".
О получении направления Вы будете уведомлены дополнительно.");
            $active_sheet->getRowDimension('32')->setRowHeight(1);
            $active_sheet->mergeCells('A33:E34');
            $active_sheet->setCellValue('A33', "Дата    ".$myrrow->date);
            $active_sheet->mergeCells('F33:L34');
            $active_sheet->setCellValue('F33', "Руководитель управления _______________");

            //заголовок
            $align_center = array(
                'alignment' => array(
                    'horizontal' => PHPExcel_STYLE_ALIGNMENT::HORIZONTAL_CENTER,
                    'vertical' => PHPExcel_STYLE_ALIGNMENT::VERTICAL_CENTER
                )
            );
            $align_right = array(
                'alignment' => array(
                    'horizontal' => PHPExcel_STYLE_ALIGNMENT::HORIZONTAL_RIGHT,
                    'vertical' => PHPExcel_STYLE_ALIGNMENT::VERTICAL_CENTER
                )
            );

            $peopleVD = array(
                'alignment' => array(
                    'horizontal' => PHPExcel_STYLE_ALIGNMENT::HORIZONTAL_LEFT,
                    'vertical' => PHPExcel_STYLE_ALIGNMENT::VERTICAL_TOP
                ),
                'borders' => array(
                    'bottom' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
                )
            );
            $peopleVP = array(
                'alignment' => array(
                    'horizontal' => PHPExcel_STYLE_ALIGNMENT::HORIZONTAL_LEFT,
                    'vertical' => PHPExcel_STYLE_ALIGNMENT::VERTICAL_CENTER
                ),
                'borders' => array(
                    'bottom' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THICK
                    )
                )
            );
            //заголовки
            $style_head_table = array(
                'font' => array(
                    'bold' => true,
                    //'italic' =>true,
                    'name' => 'Times New Roman',
                    'size' => 10
                ),

                'alignment' => array(
                    'horizontal' => PHPExcel_STYLE_ALIGNMENT::HORIZONTAL_CENTER,
                    'vertical' => PHPExcel_STYLE_ALIGNMENT::VERTICAL_CENTER
                ),
                'fill' => array(
                    'type' => PHPExcel_STYLE_FILL::FILL_SOLID, // заливка
                    'color' => array(
                        'rgb' => 'DFDEDE'
                    )
                ),
                'borders' => array(

                    'bottom' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN

                    )
                )
            );
            $style_text_table = array(

                'alignment' => array(
                    'horizontal' => PHPExcel_STYLE_ALIGNMENT::HORIZONTAL_LEFT,
                    'vertical' => PHPExcel_STYLE_ALIGNMENT::VERTICAL_CENTER
                )
            );

// общая рамка
            $style_wrap = array(
                'borders' => array(
                    'outline' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THICK //если поставить NONE рамки не будет
                    ),

                    'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN,
                        'color' => array(
                            'rgb' => '696969'
                        )
                    )
                )

            );


            //заголовки
            $style_head = array (
                'font'=> array(
                    'bold'=>true,
                    //'italic' =>true,
                    'name'=>'Times New Roman',
                    'size'=> 10
                ),

                'alignment'=> array (
                    'horizontal' => PHPExcel_STYLE_ALIGNMENT::HORIZONTAL_CENTER,
                    'vertical' => PHPExcel_STYLE_ALIGNMENT::VERTICAL_CENTER
                ),
                'fill' => array (
                    'type' => PHPExcel_STYLE_FILL::FILL_SOLID, // заливка
                    'color' => array (
                        'rgb' => 'DFDEDE'
                    )
                ),
                'borders' => array (

                    'bottom' => array (
                        'style'=>PHPExcel_Style_Border::BORDER_THICK

                    )
                )
            );



            $active_sheet->getStyle('A1:L1')->applyFromArray($align_center);
            $active_sheet->getStyle('C3:F12')->applyFromArray($align_right);
            $active_sheet->getStyle('G3:L3')->applyFromArray($peopleVD);
            $active_sheet->getStyle('G4:L6')->applyFromArray($peopleVD);
            $active_sheet->getStyle('G7:L7')->applyFromArray($peopleVP);
            $active_sheet->getStyle('G8:L8')->applyFromArray($peopleVD);
            $active_sheet->getStyle('G9:L11')->applyFromArray($peopleVD);
            $active_sheet->getStyle('G12:L12')->applyFromArray($peopleVD);
            $active_sheet->getStyle('A14')->applyFromArray($align_center);
            $active_sheet->getStyle('A22:L25')->applyFromArray($align_center);
            $active_sheet->getStyle('A26:L26')->applyFromArray($style_head);
            $active_sheet->getStyle('A27:L28')->applyFromArray($style_text_table);
            $active_sheet->getStyle('A26:L28')->applyFromArray($style_wrap);


            /*

            $active_sheet ->getStyle('A1:J'.($i-1)) ->applyFromArray($style_wrap);
            $active_sheet ->getStyle('A1:J1') ->applyFromArray($style_header);
            $active_sheet ->getStyle('A2:J3') ->applyFromArray($style_headlines);
            $active_sheet ->getStyle('F2:J3') ->applyFromArray($style_headlines_val);
            $active_sheet ->getStyle('A4:J4') ->applyFromArray($style_head);
            $active_sheet ->getStyle('A5:J'.$i) ->applyFromArray($style_text);
            */
            $active_sheet->getStyle('A1:L52')->getAlignment()->setWrapText(true);//устанавливает в нужно ячейке перенос по словам

            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, Excel5);//генерирует документ
            $objWriter->save('php://output');//сохраняет и выплевывает в браузер
            exit;


        } else {
            header('Location: ' . base_url('auth'));
            exit;
        }
    }


}
