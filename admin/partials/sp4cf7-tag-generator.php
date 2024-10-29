<?php 

/**
 * Provide a contact form 7 tag generator for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://www.pluginspro.io
 * @since      1.0.0
 *
 * @package    SP4CF7
 * @subpackage SP4CF7/admin/partials
 */
?>
<div class="control-box">
	<fieldset>
		<legend><?php echo esc_html( __( "Generate a form-tag for to display Stripe Payment Form", 'contact-form-7' ) ); ?></legend>
		<table class="form-table">
			<tr>
				<?php 
				$input_name = $args['content'] . '-name';
				?>
				<th scope="row">
					<label for="<?php echo esc_attr( $input_name ); ?>"><?php echo esc_html( __( 'Name', 'contact-form-7' ) ); ?></label>
				</th>
				<td>
					<legend class="screen-reader-text"><input type="checkbox" name="required" value="on" checked="checked" /></legend>
					<input type="text" name="name" class="tg-name oneline" id="<?php echo esc_attr( $input_name ); ?>" />
				</td>
			</tr>
		</table>
	</fieldset>
</div>
<div class="insert-box">
	<input type="text" name="<?php echo esc_attr($type); ?>" class="tag code" readonly="readonly" onfocus="this.select()" />
	<div class="submitbox">
		<input type="button" class="button button-primary insert-tag" value="<?php echo esc_attr( __( 'Insert Tag', 'contact-form-7' ) ); ?>" />
	</div>
	<br class="clear" />
	<p class="description mail-tag">
		<label for="<?php echo esc_attr( $args['content'] . '-mailtag' ); ?>">
			<?php echo sprintf( esc_html( __( "To use the value input through this field in a mail field, you need to insert the corresponding mail-tag (%s) into the field on the Mail tab.", 'contact-form-7' ) ), '<strong><span class="mail-tag"></span></strong>' ); ?>
			<input type="text" class="mail-tag code hidden" readonly="readonly" id="<?php echo esc_attr( $args['content'] . '-mailtag' ); ?>" />
		</label>
	</p>
</div>