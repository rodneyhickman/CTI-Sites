<ul class="sidebar-module">
<?php if(is_page('search-page')) :?>
<li>
 <label for="s" class="screen-reader-text"><strong>Search for:</strong></label>
    <div><form name="frm_gcse" method="post" action="">
            <select name="sel_cse" style="width:150px" >
            <option>Select</option>
            <option value="edomain">Entire Domain</option>
            <option value="red">Within CTI Corporate site only</option>
            <option value="green">Within CTI Corporate Site & Blog</option>
            <option value="blue">CTI Corporate Sites and all the local community blogs</option>
            <option value="all">All CTI Sites including Global Partners and Their Blogs</option>
        </select></form>
        <br />
        
    </div>
    
    <div class='edomain box'><?php include("includes/entire.php");?></div> 
   <div class="red box"><?php //include("includes/entire1.php");?></div>
   <div class="green box"><?php //include("includes/entire2.php");?></div>
    <div class="blue box"></div>
    <div class="all box"></div> 
</li>


   <li>


 
   </li>
   <?php endif; ?>
   <?php if ( is_search() ):?>
      <li>
 <label for="s" class="screen-reader-text"><strong>Search for:</strong></label>
   <script>
  (function() {
    var cx = '007858955710967790149:cpaygmqvl4s';
    var gcse = document.createElement('script');
    gcse.type = 'text/javascript';
    gcse.async = true;
    gcse.src = (document.location.protocol == 'https:' ? 'https:' : 'http:') +
        '//www.google.com/cse/cse.js?cx=' + cx;
    var s = document.getElementsByTagName('script')[0];
    s.parentNode.insertBefore(gcse, s);
  })();
</script>
<gcse:search></gcse:search><br />
 
   </li>
   <?php endif; ?>
   <li><p><b style="text-transform:uppercase;font-size:0.9em;">Guest blog post submissions</b><br />Suzan Acker, Transforum Producer

<a href="mailto:suzanacker@gmail.com">suzanacker@gmail.com</a></p></li>

<?php if ( !function_exists('dynamic_sidebar')

        || !dynamic_sidebar() ) : ?>

<?php endif; ?>

</ul>

