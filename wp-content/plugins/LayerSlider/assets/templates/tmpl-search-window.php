<?php

// Prevent direct file access
defined( 'LS_ROOT_FILE' ) || exit;

?>

<!-- Search Window -->
<div id="lse-search-window">

	<div class="lse-search-bar">
		<?= lsGetSVGIcon('search', 'regular') ?>
		<input type="text" placeholder="<?= __('Type to search', 'LayerSlider') ?>">
		<div class="lse-search-no-match-title"><?= __('No Results Found', 'LayerSlider') ?></div>
	</div>

	<div class="lse-search-results lse-scrollbar lse-scrollbar-light">
		<div class="lse-search-results-inner"></div>
	</div>

	<div class="lse-search-no-match">
		<div class="lse-search-no-match-desc"><?= __('Oops, we didn’t think about that, apparently. We’ll keep adding new features and making the overall search experience better with future updates. In the meantime, try searching for synonyms and alternative terms.', 'LayerSlider') ?></div>
	</div>

	<div class="lse-search-highlights-wrapper">
		<div class="lse-search-heading"><?= __('Suggestions', 'LayerSlider') ?></div>
		<div class="lse-search-highlights">

			<div class="lse-search-highlight" data-search-action="interfaceSettings">
				<?= lsGetSVGIcon('cog') ?>
				<div class="lse-search-highlight-text">
					<?= __('Interface Settings', 'LayerSlider') ?>
				</div>
			</div>

			<div class="lse-search-highlight" data-search-action="interactiveGuides">
				<?= lsGetSVGIcon('book') ?>
				<div class="lse-search-highlight-text">
					<?= __('Interactive Guides', 'LayerSlider') ?>
				</div>
			</div>

			<div class="lse-search-highlight" data-search-action="howToEmbed">
				<?= lsGetSVGIcon('plus') ?>
				<div class="lse-search-highlight-text">
					<?= __('How To Embed', 'LayerSlider') ?>
				</div>
			</div>

			<div class="lse-search-highlight" data-search-action="getHelp">
				<?= lsGetSVGIcon('question-circle') ?>
				<div class="lse-search-highlight-text">
					<?= __('Get Help', 'LayerSlider') ?>
				</div>
			</div>

			<div class="lse-search-highlight" data-search-action="moreMenu">
				<?= lsGetSVGIcon('ellipsis-v') ?>
				<div class="ls-search-highlight-text">
					<?= __('More', 'LayerSlider') ?>
				</div>
			</div>
		</div>
	</div>
</div>