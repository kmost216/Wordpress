<?php defined( 'LS_ROOT_FILE' ) || exit; ?>

<lse-b class="lse-dn">

	<lse-b id="tmpl-embed-project-sidebar">

		<lse-b class="kmw-sidebar-title">
			<?= __('Embed Projects', 'LayerSlider') ?>
		</lse-b>

		<kmw-navigation class="km-tabs-list" data-target="#lse-embed-project-tabs">

			<kmw-menuitem class="kmw-active">
				<kmw-menutext><?= __('Shortcode', 'LayerSlider') ?></kmw-menutext>
			</kmw-menuitem>

			<kmw-menuitem>
				<kmw-menutext><?= __('Gutenberg', 'LayerSlider') ?></kmw-menutext>
			</kmw-menuitem>

			<kmw-menuitem>
				<kmw-menutext><?= __('Widget', 'LayerSlider') ?></kmw-menutext>
			</kmw-menuitem>

			<kmw-menuitem>
				<kmw-menutext><?= __('Page Builders', 'LayerSlider') ?></kmw-menutext>
			</kmw-menuitem>

			<kmw-menuitem>
				<kmw-menutext><?= __('PHP Function', 'LayerSlider') ?></kmw-menutext>
			</kmw-menuitem>

		</kmw-navigation>

	</lse-b>

	<lse-b id="tmpl-embed-project" class="lse-common-modal-style">

		<kmw-h1 class="kmw-modal-title">
			<?= __('Shortcode', 'LayerSlider') ?>
		</kmw-h1>

		<!-- 		<lse-p><?php printf( __('There are a number of ways you can include LayerSlider projects to your posts and pages. Please review the available methods below or refer to our %sonline documentation%s for more information.', 'LayerSlider'), '<a href="https://layerslider.com/documentation/#publishing-sliders" target="_blank">', '</a>') ?></lse-p>
 		-->
		<lse-b id="lse-embed-project-tabs" class="km-tabs-content">

			<lse-b class="kmw-active">

				<lse-ib class="lse-difficulity lse-easy">
					<lse-text><?= __('Easy', 'LayerSlider') ?></lse-text>
					<?= lsGetSVGIcon('check',false,['class' => 'lse-it-fix']) ?>
				</lse-ib>

				<lse-p>
					<?php printf( __('Shortcodes are small text snippets that will be replaced with the actual content on your front-end pages. This is one of the most commonly used methods. It works almost all places where you can enter text, including 3rd party page builders. Just copy and paste the following shortcode: %s', 'LayerSlider'), '<input class="lse-shortcode" value="[layerslider id=&quot;1&quot;]" onclick="this.focus(); this.select();">') ?>
				</lse-p>

				<lse-p class="lse-tar">
					<a class="lse-button" href="https://layerslider.com/documentation/#publish-shortcode" target="_blank">
						<?= lsGetSVGIcon('external-link-alt') ?>
						<lse-text><?= __('Learn more', 'LayerSlider') ?></lse-text>
					</a>
				</lse-p>

			</lse-b>

			<lse-b>

				<lse-ib class="lse-difficulity lse-easy">
					<lse-text><?= __('Easy', 'LayerSlider') ?></lse-text>
					<?= lsGetSVGIcon('check',false,['class' => 'lse-it-fix']) ?>
				</lse-ib>

				<lse-p>
					<?php printf( __('The new WordPress editing experience is here and LayerSlider provides a full-fledged Gutenberg block for your convenience. Just press the + sign in the new WordPress page / post editor and select the LayerSlider block. The rest is self-explanatory, but we also have a %svideo tutorial%s if you are new to Gutenberg.', 'LayerSlider'), '<a href="https://youtu.be/ArzG3Pr2UF4" target="_blank">', '</a>') ?>
				</lse-p>

				<lse-p class="lse-tar">
					<a class="lse-button" href="https://layerslider.com/documentation/#publish-gutenberg" target="_blank">
						<?= lsGetSVGIcon('external-link-alt') ?>
						<lse-text><?= __('Learn more', 'LayerSlider') ?></lse-text>
					</a>
				</lse-p>

			</lse-b>

			<lse-b>

				<lse-ib class="lse-difficulity lse-easy">
					<lse-text><?= __('Easy', 'LayerSlider') ?></lse-text>
					<?= lsGetSVGIcon('check',false,['class' => 'lse-it-fix']) ?>
				</lse-ib>

				<lse-p>
					<?php printf( __('Widgets can provide a super easy drag and drop way of sharing your projects when it comes to embedding content to a commonly used part on your site like the header area, sidebar or the footer. However, the available widget areas are controlled by your theme and it might not offer the perfect spot that you’re looking for. Just head to %sAppearance → Widgets%s to see the options your theme offers.', 'LayerSlider'), '<a href="'.admin_url('widgets.php').'" target="_blank">', '</a>') ?>
				</lse-p>

				<lse-p class="lse-tar">
					<a class="lse-button" href="https://layerslider.com/documentation/#publish-widgets" target="_blank">
						<?= lsGetSVGIcon('external-link-alt') ?>
						<lse-text><?= __('Learn more', 'LayerSlider') ?></lse-text>
					</a>
				</lse-p>

			</lse-b>

			<lse-b>

				<lse-ib class="lse-difficulity lse-easy">
					<lse-text><?= __('Easy', 'LayerSlider') ?></lse-text>
					<?= lsGetSVGIcon('check',false,['class' => 'lse-it-fix']) ?>
				</lse-ib>

				<lse-p>
					<?= __('Most page builders support LayerSlider out of the box. Popular plugins like <b>Visual Composer</b> or <b>Elementor</b> has dedicated options to embed projects. Even if there’s no LayerSlider specific option, shortcodes and widgets are widely supported and can be relied upon in almost all cases. In general, wherever you can insert text or widgets, it can also be used to embed LayerSlider content.', 'LayerSlider') ?>
				</lse-p>

				<lse-p class="lse-tar">
					<a class="lse-button" href="https://layerslider.com/documentation/#publish-page-builders" target="_blank">
						<?= lsGetSVGIcon('external-link-alt') ?>
						<lse-text><?= __('Learn more', 'LayerSlider') ?></lse-text>
					</a>
				</lse-p>

			</lse-b>

			<lse-b>

				<lse-ib class="lse-difficulity lse-advanced">
					<lse-text><?= __('Advanced', 'LayerSlider') ?></lse-text>
					<?= lsGetSVGIcon('exclamation-triangle',false,['class' => 'lse-it-fix']) ?>
				</lse-ib>

				<lse-p><?= __('You can use the layerslider() PHP function to insert projects by editing your theme’s template files. Since you can implement custom logic in code, this option gives you unlimited control on how your projects are embedded.', 'LayerSlider') ?></lse-p>
				<lse-p><?= __('However, this approach require programming skills, thus we cannot recommend it to users lacking the necessary experience in web development.', 'LayerSlider') ?></lse-p>

				<lse-p class="lse-tar">
					<a class="lse-button" href="https://layerslider.com/documentation/#publish-php" target="_blank">
						<?= lsGetSVGIcon('external-link-alt') ?>
						<lse-text><?= __('Learn more', 'LayerSlider') ?></lse-text>
					</a>
				</lse-p>

			</lse-b>

		</lse-b>

	</lse-b>

</lse-b>