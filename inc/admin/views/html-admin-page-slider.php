<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="wrap light-slider">
	<?php if ( empty( $data['slider']['ID'] ) ) : ?>
		<h1><?php esc_html_e( 'Add New Slider', 'light-slider' ); ?></h1>
	<?php else : ?>
		<h1><?php echo esc_html( sprintf( __( 'Edit Slider #%d', 'light-slider' ), $data['slider']['ID'] ) ); ?></h1>
	<?php endif; ?>

	<div class="sls-tab-container">
		<ul class="sls-tabs">
			<li><a href="#slider-settings"><?php esc_html_e( 'Slider Settings', 'light-slider' ) ?></a></li>
			<li class="active"><a href="#slides"><?php esc_html_e( 'Slides', 'light-slider' ) ?></a></li>
		</ul>
		<div id="slider-settings" class="sls-tab-content">
			<div class="sls-group">
				<h2 class="sls-group-title"><?php esc_html_e( 'General Settings', 'light-slider' ); ?></h2>
				<div class="sls-group-content">
					<table class="form-table">
						<tbody>
						<tr>
							<th><label for="slider-name"><?php esc_html_e( 'Slider name', 'light-slider' ); ?></label></th>
							<td>
								<input data-option-id="slider.title" data-option-type="input" id="slider-name" type="text" class="regular-text">
							</td>
						</tr>
						<tr>
							<th><label for="slider-name"><?php esc_html_e( 'Slider layout', 'light-slider' ); ?></label></th>
							<td>
								<select name="" id="" data-option-id="slider.params.layout" data-option-type="select">
									<option value="boxed"><?php esc_html_e( 'Boxed', 'light-slider' ); ?></option>
									<option value="full-width"><?php esc_html_e( 'Full Width', 'light-slider' ); ?></option>
								</select>
							</td>
						</tr>
						<tr>
							<th>
								<label for="slider-width"><?php esc_html_e( 'Content Slider Width', 'light-slider' ); ?></label>
							</th>
							<td>
								<input id="slider-width" type="text" class="regular-text" data-option-id="slider.params.width" data-option-type="input">
							</td>
						</tr>
						<tr>
							<th><label for="slider-height"><?php esc_html_e( 'Slider height', 'light-slider' ); ?></label></th>
							<td>
								<input id="slider-height" type="text" class="regular-text" data-option-id="slider.params.height" data-option-type="input">
							</td>
						</tr>
						</tbody>
					</table>
				</div>
			</div>

			<div class="sls-group">
				<h2 class="sls-group-title"><?php esc_html_e( 'Appearance', 'light-slider' ); ?></h2>
				<div class="sls-group-content">
					<table class="form-table">
						<tbody>
						<tr>
							<th><label for="slider-background-image"><?php esc_html_e( 'Background Image', 'light-slider' ); ?></label></th>
							<td>
								<div data-option-id="slider.params.background_image" data-option-type="image">
									<input type="text" class="sls-option-input">
									<a href="#change-slide-image" class="button option-btn-change-image"><?php esc_html_e( 'Change Image', 'light-slider' ); ?></a>
									<a href="#clear-image" class="button option-btn-clear-image"><?php esc_html_e( 'Clear', 'light-slider' ); ?></a>
								</div>
							</td>
						</tr>
						<tr>
							<th><label for="slider-background-color"><?php esc_html_e( 'Background Color', 'light-slider' ); ?></label></th>
							<td>
								<input id="slider-background-color" type="text" class="regular-text" data-option-id="slider.params.background_color" data-option-type="color">
							</td>
						</tr>
						</tbody>
					</table>
				</div>
			</div>

			<div class="sls-group">
				<h2 class="sls-group-title"><?php esc_html_e( 'Navigation', 'light-slider' ); ?></h2>
				<div class="sls-group-content">
					<table class="form-table">
						<tbody>
						<tr>
							<th><?php esc_html_e( 'Enable Autoplay', 'light-slider' ); ?></th>
							<td>
								<fieldset>
									<label>
										<input type="checkbox" value="yes" data-option-id="slider.params.enable_autoplay" data-option-type="input">
									</label>
								</fieldset>
							</td>
						</tr>
						<tr>
							<th><?php esc_html_e( 'Autoplay Delay', 'light-slider' ); ?></th>
							<td>
								<input type="text" class="regular-text" data-option-id="slider.params.autoplay_delay" data-option-type="input">
							</td>
						</tr>
						<tr>
							<th><?php esc_html_e( 'Autoplay Pause On Hover', 'light-slider' ); ?></th>
							<td>
								<fieldset>
									<label>
										<input type="checkbox" data-option-id="slider.params.autoplay_pause_on_hover" data-option-type="input">
									</label>
								</fieldset>
							</td>
						</tr>
						<tr>
							<th><?php esc_html_e( 'Show Navigation Arrows', 'light-slider' ); ?></th>
							<td>
								<fieldset>
									<label>
										<input type="checkbox" data-option-id="slider.params.navigation_arrows" data-option-type="input">
									</label>
								</fieldset>
							</td>
						</tr>
						<tr>
							<th><?php esc_html_e( 'Show Navigation Pagination', 'light-slider' ); ?></th>
							<td>
								<fieldset>
									<label>
										<input type="checkbox" data-option-id="slider.params.show_pagination" data-option-type="input">
									</label>
								</fieldset>
							</td>
						</tr>
						</tbody>
					</table>
				</div>
			</div>

			<div class="sls-group">
				<h2 class="sls-group-title"><?php esc_html_e( 'Miscellaneous', 'light-slider' ); ?></h2>
				<div class="sls-group-content">
					<table class="form-table">
						<tbody>
						<tr>
							<th><?php esc_html_e( 'Custom CSS Class', 'light-slider' ); ?></th>
							<td>
								<input type="text" class="regular-text" data-option-id="slider.params.custom_css_class" data-option-type="input">
							</td>
						</tr>
						<tr>
							<th><?php esc_html_e( 'Custom CSS', 'light-slider' ); ?></th>
							<td>
								<textarea cols="30" rows="10" data-option-id="slider.params.custom_css" data-option-type="textarea"></textarea>
							</td>
						</tr>
					</table>
				</div>
			</div>

		</div>
		<div id="slides" class="sls-tab-content">
			<div id="sls-slide-list" class="sls-group">
				<h2 class="sls-group-title"><?php echo esc_html_e( 'Slides', 'light-slider' ); ?></h2>
				<div class="sls-group-content">
					<p><?php esc_html_e( 'Drag & drop to sort slides' ) ?></p>

					<ul class="sls-slides-list">
					</ul>
					<a href="#add-slide" class="button button-primary sls-btn-add-image-slide"><?php esc_html_e( 'Add Slide', 'light-slider' ); ?></a>
				</div>
			</div>
			<div id="sls-slide-editor-container" class="sls-group">
				<div class="sls-group-content">
					<div class="sls-slide-container">
						<div class="sls-slide-layer-container">
							<h3><?php esc_html_e( 'Slide Options', 'light-slider' ); ?></h3>
							<ul id="sls-slide-option-container" class="sls-slide-option-list">
								<?php if ( ! empty( $data['element_styles']['layout'] ) ) : ?>
								<li class="sls-slide-option-item">
									<label class="sls-option-label"><?php esc_html_e( 'Layout', 'light-slider' ); ?></label>
									<select class="sls-option-input" data-option-id="currentSlide.params.layout" data-option-type="select">
										<?php foreach ( $data['element_styles']['layout'] as $element_style_value => $element_style ) : ?>
											<option value="<?php echo esc_attr( $element_style_value ); ?>"><?php echo esc_html( $element_style ) ?></option>
										<?php endforeach; ?>
									</select>
								</li>
								<?php endif; ?>
								<li class="sls-slide-option-item">
									<label class="sls-option-label"><?php esc_html_e( 'Background Image', 'light-slider' ); ?></label>
									<div data-option-id="currentSlide.params.background_image" data-option-type="image">
										<input type="text" class="sls-option-input">
										<a href="#change-slide-image" class="button option-btn-change-image"><?php esc_html_e( 'Change Image', 'light-slider' ); ?></a>
										<a href="#clear-image" class="button option-btn-clear-image"><?php esc_html_e( 'Clear', 'light-slider' ); ?></a>
									</div>
								</li>
								<li class="sls-slide-option-item">
									<label class="sls-option-label"><?php esc_html_e( 'Background Color', 'light-slider' ); ?></label>
									<input type="text" class="sls-option-input-color-picker" data-option-id="currentSlide.params.background_color" data-option-type="color">
								</li>
							</ul>

							<h3><?php esc_html_e( 'Layers', 'light-slider' ); ?></h3>
							<?php if ( ! empty( $data['theme_data']['slide']['layers'] ) ) : ?>
							<ul id="sls-layer-list" class="sls-layer-list">
								<?php foreach ( $data['theme_data']['slide']['layers'] as $layer ) : ?>
									<li class="sls-slide-option-item">
									<label class="sls-option-label"><?php echo esc_html( $layer['name'] ); ?></label>
									<?php if ( 'caption' == $layer['type'] ) : ?>
										<textarea class="sls-option-input" data-option-id="currentSlide.layers.<?php echo esc_attr( $layer['id'] ); ?>.content" data-option-type="textarea"></textarea>
										<?php if ( ! empty( $data['element_styles']['caption'] ) ) : ?>
											<select class="sls-option-input" data-option-id="currentSlide.layers.<?php echo esc_attr( $layer['id'] ); ?>.style" data-option-type="select">
												<?php foreach ( $data['element_styles']['caption'] as $element_style_value => $element_style ) : ?>
													<option value="<?php echo esc_attr( $element_style_value ); ?>"><?php echo esc_html( $element_style ) ?></option>
												<?php endforeach; ?>
											</select>
										<?php endif; ?>
									<?php elseif ( 'description' == $layer['type'] ) : ?>
										<textarea class="sls-option-input" data-option-id="currentSlide.layers.<?php echo esc_attr( $layer['id'] ); ?>.content" data-option-type="textarea"></textarea>
										<?php if ( ! empty( $data['element_styles']['description'] ) ) : ?>
											<select class="sls-option-input" data-option-id="currentSlide.layers.<?php echo esc_attr( $layer['id'] ); ?>.style" data-option-type="select">
												<?php foreach ( $data['element_styles']['description'] as $element_style_value => $element_style ) : ?>
													<option value="<?php echo esc_attr( $element_style_value ); ?>"><?php echo esc_html( $element_style ) ?></option>
												<?php endforeach; ?>
											</select>
										<?php endif; ?>
									<?php elseif ( 'image' == $layer['type'] ) : ?>
										<div data-option-id="currentSlide.layers.<?php echo esc_attr( $layer['id'] ); ?>.url" data-option-type="image">
											<input type="text" class="sls-option-input">
											<a href="#change-slide-image" class="button option-btn-change-image"><?php esc_html_e( 'Change Image', 'light-slider' ); ?></a>
											<a href="#clear-image" class="button option-btn-clear-image"><?php esc_html_e( 'Clear', 'light-slider' ); ?></a>
										</div>
										<?php if ( ! empty( $data['element_styles']['image'] ) ) : ?>
											<select class="sls-option-input" data-option-id="currentSlide.layers.<?php echo esc_attr( $layer['id'] ); ?>.style" data-option-type="select">
												<?php foreach ( $data['element_styles']['image'] as $element_style_value => $element_style ) : ?>
													<option value="<?php echo esc_attr( $element_style_value ); ?>"><?php echo esc_html( $element_style ) ?></option>
												<?php endforeach; ?>
											</select>
										<?php endif; ?>
									<?php elseif ( 'button' == $layer['type'] ) : ?>
										<input type="text" class="sls-option-input" data-option-id="currentSlide.layers.<?php echo esc_attr( $layer['id'] ); ?>.content" data-option-type="input">
										<input type="text" class="sls-option-input" data-option-id="currentSlide.layers.<?php echo esc_attr( $layer['id'] ); ?>.url" data-option-type="input">
										<?php if ( ! empty( $data['element_styles']['button'] ) ) : ?>
											<select class="sls-option-input" data-option-id="currentSlide.layers.<?php echo esc_attr( $layer['id'] ); ?>.style" data-option-type="select">
												<?php foreach ( $data['element_styles']['button'] as $element_style_value => $element_style ) : ?>
													<option value="<?php echo esc_attr( $element_style_value ); ?>"><?php echo esc_html( $element_style ) ?></option>
												<?php endforeach; ?>
											</select>
										<?php endif; ?>
									<?php endif; ?>
									</li>
								<?php endforeach; ?>
							</ul>
							<?php endif; ?>
						</div>
						<div class="sls-slide-preview">
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="sls-slider-action-placeholder"></div>
	<div class="sls-slider-action-container">
		<a href="#preview" class="button button-preview-slider"><?php esc_html_e( 'Preview', 'Light Slider' ); ?></a>
		<a href="#submit" class="button button-primary button-save-slider"><?php esc_html_e( 'Save', 'Light Slider' ); ?></a>
		<span class="spinner"></span>
	</div>
</div>
<form id="sls-form-preview-slider" target="sls-frame-preview" action="<?php echo esc_url( add_query_arg( array( 'page' => $_GET['page'], 'action' => 'preview', 'nonce' => wp_create_nonce( 'sls_preview_slider_nonce' ) ) ) ); ?>" method="post" >
</form>
<div id="sls-dialog-preview-slider">
	<iframe name="sls-frame-preview"></iframe>
</div>
<script type="text/html" id="tmpl-slide-item">
	<# styleAttributes = [] #>
	<# if (data.slide.params && data.slide.params.background_image) styleAttributes.push("background-image: url('"+ data.slide.params.background_image +"')") #>
	<# if (data.slide.params && data.slide.params.background_color) styleAttributes.push("background-color: "+ data.slide.params.background_color) #>
	<li class="sls-slide-item" data-slide-index="{{ data.slideIndex }}" style="{{ styleAttributes.join(';') }}">
		<div class="sls-slide-info">
			<a href="#toggle-visibility" class="sls-slide-toggle-visibility" title="<?php esc_attr_e( 'Show/Hide Slide', 'light-slider' ) ?>"><span class="dashicons dashicons-visibility"></span></a>
			<a href="#duplicate" class="sls-slide-duplicate" title="<?php esc_attr_e( 'Duplicate Slide', 'light-slider' ) ?>"><span class="dashicons dashicons-welcome-add-page"></span></a>
			<a href="#remove" class="sls-slide-remove" title="<?php esc_attr_e( 'Remove Slide', 'light-slider' ) ?>"><span class="dashicons dashicons-trash"></span></a>
		</div>
	</li>
</script>
<script type="text/html" id="tmpl-slide-preview">
	<?php include( $data['slide_template'] ); ?>
</script>
<script>
	var slsData = <?php echo json_encode($data); ?>;
</script>