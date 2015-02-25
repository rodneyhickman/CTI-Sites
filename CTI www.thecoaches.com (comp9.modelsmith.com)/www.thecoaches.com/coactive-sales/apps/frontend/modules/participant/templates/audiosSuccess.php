<h1>Listen to Audios</h1>

<p>These audios complement your learning in class. Use the players below to listen now or download the audios as MP3s that you can listen to later.</p>

<p>&nbsp;</p>

<table class="listen">
<tr><th>Description</th><th>Listen or Download</th></tr>

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
</tr>

   <?php endforeach; ?>

</table>
