<?php
require '../db.php';
require '../../xtea.class.php';

// output excel file or word docs based on input parameter

$diet = @$_GET['diet'];
$prog = @$_GET['prog'];
$med  = @$_GET['med'];

$dbhandle = mysql_connect($hostname, $dbuser, $password); 
$selected = mysql_select_db("CTIDATABASE",$dbhandle);

$xtea = new XTEA($secret);

if($diet == 1){
  $tempfilename = '/tmp/diet.xls';
  $file = fopen($tempfilename,"w");
  
  $header = 0;

  // get ids
  $result = mysql_query("SELECT id FROM launchpad_user");
    
  // get file
  while( $row = mysql_fetch_array($result) ){
    $id = $row['id'];
    $filename = "/www/www.thecoaches.com/lib/launchpad_data/diet_form_for_$id.json";
    $json = file_get_contents($filename);
    $data = json_decode($json,true);

    //echo "$json\n";
    // if header not done, print header
    if($header == 0){
      $fieldArray = array( );
      foreach($data as $key => $value){
        $text = preg_replace('/-/',' ',$key);
        $fieldArray[] = ucfirst($text);
      }
      fputcsv($file,$fieldArray);
      $header = 1;
    }

    // print row
    $dataArray = array( );
    foreach($data as $key => $value){
      $dataArray[] = $value;
    }
      
    fputcsv($file,$dataArray);
  }
  // output file

  fclose($file);

  header("Content-Type: application/csv");
  header("Content-Disposition: attachment;Filename=SPAIN-diet.csv");
  header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
  header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past

  // send file to browser
  readfile($tempfilename);
  //unlink($tempfilename);
}
else if($prog > 0){
  $zip = new ZipArchive();
  $zipfilename =  "Spain-Program-".date('Y-m-d').".zip";

  if(file_exists("/tmp/$zipfilename")){
      unlink("/tmp/$zipfilename"); // remove it if it already exists
  }

  if ($zip->open("/tmp/$zipfilename", ZIPARCHIVE::CREATE) !== TRUE) {
    exit("cannot open <$zipfilename>\n");
  }

 // get ids
  $result = mysql_query("SELECT * FROM launchpad_user");
    
  // get file
  while( $row = mysql_fetch_array($result) ){
    $id            = $row['id'];
    $username      = $row['username'];
    $program_file_name = $row['program_file_name'];
    if($program_file_name != ''){
      $cipher        = file_get_contents($program_file_name);
      $json          = $xtea->Decrypt($cipher); //Decrypts the cipher text
      //print_r($json);
      $data = json_decode($json,true);
      $word_text     = word_output_program( $data );
      //echo $word_text; die();
      $name          = $data['q1_nombre'];
      if($name == ''){
        $name = $username;
      }
      $name = preg_replace('/ /','_',$name);
      $zip->addFromString("program_form_for_".$name."_$id.doc", $word_text); // create a TXT file with a message inside
    }
  }

  $zip->close();


  header("Content-Type: application/octet-stream");
  header("Content-Disposition: attachment;Filename=$zipfilename");
  header("Content-Length: ".filesize("/tmp/$zipfilename"));
  header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
  header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past
  readfile("/tmp/$zipfilename");
  exit();
}


else if($med > 0){
  $zip = new ZipArchive();
  $zipfilename =  "Spain-Medical-".date('Y-m-d').".zip";

  if(file_exists("/tmp/$zipfilename")){
      unlink("/tmp/$zipfilename"); // remove it if it already exists
  }

  if ($zip->open("/tmp/$zipfilename", ZIPARCHIVE::CREATE) !== TRUE) {
    exit("cannot open <$zipfilename>\n");
  }

 // get ids
  $result = mysql_query("SELECT * FROM launchpad_user");
    
  // get file
  while( $row = mysql_fetch_array($result) ){
    $id            = $row['id'];
    $username      = $row['username'];
    $med_file_name = $row['med_file_name'];
    if($med_file_name != ''){
      $cipher        = file_get_contents($med_file_name);
      $json          = $xtea->Decrypt($cipher); //Decrypts the cipher text
      //print_r($json);
      $data = json_decode($json,true);
      $word_text     = word_output_medical( $data );
      //echo $word_text; die();
      $name          = $data['q1_nombre'];
      if($name == ''){
        $name = $username;
      }
      $name = preg_replace('/ /','_',$name);
      $zip->addFromString("med_form_for_".$name."_$id.doc", $word_text); // create a TXT file with a message inside
    }
  }

  $zip->close();


  header("Content-Type: application/octet-stream");
  header("Content-Disposition: attachment;Filename=$zipfilename");
  header("Content-Length: ".filesize("/tmp/$zipfilename"));
  header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
  header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past
  readfile("/tmp/$zipfilename");
  exit();
}


function word_output_program( $data ){
  
  $body =  "<html>";
  $body .= "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\">";
  $body .= "<body>";
  $body .= "<pre>";

$body .= "<p>Nombre:<br>".$data['q1_nombre']."<br>&nbsp;</p>";
$body .= "<p>Correo electrónico:<br>".$data['q2_correo-electrnico']."<br>&nbsp;</p>";
$body .= "<p>Edad:<br>".$data['q3_edad']."<br>&nbsp;</p>";
$body .= "<p>Género:<br>".$data['q4_gnero']."<br>&nbsp;</p>";
$body .= "<p>Nacionalidad:<br>".$data['q5_nacionalidad']."<br>&nbsp;</p>";
$body .= "<p>Estado civil:<br>".$data['q6_estado-civil']."<br>&nbsp;</p>";
$body .= "<p>Profesión actual:<br>".$data['q7_profesin-actual']."<br>&nbsp;</p>";
$body .= "<p>Profesiones anteriores:<br>".$data['q8_profesiones-anterior']."<br>&nbsp;</p>";
$body .= "<p>¿Cuáles son tus objetivos personales y profesionales actuales?<br>".$data['q9_cules-son-tus-objeti']."<br>&nbsp;</p>";
$body .= "<p>¿Cuáles son tus fortalezas y cómo eres capaz de usarlas?<br>".$data['q10_cules-son-tus-fortal']."<br>&nbsp;</p>";
$body .= "<p>¿Qué te impide conseguir tus objetivos y sueños?<br>".$data['q11_qu-te-impide-consegu']."<br>&nbsp;</p>";
$body .= "<p>¿Cuál es tu relación con el fracaso?<br>".$data['q12_cul-es-tu-relacin-co']."<br>&nbsp;</p>";
$body .= "<p>¿Cuál es tu relación con la verdad?<br>".$data['q13_cul-es-tu-relacin-co']."<br>&nbsp;</p>";
$body .= "<p>¿Cuál es tu relación con la confrontación?<br>".$data['q14_cul-es-tu-relacin-co']."<br>&nbsp;</p>";
$body .= "<p>¿Cuán decidido estás a retar estas relaciones por el bien de tu desarrollo como líder?<br>".$data['q15_cun-decidido-ests-a-']."<br>&nbsp;</p>";
$body .= "<p>¿Estás o has estado alguna vez en terapia?<br>".$data['q16_ests-o-has-estado-al']."<br>&nbsp;</p>";
$body .= "<p>Si es así, enumera cuándo y por qué razón.<br>".$data['q17_si-es-as-enumera-cun']."<br>&nbsp;</p>";
$body .= "<p>¿Qué impacto ha tenido la terapia en tu desarrollo?<br>".$data['q18_qu-impacto-ha-tenido']."<br>&nbsp;</p>";
$body .= "<p>¿Qué cursos de CTI has realizado?<br>".$data['q19_qu-cursos-de-cti-has']."<br>&nbsp;</p>";
$body .= "<p>¿Tienes actualmente o has tenido un coach alguna vez?<br>".$data['q20_tienes-actualmente-o']."<br>&nbsp;</p>";
$body .= "<p>¿Qué impacto ha tenido el coaching en tu desarrollo?<br>".$data['q21_qu-impacto-ha-tenido']."<br>&nbsp;</p>";
$body .= "<p>Por favor, describe tus filiaciones religiosas o influencias espirituales.<br>".$data['q22_por-favor-describe-t']."<br>&nbsp;</p>";
$body .= "<p>¿Cómo ha influido tu ruta espiritual en tu desarrollo personal?<br>".$data['q23_cmo-ha-influido-tu-r']."<br>&nbsp;</p>";
$body .= "<p>Por favor, describe otras experiencias de crecimiento personal que hayan tenido un impacto significativo en ti y tu desarrollo personal.<br>".$data['q24_por-favor-describe-o']."<br>&nbsp;</p>";
$body .= "<p>1. ¿Cuál es tu definición de liderazgo?<br>".$data['q25_1-cul-es-tu-definici']."<br>&nbsp;</p>";
$body .= "<p>2. ¿De qué formas estás deseando que te reten, crecer y expandirte?<br>".$data['q26_2-de-qu-formas-ests-']."<br>&nbsp;</p>";
$body .= "<p>3. De todas las cosas posibles que podrías haber hecho para expandir tu liderazgo, ¿por qué escogiste este programa concreto?<br>".$data['q27_3-de-todas-las-cosas']."<br>&nbsp;</p>";
$body .= "<p>4. Considerando tu vida actual y compromisos, ¿cuán disponible estás para jugar \"a tope\" en el Programa de Liderazgo Co-Activo® en una escala del 1 al 10 (siendo 10 lo más alto)?<br>".$data['q28_4-considerando-tu-vi']."<br>&nbsp;</p>";
$body .= "<p>5. Si pudieras escoger cambiar ese número por otro, ¿qué número escogerías?<br>".$data['q29_5-si-pudieras-escoge']."<br>&nbsp;</p>";
$body .= "<p>6. ¿Qué tendrías que hacer para que eso fuese cierto?<br>".$data['q30_6-qu-tendras-que-hac']."<br>&nbsp;</p>";
$body .= "<p>7. ¿Con qué número estás dispuesto a comprometerte?<br>".$data['q31_7-con-qu-nmero-ests-']."<br>&nbsp;</p>";
$body .= "<p>8. ¿Cómo retornarás a ese nivel cuando las cosas vayan mal, cuando no tengas ganas o cuando se vuelva retador y quieras ocultarte?<br>".$data['q32_8-cmo-retornars-a-es']."<br>&nbsp;</p>";
$body .= "<p>9. ¿Cómo sabes que estás comprometido a hacer el camino? ¿Cuáles son tus pruebas?<br>".$data['q33_9-cmo-sabes-que-ests']."<br>&nbsp;</p>";
$body .= "<p>10. Cuando comiences este viaje de Liderazgo Co-Activo, es importante prestar atención al impacto que quieres tener en el mundo como líder. En servicio de esa conversación continua, completa la siguiente frase:<br>".$data['q34_10-cuando-comiences-']."<br>&nbsp;</p>";
$body .= "<p>11. Yo nací en este momento de la historia para…<br>".$data['q35_11-yo-nac-en-este-mo']."<br>&nbsp;</p>";
$body .= "<p>12. ¿Qué más quieres que sepamos?<br>".$data['q36_12-qu-ms-quieres-que']."<br>&nbsp;</p>";

  $body .= "</pre>";
  $body .= "</body>";
  $body .= "</html>";

  return $body;
}

function word_output_medical( $data ){
  
  $body =  "<html>";
  $body .= "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\">";
  $body .= "<body>";
  $body .= "<pre>";

$body .= "<p>NOMBRE:<br>".$data['q1_nombre']."<br>&nbsp;</p>";
$body .= "<p>FECHA: <br>".$data['q2_fecha-']."<br>&nbsp;</p>";
$body .= "<p>Email:<br>".$data['q3_email']."<br>&nbsp;</p>";
$body .= "<p>COMIENZO DE PROGRAMA:<br>".$data['q4_comienzo-de-programa']."<br>&nbsp;</p>";
$body .= "<p>Edad: <br>".$data['q5_edad-']."<br>&nbsp;</p>";
$body .= "<p>Fecha de Nacimiento: <br>".$data['q6_fecha-de-nacimiento-']."<br>&nbsp;</p>";
$body .= "<p>Sexo: <br>".$data['q7_sexo-']."<br>&nbsp;</p>";
$body .= "<p>Altura: <br>".$data['q8_altura-']."<br>&nbsp;</p>";
$body .= "<p>Peso:<br>".$data['q9_peso']."<br>&nbsp;</p>";
$body .= "<p>¿Padeces alguna incapacidad física limitante (temporal o permanente) que pueda afectar tu nivel de participación en el Programa Co-Activo de Liderazgo?:<br>".$data['q10_padeces-alguna-incap']."<br>&nbsp;</p>";
$body .= "<p>Solicitud de alojamiento para discapacitados físicos. Se llevará a cabo alojamiento de acuerdo a tal efecto si es factible . Especificar alguna si<br>".$data['q11_solicitud-de-alojami']."<br>&nbsp;</p>";
$body .= "<p>¿Presentas alguna condición emocional o psicológica que pueda afectar tu nivel de participación en el Programa Co- Activo de Liderazgo?:<br>".$data['q12_presentas-alguna-con']."<br>&nbsp;</p>";
$body .= "<p>Está embarazada?:<br>".$data['q13_esta-embarazada']."<br>&nbsp;</p>";
$body .= "<p>En caso afirmativo, fecha de parto:<br>".$data['q14_en-caso-afirmativo-f']."<br>&nbsp;</p>";
$body .= "<p>¿Historial de mareos o desmayos?:<br>".$data['q15_historial-de-mareos-']."<br>&nbsp;</p>";
$body .= "<p>¿Historial de enfermedad coronaria o ataque al corazón?:<br>".$data['q16_historial-de-enferme']."<br>&nbsp;</p>";
$body .= "<p>Ojos:<br>".$data['q17_ojos']."<br>&nbsp;</p>";
$body .= "<p>Muñecas:<br>".$data['q18_munecas']."<br>&nbsp;</p>";
$body .= "<p>Rodillas:<br>".$data['q19_rodillas']."<br>&nbsp;</p>";
$body .= "<p>Hipertensión:<br>".$data['q20_hipertension']."<br>&nbsp;</p>";
$body .= "<p>Oídos:<br>".$data['q21_oidos']."<br>&nbsp;</p>";
$body .= "<p>Manos:<br>".$data['q22_manos']."<br>&nbsp;</p>";
$body .= "<p>Parte inferior de las piernas:<br>".$data['q23_parte-inferior-de-la']."<br>&nbsp;</p>";
$body .= "<p>Pulmones:<br>".$data['q24_pulmones']."<br>&nbsp;</p>";
$body .= "<p>Cabeza:<br>".$data['q25_cabeza']."<br>&nbsp;</p>";
$body .= "<p>Parte superior de la espal:<br>".$data['q26_parte-superior-de-la']."<br>&nbsp;</p>";
$body .= "<p>Tobillos:<br>".$data['q27_tobillos']."<br>&nbsp;</p>";
$body .= "<p>Asma:<br>".$data['q28_asma']."<br>&nbsp;</p>";
$body .= "<p>Cuello:<br>".$data['q29_cuello']."<br>&nbsp;</p>";
$body .= "<p>Parte inferior de la espald:<br>".$data['q30_parte-inferior-de-la']."<br>&nbsp;</p>";
$body .= "<p>Pies:<br>".$data['q31_pies']."<br>&nbsp;</p>";
$body .= "<p>Corazón:<br>".$data['q32_corazon']."<br>&nbsp;</p>";
$body .= "<p>Latigazo cervical:<br>".$data['q33_latigazo-cervical']."<br>&nbsp;</p>";
$body .= "<p>Pelvis:<br>".$data['q34_pelvis']."<br>&nbsp;</p>";
$body .= "<p>Órganos internos:<br>".$data['q35_organos-internos']."<br>&nbsp;</p>";
$body .= "<p>Diabetes:<br>".$data['q36_diabetes']."<br>&nbsp;</p>";
$body .= "<p>Hombros:<br>".$data['q37_hombros']."<br>&nbsp;</p>";
$body .= "<p>Ingle:<br>".$data['q38_ingle']."<br>&nbsp;</p>";
$body .= "<p>Epilepsia/Ataques:<br>".$data['q39_epilepsiaataques']."<br>&nbsp;</p>";
$body .= "<p>Usa lentes de contacto:<br>".$data['q40_usa-lentes-de-contac']."<br>&nbsp;</p>";
$body .= "<p>Brazos:<br>".$data['q41_brazos']."<br>&nbsp;</p>";
$body .= "<p>Muslos:<br>".$data['q42_muslos']."<br>&nbsp;</p>";
$body .= "<p>Otras enfermedade:<br>".$data['q43_otras-enfermedade']."<br>&nbsp;</p>";
$body .= "<p>Fuma:<br>".$data['q44_fuma']."<br>&nbsp;</p>";
$body .= "<p>Dislocaciones:<br>".$data['q45_dislocaciones']."<br>&nbsp;</p>";
$body .= "<p>De ser así, ¿dónde? ss graves:<br>".$data['q46_de-ser-asi-donde-ss-']."<br>&nbsp;</p>";
$body .= "<p>¿Alguna vez ha fumado?:<br>".$data['q47_alguna-vez-ha-fumado']."<br>&nbsp;</p>";
$body .= "<p>Explica las respuestas afirmativas de arriba<br>".$data['q48_explica-las-respuest']."<br>&nbsp;</p>";
$body .= "<p>DATOS DE CONTACTO DEL PARTICIPANTE:<br>".$data['q49_datos-de-contacto-de']."<br>&nbsp;</p>";
$body .= "<p>FECHA DE COMIENZO DEL PROGRAMA: <br>".$data['q50_fecha-de-comienzo-de']."<br>&nbsp;</p>";
$body .= "<p>Teléfono (Fijo):<br>".$data['q51_telefono-fijo']."<br>&nbsp;</p>";
$body .= "<p>Teléfono (Trabajo):<br>".$data['q52_telefono-trabajo']."<br>&nbsp;</p>";
$body .= "<p>Correo electrónico:<br>".$data['q53_correo-electronico']."<br>&nbsp;</p>";
$body .= "<p>Dirección:<br>".$data['q54_direccion']."<br>&nbsp;</p>";
$body .= "<p>Ciudad, País, Código Postal:<br>".$data['q55_ciudad-pais-codigo-p']."<br>&nbsp;</p>";
$body .= "<p>INFORMACIÓN DE CONTACTO EN CASO DE EMERGENCIA:<br>".$data['q56_informacion-de-conta']."<br>&nbsp;</p>";
$body .= "<p>Contacto en caso de emergencia: Dirección:<br>".$data['q57_contacto-en-caso-de-']."<br>&nbsp;</p>";
$body .= "<p>Teléfono del trabajo:<br>".$data['q58_telefono-del-trabajo']."<br>&nbsp;</p>";
$body .= "<p>Parentezco: Teléfono fijo:<br>".$data['q59_parentezco-telefono-']."<br>&nbsp;</p>";
$body .= "<p>Otro teléfono:<br>".$data['q60_otro-telefono']."<br>&nbsp;</p>";
$body .= "<p>Núm de póliza.:<br>".$data['q61_num-de-poliza']."<br>&nbsp;</p>";
$body .= "<p>Compañía Aseguradora:<br>".$data['q62_compania-aseguradora']."<br>&nbsp;</p>";
$body .= "<p>Otra información sobre el seguro:<br>".$data['q63_otra-informacion-sob']."<br>&nbsp;</p>";
$body .= "<p>Nombre del Doctor Teléfono del Doctor:<br>".$data['q64_nombre-del-doctor-te']."<br>&nbsp;</p>";
$body .= "<p>Alergias (Comida, Medicamentos, Plantas, Insectos, etc.):<br>".$data['q65_alergias-comida-medi']."<br>&nbsp;</p>";
$body .= "<p>¿Tomas alguna medicación en la actualidad?:<br>".$data['q66_tomas-alguna-medicac']."<br>&nbsp;</p>";
$body .= "<p>No ¿Con qué motivo?:<br>".$data['q67_no-con-que-motivo']."<br>&nbsp;</p>";
$body .= "<p>Nombre del medicamento(s): Dosis:<br>".$data['q68_nombre-del-medicamen']."<br>&nbsp;</p>";


$body .= "</pre>";
  $body .= "</body>";
  $body .= "</html>";

  return $body;
}

function zip_files( $type, $path, $files ){
  $zip = new ZipArchive();
  $zipfilename =  "Spain-$type-".date('Y-m-d').".zip";

  if(file_exists("/tmp/$zipfilename")){
      unlink("/tmp/$zipfilename"); // remove it if it already exists
  }

  if ($zip->open("/tmp/$zipfilename", ZIPARCHIVE::CREATE) !== TRUE) {
    exit("cannot open <$zipfilename>\n");
  }
  
  foreach($files as $file){
    $zip->addFile( "$path/$file", $file);
  }

 $zip->close();
 return "/tmp/$zipfilename";
}


function xtea_example(){
 if($_GET['foo'] == 1){
  $xtea = new XTEA($secret);
  $filename = "/www/www.thecoaches.com/lib/launchpad_data/med_form_for_1.json";
  $cipher = file_get_contents($filename);
  $plain = $xtea->Decrypt($cipher); //Decrypts the cipher text
  echo $plain;
 }
}



