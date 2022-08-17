<!doctype html>
<html>

<head>
	<meta charset="UTF-8">
	<meta name="robots" content="noindex">

	<title>Whoops!</title>

	<style>
		body {
			margin: 0;
			font-size: 20px;
		}

		* {
			box-sizing: border-box;
		}

		.container {
			position: relative;
			display: flex;
			align-items: center;
			justify-content: center;
			height: 100vh;
			background: white;
			color: black;
			font-family: arial, sans-serif;
			overflow: hidden;
		}

		.content {
			position: relative;
			width: 600px;
			max-width: 100%;
			margin: 20px;
			background: white;
			padding: 60px 40px;
			text-align: center;
			box-shadow: -10px 10px 67px -12px rgba(0, 0, 0, 0.2);
			opacity: 0;
			animation: apparition 0.8s 1.2s cubic-bezier(0.39, 0.575, 0.28, 0.995) forwards;
		}

		.content p {
			font-size: 1.3rem;
			margin-top: 0;
			margin-bottom: 0.6rem;
			letter-spacing: 0.1rem;
			color: #595959;
		}

		.content p:last-child {
			margin-bottom: 0;
		}

		.content a {
			display: inline-block;
			margin-top: 2rem;
			padding: 0.5rem 1rem;
			border: 3px solid #595959;
			background: transparent;
			font-size: 1rem;
			color: #595959;
			text-decoration: none;
			cursor: pointer;
			font-weight: bold;
		}

		.particle {
			position: absolute;
			display: block;
			pointer-events: none;
		}

		.particle:nth-child(1) {
			top: 32.1167883212%;
			left: 78.2778864971%;
			font-size: 22px;
			filter: blur(0.02px);
			animation: 22s floatReverse2 infinite;
		}

		.particle:nth-child(2) {
			top: 44.3896424168%;
			left: 86.0534124629%;
			font-size: 11px;
			filter: blur(0.04px);
			animation: 27s floatReverse2 infinite;
		}

		.particle:nth-child(3) {
			top: 71.7444717445%;
			left: 50.2958579882%;
			font-size: 14px;
			filter: blur(0.06px);
			animation: 37s floatReverse2 infinite;
		}

		.particle:nth-child(4) {
			top: 78.1664656212%;
			left: 79.6890184645%;
			font-size: 29px;
			filter: blur(0.08px);
			animation: 23s floatReverse infinite;
		}

		.particle:nth-child(5) {
			top: 69.4813027744%;
			left: 51.5063168124%;
			font-size: 29px;
			filter: blur(0.1px);
			animation: 36s floatReverse2 infinite;
		}

		.particle:nth-child(6) {
			top: 19.5599022005%;
			left: 55.0098231827%;
			font-size: 18px;
			filter: blur(0.12px);
			animation: 31s float2 infinite;
		}

		.particle:nth-child(7) {
			top: 30.243902439%;
			left: 39.2156862745%;
			font-size: 20px;
			filter: blur(0.14px);
			animation: 24s floatReverse infinite;
		}

		.particle:nth-child(8) {
			top: 57.0048309179%;
			left: 34.046692607%;
			font-size: 28px;
			filter: blur(0.16px);
			animation: 38s float infinite;
		}

		.particle:nth-child(9) {
			top: 38.5542168675%;
			left: 39.8058252427%;
			font-size: 30px;
			filter: blur(0.18px);
			animation: 39s floatReverse infinite;
		}

		.particle:nth-child(10) {
			top: 66.09963548%;
			left: 9.7751710655%;
			font-size: 23px;
			filter: blur(0.2px);
			animation: 25s floatReverse infinite;
		}

		.particle:nth-child(11) {
			top: 46.3054187192%;
			left: 47.4308300395%;
			font-size: 12px;
			filter: blur(0.22px);
			animation: 25s floatReverse2 infinite;
		}

		.particle:nth-child(12) {
			top: 27.4509803922%;
			left: 49.2125984252%;
			font-size: 16px;
			filter: blur(0.24px);
			animation: 28s floatReverse2 infinite;
		}

		.particle:nth-child(13) {
			top: 44.9328449328%;
			left: 87.3405299313%;
			font-size: 19px;
			filter: blur(0.26px);
			animation: 24s floatReverse2 infinite;
		}

		.particle:nth-child(14) {
			top: 33.2518337408%;
			left: 67.7799607073%;
			font-size: 18px;
			filter: blur(0.28px);
			animation: 25s floatReverse2 infinite;
		}

		.particle:nth-child(15) {
			top: 57.1428571429%;
			left: 13.6452241715%;
			font-size: 26px;
			filter: blur(0.3px);
			animation: 35s floatReverse infinite;
		}

		.particle:nth-child(16) {
			top: 59.1515151515%;
			left: 77.0731707317%;
			font-size: 25px;
			filter: blur(0.32px);
			animation: 37s floatReverse infinite;
		}

		.particle:nth-child(17) {
			top: 58.4652862363%;
			left: 12.7326150833%;
			font-size: 21px;
			filter: blur(0.34px);
			animation: 23s floatReverse2 infinite;
		}

		.particle:nth-child(18) {
			top: 96.5853658537%;
			left: 77.4509803922%;
			font-size: 20px;
			filter: blur(0.36px);
			animation: 30s floatReverse infinite;
		}

		.particle:nth-child(19) {
			top: 85.4368932039%;
			left: 72.265625%;
			font-size: 24px;
			filter: blur(0.38px);
			animation: 37s floatReverse infinite;
		}

		.particle:nth-child(20) {
			top: 37.7723970944%;
			left: 82.8460038986%;
			font-size: 26px;
			filter: blur(0.4px);
			animation: 39s float2 infinite;
		}

		.particle:nth-child(21) {
			top: 34.1463414634%;
			left: 93.137254902%;
			font-size: 20px;
			filter: blur(0.42px);
			animation: 21s float2 infinite;
		}

		.particle:nth-child(22) {
			top: 85.1897184823%;
			left: 48.1809242871%;
			font-size: 17px;
			filter: blur(0.44px);
			animation: 34s floatReverse infinite;
		}

		.particle:nth-child(23) {
			top: 55.205811138%;
			left: 26.3157894737%;
			font-size: 26px;
			filter: blur(0.46px);
			animation: 37s floatReverse2 infinite;
		}

		.particle:nth-child(24) {
			top: 61.1590628853%;
			left: 40.5539070227%;
			font-size: 11px;
			filter: blur(0.48px);
			animation: 38s floatReverse2 infinite;
		}

		.particle:nth-child(25) {
			top: 18.3353437877%;
			left: 42.7599611273%;
			font-size: 29px;
			filter: blur(0.5px);
			animation: 30s float infinite;
		}

		.particle:nth-child(26) {
			top: 84.4171779141%;
			left: 54.1871921182%;
			font-size: 15px;
			filter: blur(0.52px);
			animation: 38s float2 infinite;
		}

		.particle:nth-child(27) {
			top: 43.3734939759%;
			left: 92.2330097087%;
			font-size: 30px;
			filter: blur(0.54px);
			animation: 34s floatReverse2 infinite;
		}

		.particle:nth-child(28) {
			top: 42.1568627451%;
			left: 18.7007874016%;
			font-size: 16px;
			filter: blur(0.56px);
			animation: 25s floatReverse2 infinite;
		}

		.particle:nth-child(29) {
			top: 77.3561811506%;
			left: 26.5486725664%;
			font-size: 17px;
			filter: blur(0.58px);
			animation: 39s float2 infinite;
		}

		.particle:nth-child(30) {
			top: 66.5060240964%;
			left: 29.1262135922%;
			font-size: 30px;
			filter: blur(0.6px);
			animation: 37s floatReverse2 infinite;
		}

		.particle:nth-child(31) {
			top: 67.0716889429%;
			left: 23.4604105572%;
			font-size: 23px;
			filter: blur(0.62px);
			animation: 23s float infinite;
		}

		.particle:nth-child(32) {
			top: 54.501216545%;
			left: 39.1389432485%;
			font-size: 22px;
			filter: blur(0.64px);
			animation: 30s float2 infinite;
		}

		.particle:nth-child(33) {
			top: 89.7657213317%;
			left: 7.9129574679%;
			font-size: 11px;
			filter: blur(0.66px);
			animation: 36s float2 infinite;
		}

		.particle:nth-child(34) {
			top: 78.1440781441%;
			left: 88.3218842002%;
			font-size: 19px;
			filter: blur(0.68px);
			animation: 28s float infinite;
		}

		.particle:nth-child(35) {
			top: 28.0193236715%;
			left: 93.3852140078%;
			font-size: 28px;
			filter: blur(0.7px);
			animation: 29s float infinite;
		}

		.particle:nth-child(36) {
			top: 50.8557457213%;
			left: 55.9921414538%;
			font-size: 18px;
			filter: blur(0.72px);
			animation: 36s floatReverse infinite;
		}

		.particle:nth-child(37) {
			top: 43.425814234%;
			left: 40.8163265306%;
			font-size: 29px;
			filter: blur(0.74px);
			animation: 34s floatReverse infinite;
		}

		.particle:nth-child(38) {
			top: 59.9758162031%;
			left: 1.9474196689%;
			font-size: 27px;
			filter: blur(0.76px);
			animation: 30s float2 infinite;
		}

		.particle:nth-child(39) {
			top: 90.5109489051%;
			left: 24.4618395303%;
			font-size: 22px;
			filter: blur(0.78px);
			animation: 22s floatReverse infinite;
		}

		.particle:nth-child(40) {
			top: 60.8695652174%;
			left: 92.4124513619%;
			font-size: 28px;
			filter: blur(0.8px);
			animation: 32s float infinite;
		}

		.particle:nth-child(41) {
			top: 97.5609756098%;
			left: 21.568627451%;
			font-size: 20px;
			filter: blur(0.82px);
			animation: 27s floatReverse infinite;
		}

		.particle:nth-child(42) {
			top: 76.0048721072%;
			left: 62.6836434868%;
			font-size: 21px;
			filter: blur(0.84px);
			animation: 21s float infinite;
		}

		.particle:nth-child(43) {
			top: 50.2463054187%;
			left: 62.2529644269%;
			font-size: 12px;
			filter: blur(0.86px);
			animation: 28s floatReverse infinite;
		}

		.particle:nth-child(44) {
			top: 95.7264957265%;
			left: 7.8508341511%;
			font-size: 19px;
			filter: blur(0.88px);
			animation: 37s float infinite;
		}

		.particle:nth-child(45) {
			top: 72.2832722833%;
			left: 6.8694798822%;
			font-size: 19px;
			filter: blur(0.9px);
			animation: 21s floatReverse2 infinite;
		}

		.particle:nth-child(46) {
			top: 62.6506024096%;
			left: 66.9902912621%;
			font-size: 30px;
			filter: blur(0.92px);
			animation: 26s floatReverse infinite;
		}

		.particle:nth-child(47) {
			top: 81.9512195122%;
			left: 62.7450980392%;
			font-size: 20px;
			filter: blur(0.94px);
			animation: 30s floatReverse infinite;
		}

		.particle:nth-child(48) {
			top: 52.1739130435%;
			left: 58.3657587549%;
			font-size: 28px;
			filter: blur(0.96px);
			animation: 40s floatReverse infinite;
		}

		.particle:nth-child(49) {
			top: 2.9197080292%;
			left: 30.3326810176%;
			font-size: 22px;
			filter: blur(0.98px);
			animation: 30s floatReverse2 infinite;
		}

		.particle:nth-child(50) {
			top: 21.568627451%;
			left: 41.3385826772%;
			font-size: 16px;
			filter: blur(1px);
			animation: 35s float infinite;
		}

		.particle:nth-child(51) {
			top: 67.5512665862%;
			left: 2.915451895%;
			font-size: 29px;
			filter: blur(1.02px);
			animation: 23s float infinite;
		}

		.particle:nth-child(52) {
			top: 9.7442143727%;
			left: 14.6914789422%;
			font-size: 21px;
			filter: blur(1.04px);
			animation: 30s float infinite;
		}

		.particle:nth-child(53) {
			top: 24.6002460025%;
			left: 33.5636722606%;
			font-size: 13px;
			filter: blur(1.06px);
			animation: 38s floatReverse infinite;
		}

		.particle:nth-child(54) {
			top: 23.2727272727%;
			left: 59.512195122%;
			font-size: 25px;
			filter: blur(1.08px);
			animation: 32s float infinite;
		}

		.particle:nth-child(55) {
			top: 61.0086100861%;
			left: 37.5123395854%;
			font-size: 13px;
			filter: blur(1.1px);
			animation: 40s float2 infinite;
		}

		.particle:nth-child(56) {
			top: 80%;
			left: 82.3529411765%;
			font-size: 20px;
			filter: blur(1.12px);
			animation: 32s float2 infinite;
		}

		.particle:nth-child(57) {
			top: 50.9803921569%;
			left: 56.1023622047%;
			font-size: 16px;
			filter: blur(1.14px);
			animation: 40s float infinite;
		}

		.particle:nth-child(58) {
			top: 71.1327649208%;
			left: 20.5680705191%;
			font-size: 21px;
			filter: blur(1.16px);
			animation: 28s floatReverse2 infinite;
		}

		.particle:nth-child(59) {
			top: 4.9079754601%;
			left: 10.8374384236%;
			font-size: 15px;
			filter: blur(1.18px);
			animation: 23s floatReverse2 infinite;
		}

		.particle:nth-child(60) {
			top: 76.6584766585%;
			left: 34.516765286%;
			font-size: 14px;
			filter: blur(1.2px);
			animation: 32s floatReverse infinite;
		}

		.particle:nth-child(61) {
			top: 35.2941176471%;
			left: 9.842519685%;
			font-size: 16px;
			filter: blur(1.22px);
			animation: 21s float2 infinite;
		}

		.particle:nth-child(62) {
			top: 54.0540540541%;
			left: 12.8205128205%;
			font-size: 14px;
			filter: blur(1.24px);
			animation: 22s float2 infinite;
		}

		.particle:nth-child(63) {
			top: 91.6767189385%;
			left: 32.0699708455%;
			font-size: 29px;
			filter: blur(1.26px);
			animation: 30s floatReverse infinite;
		}

		.particle:nth-child(64) {
			top: 16.6056166056%;
			left: 75.5642787046%;
			font-size: 19px;
			filter: blur(1.28px);
			animation: 40s float infinite;
		}

		.particle:nth-child(65) {
			top: 35.792019347%;
			left: 11.6845180136%;
			font-size: 27px;
			filter: blur(1.3px);
			animation: 36s floatReverse2 infinite;
		}

		.particle:nth-child(66) {
			top: 41.2776412776%;
			left: 86.7850098619%;
			font-size: 14px;
			filter: blur(1.32px);
			animation: 34s floatReverse2 infinite;
		}

		.particle:nth-child(67) {
			top: 65.8595641646%;
			left: 38.0116959064%;
			font-size: 26px;
			filter: blur(1.34px);
			animation: 22s float infinite;
		}

		.particle:nth-child(68) {
			top: 11.8226600985%;
			left: 86.9565217391%;
			font-size: 12px;
			filter: blur(1.36px);
			animation: 35s floatReverse2 infinite;
		}

		.particle:nth-child(69) {
			top: 21.6216216216%;
			left: 63.1163708087%;
			font-size: 14px;
			filter: blur(1.38px);
			animation: 39s float2 infinite;
		}

		.particle:nth-child(70) {
			top: 23.6162361624%;
			left: 83.9091806515%;
			font-size: 13px;
			filter: blur(1.4px);
			animation: 32s float infinite;
		}

		.particle:nth-child(71) {
			top: 33.4563345633%;
			left: 55.2813425469%;
			font-size: 13px;
			filter: blur(1.42px);
			animation: 21s floatReverse infinite;
		}

		.particle:nth-child(72) {
			top: 16.6871165644%;
			left: 21.6748768473%;
			font-size: 15px;
			filter: blur(1.44px);
			animation: 30s float infinite;
		}

		.particle:nth-child(73) {
			top: 59.8039215686%;
			left: 53.1496062992%;
			font-size: 16px;
			filter: blur(1.46px);
			animation: 39s floatReverse infinite;
		}

		.particle:nth-child(74) {
			top: 69.864698647%;
			left: 61.2043435341%;
			font-size: 13px;
			filter: blur(1.48px);
			animation: 37s floatReverse2 infinite;
		}

		.particle:nth-child(75) {
			top: 4.8367593712%;
			left: 6.8159688413%;
			font-size: 27px;
			filter: blur(1.5px);
			animation: 36s float2 infinite;
		}

		.particle:nth-child(76) {
			top: 79.0243902439%;
			left: 94.1176470588%;
			font-size: 20px;
			filter: blur(1.52px);
			animation: 33s float2 infinite;
		}

		.particle:nth-child(77) {
			top: 31.4496314496%;
			left: 40.4339250493%;
			font-size: 14px;
			filter: blur(1.54px);
			animation: 32s floatReverse infinite;
		}

		.particle:nth-child(78) {
			top: 13.7086903305%;
			left: 4.9164208456%;
			font-size: 17px;
			filter: blur(1.56px);
			animation: 25s floatReverse infinite;
		}

		.particle:nth-child(79) {
			top: 40.7272727273%;
			left: 90.7317073171%;
			font-size: 25px;
			filter: blur(1.58px);
			animation: 22s floatReverse2 infinite;
		}

		.particle:nth-child(80) {
			top: 95.8837772397%;
			left: 64.3274853801%;
			font-size: 26px;
			filter: blur(1.6px);
			animation: 24s floatReverse2 infinite;
		}

		@keyframes apparition {
			from {
				opacity: 0;
				transform: translateY(100px);
			}

			to {
				opacity: 1;
				transform: translateY(0);
			}
		}

		@keyframes float {

			0%,
			100% {
				transform: translateY(0);
			}

			50% {
				transform: translateY(180px);
			}
		}

		@keyframes floatReverse {

			0%,
			100% {
				transform: translateY(0);
			}

			50% {
				transform: translateY(-180px);
			}
		}

		@keyframes float2 {

			0%,
			100% {
				transform: translateY(0);
			}

			50% {
				transform: translateY(28px);
			}
		}

		@keyframes floatReverse2 {

			0%,
			100% {
				transform: translateY(0);
			}

			50% {
				transform: translateY(-28px);
			}
		}
	</style>

	<style type="text/css">
		<?= preg_replace('#[\r\n\t ]+#', ' ', file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'debug.css')) ?>
	</style>
</head>

<body>
	<main class='container'>
		<span class='particle'>4</span>
		<span class='particle'>4</span>
		<span class='particle'>4</span>
		<span class='particle'>4</span>
		<span class='particle'>4</span>
		<span class='particle'>4</span>
		<span class='particle'>4</span>
		<span class='particle'>4</span>
		<span class='particle'>4</span>
		<span class='particle'>4</span>
		<span class='particle'>4</span>
		<span class='particle'>4</span>
		<span class='particle'>4</span>
		<span class='particle'>4</span>
		<span class='particle'>4</span>
		<span class='particle'>4</span>
		<span class='particle'>4</span>
		<span class='particle'>4</span>
		<span class='particle'>4</span>
		<span class='particle'>4</span>
		<span class='particle'>4</span>
		<span class='particle'>4</span>
		<span class='particle'>4</span>
		<span class='particle'>4</span>
		<span class='particle'>4</span>
		<span class='particle'>4</span>
		<span class='particle'>4</span>
		<span class='particle'>4</span>
		<span class='particle'>4</span>
		<span class='particle'>4</span>
		<span class='particle'>4</span>
		<span class='particle'>4</span>
		<span class='particle'>4</span>
		<span class='particle'>4</span>
		<span class='particle'>4</span>
		<span class='particle'>4</span>
		<span class='particle'>4</span>
		<span class='particle'>4</span>
		<span class='particle'>4</span>
		<span class='particle'>4</span>
		<span class='particle'>0</span>
		<span class='particle'>0</span>
		<span class='particle'>0</span>
		<span class='particle'>0</span>
		<span class='particle'>0</span>
		<span class='particle'>0</span>
		<span class='particle'>0</span>
		<span class='particle'>0</span>
		<span class='particle'>0</span>
		<span class='particle'>0</span>
		<span class='particle'>0</span>
		<span class='particle'>0</span>
		<span class='particle'>0</span>
		<span class='particle'>0</span>
		<span class='particle'>0</span>
		<span class='particle'>0</span>
		<span class='particle'>0</span>
		<span class='particle'>0</span>
		<span class='particle'>0</span>
		<span class='particle'>0</span>
		<span class='particle'>0</span>
		<span class='particle'>0</span>
		<span class='particle'>0</span>
		<span class='particle'>0</span>
		<span class='particle'>0</span>
		<span class='particle'>0</span>
		<span class='particle'>0</span>
		<span class='particle'>0</span>
		<span class='particle'>0</span>
		<span class='particle'>0</span>
		<span class='particle'>0</span>
		<span class='particle'>0</span>
		<span class='particle'>0</span>
		<span class='particle'>0</span>
		<span class='particle'>0</span>
		<span class='particle'>0</span>
		<span class='particle'>0</span>
		<span class='particle'>0</span>
		<span class='particle'>0</span>
		<span class='particle'>0</span>
		<article class='content'>
			<p>Whoops!,</p>
			<p>We seem to have <strong>hit a snag</strong>. Please try again later....</p>
			<p>
				<?php $url_value = session()->get('user_level'); ?>
				<?php if ($url_value == 'admin super') {
					$url_redirect_value = explode(' ', $url_value);
				}; ?>
				<a href="<?= $url_value == 'admin super' ? base_url($url_redirect_value[0]) : base_url('home'); ?>">Go back to earth.</a>
			</p>
		</article>
	</main>

</body>

</html>