<?php use_helper('Object'); ?>
  <div class="dabblePageContainer dabblePageNoNavigation">
    <div class="dabblePageLeftShadow">
      <div class="dabblePageRightShadow">
        <div class=
        "dabblePage dabblePageWithLogo dabbleSearchPage">
          <div class="dabblePageHeader" id="dabblePageTop">
            <div class="dabblePageLogo">
             <img alt="" height="57" width="176" class="png24bit" src="/launchpad/images/logo250857176.png" />
            </div>

<div style="padding:20px;">

<h1>Choose Form</h1>

<p>Please choose a form:</p>

<?php foreach($flexforms as $flexform): ?>
    <p>&raquo; <a href="<?php echo url_for('flexform/show?id='.$flexform->getId()); ?>"?><?php echo $flexform->getTitle() ?></a></p>
<?php endforeach; ?>


</div>


   </div>
        </div>
      </div>
    </div>

    <div class="dabblePageBottomLeftShadow"></div>

    <div class="dabblePageBottomRightShadow"></div>

    <div class="dabblePageBottomShadow"></div>
  </div>
<div style="clear:both">&nbsp;</div>
<div style="clear:both">&nbsp;</div>
<div style="clear:both">&nbsp;</div>
<div style="clear:both">&nbsp;</div>
