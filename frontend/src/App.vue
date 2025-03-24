<script setup>
import { ref, onMounted, onUnmounted, computed, watch } from 'vue';
import { RouterView } from "vue-router";
import Footer from "./components/helpers/Footer.vue";
import { useMainStore } from "@/stores/main"
import { storeToRefs } from 'pinia';

const mainStore = useMainStore()

const { currentBackground, isMobile } = storeToRefs(mainStore)
const { updateScreenWidth } = mainStore

onMounted(() => {
	window.addEventListener('resize', function () {
		updateScreenWidth()
	});
});

onUnmounted(() => {
	window.removeEventListener('resize', function () {
		updateScreenWidth()
	});
});
</script>

<template>
	<video-background class="video-background" :src="currentBackground" poster="" :sources="[
		{ src: currentBackground, res: 900, autoplay: true },
		{ src: currentBackground, res: 638, autoplay: true, poster: '' }
	]">
		<div class="app-container">
			<div class="main-content">
				<div class="router-view" :class="[isMobile ? 'mobile' : 'desktop']">
					<router-view v-slot="{ Component }">
						<component :is="Component" />
					</router-view>
				</div>
				<Footer />
			</div>
		</div>
	</video-background>
</template>

<style scoped>
.app-container {
	display: flex;
	flex-direction: column;
	height: 100vh;
	width: 100vw;
}

.mobile {
	padding: 4rem 2rem;
}

.desktop {
	padding: 7rem 10rem;
}

.main-content {
	display: flex;
	flex-grow: 1;
	flex-direction: column;
	/* padding-bottom: calc(5rem); */
	overflow: auto;
}

.router-view {
	flex-grow: 1;
	width: calc(100%);
	height: calc(100%);
	overflow: auto;
}

header {
	line-height: 1.5;
	max-height: 100vh;
	padding: 3rem;
}

.video-background {
	min-height: 100vh;
	min-width: 100vw;
}


@media (min-width: 1024px) {
	header {
		display: flex;
		place-items: center;
		padding-right: calc(var(--section-gap) / 2);
	}

	header .wrapper {
		display: flex;
		place-items: flex-start;
		flex-wrap: wrap;
	}

	nav {
		text-align: left;
		margin-left: -1rem;
		/* font-size: 1rem; */

		padding: 1rem 0;
		margin-top: 1rem;
	}
}

.fade-enter-active,
.fade-leave-active {
	transition: opacity 0.3s ease;
}

.fade-enter-from,
.fade-leave-to {
	opacity: 0;
}
</style>
