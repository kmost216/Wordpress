<?php defined( 'LS_ROOT_FILE' ) || exit; ?>

<script type="text/html" id="tmpl-callback-events-modal-sidebar">
	<lse-b class="kmw-sidebar-title">
		<?= __('Event Callbacks', 'LayerSlider') ?>
	</lse-b>

	<lse-ul id="lse-callback-events-sidebar" class="lse-settings-modal-window-sidebar ls-compact">

		<lse-li class="lse-settings-sidebar-category lse-disabled">
			<?= __('Init Events', 'LayerSlider') ?>
		</lse-li>
		<lse-li>sliderWillLoad</lse-li>
		<lse-li>sliderDidLoad</lse-li>


		<lse-li class="lse-settings-sidebar-category lse-disabled">
			<?= __('Resize Events', 'LayerSlider') ?>
		</lse-li>
		<lse-li>sliderWillResize</lse-li>
		<lse-li>sliderDidResize</lse-li>


		<lse-li class="lse-settings-sidebar-category lse-disabled">
			<?= __('Slideshow Events', 'LayerSlider') ?>
		</lse-li>
		<lse-li>slideshowStateDidChange</lse-li>
		<lse-li>slideshowDidPause</lse-li>
		<lse-li>slideshowDidResume</lse-li>


		<lse-li class="lse-settings-sidebar-category lse-disabled">
			<?= __('Slide Change Events', 'LayerSlider') ?>
		</lse-li>
		<lse-li>slideChangeWillStart</lse-li>
		<lse-li>slideChangeDidStart</lse-li>
		<lse-li>slideChangeWillComplete</lse-li>
		<lse-li>slideChangeDidComplete</lse-li>



		<lse-li class="lse-settings-sidebar-category lse-disabled">
			<?= __('Slide Timeline Events', 'LayerSlider') ?>
		</lse-li>
		<lse-li>slideTimelineDidCreate</lse-li>
		<lse-li>slideTimelineDidUpdate</lse-li>
		<lse-li>slideTimelineDidStart</lse-li>
		<lse-li>slideTimelineDidComplete</lse-li>



		<lse-li class="lse-settings-sidebar-category lse-disabled">
			<?= __('Media Events', 'LayerSlider') ?>
		</lse-li>
		<lse-li>mediaDidStart</lse-li>
		<lse-li>mediaDidStop</lse-li>



		<lse-li class="lse-settings-sidebar-category lse-disabled">
			<?= __('Popup Events', 'LayerSlider') ?>
		</lse-li>
		<lse-li>popupWillOpen</lse-li>
		<lse-li>popupDidOpen</lse-li>
		<lse-li>popupWillClose</lse-li>
		<lse-li>popupDidClose</lse-li>



		<lse-li class="lse-settings-sidebar-category lse-disabled">
			<?= __('Destroy Events', 'LayerSlider') ?>
		</lse-li>
		<lse-li>sliderDidDestroy</lse-li>
		<lse-li>sliderDidRemove</lse-li>

	</lse-ul>
</script>


<script type="text/html" id="tmpl-callback-events-modal">

		<lse-b id="lse-callback-events" class="lse-callback-page">

			<lse-b id="lse-callback-events-content" class="lse-settings-modal-window-content">

				<lse-b class="lse-notification lse-bg-highlight">
					<?= lsGetSVGIcon('info-circle') ?>
					<lse-text><?= sprintf(__('The LayerSlider API and its Event Callbacks are intended for web developers who would like to further customize the plugin with custom coding. You don’t have to bother with this portion of LayerSlider if you aren’t familiar with JavaScript or programming in general. If you are, however, please read our %sonline documentation%s for more information about the JS API. There are also %sserver-side APIs%s available.', 'LayerSlider'), '<a href="https://layerslider.com/documentation/#layerslider-api" target="_blank">', '</a>', '<a href="https://layerslider.com/developers/" target="_blank">', '</a>') ?></lse-text>
				</lse-b>

				<lse-b class="lse-callback-box">
					<lse-h3 class="lse-callback-header">
						sliderWillLoad
						<figure><lse-i>|</lse-i> <?= __('Fires before parsing user data and rendering the UI.', 'LayerSlider') ?></figure>
					</lse-h3>
					<lse-b>
						<textarea name="sliderWillLoad" cols="20" rows="5" class="ls-codemirror">function( event ) {

}</textarea>
					</lse-b>
				</lse-b>

				<lse-b class="lse-callback-box">
					<lse-h3 class="lse-callback-header">
						sliderDidLoad
						<figure><lse-i>|</lse-i> <?= __('Fires when the slider is fully initialized and its DOM nodes become accessible.', 'LayerSlider') ?></figure>
					</lse-h3>
					<lse-b>
						<textarea name="sliderDidLoad" cols="20" rows="5" class="ls-codemirror">function( event, slider ) {

}</textarea>
					</lse-b>
				</lse-b>

				<lse-b class="lse-callback-box">
					<lse-h3 class="lse-callback-header">
						sliderWillResize
						<figure><lse-i>|</lse-i> <?= __('Fires before the slider renders resize events.', 'LayerSlider') ?></figure>
					</lse-h3>
					<lse-b>
						<textarea name="sliderWillResize" cols="20" rows="5" class="ls-codemirror">function( event, slider ) {

}</textarea>
					</lse-b>
				</lse-b>

				<lse-b class="lse-callback-box">
					<lse-h3 class="lse-callback-header">
						sliderDidResize
						<figure><lse-i>|</lse-i> <?= __('Fires after the slider has rendered resize events.', 'LayerSlider') ?></figure>
					</lse-h3>
					<lse-b>
						<textarea name="sliderDidResize" cols="20" rows="5" class="ls-codemirror">function( event, slider ) {

}</textarea>
					</lse-b>
				</lse-b>




				<lse-b class="lse-callback-box">
					<lse-h3 class="lse-callback-header">
						slideshowStateDidChange
						<figure><lse-i>|</lse-i> <?= __('Fires upon every slideshow state change, which may not influence the playing status.', 'LayerSlider') ?></figure>
					</lse-h3>
					<lse-b>
						<textarea name="slideshowStateDidChange" cols="20" rows="5" class="ls-codemirror">function( event, slider ) {

}</textarea>
					</lse-b>
				</lse-b>

				<lse-b class="lse-callback-box">
					<lse-h3 class="lse-callback-header">
						slideshowDidPause
						<figure><lse-i>|</lse-i> <?= __('Fires when the slideshow pauses from playing status.', 'LayerSlider') ?></figure>
					</lse-h3>
					<lse-b>
						<textarea name="slideshowDidPause" cols="20" rows="5" class="ls-codemirror">function( event, slider ) {

}</textarea>
					</lse-b>
				</lse-b>

				<lse-b class="lse-callback-box">
					<lse-h3 class="lse-callback-header">
						slideshowDidResume
						<figure><lse-i>|</lse-i> <?= __('Fires when the slideshow resumes from paused status.', 'LayerSlider') ?></figure>
					</lse-h3>
					<lse-b>
						<textarea name="slideshowDidResume" cols="20" rows="5" class="ls-codemirror">function( event, slider ) {

}</textarea>
					</lse-b>
				</lse-b>





				<lse-b class="lse-callback-box">
					<lse-h3 class="lse-callback-header">
						slideChangeWillStart
						<figure><lse-i>|</lse-i> <?= __('Signals when the slider wants to change slides, and is your last chance to divert it or intervene in any way.', 'LayerSlider') ?></figure>
					</lse-h3>
					<lse-b>
						<textarea name="slideChangeWillStart" cols="20" rows="5" class="ls-codemirror">function( event, slider ) {

}</textarea>
					</lse-b>
				</lse-b>

				<lse-b class="lse-callback-box">
					<lse-h3 class="lse-callback-header">
						slideChangeDidStart
						<figure><lse-i>|</lse-i> <?= __('Fires when the slider has started a slide change.', 'LayerSlider') ?></figure>
					</lse-h3>
					<lse-b>
						<textarea name="slideChangeDidStart" cols="20" rows="5" class="ls-codemirror">function( event, slider ) {

}</textarea>
					</lse-b>
				</lse-b>

				<lse-b class="lse-callback-box">
					<lse-h3 class="lse-callback-header">
						slideChangeWillComplete
						<figure><lse-i>|</lse-i> <?= __('Fires before completing a slide change.', 'LayerSlider') ?></figure>
					</lse-h3>
					<lse-b>
						<textarea name="slideChangeWillComplete" cols="20" rows="5" class="ls-codemirror">function( event, slider ) {

}</textarea>
					</lse-b>
				</lse-b>

				<lse-b class="lse-callback-box">
					<lse-h3 class="lse-callback-header">
						slideChangeDidComplete
						<figure><lse-i>|</lse-i> <?= __('Fires after a slide change has completed and the slide indexes have been updated. ', 'LayerSlider') ?></figure>
					</lse-h3>
					<lse-b>
						<textarea name="slideChangeDidComplete" cols="20" rows="5" class="ls-codemirror">function( event, slider ) {

}</textarea>
					</lse-b>
				</lse-b>




				<lse-b class="lse-callback-box">
					<lse-h3 class="lse-callback-header">
						slideTimelineDidCreate
						<figure><lse-i>|</lse-i> <?= __('Fires when the current slide’s animation timeline (e.g. your layers) becomes accessible for interfacing.', 'LayerSlider') ?></figure>
					</lse-h3>
					<lse-b>
						<textarea name="slideTimelineDidCreate" cols="20" rows="5" class="ls-codemirror">function( event, slider ) {

}</textarea>
					</lse-b>
				</lse-b>


				<lse-b class="lse-callback-box">
					<lse-h3 class="lse-callback-header">
						slideTimelineDidUpdate
						<figure><lse-i>|</lse-i> <?= __('Fires rapidly (at each frame) throughout the entire slide while playing, including reverse playback.', 'LayerSlider') ?></figure>
					</lse-h3>
					<lse-b>
						<textarea name="slideTimelineDidUpdate" cols="20" rows="5" class="ls-codemirror">function( event, timeline ) {

}</textarea>
					</lse-b>
				</lse-b>


				<lse-b class="lse-callback-box">
					<lse-h3 class="lse-callback-header">
						slideTimelineDidStart
						<figure><lse-i>|</lse-i> <?= __('Fires when the current slide’s animation timeline (e.g. your layers) has started playing.', 'LayerSlider') ?></figure>
					</lse-h3>
					<lse-b>
						<textarea name="slideTimelineDidStart" cols="20" rows="5" class="ls-codemirror">function( event, slider ) {

}</textarea>
					</lse-b>
				</lse-b>

				<lse-b class="lse-callback-box">
					<lse-h3 class="lse-callback-header">
						slideTimelineDidComplete
						<figure><lse-i>|</lse-i> <?= __('Fires when the current slide’s animation timeline (e.g. layer transitions) has completed.', 'LayerSlider') ?></figure>
					</lse-h3>
					<lse-b>
						<textarea name="slideTimelineDidComplete" cols="20" rows="5" class="ls-codemirror">function( event, slider ) {

}</textarea>
					</lse-b>
				</lse-b>

				<lse-b class="lse-callback-box">
					<lse-h3 class="lse-callback-header">
						slideTimelineDidReverseComplete
						<figure><lse-i>|</lse-i> <?= __('Fires when all reversed animations have reached the beginning of the current slide.', 'LayerSlider') ?></figure>
					</lse-h3>
					<lse-b>
						<textarea name="slideTimelineDidReverseComplete" cols="20" rows="5" class="ls-codemirror">function( event, slider ) {

}</textarea>
					</lse-b>
				</lse-b>



				<lse-b class="lse-callback-box">
					<lse-h3 class="lse-callback-header">
						mediaDidStart
						<figure><lse-i>|</lse-i> <?= __('A media element on the current slide has started playback.', 'LayerSlider') ?></figure>
					</lse-h3>
					<lse-b>
						<textarea name="mediaDidStart" cols="20" rows="5" class="ls-codemirror">function( event, slider ) {

}</textarea>
					</lse-b>
				</lse-b>

				<lse-b class="lse-callback-box">
					<lse-h3 class="lse-callback-header">
						mediaDidStop
						<figure><lse-i>|</lse-i> <?= __('A media element on the current slide has stopped playback.', 'LayerSlider') ?></figure>
					</lse-h3>
					<lse-b>
						<textarea name="mediaDidStop" cols="20" rows="5" class="ls-codemirror">function( event, slider ) {

}</textarea>
					</lse-b>
				</lse-b>




				<lse-b class="lse-callback-box">
					<lse-h3 class="lse-callback-header">
						popupWillOpen
						<figure><lse-i>|</lse-i> <?= __('Fires when the Popup starts its opening transition and becomes visible.', 'LayerSlider') ?></figure>
					</lse-h3>
					<lse-b>
						<textarea name="popupWillOpen" cols="20" rows="5" class="ls-codemirror">function( event, slider ) {

}</textarea>
					</lse-b>
				</lse-b>

				<lse-b class="lse-callback-box">
					<lse-h3 class="lse-callback-header">
						popupDidOpen
						<figure><lse-i>|</lse-i> <?= __('Fires when the Popup completed its opening transition.', 'LayerSlider') ?></figure>
					</lse-h3>
					<lse-b>
						<textarea name="popupDidOpen" cols="20" rows="5" class="ls-codemirror">function( event, slider ) {

}</textarea>
					</lse-b>
				</lse-b>

				<lse-b class="lse-callback-box">
					<lse-h3 class="lse-callback-header">
						popupWillClose
						<figure><lse-i>|</lse-i> <?= __('Fires when the Popup stars its closing transition.', 'LayerSlider') ?></figure>
					</lse-h3>
					<lse-b>
						<textarea name="popupWillClose" cols="20" rows="5" class="ls-codemirror">function( event, slider ) {

}</textarea>
					</lse-b>
				</lse-b>

				<lse-b class="lse-callback-box">
					<lse-h3 class="lse-callback-header">
						popupDidClose
						<figure><lse-i>|</lse-i> <?= __('Fires when the Popup completed its closing transition and became hidden.', 'LayerSlider') ?></figure>
					</lse-h3>
					<lse-b>
						<textarea name="popupDidClose" cols="20" rows="5" class="ls-codemirror">function( event, slider ) {

}</textarea>
					</lse-b>
				</lse-b>





				<lse-b class="lse-callback-box">
					<lse-h3 class="lse-callback-header">
						sliderDidDestroy
						<figure><lse-i>|</lse-i> <?= __('Fires when the slider destructor has finished and it is safe to remove the slider from the DOM.', 'LayerSlider') ?></figure>
					</lse-h3>
					<lse-b>
						<textarea name="sliderDidDestroy" data-event-data="false" cols="20" rows="5" class="ls-codemirror">function( event ) {

}</textarea>
					</lse-b>
				</lse-b>

				<lse-b class="lse-callback-box">
					<lse-h3 class="lse-callback-header">
						sliderDidRemove
						<figure><lse-i>|</lse-i> <?= __('Fires when the slider has been removed from the DOM when using the <i>destroy</i> API method.', 'LayerSlider') ?></figure>
					</lse-h3>
					<lse-b>
						<textarea name="sliderDidRemove" data-event-data="false" cols="20" rows="5" class="ls-codemirror">function( event ) {

}</textarea>
					</lse-b>
				</lse-b>
			</lse-b>

		</lse-b>

	</lse-b>

</script>