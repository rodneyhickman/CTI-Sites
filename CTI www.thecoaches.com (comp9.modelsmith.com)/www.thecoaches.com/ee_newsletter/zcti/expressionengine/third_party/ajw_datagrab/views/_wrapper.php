<style type="text/css" media="screen">
	table.mainTable td.box { 
		background: #fdfcd1; 
		line-height:130%;
	}
	.info {
		border: 1px solid #d0d7df;
		background-color: #f4f6f6;
		padding: 8px 16px;
		line-height: 150%;
	}
</style>

<?php if( isset( $errors ) && count( $errors ) ) {
	foreach( $errors as $error ) {
		echo '<p class="notice">Error: ' . $error . '</p>';
	}
}
?>

<?php $this->view($content); ?>