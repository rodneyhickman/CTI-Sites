<tr>
	<td><?=lang('f:test_mode')?></td>
	<td>
		<?=form_radio($form_name_settings.'[test_mode]', 'yes', ((isset($test_mode) == FALSE OR $test_mode == 'yes') ? TRUE : FALSE), '  ')?> <?=lang('yes')?>&nbsp;&nbsp;
		<?=form_radio($form_name_settings.'[test_mode]', 'no', ((isset($test_mode) == TRUE && $test_mode == 'no') ? TRUE : FALSE), '  ')?> <?=lang('no')?>&nbsp;&nbsp;
	</td>
</tr>

<tr>
	<td><?=lang('f:ccs')?></td>
	<td>
		<?=form_checkbox($form_name_settings.'[cc][]', 'visa', (in_array('visa', $cc)))?> VISA<br>
		<?=form_checkbox($form_name_settings.'[cc][]', 'mc', (in_array('mc', $cc)))?> MasterCard<br>
		<?=form_checkbox($form_name_settings.'[cc][]', 'amex', (in_array('amex', $cc)))?> American Express<br>
		<?=form_checkbox($form_name_settings.'[cc][]', 'discover', (in_array('discover', $cc)))?> Discover<br>
		<?=form_checkbox($form_name_settings.'[cc][]', 'jcb', (in_array('jcb', $cc)))?> JCB<br>
	</td>
</tr>

<tr>
	<td><?=lang('f:currency')?></td>
	<td>
		<?=form_radio($form_name_settings.'[currency]', 'usd', ((isset($currency) == FALSE OR $currency == 'usd') ? TRUE : FALSE), '  ')?> US Dollar&nbsp;&nbsp;
		<?=form_radio($form_name_settings.'[currency]', 'cad', ((isset($currency) == TRUE && $currency == 'cad') ? TRUE : FALSE), '  ')?> Canadian Dollar&nbsp;&nbsp;
	</td>
</tr>
