<ul class="sidebar-module">
 
<li style="display:none;">
<label for="s" class=""><strong>Search for:</strong></label>
 <!--<label for="s" class=""><strong>Search for:</strong></label>
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
        
    </div>-->
    
    <div class='edomain'><?php include("includes/entire.php");?></div> 
  
</li>


   <li>


 
   </li>
   
  
   

<?php if ( !function_exists('dynamic_sidebar')

        || !dynamic_sidebar() ) : ?>

<?php endif; ?>

</ul>

