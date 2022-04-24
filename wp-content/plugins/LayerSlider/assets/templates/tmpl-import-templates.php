<?php

// Prevent direct file access
defined( 'LS_ROOT_FILE' ) || exit;

$demoSliders = LS_Sources::getDemoSliders();

?>
<script type="text/javascript">
	window.lsImportNonce = '<?= wp_create_nonce('ls-import-demos'); ?>';
</script>
<script type="text/html" id="tmpl-import-sliders">
	<div id="ls-import-modal-window" class="<?= $lsStoreHasUpdate ? 'has-updates' : '' ?>">
		<header class="header">

			<img src="<?= LS_ROOT_URL.'/static/admin/img/ls-logo.png' ?>" alt="LayerSlider Logo" class="ls-logo">

			<h1>
				<?= __('LayerSlider Templates', 'LayerSlider') ?>
			</h1>

			<div class="last-update">
				<strong><?= __('Last updated: ', 'LayerSlider') ?></strong>
				<span>
					<?php

						if( time() - 15 > (int) LS_RemoteData::lastUpdated() ) {
							echo human_time_diff( LS_RemoteData::lastUpdated() ), __(' ago', 'LayerSlider');
						} else {
							_e('Just now', 'LayerSlider');
						}
					?>
				</span>
				<a title="<?= __('Force Library Update', 'LayerSlider') ?>"href="<?= wp_nonce_url( admin_url('admin.php?page=layerslider&action=update_store'), 'update_store') ?>" class="refresh-btn"><?= lsGetSVGIcon('sync-alt'); ?></a>
			</div>
 			<b class="modal-close-btn dashicons dashicons-no"></b>
		</header>

		<!-- SLIDERS -->
		<div class="ls-templates-holder inner sliders active">
			<nav class="templates-sidemenu">
				<ul class="content-filter">
					<li data-index="0" class="active">
						<?= lsGetSVGIcon('layer-group'); ?>
						<?= __('SLIDERS', 'LayerSlider') ?>
					</li>
					<li data-index="1">
						<?= lsGetSVGIcon('window-maximize', 'regular'); ?>
						<?= __('POPUPS', 'LayerSlider') ?>
					</li>
				</ul>


				<div class="separator"></div>


				<h5><?= __('Categories', 'LayerSlider') ?></h5>
				<ul class="shuffle-filters">
					<li class="active">
						<?= lsGetSVGIcon('tags'); ?>
						<?= __('All', 'LayerSlider') ?>
					</li>

					<?php if( count($demoSliders) ) : ?>
					<li data-group="bundled">
						<?= lsGetSVGIcon('file-archive'); ?>
						<?= __('Bundled', 'LayerSlider') ?>
					</li>
					<?php endif; ?>

					<li data-group="slider">
						<?= lsGetSVGIcon('sort', null, ['class' => 'ls-sort-icon']); ?>
						<?= __('Slider', 'LayerSlider') ?>
					</li>

					<li data-group="landing">
						<?= lsGetSVGIcon('desktop'); ?>
						<?= __('Hero Scene', 'LayerSlider') ?>
					</li>

					<li data-group="website">
						<?= lsGetSVGIcon('globe-americas'); ?>
						<?= __('Website', 'LayerSlider') ?>
					</li>

					<li data-group="specialeffects">
						<?= lsGetSVGIcon('snowflake'); ?>
						<?= __('Special Effects', 'LayerSlider') ?>
					</li>

					<li data-group="addons">
						<?= lsGetSVGIcon('puzzle-piece'); ?>
						<?= __('Add-Ons', 'LayerSlider') ?>
					</li>
				</ul>

				<?php if( ! LS_Config::isActivatedSite() ) : ?>
				<h5><?= __('Filter', 'LayerSlider') ?></h5>
				<ul class="shuffle-filters">
					<li class="active">
						<?= lsGetSVGIcon('tags'); ?>
						<?= __('All', 'LayerSlider') ?>
					</li>
					<li data-group="free">
						<?= lsGetSVGIcon('gift'); ?>
						<?= __('Free', 'LayerSlider') ?>
					</li>
					<li data-group="premium">
						<?= lsGetSVGIcon('star'); ?>
						<?= __('Premium', 'LayerSlider') ?>
					</li>
				</ul>
				<?php endif ?>
			</nav>

			<div class="items ls-template-items">
				<?php
					if( ! empty($lsStoreData) && ! empty($lsStoreData['sliders']) ) {
						$demoSliders = array_merge($demoSliders, $lsStoreData['sliders']);
					}
					$now = time();
					foreach($demoSliders as $handle => $item) :

						if( ! empty( $item['popup'] ) ) { continue; }
				?>
				<figure class="item" data-name="<?= $item['name'] ?>" data-groups="<?= $item['groups'] ?>" data-handle="<?= $handle; ?>" data-bundled="<?= ! empty($item['bundled']) ? 'true' : 'false' ?>" data-premium="<?= ( ! empty($item['premium']) ) ? 'true' : 'false' ?>" data-version-warning="<?= version_compare($item['requires'], LS_PLUGIN_VERSION, '>') ? 'true' : 'false' ?>">
					<div class="aspect">
						<div class="item-picture" style="background: url(<?= $item['preview'] ?>);">
						</div>
						<figcaption>
							<h5>
								<?= $item['name'] ?>
								<span>By <?= ! empty( $item['info']['author'] ) ? $item['info']['author'] : 'Kreatura' ?> </span>
							</h5>
						</figcaption>
						<div class="item-action item-preview">
							<a target="_blank" href="<?= ! empty($item['url']) ? $item['url'] : '#' ?>" >
								<?= lsGetSVGIcon('search') ?><?= __('preview', 'LayerSlider') ?>
							</a>
						</div>
						<div class="item-action item-import">
							<a href="#">
								<?= lsGetSVGIcon('download') ?><?= __('import', 'LayerSlider') ?>
							</a>
						</div>

						<?php if( ! empty( $item['released'] ) ) : ?>
							<?php if( strtotime($item['released']) + MONTH_IN_SECONDS > $now ) :  ?>
							<span class="badge-new"><?php _ex('NEW', 'Template Store', 'LayerSlider') ?>
							<?php endif ?>
						<?php endif ?>
					</div>
				</figure>
				<?php endforeach ?>
			</div>
		</div>















		<!-- KREATURA POPUPS -->
		<div class="ls-templates-holder inner popups">
			<nav class="templates-sidemenu">

				<ul class="content-filter">
					<li data-index="0">
						<?= lsGetSVGIcon('layer-group'); ?>
						<?= __('SLIDERS', 'LayerSlider') ?>
					</li>
					<li data-index="1" class="active">
						<?= lsGetSVGIcon('window-maximize', 'regular'); ?>
						<?= __('POPUPS', 'LayerSlider') ?>
					</li>
				</ul>

				<div class="separator"></div>

				<h5><?= __('Sources', 'LayerSlider') ?></h5>
				<ul class="source-filter">
					<li data-index="1" class="active">
						<img src="<?= LS_ROOT_URL.'/static/admin/img/kreatura-logo-red.png' ?>" alt="Kreatura logo">
						<?= __('Kreatura', 'LayerSlider') ?>
					</li>
					<li data-index="2">
						<img src="<?= LS_ROOT_URL.'/static/admin/img/webshopworks-logo-red.png' ?>" alt="WebshopWorks logo">
						<?= __('WebshopWorks', 'LayerSlider') ?>
					</li>
				</ul>


			</nav>

			<div class="items ls-template-items">
				<?php if( ! empty( $lsStoreData['kreatura-popups'] ) ) : ?>
				<?php foreach( $lsStoreData['kreatura-popups'] as $handle => $item) : ?>
				<figure class="item" data-collection="kreatura-popups" data-name="<?= $item['name'] ?>" data-groups="<?= $item['groups'] ?>" data-handle="<?= $handle; ?>" data-bundled="<?= ! empty($item['bundled']) ? 'true' : 'false' ?>" data-premium="<?= ( ! empty($item['premium']) ) ? 'true' : 'false' ?>" data-version-warning="<?= version_compare($item['requires'], LS_PLUGIN_VERSION, '>') ? 'true' : 'false' ?>">
					<div class="aspect">
						<div class="item-picture" style="background: url(<?= $item['preview'] ?>);">
						</div>
						<figcaption>
							<h5>
								<?= $item['name'] ?>
								<span>By Kreatura</span>
							</h5>
						</figcaption>
						<div class="item-action item-preview">
							<a target="_blank" href="<?= ! empty($item['url']) ? $item['url'] : '#' ?>" >
								<?= lsGetSVGIcon('search') ?><?= __('preview', 'LayerSlider') ?>
							</a>
						</div>
						<div class="item-action item-import">
							<a href="#">
								<?= lsGetSVGIcon('download') ?><?= __('import', 'LayerSlider') ?>
							</a>
						</div>

						<?php if( ! empty( $item['released'] ) ) : ?>
							<?php if( strtotime($item['released']) + MONTH_IN_SECONDS > $now ) :  ?>
							<span class="badge-new"><?php _ex('NEW', 'Template Store', 'LayerSlider') ?>
							<?php endif ?>
						<?php endif ?>
					</div>
				</figure>
				<?php endforeach ?>
				<?php endif ?>
			</div>

			<!-- Looking for more? slider HTML markup -->
			<div style="width: 100%; overflow: hidden;">
				<div id="popups-looking-for-more" style="width:900px;height:500px;max-width:800px;margin:0 auto;margin-bottom: 100px;">


					<!-- Slide 1-->
					<div class="ls-slide" data-ls="globalhover:true; overflow:true; kenburnsscale:1.2; parallaxevent:scroll; parallaxdurationmove:300; parallaxdistance:5;">
						<img width="900" height="500" src="<?= LS_ROOT_URL ?>/static/admin/img/ls-slider-296-slide-1.jpg" class="ls-tn" alt="" />
						<div style="box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.08); border-radius: 1rem !important;top:100%; left:0px; background-size:inherit; background-position:inherit; font-size:18px; width:100%; height:70%; background-color:#ffffff;" class="ls-l"></div>
						<img width="447" height="297" src="<?= LS_ROOT_URL ?>/static/admin/img/surprise-box.png" class="ls-l" alt="" style="top:239px; left:611px; background-size:inherit; background-position:inherit; width:288px; height:191px;" data-ls="offsetyin:50; durationin:2000; easingin:easeOutQuint; loopstartat:transitioninstart ;">
						<img width="731" height="365" src="<?= LS_ROOT_URL ?>/static/admin/img/papers-far.png" class="ls-l" alt="" style="top:52px; left:539px; background-size:inherit; background-position:inherit; width:471px; height:235px;" data-ls="offsetyin:75; durationin:2000; easingin:easeOutQuint; scalexin:.5; scaleyin:.5; loop:true; loopoffsety:-10; loopduration:10000; loopstartat:transitioninstart ; loopeasing:easeInOutSine; looprotate:5; loopscalex:1.05; loopscaley:1.05; loopcount:-1; loopyoyo:true;">
						<p style="top:298px; left:42px; text-align:initial; font-weight:700; font-style:normal; text-decoration:none; mix-blend-mode:normal; color:#ff5f5a; font-family:Poppins; letter-spacing:0px; line-height:falsepx; font-size:67px;" class="ls-l" data-ls="offsetyin:40; durationin:2000; delayin:500; easingin:easeOutQuint; offsetyout:100; easingout:easeInQuint;">WebshopWorks</p>
						<p style="top:291px; left:306px; text-align:initial; font-weight:400; font-style:normal; text-decoration:none; mix-blend-mode:normal; color:#ff5f5a; font-family:Caveat; font-size:36px; letter-spacing:0px;" class="ls-l" data-ls="offsetyin:60; durationin:2000; delayin:500; easingin:easeOutQuint; offsetyout:80; easingout:easeInQuint;">from</p>
						<p style="top:254px; left:43px; text-align:initial; font-weight:300; font-style:normal; text-decoration:none; mix-blend-mode:normal; color:#ff5f5a; font-family:Poppins; font-size:36px; letter-spacing:0px;" class="ls-l" data-ls="offsetyin:80; durationin:2000; delayin:500; easingin:easeOutQuint; offsetyout:60; easingout:easeInQuint;">Premium Popup Template Pack</p>
						<p style="top:172px; left:40px; text-align:initial; font-weight:700; font-style:normal; text-decoration:none; mix-blend-mode:normal; color:#21d4da; font-family:Lobster; line-height:falsepx; font-size:58px; letter-spacing:2px;" class="ls-l" data-ls="offsetyin:100; durationin:2000; delayin:500; easingin:easeOutQuint; offsetyout:100; easingout:easeInQuint;">Looking for more?</p>
						<img width="363" height="290" src="<?= LS_ROOT_URL ?>/static/admin/img/surprise-box-top.png" class="ls-l" alt="" style="top:71px; left:655px; background-size:inherit; background-position:inherit; width:234px; height:187px;" data-ls="offsetyin:75; durationin:2000; easingin:easeOutQuint; scalexin:.5; scaleyin:.5; loop:true; loopoffsety:-30; loopduration:10000; loopstartat:transitioninstart + 0; loopeasing:easeInOutSine; looprotate:5; loopcount:-1; loopyoyo:true;">
						<img width="731" height="365" src="<?= LS_ROOT_URL ?>/static/admin/img/papers-close.png" class="ls-l" alt="" style="top:80px; left:559px; background-size:inherit; background-position:inherit; width:471px; height:235px;" data-ls="offsetyin:100; durationin:2000; easingin:easeOutQuint; scalexin:.5; scaleyin:.5; loop:true; loopoffsety:-60; loopduration:10000; loopstartat:transitioninstart ; loopeasing:easeInOutSine; looprotate:5; loopscalex:1.15; loopscaley:1.15; loopcount:-1; loopyoyo:true;">

						<p style="box-shadow: 0 6px 10px rgba(0,0,0,0.1);
			cursor:pointer;top:421px; left:300px; text-align:center; font-weight:600; font-style:normal; text-decoration:none; mix-blend-mode:normal; font-family:Poppins; height:48px; border-radius:24px; line-height:48px; background-color:#24d4da; font-size:20px; padding-right:30px; padding-left:30px; color:#ffffff;" class="ls-l" data-ls="offsetyin:20; durationin:2000; delayin:500; easingin:easeOutQuint; offsetyout:140; easingout:easeInQuint; hover:true; hoveroffsety:-5;">CLICK HERE TO EXPLORE</p>
						<a href="#" id="open-webshopworks-popups" target="_self" class="ls-link ls-link-on-top"></a>
					</div>
				</div>
			</div>
		</div>


















		<!-- WEBSHOPWORKS POPUPS -->
		<div class="ls-templates-holder inner popups">
			<nav class="templates-sidemenu">

				<ul class="content-filter">
					<li data-index="0">
						<?= lsGetSVGIcon('layer-group'); ?>
						<?= __('SLIDERS', 'LayerSlider') ?>
					</li>
					<li data-index="1" class="active">
						<?= lsGetSVGIcon('window-maximize', 'regular'); ?>
						<?= __('POPUPS', 'LayerSlider') ?>
					</li>
				</ul>

				<div class="separator"></div>

				<h5><?= __('Sources', 'LayerSlider') ?></h5>
				<ul class="source-filter">
					<li data-index="1">
						<img src="<?= LS_ROOT_URL.'/static/admin/img/kreatura-logo-red.png' ?>" alt="Kreatura logo">
						<?= __('Kreatura', 'LayerSlider') ?>
					</li>
					<li data-index="2" class="active">
						<img src="<?= LS_ROOT_URL.'/static/admin/img/webshopworks-logo-red.png' ?>" alt="WebshopWorks logo">
						<?= __('WebshopWorks', 'LayerSlider') ?>
					</li>
				</ul>

				<h5><?= __('Categories', 'LayerSlider') ?></h5>
				<ul class="shuffle-filters">
					<li class="active">
						<?= lsGetSVGIcon('tags'); ?>
						<?= __('All', 'LayerSlider') ?>
					</li>

					<li data-group="newsletter">
						<?= lsGetSVGIcon('envelope'); ?>
						<?= __('Newsletter', 'LayerSlider') ?>
					</li>

					<li data-group="sales">
						<?= lsGetSVGIcon('percent'); ?>
						<?= __('Sales', 'LayerSlider') ?>
					</li>

					<li data-group="exit-intent">
						<?= lsGetSVGIcon('door-open'); ?>
						<?= __('Exit-intent', 'LayerSlider') ?>
					</li>

					<li data-group="contact-us">
						<?= lsGetSVGIcon('user-friends'); ?>
						<?= __('Contact Us', 'LayerSlider') ?>
					</li>

					<li data-group="social">
						<?= lsGetSVGIcon('share-alt'); ?>
						<?= __('Social', 'LayerSlider') ?>
					</li>

					<li data-group="age-verification">
						<?= lsGetSVGIcon('user-check'); ?>
						<?= __('Age-verification', 'LayerSlider') ?>
					</li>

					<li data-group="seasonal">
						<?= lsGetSVGIcon('tree-decorated'); ?>
						<?= __('Seasonal', 'LayerSlider') ?>
					</li>

					<li data-group="coupon">
						<?= lsGetSVGIcon('ticket-alt'); ?>
						<?= __('Coupons', 'LayerSlider') ?>
					</li>

					<li data-group="promotion">
						<?= lsGetSVGIcon('tshirt'); ?>
						<?= __('Promotion', 'LayerSlider') ?>
					</li>

					<li data-group="fullscreen">
						<?= lsGetSVGIcon('expand'); ?>
						<?= __('Fullscreen', 'LayerSlider') ?>
					</li>
				</ul>

			</nav>

			<div class="items ls-template-items">
				<?php if( ! empty( $lsStoreData['webshopworks-popups'] ) ) : ?>
				<?php foreach( $lsStoreData['webshopworks-popups'] as $handle => $item) : ?>
				<figure class="item" data-collection="webshopworks-popups" data-name="<?= $item['name'] ?>" data-groups="<?= $item['groups'] ?>" data-handle="<?= $handle; ?>" data-bundled="<?= ! empty($item['bundled']) ? 'true' : 'false' ?>" data-premium="<?= ( ! empty($item['premium']) ) ? 'true' : 'false' ?>" data-version-warning="<?= version_compare($item['requires'], LS_PLUGIN_VERSION, '>') ? 'true' : 'false' ?>">
					<div class="aspect">
						<div class="item-picture" style="background: url(<?= $item['preview'] ?>);">
						</div>
						<figcaption>
							<h5>
								<?= $item['name'] ?>
								<span>By WebshopWorks</span>
							</h5>
						</figcaption>
						<div class="item-action item-preview">
							<a target="_blank" href="<?= ! empty($item['url']) ? $item['url'] : '#' ?>" >
								<?= lsGetSVGIcon('search') ?><?= __('preview', 'LayerSlider') ?>
							</a>
						</div>
						<div class="item-action item-import">
							<a href="#">
								<?= lsGetSVGIcon('download') ?><?= __('import', 'LayerSlider') ?>
							</a>
						</div>

						<?php if( ! empty( $item['released'] ) ) : ?>
							<?php if( strtotime($item['released']) + MONTH_IN_SECONDS > $now ) :  ?>
							<span class="badge-new"><?php _ex('NEW', 'Template Store', 'LayerSlider') ?>
							<?php endif ?>
						<?php endif ?>
					</div>
				</figure>
				<?php endforeach ?>
				<?php endif ?>
			</div>
		</div>
	</div>
</script>