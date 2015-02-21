<?php use_helper('Object'); ?>
<!-- This file contains the CA Step 1 form           -->

  <div class="dabblePageContainer dabblePageNoNavigation">
    <div class="dabblePageLeftShadow">
      <div class="dabblePageRightShadow">
        <div class=
        "dabblePage dabblePageWithLogo dabbleSearchPage">
          <div class="dabblePageHeader" id="dabblePageTop">
            <div class="dabblePageLogo">
              <!--[if lte IE 6]><span style="display:block;width:176px;height:57px;filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src='/launchpad/images/logo250857176.png',sizingMethod='crop')"><![endif]--><img alt=""
              height="57" width="176" class="png24bit" src=
              "/launchpad/images/logo250857176.png" /> <!-- /publish/logo250857176.png -->
              <!--[if lte IE 6]></span><![endif]-->
            </div>

    <h1>&nbsp;</h1>

            <div id="dabblePageMenuLink" class=
            "dabblePageMobileOnly dabblePageNavigationLinks">
               
            </div>
          </div>

          <div id="dabblePageContent">

<?php echo form_tag('ctiforms/DeclareStartMonthProcess', 'method=post id=dabblePageForm  class=dabblePageForm name=dabblePageForm') ?>

                <input type="hidden" name="referer" value="http://www.thecoaches.com/coach-training/certification/registration.html" />




<div class="dabblePageSection dabblePageSectionFull">
<div class="dabblePageColumn dabblePageColumn1">

<!--
<div class="dabblePageTextItem">
<div class="dabblePageText">
<p></p>
</div>
</div>
-->


<div class="dabblePageTextItem">
<div class="dabblePageText">
    <p>&nbsp;</p>
    <p>&nbsp;</p>
<h1>CERTIFICATION START MONTH DECLARATION FORM</h1>
<p><strong>The Coaches Training Institute</strong></p>
<p>
Instructions - To declare a start month, please complete the following:
</p>
</div>
</div>





<div class="dabblePageFormLabel">
<label for="name">First Name</label>
</div>
<div class="dabblePageFormField dabblePageFormItemRequired">

<input type="text" class="text" name="cert[first-name]" value="" />

</div>



<div class="dabblePageFormLabel">
<label for="name">Last Name</label>
</div>
<div class="dabblePageFormField dabblePageFormItemRequired">

<input type="text" class="text" name="cert[last-name]" value="" />

</div>
<div style="clear:both">&nbsp;</div>


<div class="dabblePageFormLabel">
<label for="email">Email</label>
</div>
<div class="dabblePageFormField dabblePageFormItemRequired">

<input type="text" class="text" name="cert[email]" value="" />

</div>
<div style="clear:both">&nbsp;</div>



<div class="dabblePageFormLabel">
<label for="month-to-begin-certification">What month would you like to begin certification?</label>
</div>
<div class="dabblePageFormField dabblePageFormItemRequired">
<select  name="cert[month-to-begin-certification]">
    <?php  echo options_for_select( $months ) ?>

</select>
</div>
<div style="clear:both">&nbsp;</div>







          
<p class="qwed"></p>
             
                  <div class="dabblePageTextItem">
                    <div class="dabblePageText">
                      <p>Please be patient and <em> Click "Submit" once!
                      </em>It takes a bit for the data to be
                      recorded. Once it is finished, you will be
                      returned to the main landing page.</p>

                    </div>
                  </div>
                </div>
              </div>

              <div class="clear"></div>

              <div class=
              "dabblePageSection dabblePageSectionFormActions">
                <div class="dabblePageColumn dabblePagColmn1">
                  <div class="dabblePageFormActions">
                    <span class=
                    "dabblePageFormButton dabblePageFormSubmit">
					<input name="save"
                    accesskey="s" id="dabblePageFormSubmit" value=
                    "Submit Form" type="submit" class=
                    "submit" /> 
					<?php echo button_to('Cancel',$referer, 'class=submit') ?>	
					<!-- <input name="cancel" value="Cancel"
                    type="submit" class="submit" /> -->
					</span>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <div class="dabblePageBottomLeftShadow"></div>

    <div class="dabblePageBottomRightShadow"></div>

    <div class="dabblePageBottomShadow"></div>
  </div>