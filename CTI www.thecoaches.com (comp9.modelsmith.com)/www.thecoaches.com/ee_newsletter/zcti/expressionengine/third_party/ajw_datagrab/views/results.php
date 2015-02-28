<?php 

$this->table->set_template($cp_table_template);
$this->table->set_heading("Results");

$this->table->add_row(
	$results
);

echo $this->table->generate();

?>

<?php if( $id == 0 ): ?>

	<p>

		<?php echo form_open( $form_action ); ?>
		<?php echo form_hidden( 'id', 0 ); ?>
		<input type="submit" value="Save" class="submit" />
		<?php echo form_close(); ?>

	</p>

<?php else: ?>

	<p>

		<?php echo form_open( $form_action ); ?>
		<?php echo form_hidden( 'id',  $id ); ?>
		<input type="submit" value="Update saved import" class="submit" />
		<?php echo form_close(); ?>

	</p>
	<p>

		<?php echo form_open( $form_action ); ?>
		<?php echo form_hidden( 'id', 0 ); ?>
		<input type="submit" value="Save as new import" class="submit" />
		<?php echo form_close(); ?>

	</p>

<?php endif; ?>

