<?php

/**
 * DataGrab Date fieldtype class
 *
 * @package   DataGrab
 * @author    Andrew Weaver <aweaver@brandnewbox.co.uk>
 * @copyright Copyright (c) Andrew Weaver
 */
class Datagrab_date extends Datagrab_fieldtype {

	function prepare_post_date( $DG, $item, $field_id, $field, &$data, $update = FALSE ) {
		
		$data[ "field_id_" . $field_id ] = $DG->_parse_date(
				$DG->datatype->get_item( $item, $DG->settings[ $field ] )
				);
		$data[ "field_id_" . $field_id ] -= $DG->settings["offset"];
		$data[ "field_dt_" . $field_id ] = 'UTC';
		
	}

}

?>