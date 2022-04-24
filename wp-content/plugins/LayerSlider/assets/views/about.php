<?php

defined( 'LS_ROOT_FILE' ) || exit;

include LS_ROOT_PATH . '/includes/ls_global.php';

update_user_meta( get_current_user_id(), 'ls-v7-welcome-screen-date', time() );

wp_localize_script('ls-about-page', 'LS_pageMeta', [
	'skinsPath' => LS_ROOT_URL.'/static/layerslider/skins/',
]);

?>

<ls-wrapper id="ls-welcome-page" class="wrap">


	<div id="ls--welcome-slider-wrapper">

		<div id="ls--slider-bg">

			<!-- Slider HTML markup -->
			<div id="ls-welcome-slider-bg" style="width:1000px;height:800px;margin:0 auto;user-select: none;">

				<!-- Slide 1-->
				<div class="ls-slide" data-ls="transitionduration:0; kenburnsscale:1.2; parallaxevent:scroll; parallaxaxis:y; parallaxdurationmove:100; parallaxdistance:-20;">

					<div style="top:208px; left:150%; text-align:initial; font-weight:400; color:rgba(0,0,0, 0.3); font-size:45px;" class="ls-l ls--layer-blend-mode" data-ls="showinfo:1; durationin:0; delayin:15200; fadein:false; transformoriginin:slidercenter slidermiddle; offsetxout:left; startatout:slidechangeonly 0; easingout:linear; fadeout:false; loop:true; loopoffsetx:-200sw; loopduration:15600; loopstartat:transitioninstart ; loopcount:-1;  position:fixed;">Bi xer hati</div>
					<div style="top:476px; left:145%; text-align:initial; font-weight:400; color:rgba(0,0,0, 0.3); font-size:45px;" class="ls-l ls--layer-blend-mode" data-ls="showinfo:1; durationin:0; delayin:14800; fadein:false; transformoriginin:slidercenter slidermiddle; offsetxout:left; startatout:slidechangeonly 0; easingout:linear; fadeout:false; loop:true; loopoffsetx:-190sw; loopduration:15600; loopstartat:transitioninstart ; loopcount:-1;  position:fixed;">Croeso</div>
					<div style="top:738px; left:150%; text-align:initial; font-weight:400; color:rgba(0,0,0, 0.3); font-size:45px;" class="ls-l ls--layer-blend-mode" data-ls="showinfo:1; durationin:0; delayin:14400; fadein:false; transformoriginin:slidercenter slidermiddle; offsetxout:left; startatout:slidechangeonly 0; easingout:linear; fadeout:false; loop:true; loopoffsetx:-200sw; loopduration:15600; loopstartat:transitioninstart ; loopcount:-1;  position:fixed;">Benvign&ugrave;o</div>
					<div style="top:115px; left:145%; text-align:initial; font-weight:400; color:rgba(0,0,0, 0.3); font-size:45px;" class="ls-l ls--layer-blend-mode" data-ls="showinfo:1; durationin:0; delayin:14000; fadein:false; transformoriginin:slidercenter slidermiddle; offsetxout:left; startatout:slidechangeonly 0; easingout:linear; fadeout:false; loop:true; loopoffsetx:-190sw; loopduration:15600; loopstartat:transitioninstart ; loopcount:-1;  position:fixed;">Xush kelibsiz</div>
					<div style="top:621px; left:150%; text-align:initial; font-weight:400; color:rgba(0,0,0, 0.3); font-size:45px;" class="ls-l ls--layer-blend-mode" data-ls="showinfo:1; durationin:0; delayin:13600; fadein:false; transformoriginin:slidercenter slidermiddle; offsetxout:left; startatout:slidechangeonly 0; easingout:linear; fadeout:false; loop:true; loopoffsetx:-200sw; loopduration:15600; loopstartat:transitioninstart ; loopcount:-1;  position:fixed;">&#1051;&#1072;&#1089;&#1082;&#1072;&#1074;&#1086; &#1087;&#1088;&#1086;&#1089;&#1080;&#1084;&#1086;</div>
					<div style="top:348px; left:145%; text-align:initial; font-weight:400; color:rgba(0,0,0, 0.3); font-size:45px;" class="ls-l ls--layer-blend-mode" data-ls="showinfo:1; durationin:0; delayin:13200; fadein:false; transformoriginin:slidercenter slidermiddle; offsetxout:left; startatout:slidechangeonly 0; easingout:linear; fadeout:false; loop:true; loopoffsetx:-190sw; loopduration:15600; loopstartat:transitioninstart ; loopcount:-1;  position:fixed;">&#2997;&#3006;&#2992;&#3009;&#2969;&#3021;&#2965;&#2995;&#3021;</div>
					<div style="top:70px; left:150%; text-align:initial; font-weight:400; color:rgba(0,0,0, 0.3); font-size:45px;" class="ls-l ls--layer-blend-mode" data-ls="showinfo:1; durationin:0; delayin:12800; fadein:false; transformoriginin:slidercenter slidermiddle; offsetxout:left; startatout:slidechangeonly 0; easingout:linear; fadeout:false; loop:true; loopoffsetx:-200sw; loopduration:15600; loopstartat:transitioninstart ; loopcount:-1;  position:fixed;">V&auml;lkommen</div>
					<div style="top:691px; left:145%; text-align:initial; font-weight:400; color:rgba(0,0,0, 0.3); font-size:45px;" class="ls-l ls--layer-blend-mode" data-ls="showinfo:1; durationin:0; delayin:12400; fadein:false; transformoriginin:slidercenter slidermiddle; offsetxout:left; startatout:slidechangeonly 0; easingout:linear; fadeout:false; loop:true; loopoffsetx:-190sw; loopduration:15600; loopstartat:transitioninstart ; loopcount:-1;  position:fixed;">Dobrodo&scaron;li</div>
					<div style="top:162px; left:150%; text-align:initial; font-weight:400; color:rgba(0,0,0, 0.3); font-size:45px;" class="ls-l ls--layer-blend-mode" data-ls="showinfo:1; durationin:0; delayin:12000; fadein:false; transformoriginin:slidercenter slidermiddle; offsetxout:left; startatout:slidechangeonly 0; easingout:linear; fadeout:false; loop:true; loopoffsetx:-200sw; loopduration:15600; loopstartat:transitioninstart ; loopcount:-1;  position:fixed;">Vitaj</div>
					<div style="top:521px; left:145%; text-align:initial; font-weight:400; color:rgba(0,0,0, 0.3); font-size:45px;" class="ls-l ls--layer-blend-mode" data-ls="showinfo:1; durationin:0; delayin:11600; fadein:false; transformoriginin:slidercenter slidermiddle; offsetxout:left; startatout:slidechangeonly 0; easingout:linear; fadeout:false; loop:true; loopoffsetx:-190sw; loopduration:15600; loopstartat:transitioninstart ; loopcount:-1;  position:fixed;">&#1044;&#1086;&#1073;&#1088;&#1086;&#1076;&#1086;&#1096;&#1083;&#1080;</div>
					<div style="top:70px; left:150%; text-align:initial; font-weight:400; color:rgba(0,0,0, 0.3); font-size:45px;" class="ls-l ls--layer-blend-mode" data-ls="showinfo:1; durationin:0; delayin:11200; fadein:false; transformoriginin:slidercenter slidermiddle; offsetxout:left; startatout:slidechangeonly 0; easingout:linear; fadeout:false; loop:true; loopoffsetx:-200sw; loopduration:15600; loopstartat:transitioninstart ; loopcount:-1;  position:fixed;">&#2360;&#2381;&#2357;&#2366;&#2327;&#2340;&#2350;&#2381;</div>
					<div style="top:574px; left:145%; text-align:initial; font-weight:400; color:rgba(0,0,0, 0.3); font-size:45px;" class="ls-l ls--layer-blend-mode" data-ls="showinfo:1; durationin:0; delayin:10800; fadein:false; transformoriginin:slidercenter slidermiddle; offsetxout:left; startatout:slidechangeonly 0; easingout:linear; fadeout:false; loop:true; loopoffsetx:-190sw; loopduration:15600; loopstartat:transitioninstart ; loopcount:-1;  position:fixed;">Selamat datang</div>
					<div style="top:234px; left:150%; text-align:initial; font-weight:400; color:rgba(0,0,0, 0.3); font-size:45px;" class="ls-l ls--layer-blend-mode" data-ls="showinfo:1; durationin:0; delayin:10400; fadein:false; transformoriginin:slidercenter slidermiddle; offsetxout:left; startatout:slidechangeonly 0; easingout:linear; fadeout:false; loop:true; loopoffsetx:-200sw; loopduration:15600; loopstartat:transitioninstart ; loopcount:-1;  position:fixed;">&#1044;&#1086;&#1073;&#1088;&#1077;&#1076;&#1086;&#1112;&#1076;&#1086;&#1074;&#1090;&#1077;</div>
					<div style="top:382px; left:145%; text-align:initial; font-weight:400; color:rgba(0,0,0, 0.3); font-size:45px;" class="ls-l ls--layer-blend-mode" data-ls="showinfo:1; durationin:0; delayin:10000; fadein:false; transformoriginin:slidercenter slidermiddle; offsetxout:left; startatout:slidechangeonly 0; easingout:linear; fadeout:false; loop:true; loopoffsetx:-190sw; loopduration:15600; loopstartat:transitioninstart ; loopcount:-1;  position:fixed;">W&euml;llkomm</div>
					<div style="top:691px; left:150%; text-align:initial; font-weight:400; color:rgba(0,0,0, 0.3); font-size:45px;" class="ls-l ls--layer-blend-mode" data-ls="showinfo:1; durationin:0; delayin:9600; fadein:false; transformoriginin:slidercenter slidermiddle; offsetxout:left; startatout:slidechangeonly 0; easingout:linear; fadeout:false; loop:true; loopoffsetx:-200sw; loopduration:15600; loopstartat:transitioninstart ; loopcount:-1;  position:fixed;">Sveiki atvyk&#281;</div>
					<div style="top:23px; left:145%; text-align:initial; font-weight:400; color:rgba(0,0,0, 0.3); font-size:45px;" class="ls-l ls--layer-blend-mode" data-ls="showinfo:1; durationin:0; delayin:9200; fadein:false; transformoriginin:slidercenter slidermiddle; offsetxout:left; startatout:slidechangeonly 0; easingout:linear; fadeout:false; loop:true; loopoffsetx:-190sw; loopduration:15600; loopstartat:transitioninstart ; loopcount:-1;  position:fixed;">Laipni l&#363;dzam</div>
					<div style="top:284px; left:150%; text-align:initial; font-weight:400; color:rgba(0,0,0, 0.3); font-size:45px;" class="ls-l ls--layer-blend-mode" data-ls="showinfo:1; durationin:0; delayin:8800; fadein:false; transformoriginin:slidercenter slidermiddle; offsetxout:left; startatout:slidechangeonly 0; easingout:linear; fadeout:false; loop:true; loopoffsetx:-200sw; loopduration:15600; loopstartat:transitioninstart ; loopcount:-1;  position:fixed;">&#54872;&#50689;&#54633;&#45768;&#45796;</div>
					<div style="top:621px; left:145%; text-align:initial; font-weight:400; color:rgba(0,0,0, 0.3); font-size:45px;" class="ls-l ls--layer-blend-mode" data-ls="showinfo:1; durationin:0; delayin:8400; fadein:false; transformoriginin:slidercenter slidermiddle; offsetxout:left; startatout:slidechangeonly 0; easingout:linear; fadeout:false; loop:true; loopoffsetx:-190sw; loopduration:15600; loopstartat:transitioninstart ; loopcount:-1;  position:fixed;">&#6047;&#6076;&#6040;&#8203;&#6047;&#6098;&#6044;&#6070;&#6018;&#6040;&#6035;&#6093;</div>
					<div style="top:476px; left:150%; text-align:initial; font-weight:400; color:rgba(0,0,0, 0.3); font-size:45px;" class="ls-l ls--layer-blend-mode" data-ls="showinfo:1; durationin:0; delayin:8000; fadein:false; transformoriginin:slidercenter slidermiddle; offsetxout:left; startatout:slidechangeonly 0; easingout:linear; fadeout:false; loop:true; loopoffsetx:-200sw; loopduration:15600; loopstartat:transitioninstart ; loopcount:-1;  position:fixed;">&#1178;&#1086;&#1096; &#1082;&#1077;&#1083;&#1076;&#1110;&#1187;&#1110;&#1079;</div>
					<div style="top:203px; left:145%; text-align:initial; font-weight:400; color:rgba(0,0,0, 0.3); font-size:45px;" class="ls-l ls--layer-blend-mode" data-ls="showinfo:1; durationin:0; delayin:7600; fadein:false; transformoriginin:slidercenter slidermiddle; offsetxout:left; startatout:slidechangeonly 0; easingout:linear; fadeout:false; loop:true; loopoffsetx:-190sw; loopduration:15600; loopstartat:transitioninstart ; loopcount:-1;  position:fixed;">Benvenuto</div>
					<div style="top:335px; left:150%; text-align:initial; font-weight:400; color:rgba(0,0,0, 0.3); font-size:45px;" class="ls-l ls--layer-blend-mode" data-ls="showinfo:1; durationin:0; delayin:7200; fadein:false; transformoriginin:slidercenter slidermiddle; offsetxout:left; startatout:slidechangeonly 0; easingout:linear; fadeout:false; loop:true; loopoffsetx:-200sw; loopduration:15600; loopstartat:transitioninstart ; loopcount:-1;  position:fixed;">F&aacute;ilte</div>
					<div style="top:429px; left:145%; text-align:initial; font-weight:400; color:rgba(0,0,0, 0.3); font-size:45px;" class="ls-l ls--layer-blend-mode" data-ls="showinfo:1; durationin:0; delayin:6800; fadein:false; transformoriginin:slidercenter slidermiddle; offsetxout:left; startatout:slidechangeonly 0; easingout:linear; fadeout:false; loop:true; loopoffsetx:-190sw; loopduration:15600; loopstartat:transitioninstart ; loopcount:-1;  position:fixed;">Selamat datang</div>
					<div style="top:162px; left:150%; text-align:initial; font-weight:400; color:rgba(0,0,0, 0.3); font-size:45px;" class="ls-l ls--layer-blend-mode" data-ls="showinfo:1; durationin:0; delayin:6400; fadein:false; transformoriginin:slidercenter slidermiddle; offsetxout:left; startatout:slidechangeonly 0; easingout:linear; fadeout:false; loop:true; loopoffsetx:-200sw; loopduration:15600; loopstartat:transitioninstart ; loopcount:-1;  position:fixed;">Velkominn</div>
					<div style="top:738px; left:145%; text-align:initial; font-weight:400; color:rgba(0,0,0, 0.3); font-size:45px;" class="ls-l ls--layer-blend-mode" data-ls="showinfo:1; durationin:0; delayin:6000; fadein:false; transformoriginin:slidercenter slidermiddle; offsetxout:left; startatout:slidechangeonly 0; easingout:linear; fadeout:false; loop:true; loopoffsetx:-190sw; loopduration:15600; loopstartat:transitioninstart ; loopcount:-1;  position:fixed;">&Uuml;dv&ouml;zlet</div>
					<div style="top:399px; left:150%; text-align:initial; font-weight:400; color:rgba(0,0,0, 0.3); font-size:45px;" class="ls-l ls--layer-blend-mode" data-ls="showinfo:1; durationin:0; delayin:5600; fadein:false; transformoriginin:slidercenter slidermiddle; offsetxout:left; startatout:slidechangeonly 0; easingout:linear; fadeout:false; loop:true; loopoffsetx:-200sw; loopduration:15600; loopstartat:transitioninstart ; loopcount:-1;  position:fixed;">&#2360;&#2381;&#2357;&#2366;&#2327;&#2340;</div>
					<div style="top:120px; left:145%; text-align:initial; font-weight:400; color:rgba(0,0,0, 0.3); font-size:45px;" class="ls-l ls--layer-blend-mode" data-ls="showinfo:1; durationin:0; delayin:5200; fadein:false; transformoriginin:slidercenter slidermiddle; offsetxout:left; startatout:slidechangeonly 0; easingout:linear; fadeout:false; loop:true; loopoffsetx:-190sw; loopduration:15600; loopstartat:transitioninstart ; loopcount:-1;  position:fixed;">&#1489;&#1512;&#1493;&#1498; &#1492;&#1489;&#1488;</div>
					<div style="top:574px; left:150%; text-align:initial; font-weight:400; color:rgba(0,0,0, 0.3); font-size:45px;" class="ls-l ls--layer-blend-mode" data-ls="showinfo:1; durationin:0; delayin:4800; fadein:false; transformoriginin:slidercenter slidermiddle; offsetxout:left; startatout:slidechangeonly 0; easingout:linear; fadeout:false; loop:true; loopoffsetx:-200sw; loopduration:15600; loopstartat:transitioninstart ; loopcount:-1;  position:fixed;">Aloha</div>
					<div style="top:256px; left:145%; text-align:initial; font-weight:400; color:rgba(0,0,0, 0.3); font-size:45px;" class="ls-l ls--layer-blend-mode" data-ls="showinfo:1; durationin:0; delayin:4400; fadein:false; transformoriginin:slidercenter slidermiddle; offsetxout:left; startatout:slidechangeonly 0; easingout:linear; fadeout:false; loop:true; loopoffsetx:-190sw; loopduration:15600; loopstartat:transitioninstart ; loopcount:-1;  position:fixed;">&Kappa;&alpha;&lambda;&#974;&sigmaf; &Omicron;&rho;&#943;&sigma;&alpha;&tau;&epsilon;</div>
					<div style="top:621px; left:150%; text-align:initial; font-weight:400; color:rgba(0,0,0, 0.3); font-size:45px;" class="ls-l ls--layer-blend-mode" data-ls="showinfo:1; durationin:0; delayin:4000; fadein:false; transformoriginin:slidercenter slidermiddle; offsetxout:left; startatout:slidechangeonly 0; easingout:linear; fadeout:false; loop:true; loopoffsetx:-200sw; loopduration:15600; loopstartat:transitioninstart ; loopcount:-1;  position:fixed;">Tervetuloa</div>
					<div style="top:382px; left:145%; text-align:initial; font-weight:400; color:rgba(0,0,0, 0.3); font-size:45px;" class="ls-l ls--layer-blend-mode" data-ls="showinfo:1; durationin:0; delayin:3600; fadein:false; transformoriginin:slidercenter slidermiddle; offsetxout:left; startatout:slidechangeonly 0; easingout:linear; fadeout:false; loop:true; loopoffsetx:-190sw; loopduration:15600; loopstartat:transitioninstart ; loopcount:-1;  position:fixed;">Tere tulemast</div>
					<div style="top:70px; left:150%; text-align:initial; font-weight:400; color:rgba(0,0,0, 0.3); font-size:45px;" class="ls-l ls--layer-blend-mode" data-ls="showinfo:1; durationin:0; delayin:3200; fadein:false; transformoriginin:slidercenter slidermiddle; offsetxout:left; startatout:slidechangeonly 0; easingout:linear; fadeout:false; loop:true; loopoffsetx:-200sw; loopduration:15600; loopstartat:transitioninstart ; loopcount:-1;  position:fixed;">Velkommen</div>
					<div style="top:691px; left:145%; text-align:initial; font-weight:400; color:rgba(0,0,0, 0.3); font-size:45px;" class="ls-l ls--layer-blend-mode" data-ls="showinfo:1; durationin:0; delayin:2800; fadein:false; transformoriginin:slidercenter slidermiddle; offsetxout:left; startatout:slidechangeonly 0; easingout:linear; fadeout:false; loop:true; loopoffsetx:-190sw; loopduration:15600; loopstartat:transitioninstart ; loopcount:-1;  position:fixed;">V&iacute;tejte</div>
					<div style="top:115px; left:150%; text-align:initial; font-weight:400; color:rgba(0,0,0, 0.3); font-size:45px;" class="ls-l ls--layer-blend-mode" data-ls="showinfo:1; durationin:0; delayin:2400; fadein:false; transformoriginin:slidercenter slidermiddle; offsetxout:left; startatout:slidechangeonly 0; easingout:linear; fadeout:false; loop:true; loopoffsetx:-200sw; loopduration:15600; loopstartat:transitioninstart ; loopcount:-1;  position:fixed;">Benvingut</div>
					<div style="top:463px; left:145%; text-align:initial; font-weight:400; color:rgba(0,0,0, 0.3); font-size:45px;" class="ls-l ls--layer-blend-mode" data-ls="showinfo:1; durationin:0; delayin:2000; fadein:false; transformoriginin:slidercenter slidermiddle; offsetxout:left; startatout:slidechangeonly 0; easingout:linear; fadeout:false; loop:true; loopoffsetx:-190sw; loopduration:15600; loopstartat:transitioninstart ; loopcount:-1;  position:fixed;">&#1044;&#1086;&#1073;&#1088;&#1077; &#1076;&#1086;&#1096;&#1083;&#1086;</div>
					<div style="top:322px; left:150%; text-align:initial; font-weight:400; color:rgba(0,0,0, 0.3); font-size:45px;" class="ls-l ls--layer-blend-mode" data-ls="showinfo:1; durationin:0; delayin:1600; fadein:false; transformoriginin:slidercenter slidermiddle; offsetxout:left; startatout:slidechangeonly 0; easingout:linear; fadeout:false; loop:true; loopoffsetx:-200sw; loopduration:15600; loopstartat:transitioninstart ; loopcount:-1;  position:fixed;">&#2488;&#2509;&#2476;&#2494;&#2455;&#2468;&#2478;</div>
					<div style="top:23px; left:145%; text-align:initial; font-weight:400; color:rgba(0,0,0, 0.3); font-size:45px;" class="ls-l ls--layer-blend-mode" data-ls="showinfo:1; durationin:0; delayin:1200; fadein:false; transformoriginin:slidercenter slidermiddle; offsetxout:left; startatout:slidechangeonly 0; easingout:linear; fadeout:false; loop:true; loopoffsetx:-190sw; loopduration:15600; loopstartat:transitioninstart ; loopcount:-1;  position:fixed;">Xo&#351; g&#601;lmi&#351;siniz</div>
					<div style="top:568px; left:150%; text-align:initial; font-weight:400; color:rgba(0,0,0, 0.3); font-size:45px;" class="ls-l ls--layer-blend-mode" data-ls="showinfo:1; durationin:0; delayin:800; fadein:false; transformoriginin:slidercenter slidermiddle; offsetxout:left; startatout:slidechangeonly 0; easingout:linear; fadeout:false; loop:true; loopoffsetx:-200sw; loopduration:15600; loopstartat:transitioninstart ; loopcount:-1;  position:fixed;">&#1571;&#1607;&#1604;&#1575;&#1611; &#1608; &#1587;&#1607;&#1604;&#1575;&#1611;</div>
					<div style="top:243px; left:145%; text-align:initial; font-weight:400; color:rgba(0,0,0, 0.3); font-size:45px;" class="ls-l ls--layer-blend-mode" data-ls="showinfo:1; durationin:0; delayin:400; fadein:false; transformoriginin:slidercenter slidermiddle; offsetxout:left; startatout:slidechangeonly 0; easingout:linear; fadeout:false; loop:true; loopoffsetx:-190sw; loopduration:15600; loopstartat:transitioninstart ; loopcount:-1;  position:fixed;">Mir&euml;sevjen</div>
					<div style="top:690px; left:150%; text-align:initial; font-weight:400; color:rgba(0,0,0, 0.3); font-size:45px;" class="ls-l ls--layer-blend-mode" data-ls="showinfo:1; durationin:0; fadein:false; transformoriginin:slidercenter slidermiddle; offsetxout:left; startatout:slidechangeonly 0; easingout:linear; fadeout:false; loop:true; loopoffsetx:-200sw; loopduration:15600; loopstartat:transitioninstart ; loopcount:-1;  position:fixed;">Bonvenon</div>
					<div style="top:323px; left:160%; text-align:initial; font-weight:400; color:rgba(100,100,100, 1); font-size:80px;" class="ls-l ls--layer-blend-mode" data-ls="showinfo:1; durationin:0; delayin:11000; easingin:linear; fadein:false; transformoriginin:slidercenter slidermiddle; startatout:slidechangeonly 0; easingout:linear; fadeout:false; loop:true; loopoffsetx:-220sw; loopduration:12000; loopstartat:transitioninend ; loopcount:-1;  position:fixed;">Ho&#351; geldin</div>
					<div style="top:32px; left:170%; text-align:initial; font-weight:400; color:rgba(100,100,100, 1); font-size:80px;" class="ls-l ls--layer-blend-mode" data-ls="showinfo:1; durationin:0; delayin:10000; easingin:linear; fadein:false; transformoriginin:slidercenter slidermiddle; startatout:slidechangeonly 0; easingout:linear; fadeout:false; loop:true; loopoffsetx:-240sw; loopduration:12000; loopstartat:transitioninend ; loopcount:-1;  position:fixed;">Bienvenido</div>
					<div style="top:546px; left:150%; text-align:initial; font-weight:400; color:rgba(100,100,100, 1); font-size:80px;" class="ls-l ls--layer-blend-mode" data-ls="showinfo:1; durationin:0; delayin:9000; easingin:linear; fadein:false; transformoriginin:slidercenter slidermiddle; startatout:slidechangeonly 0; easingout:linear; fadeout:false; loop:true; loopoffsetx:-200sw; loopduration:12000; loopstartat:transitioninend ; loopcount:-1;  position:fixed;">Witamy</div>
					<div style="top:198px; left:160%; text-align:initial; font-weight:400; color:rgba(100,100,100, 1); font-size:80px;" class="ls-l ls--layer-blend-mode" data-ls="showinfo:1; durationin:0; delayin:8000; easingin:linear; fadein:false; transformoriginin:slidercenter slidermiddle; startatout:slidechangeonly 0; easingout:linear; fadeout:false; loop:true; loopoffsetx:-220sw; loopduration:12000; loopstartat:transitioninend ; loopcount:-1;  position:fixed;">&#12424;&#12358;&#12371;&#12381;</div>
					<div style="top:323px; left:170%; text-align:initial; font-weight:400; color:rgba(100,100,100, 1); font-size:80px;" class="ls-l ls--layer-blend-mode" data-ls="showinfo:1; durationin:0; delayin:7000; easingin:linear; fadein:false; transformoriginin:slidercenter slidermiddle; startatout:slidechangeonly 0; easingout:linear; fadeout:false; loop:true; loopoffsetx:-240sw; loopduration:12000; loopstartat:transitioninend ; loopcount:-1;  position:fixed;">Bine ai venit</div>
					<div style="top:101px; left:150%; text-align:initial; font-weight:400; color:rgba(100,100,100, 1); font-size:80px;" class="ls-l ls--layer-blend-mode" data-ls="showinfo:1; durationin:0; delayin:6000; easingin:linear; fadein:false; transformoriginin:slidercenter slidermiddle; startatout:slidechangeonly 0; easingout:linear; fadeout:false; loop:true; loopoffsetx:-200sw; loopduration:12000; loopstartat:transitioninend ; loopcount:-1;  position:fixed;">&#3618;&#3636;&#3609;&#3604;&#3637;&#3605;&#3657;&#3629;&#3609;&#3619;&#3633;&#3610;</div>
					<div style="top:463px; left:160%; text-align:initial; font-weight:400; color:rgba(100,100,100, 1); font-size:80px;" class="ls-l ls--layer-blend-mode" data-ls="showinfo:1; durationin:0; delayin:5000; easingin:linear; fadein:false; transformoriginin:slidercenter slidermiddle; startatout:slidechangeonly 0; easingout:linear; fadeout:false; loop:true; loopoffsetx:-220sw; loopduration:12000; loopstartat:transitioninend ; loopcount:-1;  position:fixed;">Welkom</div>
					<div style="top:273px; left:170%; text-align:initial; font-weight:400; color:rgba(120,120,120, 1); font-size:60px;" class="ls-l ls--layer-blend-mode" data-ls="showinfo:1; durationin:0; delayin:4000; easingin:linear; fadein:false; transformoriginin:slidercenter slidermiddle; startatout:slidechangeonly 0; easingout:linear; fadeout:false; loop:true; loopoffsetx:-240sw; loopduration:12000; loopstartat:transitioninend ; loopcount:-1;  position:fixed;">&#1044;&#1086;&#1073;&#1088;&#1086; &#1087;&#1086;&#1078;&#1072;&#1083;&#1086;&#1074;&#1072;&#1090;&#1100;</div>
					<div style="top:23px; left:150%; text-align:initial; font-weight:400; color:rgba(100,100,100, 1); font-size:80px;" class="ls-l ls--layer-blend-mode" data-ls="showinfo:1; durationin:0; delayin:3000; easingin:linear; fadein:false; transformoriginin:slidercenter slidermiddle; startatout:slidechangeonly 0; easingout:linear; fadeout:false; loop:true; loopoffsetx:-200sw; loopduration:12000; loopstartat:transitioninend ; loopcount:-1;  position:fixed;">Bienvenue</div>
					<div style="top:406px; left:160%; text-align:initial; font-weight:400; color:rgba(100,100,100, 1); font-size:80px;" class="ls-l ls--layer-blend-mode" data-ls="showinfo:1; durationin:0; delayin:2000; easingin:linear; fadein:false; transformoriginin:slidercenter slidermiddle; startatout:slidechangeonly 0; easingout:linear; fadeout:false; loop:true; loopoffsetx:-220sw; loopduration:12000; loopstartat:transitioninend ; loopcount:-1;  position:fixed;">&#27489;&#36814;&#20809;&#33256;</div>
					<div style="top:559px; left:170%; text-align:initial; font-weight:400; color:rgba(100,100,100, 1); font-size:80px;" class="ls-l ls--layer-blend-mode" data-ls="showinfo:1; durationin:0; delayin:1000; easingin:linear; fadein:false; transformoriginin:slidercenter slidermiddle; startatout:slidechangeonly 0; easingout:linear; fadeout:false; loop:true; loopoffsetx:-240sw; loopduration:12000; loopstartat:transitioninend ; loopcount:-1;  position:fixed;">Bem-vindo</div>
					<div style="top:169px; left:150%; text-align:initial; font-weight:400; color:rgba(100,100,100, 1); font-size:80px;" class="ls-l ls--layer-blend-mode" data-ls="showinfo:1; durationin:0; easingin:linear; fadein:false; transformoriginin:slidercenter slidermiddle; startatout:slidechangeonly 0; easingout:linear; fadeout:false; loop:true; loopoffsetx:-200sw; loopduration:12000; loopstartat:transitioninend ; loopcount:-1;  position:fixed;">Willkommen</div>

					<div style="background: linear-gradient(90deg, rgba(238,238,238,1) 2%, rgba(238,238,238,0) 100%);top:0px; left:0px; width:30%; height:100%;" class="ls-l" data-ls="durationin: 0; position:fixed;"></div>

					<div style="background: linear-gradient(270deg, rgba(238,238,238,1) 2%, rgba(238,238,238,0) 100%);top:0px; left:100%; width:30%; height:100%;" class="ls-l" data-ls="durationin: 0; position:fixed;"></div>


				</div>

			</div>

		</div>

		<div id="ls--slider-fg">

			<!-- Slider HTML markup -->
			<div id="ls-welcome-slider" style="width:1000px;height:1200px;margin:0 auto;user-select: none;">

				<!-- Slide 1-->
				<div class="ls-slide" data-ls="transitionduration:0; kenburnsscale:1.2; parallaxevent:scroll; parallaxaxis:y; parallaxdurationmove:100; parallaxdistance:-20;">

					<div style='overflow: hidden;top:-174px; left:-837px; background-size:cover; background-position:50% 50%; font-size:17px; width:340px; height:190px; border-radius:7px; background-image:url("<?= LS_ROOT_URL ?>/static/admin/img/slider/marketing-page-pack.jpg");' class="ls-l" data-ls="offsetyin:-220; durationin:2000; easingin:easeOutCubic; rotatein:45; skewxin:-15; skewyin:-15; loop:true; loopoffsetx:-20sh; loopoffsety:-20sh; loopduration:3000; loopstartat: allinend - 1000; loopeasing:easeInOutQuint; loopcount:1; rotation:45; skewX:-15; skewY:-15;"></div>
					<div style='overflow: hidden;top:-201px; left:-529px; background-size:cover; background-position:50% 50%; font-size:17px; width:340px; height:190px; border-radius:7px; background-image:url("<?= LS_ROOT_URL ?>/static/admin/img/slider/ecommerce-global-hover-example.jpg");' class="ls-l" data-ls="offsetyin:-210; durationin:2000; easingin:easeOutCubic; rotatein:45; skewxin:-15; skewyin:-15; loop:true; loopoffsetx:-20sh; loopoffsety:-20sh; loopduration:3000; loopstartat: allinend - 1000; loopeasing:easeInOutQuint; loopcount:1; rotation:45; skewX:-15; skewY:-15;"></div>
					<div style='overflow: hidden;top:-155px; left:396px; background-size:cover; background-position:50% 50%; font-size:17px; width:340px; height:190px; border-radius:7px; background-image:url("<?= LS_ROOT_URL ?>/static/admin/img/slider/flying-banners-1.jpg");' class="ls-l" data-ls="offsetyin:-200; durationin:2000; easingin:easeOutCubic; rotatein:-45; skewxin:15; skewyin:15; loop:true; loopoffsetx:20sh; loopoffsety:-20sh; loopduration:3000; loopstartat: allinend - 1000; loopeasing:easeInOutQuint; loopcount:1; rotation:-45; skewX:15; skewY:15;"></div>
					<div style='overflow: hidden;top:-127px; left:703px; background-size:cover; background-position:50% 50%; font-size:17px; width:340px; height:190px; border-radius:7px; background-image:url("<?= LS_ROOT_URL ?>/static/admin/img/slider/fashion-shop.jpg");' class="ls-l" data-ls="offsetyin:-190; durationin:2000; easingin:easeOutCubic; rotatein:-45; skewxin:15; skewyin:15; loop:true; loopoffsetx:20sh; loopoffsety:-20sh; loopduration:3000; loopstartat: allinend - 1000; loopeasing:easeInOutQuint; loopcount:1; rotation:-45; skewX:15; skewY:15;"></div>
					<div style='overflow: hidden;top:-100px; left:1012px; background-size:cover; background-position:50% 50%; font-size:17px; width:340px; height:190px; border-radius:7px; background-image:url("<?= LS_ROOT_URL ?>/static/admin/img/slider/summer-collection.jpg");' class="ls-l" data-ls="offsetyin:-180; durationin:2000; easingin:easeOutCubic; rotatein:-45; skewxin:15; skewyin:15; loop:true; loopoffsetx:20sh; loopoffsety:-20sh; loopduration:3000; loopstartat: allinend - 1000; loopeasing:easeInOutQuint; loopcount:1; rotation:-45; skewX:15; skewY:15;"></div>
					<div style='overflow: hidden;top:-71px; left:1320px; background-size:cover; background-position:50% 50%; font-size:17px; width:340px; height:190px; border-radius:7px; background-image:url("<?= LS_ROOT_URL ?>/static/admin/img/slider/product-showcase-dark.jpg");' class="ls-l" data-ls="offsetyin:-170; durationin:2000; easingin:easeOutCubic; rotatein:-45; skewxin:15; skewyin:15; loop:true; loopoffsetx:20sh; loopoffsety:-20sh; loopduration:3000; loopstartat: allinend - 1000; loopeasing:easeInOutQuint; loopcount:1; rotation:-45; skewX:15; skewY:15;"></div>
					<div style='overflow: hidden;top:-52px; left:88px; background-size:cover; background-position:50% 50%; font-size:17px; width:340px; height:190px; border-radius:7px; background-image:url("<?= LS_ROOT_URL ?>/static/admin/img/slider/shoes.jpg");' class="ls-l" data-ls="offsetyin:-160; durationin:2000; easingin:easeOutCubic; rotatein:45; skewxin:-15; skewyin:-15; loop:true; loopoffsetx:-20sh; loopoffsety:-20sh; loopduration:3000; loopstartat: allinend - 1000; loopeasing:easeInOutQuint; loopcount:1; rotation:45; skewX:-15; skewY:-15;"></div>
					<div style='overflow: hidden;top:-23px; left:-221px; background-size:cover; background-position:50% 50%; font-size:17px; width:340px; height:190px; border-radius:7px; background-image:url("<?= LS_ROOT_URL ?>/static/admin/img/slider/flying-banners-1.jpg");' class="ls-l" data-ls="offsetyin:-150; durationin:2000; easingin:easeOutCubic; rotatein:45; skewxin:-15; skewyin:-15; loop:true; loopoffsetx:-20sh; loopoffsety:-20sh; loopduration:3000; loopstartat: allinend - 1000; loopeasing:easeInOutQuint; loopcount:1; rotation:45; skewX:-15; skewY:-15;"></div>
					<div style='overflow: hidden;top:4px; left:-529px; background-size:cover; background-position:50% 50%; font-size:17px; width:340px; height:190px; border-radius:7px; background-image:url("<?= LS_ROOT_URL ?>/static/admin/img/slider/music-is-my-life.jpg");' class="ls-l" data-ls="offsetyin:-140; durationin:2000; easingin:easeOutCubic; rotatein:45; skewxin:-15; skewyin:-15; loop:true; loopoffsetx:-20sh; loopoffsety:-20sh; loopduration:3000; loopstartat: allinend - 1000; loopeasing:easeInOutQuint; loopcount:1; rotation:45; skewX:-15; skewY:-15;"></div>
					<div style='overflow: hidden;top:51px; left:395px; background-size:cover; background-position:50% 50%; font-size:17px; width:340px; height:190px; border-radius:7px; background-image:url("<?= LS_ROOT_URL ?>/static/admin/img/slider/social-share-popup.jpg");' class="ls-l" data-ls="offsetyin:-130; durationin:2000; easingin:easeOutCubic; rotatein:-45; skewxin:15; skewyin:15; loop:true; loopoffsetx:20sh; loopoffsety:-20sh; loopduration:3000; loopstartat: allinend - 1000; loopeasing:easeInOutQuint; loopcount:1; rotation:-45; skewX:15; skewY:15;"></div>
					<div style='overflow: hidden;top:79px; left:703px; background-size:cover; background-position:50% 50%; font-size:17px; width:340px; height:190px; border-radius:7px; background-image:url("<?= LS_ROOT_URL ?>/static/admin/img/slider/sky.jpg");' class="ls-l" data-ls="offsetyin:-120; durationin:2000; easingin:easeOutCubic; rotatein:-45; skewxin:15; skewyin:15; loop:true; loopoffsetx:20sh; loopoffsety:-20sh; loopduration:3000; loopstartat: allinend - 1000; loopeasing:easeInOutQuint; loopcount:1; rotation:-45; skewX:15; skewY:15;"></div>
					<div style='overflow: hidden;top:107px; left:1012px; background-size:cover; background-position:50% 50%; font-size:17px; width:340px; height:190px; border-radius:7px; background-image:url("<?= LS_ROOT_URL ?>/static/admin/img/slider/personal-page-pack.jpg");' class="ls-l" data-ls="offsetyin:-110; durationin:2000; easingin:easeOutCubic; rotatein:-45; skewxin:15; skewyin:15; loop:true; loopoffsetx:20sh; loopoffsety:-20sh; loopduration:3000; loopstartat: allinend - 1000; loopeasing:easeInOutQuint; loopcount:1; rotation:-45; skewX:15; skewY:15;"></div>
					<div style='overflow: hidden;top:154px; left:87px; background-size:cover; background-position:50% 50%; font-size:17px; width:340px; height:190px; border-radius:7px; background-image:url("<?= LS_ROOT_URL ?>/static/admin/img/slider/popup-modal-demo.jpg");' class="ls-l" data-ls="offsetyin:-100; durationin:2000; easingin:easeOutCubic; rotatein:45; skewxin:-15; skewyin:-15; loop:true; loopoffsetx:-20sh; loopoffsety:-20sh; loopduration:3000; loopstartat: allinend - 1000; loopeasing:easeInOutQuint; loopcount:1; rotation:45; skewX:-15; skewY:-15;"></div>
					<div style='overflow: hidden;top:182px; left:-221px; background-size:cover; background-position:50% 50%; font-size:17px; width:340px; height:190px; border-radius:7px; background-image:url("<?= LS_ROOT_URL ?>/static/admin/img/slider/creative-portraits.jpg");' class="ls-l" data-ls="offsetyin:-90; durationin:2000; easingin:easeOutCubic; rotatein:45; skewxin:-15; skewyin:-15; loop:true; loopoffsetx:-20sh; loopoffsety:-20sh; loopduration:3000; loopstartat: allinend - 1000; loopeasing:easeInOutQuint; loopcount:1; rotation:45; skewX:-15; skewY:-15;"></div>
					<div style='overflow: hidden;top:257px; left:395px; background-size:cover; background-position:50% 50%; font-size:17px; width:340px; height:190px; border-radius:7px; background-image:url("<?= LS_ROOT_URL ?>/static/admin/img/slider/origami-buildings.jpg");' class="ls-l" data-ls="offsetyin:-80; durationin:2000; easingin:easeOutCubic; rotatein:-45; skewxin:15; skewyin:15; loop:true; loopoffsetx:20sh; loopoffsety:-20sh; loopduration:3000; loopstartat: allinend - 1000; loopeasing:easeInOutQuint; loopcount:1; rotation:-45; skewX:15; skewY:15;"></div>
					<div style='overflow: hidden;top:285px; left:703px; background-size:cover; background-position:50% 50%; font-size:17px; width:340px; height:190px; border-radius:7px; background-image:url("<?= LS_ROOT_URL ?>/static/admin/img/slider/anniversary-slider.jpg");' class="ls-l" data-ls="offsetyin:-70; durationin:2000; easingin:easeOutCubic; rotatein:-45; skewxin:15; skewyin:15; loop:true; loopoffsetx:20sh; loopoffsety:-20sh; loopduration:3000; loopstartat: allinend - 1000; loopeasing:easeInOutQuint; loopcount:1; loopopacity: .85; rotation:-45; skewX:15; skewY:15;"></div>
					<div style='overflow: hidden;top:360px; left:87px; background-size:cover; background-position:50% 50%; font-size:17px; width:340px; height:190px; border-radius:7px; background-image:url("<?= LS_ROOT_URL ?>/static/admin/img/slider/origami.jpg");' class="ls-l" data-ls="offsetyin:-60; durationin:2000; easingin:easeOutCubic; rotatein:45; skewxin:-15; skewyin:-15; loop:true; loopoffsetx:-20sh; loopoffsety:-20sh; loopduration:3000; loopstartat: allinend - 1000; loopeasing:easeInOutQuint; loopcount:1; loopopacity: .85; rotation:45; skewX:-15; skewY:-15;"></div>
					<div style='overflow: hidden;top:463px; left:395px; background-size:cover; background-position:50% 50%; font-size:17px; width:340px; height:190px; border-radius:7px; background-image:url("<?= LS_ROOT_URL ?>/static/admin/img/slider/pixel-agency.jpg");' class="ls-l" data-ls="offsetyin:-50; durationin:2000; easingin:easeOutCubic; rotatein:-45; skewxin:15; skewyin:15; loop:true; loopoffsetx:20sh; loopoffsety:-20sh; loopduration:3000; loopstartat: allinend - 1000; loopeasing:easeInOutQuint; loopcount:1; loopopacity: .75; rotation:-45; skewX:15; skewY:15;"></div>
					<div style="background: radial-gradient(circle at center, #ff4c76, #d90b5d);-webkit-background-clip: text;-webkit-text-fill-color: transparent;top:67%; left:50%; text-align:center; font-weight:400; background-size:inherit; background-position:inherit; font-family:Poppins; color:#ff4c76; font-size:90px; letter-spacing:-1px; line-height:100px;" class="ls-l" data-ls="durationin:2000; easingin:easeOutQuint; scalexin:.85; scaleyin:.85; transformoriginin:slidercenter slidermiddle; filterin:blur(10px); loop:true; loopoffsety:28sh; loopduration:3000; loopstartat:allinend - 1050; loopeasing:easeInOutQuint; loopcount:1; position: fixed;">LAYERSLIDER</div>
					<div style="top:67%; margin-top: -70px; left:50%; text-align:center; font-weight:400; background-size:inherit; background-position:inherit; font-family:Poppins; color:#ff4c76; letter-spacing:-1px; line-height:60px; font-size:70px; padding-right:20px; padding-left:20px;" class="ls-l" data-ls="durationin:2000; easingin:easeOutQuint; scalexin:.85; scaleyin:.85; transformoriginin:slidercenter slidermiddle; filterin:blur(10px); loop:true; loopoffsety:28sh; loopduration:3000; loopstartat:allinend - 1000; loopeasing:easeInOutQuint; loopcount:1; position: fixed;"><?= __( 'welcome to', 'LayerSlider' ) ?></div>
					<a style="" class="ls-l" href="<?= admin_url('admin.php?page=layerslider') ?>" target="_self" data-ls=" durationin:2000; easingin:easeOutElastic; scalein: 0.75; delayin:5000; hover:true; hoverdurationin:200; hovereasingin:easeOutQuart; hoverscalex:1.04; hoverscaley:1.04; position: fixed;">
						<div style="background: radial-gradient(circle at left, #ff4c76, #d90b5d);top:60%; left:50%; text-align:center; font-weight:600; background-size:inherit; background-position:inherit; padding: 15px 50px 14px 50px; font-family:Poppins; font-size: 30px; background-color:#1b9af7; color:#fff; border-radius:50px; box-shadow: 0 10px 30px -10px rgba(0,0,0,.3);" class=""><?= __( 'LET’S GET STARTED', 'LayerSlider' ) ?></div>
					</a>
				</div>
			</div>

		</div>

	</div>

	<ls-section id="ls--welcome-boxes">

		<ls-grid>
			<ls-row>
				<ls-col class="ls--col1-3">
					<ls-box>
						<ls-box-inner>
							<ls-h2><?= __('Preface', 'LayerSlider') ?></ls-h2>
							<ls-ul>
								<ls-li>
									<a href="https://layerslider.com/documentation/" target="_blank">
										<?= __('Introduction', 'LayerSlider') ?>
									</a>
								</ls-li>
								<ls-li>
									<a href="https://layerslider.com/documentation/#support" target="_blank">
										<?= __('Support', 'LayerSlider') ?>
									</a>
								</ls-li>
								<ls-li>
									<a href="https://layerslider.com/support-policy/" target="_blank">
										<?= __('Support Policies', 'LayerSlider') ?>
									</a>
								</ls-li>
								<ls-li>
									<a href="https://layerslider.com/release-log/" target="_blank">
										<?= __('Release Notes', 'LayerSlider') ?>
									</a>
								</ls-li>
							</ls-ul>
						</ls-box-inner>
					</ls-box>
				</ls-col>
				<ls-col class="ls--col1-3">
					<ls-box>
						<ls-box-inner>
							<ls-h2><?= __('Licensing', 'LayerSlider') ?></ls-h2>
							<ls-ul>
								<ls-li>
									<a href="https://layerslider.com/licensing/" target="_blank">
										<?= __('Licensing', 'LayerSlider') ?>
									</a>
								</ls-li>
								<ls-li>
									<a href="https://layerslider.com/licensing/#in-stock" target="_blank">
										<?= __('In-Stock Usage', 'LayerSlider') ?>
									</a>
								</ls-li>
								<ls-li>
									<a href="https://layerslider.com/terms-of-use/" target="_blank">
										<?= __('Terms of Use', 'LayerSlider') ?>
									</a>
								</ls-li>
								<ls-li>
									<a href="https://layerslider.com/legal/" target="_blank">
										<?= __('Legal', 'LayerSlider') ?>
									</a>
								</ls-li>
							</ls-ul>
						</ls-box-inner>
					</ls-box>
				</ls-col>
				<ls-col class="ls--col1-3">
					<ls-box>
						<ls-box-inner>
							<ls-h2><?= __('Getting Started', 'LayerSlider') ?></ls-h2>
							<ls-ul>

								<ls-li>
									<a href="https://layerslider.com/documentation/#updating" target="_blank">
										<?= __('Plugin updates', 'LayerSlider') ?>
									</a>
								</ls-li>
								<ls-li>
									<a href="https://layerslider.com/documentation/#demo-sliders" target="_blank">
										<?= __('Import demo content', 'LayerSlider') ?>
									</a>
								</ls-li>
								<ls-li>
									<a href="https://layerslider.com/documentation/" target="_blank">
										<?= __('Online Documentation', 'LayerSlider') ?>
									</a>
								</ls-li>
								<ls-li>
									<a href="https://layerslider.com/documentation/#troubleshooting" target="_blank">
										<?= __('Troubleshooting', 'LayerSlider') ?>
									</a>
								</ls-li>
							</ls-ul>
						</ls-box-inner>
					</ls-box>
				</ls-col>
			</ls-row>
		</ls-grid>
		<ls-grid>
			<ls-row>
				<ls-col class="ls--col1-3">
					<ls-box>
						<ls-box-inner>
							<ls-h2><?= __('Resources', 'LayerSlider') ?></ls-h2>
							<ls-ul>
								<ls-li>
									<a href="https://layerslider.com/documentation/" target="_blank">
										<?= __('End-User Documentation', 'LayerSlider') ?>
									</a>
								</ls-li>
								<ls-li>
									<a href="https://layerslider.com/developers/" target="_blank">
										<?= __('Developer Documentation', 'LayerSlider') ?>
									</a>
								</ls-li>
								<ls-li>
									<a href="https://layerslider.com/faq/" target="_blank">
										<?= __('Frequently Asked Questions', 'LayerSlider') ?>
									</a>
								</ls-li>
								<ls-li>
									<a href="https://layerslider.com/help/" target="_blank">
										<?= __('Help', 'LayerSlider') ?>
									</a>
								</ls-li>
							</ls-ul>
						</ls-box-inner>
					</ls-box>
				</ls-col>
				<ls-col class="ls--col1-3">
					<ls-box>
						<ls-box-inner>
							<ls-h2><?= __('Stay Updated', 'LayerSlider') ?></ls-h2>
							<ls-ul>
								<ls-li>
									<a href="https://twitter.com/kreaturamedia" target="_blank">
									<?= __('Follow us on Twitter', 'LayerSlider') ?></a>
								</ls-li>
								<ls-li>
									<a href="https://www.facebook.com/kreaturamedia/" target="_blank">
									<?= __('Follow us on Facebook', 'LayerSlider') ?></a>
								</ls-li>
								<ls-li>
									<a href="https://www.instagram.com/layersliderwp/" target="_blank">
									<?= __('Follow us on Instagram', 'LayerSlider') ?></a>
								</ls-li>
								<ls-li>
									<a href="https://www.youtube.com/user/kreaturamedia" target="_blank">
									<?= __('Watch our YouTube channel', 'LayerSlider') ?></a>
								</ls-li>
							</ls-ul>
						</ls-box-inner>
					</ls-box>
				</ls-col>
			</ls-row>
		</ls-grid>

	</ls-section>

</ls-wrapper>