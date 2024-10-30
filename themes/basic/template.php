<?php
if ( ! empty( $slider['params']['custom_css'] ) ) {
	echo '<style>' . $slider['params']['custom_css'] . '</style>';
}
?>
<style>
	#sls-slider-<?php echo esc_html( $slider['ID'] ); ?> {
		<?php if ( 'boxed' == $slider['params']['layout'] ) : ?>
			width: <?php echo esc_html( $slider['params']['width'] ); ?>;
		<?php elseif ('full-width' == $slider['params']['layout']) : ?>
			max-width: none;
		<?php endif; ?>

		height: <?php echo esc_html( $slider['params']['height'] ); ?>;

		<?php if ( ! empty( $slider['params']['background_image'] ) ) : ?>
			background-image: url('<?php echo esc_url( $slider['params']['background_image'] ); ?>');
		<?php endif; ?>

		<?php if ( ! empty( $slider['params']['background_color'] ) ) : ?>
			background-color: <?php echo esc_html( $slider['params']['background_color'] ); ?>;
		<?php endif; ?>
	}
</style>
<div id="sls-slider-<?php echo esc_attr( $slider['ID'] ); ?>" class="seq sls-slider <?php echo ! empty( $slider['params']['custom_css_class'] ) ? esc_attr( $slider['params']['custom_css_class'] ) : ''; ?>">
	<div class="seq-screen">
		<ul class="seq-canvas">
			<?php foreach ( $slides as $slide ) : ?>
				<li class="sls-slide" style="<?php echo ! empty( $slide['params']['background_image'] ) ? "background-image: url('". esc_url( $slide['params']['background_image'] ) ."')" : ''; ?>">
					<div class="seq-content">
						<div data-seq class="seq-title"><?php echo wp_kses_post( $slide['layers']['caption']['content'] ); ?></div>
					</div>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
	<?php if ( ! empty( $slider['params']['show_pagination'] ) && 'yes' == $slider['params']['show_pagination'] ) : ?>
		<div rel="sls-slider-<?php echo esc_attr( $slider['ID'] ); ?>" class="seq-pagination" role="navigation" aria-label="Pagination">
			<?php foreach ( $slides as $slide ) : ?>
				<a class="sls-pagination-button"></a>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>
	<?php if ( ! empty( $slider['params']['navigation_arrows'] ) && 'yes' == $slider['params']['navigation_arrows'] ) : ?>
		<fieldset class="seq-nav" aria-controls="sequence" aria-label="<?php esc_attr_e( 'Slider buttons', 'light-slider' ); ?>">
			<button type="button" class="seq-prev" aria-label="<?php esc_attr_e( 'Previous', 'light-slider' ); ?>"></button>
			<button type="button" class="seq-next" aria-label="<?php esc_attr_e( 'Next', 'light-slider' ); ?>"></button>
		</fieldset>
	<?php endif; ?>
</div>
<script>
	jQuery(document).ready(function () {
		var sequenceElement = document.querySelector('#sls-slider-<?php echo esc_attr( $slider['ID'] ); ?>');

		var options = {
			<?php if ( ! empty( $slider['params']['enable_autoplay'] ) ): ?>
			autoPlay: true,
			autoPlayInterval: <?php echo esc_js( $slider['params']['autoplay_delay'] ); ?>,
			<?php if ( empty( $slider['params']['autoplay_pause_on_hover'] ) ) : ?>
			autoPlayPauseOnHover: false,
			<?php endif; ?>
			<?php endif; ?>
			startingStepAnimatesIn: true,
			phaseThreshold: 250,
			preloader: true,
			reverseWhenNavigatingBackwards: false,
			fadeStepWhenSkipped: false
		};

		var mySequence = sequence(sequenceElement, options);
	});
</script>