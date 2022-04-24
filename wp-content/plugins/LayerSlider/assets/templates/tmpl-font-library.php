<?php defined( 'LS_ROOT_FILE' ) || exit; ?>
<div id="ls-google-fonts-modal-holder" class="ls-d-none">
	<div id="ls-google-fonts-modal-content">
		<kmw-h1 class="kmw-modal-title"><?= __('Font Library', 'LayerSlider') ?></kmw-h1>
		<div class="kmw-modal-toolbar">
			<div class="ls-gfonts-toolbar-cnt">
				<div class="ls-gfonts-search-bar ls-gfonts-toolbar-item">
					<input type="search" id="ls-gfonts-search" placeholder="<?= __('Search for font family...', 'LayerSlider') ?>">
					<?= lsGetSVGIcon('search',false,['class' => 'ls-gfonts-search-icon']) ?>
				</div>
				<div class="ls-gfonts-type-example ls-gfonts-toolbar-item">
					<input type="text" id="ls-gfonts-sentence-input" placeholder="<?= __('Example sentence...', 'LayerSlider') ?>">
				</div>
				<div class="ls-gfonts-size-adjust ls-gfonts-toolbar-item">
					<div class="ls-gfonts-current-size">
						35px
					</div>
					<div class="ls-gfonts-resize-slider">
						<input type="range" min="8" max="100" value="35" class= "ls-gfonts-resize-range" id="ls-gfonts-resize-range">
					</div>
				</div>
				<div class="ls-gfonts-language-settings ls-gfonts-toolbar-item">
					<?= lsGetSVGIcon('language',false,['class' => 'ls-gfonts-lang-icon']) ?>
					<select name="ls-gfonts-languages" id="ls-gfonts-languages-select">
						<option value="latin">Latin</option>
						<option value="latin-ext">Latin extended</option>
						<option value="arabic">Arabic</option>
						<option value="bengali">Bengali</option>
						<option value="chinese-hongkong">Chinese (Hong Kong)</option>
						<option value="chinese-traditional">Chinese (Traditional)</option>
						<option value="chinese-simplified">Chinese (Simplified)</option>
						<option value="cyrillic">Cyrillic</option>
						<option value="cyrillic-ext">Cyrillic extended</option>
						<option value="devanagari">Devanagari</option>
						<option value="greek">Greek</option>
						<option value="greek-ext">Greek extended</option>
						<option value="gujarati">Gujarati</option>
						<option value="gurmukhi">Gurmukhi</option>
						<option value="hebrew">Hebrew</option>
						<option value="japanese">Japanese</option>
						<option value="kannada">Kannada</option>
						<option value="khmer">Khmer</option>
						<option value="korean">Korean</option>
						<option value="malayalam">Malayalam</option>
						<option value="myanmar">Myanmar</option>
						<option value="oriya">Oriya</option>
						<option value="sinhala">Sinhala</option>
						<option value="tamil">Tamil</option>
						<option value="telugu">Telugu</option>
						<option value="thai">Thai</option>
						<option value="tibetan">Tibetan</option>
						<option value="vietnamese">Vietnamese</option>
					</select>
				</div>
				<div class="ls-gfonts-category-settings ls-gfonts-toolbar-item">
					<div class="ls-gfonts-categories-dropdown">
							<select name="ls-gfonts-categories" id="ls-gfonts-categories-select">
								<option value="all"><?= _x('All Categories', 'Font typeface', 'LayerSlider') ?></option>
							 	<option value="serif"><?= _x('Serif', 'Font typeface', 'LayerSlider') ?></option>
							 	<option value="sans-serif"><?= _x('Sans-Serif', 'Font typeface', 'LayerSlider') ?></option>
							 	<option value="display"><?= _x('Display', 'Font typeface', 'LayerSlider') ?></option>
							 	<option value="handwriting"><?= _x('Handwriting', 'Font typeface', 'LayerSlider') ?></option>
							 	<option value="monospace"><?= _x('Monospace', 'Font typeface', 'LayerSlider') ?></option>
							</select>
					</div>
				</div>
			</div>
			<div class="ls-gfonts-sort-cnt">
				<div class="ls-gfonts-family-counter">

				</div>
				<div class="ls-gfont-sort-dropdown">
					<div><?= __('Sort by:', 'LayerSlider') ?></div>
					<select name="ls-gfonts-sort" id="ls-gfonts-sort-select">
						<option value="trending"><?= __('Trending', 'LayerSlider') ?></option>
					 	<option value="popular"><?= __('Most popular', 'LayerSlider') ?></option>
					 	<option value="name"><?= __('Name (A-Z)', 'LayerSlider') ?></option>
					 	<option value="newest"><?= __('Newest', 'LayerSlider') ?></option>
					</select>
				</div>
			</div>
		</div>
		<div class="ls-gfonts-font-panels-cnt">
		</div>
		<div class="ls-gfonts-not-found ls--form-control">
				<div class="ls-gfonts-not-found-shruggie">
					¯\_(ツ)_/¯
				</div>
				<div class="ls-gfonts-not-found-text">
					<?= __('Can’t find any fonts. Try a different search term.', 'LayerSlider') ?>
				</div>
				<ls-button class="ls-gfonts-not-found-reset">
					<?= __('Reset search', 'LayerSlider') ?>
				</ls-button>
		</div>
	</div>
</div>