<h1>Administration: Manage Audios</h1>

<?php if($msg){ echo "<p class=\"alert\">$msg</p>"; } ?>

<h2>New Audio</h2>
<form id="audio-form" class="upload-form" action="<?php echo url_for('admin/audioUpload') ?>" method="POST" enctype="multipart/form-data">
<fieldset>
   <label for="description">Description</label>
<textarea name="description"></textarea>
</fieldset>
<p><input type="checkbox" id="have-audio-url" /> I have a URL for this audio</p>
<p id="audio-file"><input type="file" name="audio_file" /> Choose an audio file on your computer</p>
<p id="audio-url"><input type="text" name="audio_url" /> Enter the URL</p>
<p><input type="submit" name="upload" value="Upload Audio File" /></p>
</form>


<p>&nbsp;</p>
<p>&nbsp;</p>

<h2>Available Audios</h2>
<table class="listen">
<tr><th>Description</th><th>Listen or Download</th><th></th></tr>

<?php foreach($audios as $audio): ?>

<tr>
   <td><?php echo $audio->getDescription(); ?></td>
   <td><!-- HTML5 Audio code BEGIN -->
 <audio controls="controls" preload="none" autobuffer="autobuffer" id="audio1"><!-- Audio tag, for HMTL5 compliant browsers -->
  <source src="<?php echo $audio->getUrl(); ?>"    type="audio/mpeg" />

  <!-- Flash player, for pre-HTML5 browsers -->
  <object class="playerpreview" type="application/x-shockwave-flash" 
          data="/res/swf/player_mp3_1.0.0.swf" width="145" height="20">
    <param name="movie" value="/res/swf/player_mp3_1.0.0.swf" />
    <param name="bgcolor" value="#085c68" />
    <param name="FlashVars" value="mp3=<?php echo $audio->getUrl(); ?>" />
    <embed href="/res/swf/player_mp3_1.0.0.swf" bgcolor="#085c68" width="145" 
           height="20" name="movie" align="" 
           type="application/x-shockwave-flash" flashvars="mp3=<?php echo $audio->getUrl(); ?>">
    </embed>
  </object>
 </audio>

 <div id="player_fallback"></div>
 <script>
  if (document.createElement('audio').canPlayType) {  /* if this is Firefox... */
    if (!document.createElement('audio').canPlayType('audio/mpeg')) {  /* but cannot play MP3, then use Flash player */
      swfobject.embedSWF(
        "/res/swf/player_mp3_1.0.0.swf", 
        "player_fallback", 
        "145", 
        "20", 
        "9.0.0", 
        "", 
        {"mp3":"<?php echo $audio->getUrl(); ?>"}, 
        {"bgcolor":"#085c68"});
      $('#audio1').hide(); /* hide the audio element, assumes jQuery is loaded */
    }
  }
 </script>
 <a href="<?php echo $audio->getUrl(); ?>" target="_blank">Download MP3</a>
<!-- HTML5 Audio code END -->
</td>
<td><a class="delete" href="<?php echo url_for('admin/audioDelete').'?audio_id='.$audio->getId() ?>">Delete</a></td>
</tr>

   <?php endforeach; ?>

</table>
