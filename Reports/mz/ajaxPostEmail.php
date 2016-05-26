<?php
header('Content-Type: text/html; charset=utf-8');
require_once ("../Classes/phpMainClasses.php");


 require_once ("../Classes/PHPExcel.php");

    require_once ("../Classes/PHPExcel/styleExcel.php");
$host="192.168.1.222\sharepoint";

$user="sa";
$pwd="1qazxsw2";
$db=mssql_connect($host,$user,$pwd);


session_start();
function stripslashes_array($array) {
  return is_array($array) ?
    array_map('stripslashes_array', $array) : stripslashes($array);
}

if (get_magic_quotes_gpc()) {
  $_GET = stripslashes_array($_GET);
  $_POST = stripslashes_array($_POST);
  $_COOKIE = stripslashes_array($_COOKIE);
}
$fileName=uniqid();
$q = $_POST[q];// определяем какое действие делать
$counter=$_POST[counter];
$typeEmail=$_POST['typeEmail'];
if ($_POST[date]) {
    //$date=$_POST[date];
      $date=date('d.m.Y', strtotime($_POST[date]));
}
else
    $date='-';

if ($_POST[dataEmailZNap1]) {
    //$date=$_POST[date];
      $dataEmailZNap1=date('d.m.Y', strtotime($_POST[dataEmailZNap1]));
}
else
    $dataEmailZNap1='-';

if ($_POST[dataEmailZNap2]) {
    //$date=$_POST[date];
      $dataEmailZNap2=date('d.m.Y', strtotime($_POST[dataEmailZNap2]));
}
else
    $dataEmailZNap2='-';

$query="SELECT * FROM AKTPAK..pit_mz_list_directions where counter=$counter";
$result = mssql_query($query,$db);
$myrrow  = mssql_fetch_array ($result);
//проверяем не пустаяли почта
if ( strlen($myrrow[email])<5 ){
    print 2;
    exit();
}
else
{
  $mailTo= trim($myrrow[email]);

}

if (1==$typeEmail)
{
    $nameAttach='Уведомление о внесении в лист ожидания';
    doFileZayav($fileName,$counter,$date,$db);// делаем фаил во вложении
}
else
{
    if (2==$typeEmail){
        $nameAttach='Уведомление о получении';
        doFileNaprav($fileName,$counter,$date,$dataEmailZNap1,$dataEmailZNap2,$db);// делаем фаил во вложении
    }
    else {
        print "Ошибка определения типа уведомления";
        exit();
    }
}

$file = $_SERVER['DOCUMENT_ROOT']."/eco2/Reports/tempFiles/".$fileName.".xls"; // файл
//$mailTo = "tsybin07@mail.ru"; // кому
$subject = "Министерство здравохранения Самарской области";
$message = $_POST[textEmail]; // текст письма
//echo $mailTo;
$r = sendMailAttachment($mailTo, $from, $subject, $message, $file, $nameAttach); // отправка письма c вложением
//echo ($r)?'1':'0';
unlink($_SERVER['DOCUMENT_ROOT']."/eco2/Reports/tempFiles/".$fileName.".xls");

header('Location: /eco2');
exit;

function sendMailAttachment($mailTo, $from, $subject, $message, $file = false ,$nameAttach){
    $separator = "---"; // разделитель в письме
    // Заголовки для письма
    $headers = "MIME-Version: 1.0\r\n";
    $headers .= "From: $from\nReply-To: $from\n"; // задаем от кого письмо
    $headers .= "Content-Type: multipart/mixed; boundary=\"$separator\""; // в заголовке указываем разделитель
    // если письмо с вложением
    if($file){
        $bodyMail = "--$separator\n"; // начало тела письма, выводим разделитель
        $bodyMail .= "Content-type: text/plain; charset=\"utf-8\""; // кодировка письма
        $bodyMail .= "Content-Transfer-Encoding: quoted-printable"; // задаем конвертацию письма
        $bodyMail .= "Content-Disposition: attachment; filename==?utf-8?B?".base64_encode(basename($file))."?=\n\n"; // задаем название файла
        $bodyMail .= $message."\n"; // добавляем текст письма
        $bodyMail .= "--$separator\n";
        $fileRead = fopen($file, "r"); // открываем файл
        $contentFile = fread($fileRead, filesize($file)); // считываем его до конца
        fclose($fileRead); // закрываем файл
        $bodyMail .= "Content-Type: application/octet-stream; name==?utf-8?B?".base64_encode(basename($file))."?=\n"; 
        $bodyMail .= "Content-Transfer-Encoding: base64\n"; // кодировка файла
        $bodyMail .= "Content-Disposition: attachment; filename==?utf-8?B?".base64_encode(basename("$nameAttach.xls"))."?=\n\n";
        $bodyMail .= chunk_split(base64_encode($contentFile))."\n"; // кодируем и прикрепляем файл
        $bodyMail .= "--".$separator ."--\n";
    // письмо без вложения
    }else{
        $bodyMail = $message;
    }
    $result = mail($mailTo, $subject, $bodyMail, $headers); // отправка письма
    return $result;
}

function doFileZayav($fileName,$counter,$date,$db){
   
    
    $name_report = "Уведомление о внесении в лист ожидания";
    $query="SELECT * FROM AKTPAK..pit_mz_list_directions where counter=$counter";
    $result = mssql_query($query,$db);
    $myrrow  = mssql_fetch_array ($result );
    
    $yearBirth= date('Y', strtotime($myrrow[birth]));
    $yearBirth= $myrrow[birth];
    $myrrow[surname]=iconv('windows-1251', 'utf-8',$myrrow[surname]);
    $myrrow[name]=iconv('windows-1251', 'utf-8',$myrrow[name]);
    $myrrow[secname]=iconv('windows-1251', 'utf-8',$myrrow[secname]);
    $myrrow[phone]=iconv('windows-1251', 'utf-8',$myrrow[phone]);
    $myrrow[adress]=iconv('windows-1251', 'utf-8',$myrrow[adress]);
    $myrrow[data]=iconv('windows-1251', 'utf-8',$myrrow[data]);
    $myrrow[email]=iconv('windows-1251', 'utf-8',$myrrow[email]);
    
    
    header('Content-Type: text/html; charset=utf-8');
    //header("Content-type: application/vnd.ms-excel");  
    //header("Content-disposition: attachment; filename=$name_report"."_(".$myrrow[surname].")".".xls"); 
    
    $objPHPExcel = new PHPExcel();//обычный обьект
    
    
    
    $objPHPExcel -> setActiveSheetIndex(0); //устанавливаем активный лист
    $active_sheet = $objPHPExcel ->getActiveSheet();//получаем к  активному листу доступ
    $active_sheet ->getPageSetup()
                  ->setOrientation (PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);//Устанавливаем ориентацию страницы ORIENTATION_PORTRAIT - книжная, ORIENTATION_LANDSCAPE - альбомная
    $active_sheet ->getPageSetup()
                  ->setPaperSize (PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4); //Устанавливаем размер бумаги PAPERSIZE_A4 - это формат А4
    $active_sheet ->SetTitle("Лист №1");//Даем название активному листу. Для русских названий нужно сохранять фаил в кодировки utf-8(без BOM)
    $active_sheet -> getDefaultStyle() -> GetFont() ->setName('Times New Roman');//Задаем шрифт по умолчанию тип и размер
    $active_sheet -> getDefaultStyle() -> GetFont() ->setSize('10');
    $active_sheet ->getColumnDimension('L') -> setWidth(5);
    
    $active_sheet ->mergeCells('A2:G2'); // Обьеденяем ячейки
	$active_sheet ->mergeCells('H2:L2');
	$active_sheet ->getRowDimension('2')->setRowHeight(120);//Изменяем высоту первой линии на 40
	//$active_sheet ->setCellValue('H2',"ПРИЛОЖЕНИЕ 3\n к Алгоритму \n оказания специализированной \n медицинской помощи \n с применением вспомогательных \n репродуктивных технологий \n за счет средств обязательного \n медицинского страхования");
	//$active_sheet ->mergeCells('A2:L2');
	//$active_sheet ->getRowDimension('2')->setRowHeight(1);
   
    $active_sheet->getStyle('A1:L52')->getAlignment()->setWrapText(true);//устанавливает в нужно ячейке перенос по словам
    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel,Excel5);//генерирует документ
   
    
 //   $active_sheet ->getRowDimension('21')->setRowHeight(1);
 //	$active_sheet ->getRowDimension('22')->setRowHeight(1);
	//Дальше для вставки картинки
	$iDrowing = new PHPExcel_Worksheet_Drawing(); 
	$iDrowing->setPath('mzLogo.png'); 
	$iDrowing->setCoordinates('D1'); 
	$iDrowing->setResizeProportional(false); 
	$iDrowing->setWidth(30); 
	$iDrowing->setHeight(30); 
	//$active_sheet = $objPHPExcel ->getActiveSheet();
	$iDrowing->setWorksheet($objPHPExcel->getActiveSheet()); 
	//$active_sheet ->mergeCells('A23:E23');
	//$active_sheet ->getRowDimension('23')->setRowHeight(120);
	$active_sheet ->setCellValue('A2',"
	МИНИСТЕРСТВО ЗДРАВООХРАНЕНИЯ
	САМАРСКОЙ ОБЛАСТИ
	(Минздрав Самарской области)
	443020, г. Самара, ул. Ленинская, 73
	тел. (846) 332-93-09, факс (846) 332-93-30
	ИНН 6315800971, КПП 631701001
	________________№________________
	на №_____________от  ______________
	");    
   
    $active_sheet ->mergeCells('H4:L4');   
    $active_sheet ->setCellValue('H4',"Электронный адрес заявителя:");
    $active_sheet ->mergeCells('H5:L5');   
    $active_sheet ->setCellValue('H5',"$myrrow[email]");
    
    
    $active_sheet ->mergeCells('A7:L7');  
    $active_sheet ->getRowDimension('7')->setRowHeight(30);
    $active_sheet ->setCellValue('A7',"УВЕДОМЛЕНИЕ \n о внесении в лист ожидания"); 
    
    
	$active_sheet ->mergeCells('A8:D8');
	$active_sheet ->setCellValue('A8',"ФИО");
	$active_sheet ->mergeCells('E8:F8');
	$active_sheet ->setCellValue('E8',"Год\nрождения");
	$active_sheet ->mergeCells('G8:L8');
	$active_sheet ->setCellValue('G8',"Адрес");

	$active_sheet ->mergeCells('A9:D10');
	$active_sheet ->setCellValue('A9',"$myrrow[surname] $myrrow[name] $myrrow[secname]");
	$active_sheet ->mergeCells('E9:F10');
	$active_sheet ->setCellValue('E9',"$yearBirth");
	$active_sheet ->mergeCells('G9:L10');
	$active_sheet ->setCellValue('G9',"$myrrow[adress]");
   
    $active_sheet ->mergeCells('A12:L14');
	$active_sheet ->setCellValue('A12',"Внесена в лист ожидания для получения направления на лечение с применением вспомогательных репродуктивных технологий в рамках базовой программы ОМС.");
   
    $active_sheet ->mergeCells('A16:L18');
	//$active_sheet ->setCellValue('A16',"Лист ожидания размещен на официальном сайте министерства здравоохранения Самарской области (www.minzdrav.samregion.ru).");
 
    //$active_sheet ->mergeCells('A20:L22');
	$active_sheet ->setCellValue('A16',"Ваш ЭКО – номер $counter.\nУзнать свой номер в очереди вы можете перейдя на сайт министерства здравоохранения Самарской области (http://minzdrav.samregion.ru) щелкнув по банеру 'Эко будущим родителям'.");
	
    $active_sheet ->mergeCells('A20:L20');
	$active_sheet ->setCellValue('A20',"О необходимости получения направления Вы будете уведомлены дополнительно.");
   
    $active_sheet ->mergeCells('A25:C25');
	$active_sheet ->setCellValue('A25',"Дата $date");
	
    //$active_sheet ->mergeCells('F28:I28');
	//$active_sheet ->setCellValue('F28',"Секретарь Комиссии: ");
	
	$select_userlist  ="
		SELECT 
			surname+' '+ SUBSTRING(name,0,2)+'.' + SUBSTRING(secname,0,2)+'.' [fio]
			, post [post]	
		FROM
			AKTPAK..pit_userlist 
		where
		[user]='$_SERVER[PHP_AUTH_USER]' and pass='$_SERVER[PHP_AUTH_PW]' and d_fin is null";
		
	$result_userlist =  mssql_query($select_userlist,$db); 
	$myrrow_userlist = mssql_fetch_array ($result_userlist );
	$myrrow_userlist[fio]=iconv('windows-1251', 'utf-8',$myrrow_userlist[fio]);
	
	//$active_sheet ->mergeCells('F29:I29');
	//$active_sheet ->setCellValue('F29',$myrrow_userlist[fio]);
	$active_sheet ->mergeCells('F25:J25');
	$active_sheet ->setCellValue('F25',"Секретарь Комиссии: $myrrow_userlist[fio]");
	
	
	
	 //заголовок   
	$headB= array (
			'alignment'=> array (
				'horizontal' => PHPExcel_STYLE_ALIGNMENT::HORIZONTAL_RIGHT,
				'vertical' => PHPExcel_STYLE_ALIGNMENT::VERTICAL_CENTER  
			)
	);
	$head= array (
		'font'=> array(
			   'bold'=>true, 
			   
			),
		  'alignment'=> array (
				'horizontal' => PHPExcel_STYLE_ALIGNMENT::HORIZONTAL_CENTER,
				'vertical' => PHPExcel_STYLE_ALIGNMENT::VERTICAL_CENTER  
			)
	);
	$text= array (
		   'alignment'=> array (
				'horizontal' => PHPExcel_STYLE_ALIGNMENT::HORIZONTAL_CENTER,
				'vertical' => PHPExcel_STYLE_ALIGNMENT::VERTICAL_CENTER  
			)
	);

	$border = array (
			'borders'=>array(
				'bottom' => array (
					'style'=>PHPExcel_Style_Border::BORDER_THIN      //если поставить NONE рамки не будет
				 ),
				 
			  /*   'allborders'=>array(
					'style'=>PHPExcel_Style_Border::BORDER_THIN,
					'color'=> array(
					 'rgb'=>'696969'
					 )
				 )*/
			 )
			
	);
	
	$style_wrap = array (
        'borders'=>array(
          /*  'outline' => array (
                'style'=>PHPExcel_Style_Border::BORDER_THICK //если поставить NONE рамки не будет
             ),*/
             
             'allborders'=>array(
                'style'=>PHPExcel_Style_Border::BORDER_THIN,
                'color'=> array(
                 'rgb'=>'696969'
                 )
             )
         )
        
	);	
	
	$active_sheet ->getStyle('H2:H5') ->applyFromArray($headB);
	//$active_sheet ->getStyle('A2') ->applyFromArray($head);
	$active_sheet ->getStyle('A2') ->applyFromArray($text);
	$active_sheet ->getStyle('A7:L10') ->applyFromArray($text);
	$active_sheet ->getStyle('H5:L5') ->applyFromArray($border);
	//$active_sheet ->getStyle('F28:I28') ->applyFromArray($border);
	//$active_sheet ->getStyle('F19:I19') ->applyFromArray($border);
	$active_sheet ->getStyle('A8:L10') ->applyFromArray($style_wrap);

	/*$active_sheet ->getStyle('A5:B5') ->applyFromArray($border);
	$active_sheet ->getStyle('D5:E5') ->applyFromArray($border);
	$active_sheet ->getStyle('G5:H5') ->applyFromArray($border);

	$active_sheet ->getStyle('A7:H7') ->applyFromArray($border);

	$active_sheet ->getStyle('A9:C9') ->applyFromArray($border);
	$active_sheet ->getStyle('E9:H9') ->applyFromArray($border);

	$active_sheet ->getStyle('A11:H11') ->applyFromArray($border);
	$active_sheet ->getStyle('A13:H13') ->applyFromArray($border);
	$active_sheet ->getStyle('A15:H15') ->applyFromArray($border);
	$active_sheet ->getStyle('A17:H17') ->applyFromArray($border);
	$active_sheet ->getStyle('A19:H19') ->applyFromArray($border);
	$active_sheet ->getStyle('A21:H21') ->applyFromArray($border);
	$active_sheet ->getStyle('A33:B33') ->applyFromArray($border);
	$active_sheet ->getStyle('D33:H33') ->applyFromArray($border);*/
   
    $objWriter->save($_SERVER['DOCUMENT_ROOT']."/eco2/Reports/tempFiles/".$fileName.".xls");
    //$objWriter ->save ('php://output');//сохраняет и выплевывает в браузер
}

function doFileNaprav($fileName,$counter,$date,$dataEmailZNap1,$dataEmailZNap2,$db){
   
    $name_report = "Уведомление о получении";
    $query="SELECT * FROM AKTPAK..pit_mz_list_directions where counter=$counter";
    $result = mssql_query($query,$db);
    $myrrow  = mssql_fetch_array ($result );
    
    $yearBirth= date('Y', strtotime($myrrow[birth]));
    $yearBirth= $myrrow[birth];
    $myrrow[surname]=iconv('windows-1251', 'utf-8',$myrrow[surname]);
    $myrrow[name]=iconv('windows-1251', 'utf-8',$myrrow[name]);
    $myrrow[secname]=iconv('windows-1251', 'utf-8',$myrrow[secname]);
    $myrrow[phone]=iconv('windows-1251', 'utf-8',$myrrow[phone]);
    $myrrow[adress]=iconv('windows-1251', 'utf-8',$myrrow[adress]);
    $myrrow[data]=iconv('windows-1251', 'utf-8',$myrrow[data]);
    $myrrow[email]=iconv('windows-1251', 'utf-8',$myrrow[email]);
    
    
    header('Content-Type: text/html; charset=utf-8');
    //header("Content-type: application/vnd.ms-excel");  
    //header("Content-disposition: attachment; filename=$name_report"."_(".$myrrow[surname].")".".xls"); 
    
    $objPHPExcel = new PHPExcel();//обычный обьект
    
    
    
    $objPHPExcel -> setActiveSheetIndex(0); //устанавливаем активный лист
    $active_sheet = $objPHPExcel ->getActiveSheet();//получаем к  активному листу доступ
    $active_sheet ->getPageSetup()
                  ->setOrientation (PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);//Устанавливаем ориентацию страницы ORIENTATION_PORTRAIT - книжная, ORIENTATION_LANDSCAPE - альбомная
    $active_sheet ->getPageSetup()
                  ->setPaperSize (PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4); //Устанавливаем размер бумаги PAPERSIZE_A4 - это формат А4
    $active_sheet ->SetTitle("Лист №1");//Даем название активному листу. Для русских названий нужно сохранять фаил в кодировки utf-8(без BOM)
    $active_sheet -> getDefaultStyle() -> GetFont() ->setName('Times New Roman');//Задаем шрифт по умолчанию тип и размер
    $active_sheet -> getDefaultStyle() -> GetFont() ->setSize('10');
    $active_sheet ->getColumnDimension('L') -> setWidth(5);
    
    $active_sheet ->mergeCells('A2:G2'); // Обьеденяем ячейки
	$active_sheet ->mergeCells('H2:L2');
	$active_sheet ->getRowDimension('2')->setRowHeight(120);//Изменяем высоту первой линии на 40
	//$active_sheet ->setCellValue('H2',"ПРИЛОЖЕНИЕ 4\nк Алгоритму\nоказания специализированной медицинской помощи с  применением вспомогательных репродуктивных технологий за счет средств обязательного медицинского страхования");
	//$active_sheet ->mergeCells('A2:L2');
	//$active_sheet ->getRowDimension('2')->setRowHeight(1);
   
    $active_sheet->getStyle('A1:L52')->getAlignment()->setWrapText(true);//устанавливает в нужно ячейке перенос по словам
    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel,Excel5);//генерирует документ
   
    
 //   $active_sheet ->getRowDimension('21')->setRowHeight(1);
 //	$active_sheet ->getRowDimension('22')->setRowHeight(1);
	//Дальше для вставки картинки
	$iDrowing = new PHPExcel_Worksheet_Drawing(); 
	$iDrowing->setPath('mzLogo.png'); 
	$iDrowing->setCoordinates('D1'); 
	$iDrowing->setResizeProportional(false); 
	$iDrowing->setWidth(30); 
	$iDrowing->setHeight(30); 
	//$active_sheet = $objPHPExcel ->getActiveSheet();
	$iDrowing->setWorksheet($objPHPExcel->getActiveSheet()); 
	//$active_sheet ->mergeCells('A23:E23');
	//$active_sheet ->getRowDimension('23')->setRowHeight(120);
	$active_sheet ->setCellValue('A2',"
	МИНИСТЕРСТВО ЗДРАВООХРАНЕНИЯ
	САМАРСКОЙ ОБЛАСТИ
	(Минздрав Самарской области)
	443020, г. Самара, ул. Ленинская, 73
	тел. (846) 332-93-09, факс (846) 332-93-30
	ИНН 6315800971, КПП 631701001
	________________№________________
	на №_____________от  ______________
	");    
   
    $active_sheet ->mergeCells('H4:L4');   
    $active_sheet ->setCellValue('H4',"Электронный адрес заявителя:");
    $active_sheet ->mergeCells('H5:L5');   
    $active_sheet ->setCellValue('H5',"$myrrow[email]");
    
    
    $active_sheet ->mergeCells('A7:L7');  
    $active_sheet ->getRowDimension('7')->setRowHeight(30);
    $active_sheet ->setCellValue('A7',"УВЕДОМЛЕНИЕ \n о внесении в лист ожидания"); 
    
    
	$active_sheet ->mergeCells('A8:D8');
	$active_sheet ->setCellValue('A8',"ФИО");
	$active_sheet ->mergeCells('E8:F8');
	$active_sheet ->setCellValue('E8',"Год\nрождения");
	$active_sheet ->mergeCells('G8:L8');
	$active_sheet ->setCellValue('G8',"Адрес");

	$active_sheet ->mergeCells('A9:D10');
	$active_sheet ->setCellValue('A9',"$myrrow[surname] $myrrow[name] $myrrow[secname]");
	$active_sheet ->mergeCells('E9:F10');
	$active_sheet ->setCellValue('E9',"$yearBirth");
	$active_sheet ->mergeCells('G9:L10');
	$active_sheet ->setCellValue('G9',"$myrrow[adress]");
   
    $active_sheet ->mergeCells('A12:L16');
	$active_sheet ->setCellValue('A12',"Вы можете получить направление на лечение с применением вспомогательных репродуктивных технологий в рамках базовой программы ОМС 	в срок с $dataEmailZNap1 по $dataEmailZNap2 по адресу министерства здравоохранения Самарской области: г. Самара, ул. Ленинская, 73, каб.309.");
   
  /*  $active_sheet ->mergeCells('A16:L18');
	$active_sheet ->setCellValue('A16',"Лист ожидания размещен на официальном сайте министерства здравоохранения Самарской области (www.minzdrav.samregion.ru)");
 
    $active_sheet ->mergeCells('A20:L22');
	$active_sheet ->setCellValue('A20',"Ваш ЭКО – номер $counter");
	
    $active_sheet ->mergeCells('A24:L26');
	$active_sheet ->setCellValue('A24',"О необходимости получения направления Вы будете уведомлены дополнительно.");*/
   
    $active_sheet ->mergeCells('A19:C19');
	$active_sheet ->setCellValue('A19',"Дата $date");
	
    //$active_sheet ->mergeCells('F28:I28');
	//$active_sheet ->setCellValue('F28',"Секретарь Комиссии: ");
	
	$select_userlist  ="
		SELECT 
			surname+' '+ SUBSTRING(name,0,2)+'.' + SUBSTRING(secname,0,2)+'.' [fio]
			, post [post]	
		FROM
			AKTPAK..pit_userlist 
		where
		[user]='$_SERVER[PHP_AUTH_USER]' and pass='$_SERVER[PHP_AUTH_PW]' and d_fin is null";
		
	$result_userlist =  mssql_query($select_userlist,$db); 
	$myrrow_userlist = mssql_fetch_array ($result_userlist );
	$myrrow_userlist[fio]=iconv('windows-1251', 'utf-8',$myrrow_userlist[fio]);
	
	//$active_sheet ->mergeCells('F29:I29');
	//$active_sheet ->setCellValue('F29',$myrrow_userlist[fio]);
	$active_sheet ->mergeCells('F19:J19');
	$active_sheet ->setCellValue('F19',"Секретарь Комиссии: $myrrow_userlist[fio]");
	
	
	
	 //заголовок   
	$headB= array (
			'alignment'=> array (
				'horizontal' => PHPExcel_STYLE_ALIGNMENT::HORIZONTAL_RIGHT,
				'vertical' => PHPExcel_STYLE_ALIGNMENT::VERTICAL_CENTER  
			)
	);
	$head= array (
		'font'=> array(
			   'bold'=>true, 
			   
			),
		  'alignment'=> array (
				'horizontal' => PHPExcel_STYLE_ALIGNMENT::HORIZONTAL_CENTER,
				'vertical' => PHPExcel_STYLE_ALIGNMENT::VERTICAL_CENTER  
			)
	);
	$text= array (
		   'alignment'=> array (
				'horizontal' => PHPExcel_STYLE_ALIGNMENT::HORIZONTAL_CENTER,
				'vertical' => PHPExcel_STYLE_ALIGNMENT::VERTICAL_CENTER  
			)
	);

	$border = array (
			'borders'=>array(
				'bottom' => array (
					'style'=>PHPExcel_Style_Border::BORDER_THIN      //если поставить NONE рамки не будет
				 ),
				 
			  /*   'allborders'=>array(
					'style'=>PHPExcel_Style_Border::BORDER_THIN,
					'color'=> array(
					 'rgb'=>'696969'
					 )
				 )*/
			 )
			
	);
	
	$style_wrap = array (
        'borders'=>array(
          /*  'outline' => array (
                'style'=>PHPExcel_Style_Border::BORDER_THICK //если поставить NONE рамки не будет
             ),*/
             
             'allborders'=>array(
                'style'=>PHPExcel_Style_Border::BORDER_THIN,
                'color'=> array(
                 'rgb'=>'696969'
                 )
             )
         )
        
	);	
	
	$active_sheet ->getStyle('H2:H5') ->applyFromArray($headB);
	//$active_sheet ->getStyle('A2') ->applyFromArray($head);
	$active_sheet ->getStyle('A2') ->applyFromArray($text);
	$active_sheet ->getStyle('A7:L10') ->applyFromArray($text);
	$active_sheet ->getStyle('H5:L5') ->applyFromArray($border);
	//$active_sheet ->getStyle('F28:I28') ->applyFromArray($border);
	//$active_sheet ->getStyle('F19:I19') ->applyFromArray($border);
	$active_sheet ->getStyle('A8:L10') ->applyFromArray($style_wrap);

	/*$active_sheet ->getStyle('A5:B5') ->applyFromArray($border);
	$active_sheet ->getStyle('D5:E5') ->applyFromArray($border);
	$active_sheet ->getStyle('G5:H5') ->applyFromArray($border);

	$active_sheet ->getStyle('A7:H7') ->applyFromArray($border);

	$active_sheet ->getStyle('A9:C9') ->applyFromArray($border);
	$active_sheet ->getStyle('E9:H9') ->applyFromArray($border);

	$active_sheet ->getStyle('A11:H11') ->applyFromArray($border);
	$active_sheet ->getStyle('A13:H13') ->applyFromArray($border);
	$active_sheet ->getStyle('A15:H15') ->applyFromArray($border);
	$active_sheet ->getStyle('A17:H17') ->applyFromArray($border);
	$active_sheet ->getStyle('A19:H19') ->applyFromArray($border);
	$active_sheet ->getStyle('A21:H21') ->applyFromArray($border);
	$active_sheet ->getStyle('A33:B33') ->applyFromArray($border);
	$active_sheet ->getStyle('D33:H33') ->applyFromArray($border);*/
   
    $objWriter->save($_SERVER['DOCUMENT_ROOT']."/eco2/Reports/tempFiles/".$fileName.".xls");
    //$objWriter ->save ('php://output');//сохраняет и выплевывает в браузер
}

mssql_close();


?>
