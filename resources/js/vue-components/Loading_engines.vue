<style>
	.gear {
		float: left;
		position: relative;
		z-index:20;
	}
	.gears .gear .bar {
		height: 100%;
		width: 100%;
		border: 2px solid black;
		border-radius: 10px 0px;
	}
	.bar {
		position: absolute;
	}
	.bar2 {
		transform: rotate(57deg)
	}
	.bar3 {
		transform: rotate(-57deg)
	}
	.gears {
		width: 57px;
	}
	.gears .error {
		position: relative;
		left: -6px;
		top: -18px;
	}
	@-webkit-keyframes clockwise {
		0% { -webkit-transform: rotate(0deg); }
		100% { -webkit-transform: rotate(360deg); }
	}
	@-webkit-keyframes anticlockwise {
		0% { -webkit-transform: rotate(360deg);}
		100% { -webkit-transform: rotate(0deg);}
	}
	.gear.one {
		top: -1px;
		height:15px;
		width:7px;
		-webkit-animation: clockwise 1.5s linear infinite;
	}
	.gear.two {
		top: 2px;
		left: 7px;
		height:20px;
		width:10px;
		-webkit-animation: anticlockwise 2s linear infinite;
	}
	.gear.three {
		top: 2px;
		left: 13px;
		height:15px;
		width:10px;
		-webkit-animation: clockwise 1.5s linear infinite;
	}
	.gear.four {
		top: 2px;
		left: 19px;
		height:19px;
		width:9px;
		-webkit-animation: anticlockwise 2s linear infinite;
	}
</style>

<template>
	<div class="gears">
		<div class="gear one">
			<div class="bar bar1"></div>
			<div class="bar bar2"></div>
			<div class="bar bar3"></div>
		</div>
		<div class="gear two">
			<div class="bar bar1"></div>
			<div class="bar bar2"></div>
			<div class="bar bar3"></div>
		</div>
		<div class="gear three">
			<div class="bar bar1"></div>
			<div class="bar bar2"></div>
			<div class="bar bar3"></div>
		</div>
		<div class="gear four">
			<div class="bar bar1"></div>
			<div class="bar bar2"></div>
			<div class="bar bar3"></div>
		</div>
		<div v-if="error" class="z-30 inline-block bg-red-500 rounded error text-sm">
			Error!
		</div>
	</div>
</template>

<script>
export default {
	props: {
		error: {default:false}
	}
}
</script>