<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<?php
require_once ('FileMaker.php');

// localized string helper class
class Localizations {
  var $parser = null;
  var $cache = array();
  var $current = '';

  function localizations($language) {
    $this->parser = xml_parser_create();
    xml_set_object($this->parser,$this);
    xml_set_character_data_handler($this->parser, '_characterData');
    xml_set_element_handler($this->parser, "_startElement", "_endElement");

    if (!($file = fopen("localizations/strings_" . $language . ".xml", "r"))) {
      die("Cannot find localization file for language '" . $language . "'");
    }
    
    while ($data = fread($file, 1024)) {
      if (!xml_parse($this->parser, $data, feof($file))) {
        die("XML parse error: " .
          xml_error_string(xml_get_error_code($this->parser)) . " line " .  
          xml_get_current_line_number($this->parser));
        xml_parser_free($this->parser);
      }
    }
    
    return true;
  }

  function get($key) {
    return $this->cache[$key];
  }

  function _startElement($parser, $name, $attribs){
    if ($name == 'PROPERTY') {
      $this->current = $attribs['NAME'];
      $this->cache[$this->current] = '';
    }
  }

  function _characterData($parser, $data){
    if(!empty($data) && $this->current != '') {
      $this->cache[$this->current] .= $data;
    }
  }

  function _endElement($parser, $name) {
  }
}

// layout names
$LAYOUTS = array(
  'en' => "English_List_View",
  'fr' => "Français_List_View",
  'it' => "Italiano_List_View",
  'de' => "Deutsch_List_View",
  'sv' => "Svenska_List_View",
  'ja' => "日本語_List_View"
);

// determine which language is specified
if (isset($_GET['lang'])) $language = $_GET['lang'];
else $language = 'en';

// load the appropriate localization file
$localized_strings = new Localizations($language);

// select a layout (and url-decode it since the api will re-encode internally)
$layout = $LAYOUTS[$language];

if (isset($_GET['server'])) $server_name = htmlspecialchars($_GET['server']);
else $server_name = '';

// fetch the appropriate data from the database
if (class_exists("FileMaker")) {
  $fm = new FileMaker('FMServer_Sample');
  $command =& $fm->newFindAllCommand($layout);
  $impl_data = $command->execute();
  $error = NULL;
  if (FileMaker::isError($impl_data)) {
    $error = $impl_data;
  }  
}

//
// BEGIN PAGE
//
?>

<html>
  <head>
    <title><?php echo $localized_strings->get('page.title')?></title>
    <link href="/fmi-test/css/test.css" rel="stylesheet" type="text/css" />
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
  </head>
  <body>
    <div id="page">
      
      <?php /* HEADER */?>
      <div id="watermark"></div>
      <div id="header_test_img"></div>
      <div id="header_test">
        <div id="header_info">
          <div id="title"><img src="/fmi-test/images/title.gif" /><br />
            <span class="product_subtitle"><span class="gray_text">
              <?php echo $localized_strings->get('page.title')?>
            </span></span>
          </div>
          <div id="server_info">
            <table width="100%" border="0" cellspacing="1">
            <tr valign="top">
              <td width="21%" align="right" class="server_name_label">
                <div align="left">
                  <?php echo $localized_strings->get('page.label.server')?>
                </div>
              </td>
              <td width="79%" class="server_name"><?php echo $server_name ?></td>
            </tr>
            <tr>
              <td class="server_info" colspan="2"><a href="/"></a></td>
            </tr>
            </table>
          </div>
        </div>
      </div>

      <?php /* TEST */?>
      <div id="test_box">
        <div id="test_top">
          <div id="test_top_text">
            <?php echo $localized_strings->get('page.test-name')?>
          </div>
        </div>
        <div id="test_body">

          <?php if (class_exists("FileMaker") && !$error) { ?>
            <div id="test_ball_success"></div>
            <div id="test_impl_body_text">
              <?php echo $localized_strings->get('message.success')?>
            </div>
          <?php } else { ?>
            <div id="test_ball_failure"></div>
            <div id="test_impl_body_text">
              <?php echo $localized_strings->get('message.failure')?>
              <p>
                <?php
                if (!class_exists("FileMaker")) {
                  print $localized_strings->get("message.error.no-php-api");
                } else if ($localized_strings->get("message.error.fm." . $error->code)) {
                  print $localized_strings->get("message.error.fm." . $error->code);
								} else if (preg_match("/Communication Error: \((\d+)\)/", $error->getMessage(), $matches) > 0
														&& $localized_strings->get("message.error.curl." . $matches[1])) {
									print $localized_strings->get("message.error.curl." . $matches[1]);
                } else {
                  print $localized_strings->get("message.error.unknown");
                }
                ?>
                <?php
                if (class_exists("FileMaker")) {
                  if ($error->code) {
                    print "(Error ". $error->code . "; " . $error->getErrorString() . ")";
                  } else {
                    print "(" . $error->getMessage() . ")";
 									}
                }
                ?>
              </p>
            </div>
          <?php } ?>
        </div>
        <div id="test_bottom"></div>
      </div>

      <?php /* IMPL */?>
      <?php if (class_exists("FileMaker") && !$error) { ?>
        <br />
        <div id="test_table">
          <table width="600" border="0" cellpadding="3" cellspacing="1">
            <tr>
              <td bgcolor="#BEBEBE" colspan="<?php echo count($impl_data->getFields()) ?>">
                <span class="impl_top_text"><?php echo $localized_strings->get("db.title") ?></span>
              </td>
            </tr>
            <tr>
              <?php foreach ($impl_data->getFields() as $field) { ?>
                <td><span class="impl_body_title"><?php echo $field ?></span></td>
              <?php } ?>
            </tr>
            <?php foreach ($impl_data->getRecords() as $record) { ?>
               <tr>
                <?php foreach ($impl_data->getFields() as $field) { ?>
                  <td class="impl_body_text"><?php echo $record->getField($field) ?></td>
                <?php } ?>
               </tr>
            <?php } ?>
          </table>
        </div>
      <?php } ?>
    </div>
  </body>
</html>
