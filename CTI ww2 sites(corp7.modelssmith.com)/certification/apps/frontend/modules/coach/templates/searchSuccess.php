<!-- This file contains a starting point for a templte page   -->

<?php include_partial('nav') ?>

<h1>
Search For A <?php echo $type ?> Coach
</h1>



<form action="<?php echo url_for('coach/searchAllProfileExtra') ?>" method="POST">



<h2>How to find a coach</h2>
<ul>
  <li>Interview several coaches and have sample sessions. You want to make sure you have a rapport with your coach and can have the basis for respect and trust. Ask for a sample session. Ask for references. And at the end, trust your "gut" feeling in this process.<br />&nbsp;</li>
<li>Know what you want in a coach. Do you have a male or female, or age preference for your coach? Are there specific personal styles that
you are drawn to? To the extent you can articulate clearly what you are looking for; you can find your match faster.</li>
</ul>
<p>&nbsp;</p>
<p style="padding-bottom:5px"><b>Scroll through the database of coaches by credential:<b> <input type="submit" name="submitCredential" value="Search" /></p>
<p>&nbsp;</p>

<p style="padding-bottom:5px">Begin Searching for a Coach by Credentials:</p>
                                                                                       <p>&nbsp;</p>
                                                                                       <div style="float:left;width:100px !important;height:30px;margin:0"><?php echo button_to('CPCC','coach/searchAllProfileExtra?q=CPCC+ACC') ?></div>
<div style="float:left;width:500px;margin:-10px 0 0 0"><p>No charge for the first 6 hours and $100 per hour thereafter for a CPCC/ACC credentialed coach</p></div>
                                                                                       <div style="clear:both;">&nbsp;</div>

<div style="float:left;width:100px;margin:0"><?php echo button_to('CPCC/PCC','coach/searchAllProfileExtra?q=PCC') ?></div>
<div style="float:left;width:500px;margin:-10px 0 0 0"><p>$50 per hour for the first 6 hours and $150 per hour thereafter for a CPCC/PCC credentialed coach</p></div>
<div style="clear:both;">&nbsp;</div>

<div style="float:left;width:100px;margin:0"><?php echo button_to('CPCC/MCC','coach/searchAllProfileExtra?q=MCC') ?></div>
<div style="float:left;width:500px;margin:-10px 0 0 0"><p>$100 per hour for the first 6 hours and $150/hour thereafter for a CPCC/MCC credentialed coach or a CTI Faculty coach</p></div>
<div style="clear:both;">&nbsp;</div>



<p style="padding-bottom:5px">Or scroll through the database of all coaches:</b> <input type="submit" name="submitAll" value="Search" /></p>
<p>&nbsp;</p>


  <table>
    <?php echo $form ?>
    <tr>
      <td></td>
      <td>
        <input type="submit" name="submitAny" value="Search" />
      </td>
    </tr>
  
  </table>


<!--
  <p>&nbsp;</p>

<p>Or using keyword   search, you can search for, area codes, cities, states or any other text   fields:</p>
<p><strong>Keyword Search</strong>
<p><strong>Or specific fields:</strong></p>
<p>Last Name: <br /> </p>
<p>City: <br /><img alt="" /></p>
<p>Province/State: <br /><img alt="" /></p>
<p>Country<br /><img alt="" /></p>
<p><strong>Academic   Credentials:</strong>
<select name="academic" id="">
<option value="Bachelors degree">Bachelors degree</option>
<option value="Masters degree">Masters degree</option>
<Option Value="Doctorate">Doctorate</Option>
<Option Value="Other">Other</Option>
</select>

<p>&nbsp;</p>
<p><strong>Language:</strong></a></p>
-->

<!-- create list from languages posted by coaches -->

<!--
<select name="language" id="">
<Option Value="English">English</Option>
<Option Value="French">French</Option>
<Option Value="Spanish">Spanish</Option>
<Option Value="German">German</Option>
<Option Value="Japanese">Japanese</Option>
<Option Value="Russian">Russian</Option>
<Option Value="Turkish">Turkish</Option>
<Option Value="Hebrew">Hebrew</Option>
<option value="Chinese (Mandarin)">Chinese (Mandarin)</option>
<option value="Chinese (Cantonese)">Chinese (Cantonese)</option>
<Option Value="Italian">Italian</Option>
<Option Value="Norwegian">Norwegian</Option>
<Option Value="Swedish">Swedish</Option>
<Option Value="Danish">Danish</Option>
<Option Value="Korean">Korean</Option>
<Option Value="Portuguese">Portuguese</Option>
</select>

 <strong>Other Language</strong></p>
<p>&nbsp;</p>

-->



</form>



