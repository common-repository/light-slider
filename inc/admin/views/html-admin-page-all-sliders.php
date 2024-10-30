<div class="wrap light-slider">
	<h1><?php esc_html_e( 'All Sliders', 'light-slider' ); ?></h1>

	<table class="widefat sls-slider-list">
		<thead>
		<tr>
			<th><?php esc_html_e( 'ID', 'light-slider' ); ?></th>
			<th><?php esc_html_e( 'Name', 'light-slider' ); ?></th>
			<th><?php esc_html_e( 'Shortcode', 'light-slider' ); ?></th>
			<th><?php esc_html_e( 'Date Created', 'light-slider' ); ?></th>
			<th><?php esc_html_e( 'Last Modify', 'light-slider' ); ?></th>
			<th><?php esc_html_e( 'Actions', 'light-slider' ); ?></th>
		</tr>
		</thead>

		<tbody>
		<?php if ( ! empty( $sliders ) ) : ?>
			<?php foreach ( $sliders as $slider ) : ?>
				<tr class="slider-row">
					<td><?php echo esc_html( $slider['ID'] ); ?></td>
					<td><?php echo esc_html( $slider['title'] ) ?></td>
					<td>[light_slider id="<?php echo esc_html( $slider['ID'] ); ?>"]</td>
					<td><?php echo esc_html( $slider['created'] ); ?></td>
					<td><?php echo esc_html( $slider['modified'] ); ?></td>
					<td>
						<a href="<?php echo esc_url( add_query_arg( array( 'page' => $_GET['page'], 'action' => 'edit', 'id' => $slider['ID'], 'theme' => $slider['theme'] ) ) ); ?>"><?php esc_html_e( 'Edit', 'light-slider' ); ?></a> |
						<a href="<?php echo esc_url( add_query_arg( array( 'page' => $_GET['page'], 'action' => 'preview', 'id' => $slider['ID'], 'theme' => $slider['theme'] ) ) ); ?>" class="sls-preview-slider"><?php esc_html_e( 'Preview', 'light-slider' ); ?></a> |
						<a href="<?php echo esc_url( add_query_arg( array( 'page' => $_GET['page'], 'action' => 'duplicate', 'id' => $slider['ID'], 'nonce' => wp_create_nonce( 'sls_duplicate_slider_nonce' ) ) ) ); ?>" class="sls-duplicate-slider"><?php esc_html_e( 'Duplicate', 'light-slider' ); ?></a> |
						<a href="<?php echo esc_url( add_query_arg( array( 'page' => $_GET['page'], 'action' => 'delete', 'id' => $slider['ID'], 'nonce' => wp_create_nonce( 'sls_delete_slider_nonce' ) ) ) ); ?>" class="sls-delete-slider"><?php esc_html_e( 'Delete', 'light-slider' ); ?></a>
					</td>
				</tr>
			<?php endforeach; ?>
		<?php else : ?>
			<tr class="no-items">
				<td class="colspanchange" colspan="100%"><?php esc_html_e( 'No sliders found.', 'light-slider' ); ?></td>
			</tr>
		<?php endif; ?>
		</tbody>

		<tfoot>
		<tr>
			<th><?php _e( 'ID', 'light-slider' ); ?></th>
			<th><?php _e( 'Name', 'light-slider' ); ?></th>
			<th><?php _e( 'Shortcode', 'light-slider' ); ?></th>
			<th><?php _e( 'Date Created', 'light-slider' ); ?></th>
			<th><?php _e( 'Last Modify', 'light-slider' ); ?></th>
			<th><?php _e( 'Actions', 'light-slider' ); ?></th>
		</tr>
		</tfoot>
	</table>
	<div class="sls-slider-list-actions">
		<a href="#create-new-slider" id="btn-create-new-slider" class="button button-primary"><?php esc_html_e( 'Create New Slider', 'light-slider' ); ?></a>
	</div>
</div>
<div id="dialog-create-new-slider" title="<?php esc_attr_e( 'Choose theme for new slider', 'light-slider' ); ?>">
	<a href="#"></a>
	<ul class="sls-theme-list">
		<?php foreach ( $themes as $theme ) : ?>
			<li class="sls-theme-item">
				<img src="<?php echo esc_url( $theme->get_thumbnail_url() ); ?>">
				<div class="sls-theme-item-info">
					<div class="sls-theme-item-buttons">
						<?php if ( $theme->get_preview_url() ) : ?>
							<a href="<?php echo esc_url( $theme->get_preview_url() ) ?>" target="_blank" rel="noopener"><?php esc_html_e( 'Preview', 'light-slider' ); ?></a> |
						<?php endif; ?>
						<a class="sls-theme-item-choose" href="<?php echo esc_url( add_query_arg( array( 'page' => $_GET['page'], 'action' => 'add', 'theme' => $theme->get_id() ) ) ) ?>"><?php esc_html_e( 'Choose', 'light-slider' ); ?></a>
					</div>
					<h4 class="sls-theme-item-info-name"><?php echo esc_html( $theme->get_name() ); ?></h4>
				</div>
			</li>
		<?php endforeach; ?>
	</ul>
</div>
<div id="sls-dialog-preview-slider">
	<iframe name="sls-frame-preview"></iframe>
</div>