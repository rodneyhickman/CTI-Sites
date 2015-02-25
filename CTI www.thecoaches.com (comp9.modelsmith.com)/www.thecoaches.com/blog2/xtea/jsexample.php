<?php
session_set_cookie_params(3600);
session_start();
?>
<html>
<head>

<script>
 // use (16 chars of) 'password' to encrypt 'plaintext'

function encrypt(plaintext, password) {
  var v = new Array(2), k = new Array(4), s = "", i;

  plaintext = escape(plaintext);  // use escape() so only have single-byte chars to encode 

  // build key directly from 1st 16 chars of password
  for (var i=0; i<4; i++) k[i] = Str4ToLong(password.slice(i*4,(i+1)*4));

  for (i=0; i<plaintext.length; i+=8) {  // encode plaintext into s in 64-bit (8 char) blocks
    v[0] = Str4ToLong(plaintext.slice(i,i+4));  // ... note this is 'electronic codebook' mode
    v[1] = Str4ToLong(plaintext.slice(i+4,i+8));
    code(v, k);
    s += LongToStr4(v[0]) + LongToStr4(v[1]);
  }

  return escCtrlCh(s);
  // note: if plaintext or password are passed as string objects, rather than strings, this
  // function will throw an 'Object doesn't support this property or method' error
 }

// use (16 chars of) 'password' to decrypt 'ciphertext' with xTEA

function decrypt(ciphertext, password) {
  var v = new Array(2), k = new Array(4), s = "", i;

  for (var i=0; i<4; i++) k[i] = Str4ToLong(password.slice(i*4,(i+1)*4));

  ciphertext = unescCtrlCh(ciphertext);
  for (i=0; i<ciphertext.length; i+=8) {  // decode ciphertext into s in 64-bit (8 char) blocks
    v[0] = Str4ToLong(ciphertext.slice(i,i+4));
    v[1] = Str4ToLong(ciphertext.slice(i+4,i+8));
    decode(v, k);
    s += LongToStr4(v[0]) + LongToStr4(v[1]);
  }

  // strip trailing null chars resulting from filling 4-char blocks:
  s = s.replace(/\0+$/, '');

  return unescape(s);
}


function code(v, k) {
  // Extended TEA: this is the 1997 revised version of Needham & Wheeler's algorithm
  // params: v[2] 64-bit value block; k[4] 128-bit key
  var y = v[0], z = v[1];
  var delta = 0x9E3779B9, limit = delta*32, sum = 0;

  while (sum != limit) {
    y += (z<<4 ^ z>>>5)+z ^ sum+k[sum & 3];
    sum += delta;
    z += (y<<4 ^ y>>>5)+y ^ sum+k[sum>>>11 & 3];
    // note: unsigned right-shift '>>>' is used in place of original '>>', due to lack 
    // of 'unsigned' type declaration in JavaScript (thanks to Karsten Kraus for this)
  }
  v[0] = y; v[1] = z;
}

function decode(v, k) {
  var y = v[0], z = v[1];
  var delta = 0x9E3779B9, sum = delta*32;

  while (sum != 0) {
    z -= (y<<4 ^ y>>>5)+y ^ sum+k[sum>>>11 & 3];
    sum -= delta;
    y -= (z<<4 ^ z>>>5)+z ^ sum+k[sum & 3];
  }
  v[0] = y; v[1] = z;
}


// supporting functions

function Str4ToLong(s) {  // convert 4 chars of s to a numeric long
  var v = 0;
  for (var i=0; i<4; i++) v |= s.charCodeAt(i) << i*8;
  return isNaN(v) ? 0 : v;
}

function LongToStr4(v) {  // convert a numeric long to 4 char string
  var s = String.fromCharCode(v & 0xFF, v>>8 & 0xFF, v>>16 & 0xFF, v>>24 & 0xFF);
  return s;
}

function escCtrlCh(str) {  // escape control chars which might cause problems with encrypted texts
  return str.replace(/[\0\t\n\v\f\r\xa0'"!]/g, function(c) { return '!' + c.charCodeAt(0) + '!'; });  //'
}

function unescCtrlCh(str) {  // unescape potentially problematic nulls and control characters
  return str.replace(/!\d\d?\d?!/g, function(c) { return String.fromCharCode(c.slice(1,-1)); });
}
 
</script>
</head>
<body>
                     <p>starting <?php echo session_name();  ?></p>


<?php
                     if($_SESSION["foo"]==""){
                     $_SESSION["foo"] = "baz";                     
                     }
print_r ($_SESSION);
$text = trim($_POST["text"]);
$key = $_SESSION["bar"];


//Wurde kein Key &uuml;bertragen? Wenn nein, 8 stelligen Key zuf&auml;llig erstellen
if(!isset($key))
{
  mt_srand(crc32(microtime()));
  $buchstaben = array("","a","b","c","d","e","f","g","h","i","j","k","m","n","p","q","r","s","t","u","v","w","x","y","z",1,2,3,4,5,6,7,8,9);
  $array_max = count($buchstaben)-1;
  
  for($i=0;$i < 8;$i++)
  {
    $rand_num = mt_rand(1, $array_max);
    $key .= $buchstaben[$rand_num];
    $a++;
  }
}

$_SESSION["bar"] = $key;
?>

<form action="#ausgabe" method="post">

Key:<br>
<input type="Text" name="key" value="<?php echo htmlentities($key); ?>" maxlength="16"><br>      <br>

Text:<br>
<textarea name="text" cols="45" rows="9"></textarea> <br> <br>


<input name="crypt" type="Submit" value="Verschluesseln"> &nbsp;&nbsp;&nbsp;
<input name="decrypt" type="Submit" value="Entschluesseln">

</form>


<a name="ausgabe"></a>
<?php

print_r ($_SESSION);

include("xtea.class.php"); 


if(isset($_POST["crypt"]))
{
  $start = (double)microtime()+time();
  $xtea = new XTEA($key);
  $ausgabe = $xtea->Encrypt($text);
  $diff = (double)microtime()+time() - $start;
  
  echo "<br><b>Verschl&uuml;sselt</b> sieht der Text so aus:<br>
   <textarea name=\"ausgabe\" cols=\"45\" rows=\"9\">".
    $ausgabe."</textarea><br>Ben&ouml;tigte Zeit: ".round($diff, 3)." Sekunden";
}
                     
else if(isset($_POST["decrypt"]))
{
  $start = (double)microtime()+time();
  $xtea = new XTEA($key);
  $ausgabe =$xtea->Decrypt($text);
  $diff = (double)microtime()+time() - $start;
  
  echo  "<b>Entschl&uuml;sselt</b> sieht der Text so aus:<br>".
    nl2br(htmlentities(stripslashes($ausgabe)))."<br><hr><br>Ben&ouml;tigte Zeit: ".round($diff, 3)." Sekunden";
}
                     
?>