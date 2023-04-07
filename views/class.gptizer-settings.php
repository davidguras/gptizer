<div class="wrap">
	<h1><?= esc_html( get_admin_page_title() ) ?></h1>
	<form action="options.php" method="post">
		<?php
		settings_fields( 'gptizer_group' );
		do_settings_sections( 'gptizer_page1' );
		do_settings_sections( 'gptizer_page2' );
		submit_button( 'Save Settings' );
		?>
	</form>
</div>