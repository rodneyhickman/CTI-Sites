<!-- This file contains a starting point for a templte page   -->

<?php include_partial('nav') ?>

<h1>
  Search For A Coach (Test Bed)
</h1>

<div style="float:left;">

<form action="<?php echo url_for('coach/searchResultsTestBed') ?>" method="POST">
  <table>
    <?php echo $form ?>
    <tr>
      <td></td>
      <td>
        <input type="submit" name="submit" value="Search" />
      </td>
    </tr>

  </table>
</form>
</div>

<div style="float:left;margin-left:30px;">


   <p>Examples:</p>

<p>
<ul>
<li>Time zones</li>
<li>Organizational</li>
<li>San Francisco</li>
<li>Career</li>
<li>Business</li>
<li>Relationship</li>
</ul>
</p>
</div>
