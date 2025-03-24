<template>
	<AppLoader v-if="isLoadingApp" />
	<main class="min-h-screen text-center">
		<!-- Main content -->
		<div class="wrapper px-10 py-5 border-2 border-solid border-black rounded-lg bg-gray-200 mx-auto text-center"
			:class="isMobile ? 'home-mobile' : 'home-desktop'">
			<img alt="Vue logo" class="w-28 h-20 mx-auto" src="@/assets/logo.png" />
			<h1 class="text-2xl text-identity-dark dark:text-gray-300 m-4">Events Challange</h1>
			<!-- Client ID -->
			<div class="flex justify-center items-center py-2 px-10 text-center cursor-pointer rounded-lg border border-gray-600 shadow-lg gap-4"
				@click="toggleCollapse">
				<div class="flex justify-center items-center cursor-pointer">
					<span class="text-black text-base font-bold ">Client ID</span>
				</div>
				<span class="text-sm text-gray-500">
					<component v-if="isCollapsed" class="h-6 w-6" :is="iconsForm['IconArrowDown']" />
					<component v-else class="h-6 w-6" :is="iconsForm['IconArrowUp']" />
				</span>
			</div>
			<!-- Content retraibale -->
			<div v-if="!isCollapsed" class="flex flex-wrap flex-row transition-all duration-300 px-4 py-2">
				<div class="basis-2/3">
					<input v-model="CLIENT_ID" :disabled="true" type="text" :placeholder="'Client ID'"
						:class="'bg-gray-400'"
						class="block w-full rounded-lg px-5 py-2.5 placeholder-gray-400/70 text-gray-700 border border-gray-200 dark:border-gray-600 focus:border-indigo-600 dark:focus:border-indigo-300 focus:ring-indigo-300 focus:outline-none focus:ring focus:ring-opacity-40" />
				</div>
				<div class="basis-1/3">
					<button @click="copyToClipboard" :class="'bg-identity-dark hover:bg-gray-700'"
						class="flex items-center px-5 py-2 text-sm text-identity capitalize transition-colors duration-200 border rounded-md gap-x-2 dark:text-gray-200 dark:border-gray-200 ">
						<component class="h-6 w-6" :is="iconsForm['IconCopy']" />
					</button>
				</div>
			</div>
		</div>
		<!-- Input Client ID -->
		<div
			class="wrapper flex flex-row items-center justify-center px-10 py-2 border-2 border-solid border-black rounded-lg bg-gray-200 mx-auto text-center">
			<div :class="isMobile ? 'basis-3/4' : 'basis-1/3'">
				<input v-model="clientCopied" type="text" :placeholder="'Client ID'"
					:class="lockApplied ? 'bg-gray-400' : 'bg-white'" :disabled="lockApplied"
					class="block w-full rounded-lg px-5 py-2.5 placeholder-gray-400/70 text-gray-700 border border-gray-200 dark:border-gray-600 focus:border-indigo-600 dark:focus:border-indigo-300 focus:ring-indigo-300 focus:outline-none focus:ring focus:ring-opacity-40" />
			</div>
			<div>
				<button @click="lockClient" :class="'bg-identity-dark hover:bg-gray-700'"
					class="flex items-center px-5 py-2 text-sm text-identity capitalize transition-colors duration-200 border rounded-md gap-x-2 dark:text-gray-200 dark:border-gray-200 ">
					<component v-if="lockApplied" class="h-6 w-6" :is="iconsForm['IconLockClosed']" />
					<component v-else class="h-6 w-6" :is="iconsForm['IconLockOpen']" />
				</button>
			</div>
		</div>
		<div class="px-8 py-4 bg-gray-200 border-2 border-solid border-black rounded-lg mt-4 mx-auto"
			style="width: fit-content;">
			<div class="flex flex-row items-center">
				<button @click="addEvent" :class="'bg-identity-dark hover:bg-gray-700'"
					class="mb-2 flex items-center px-5 py-2 text-sm text-identity capitalize transition-colors duration-200 border rounded-md gap-x-2 dark:text-gray-200 dark:border-gray-200 ">
					<component class="h-6 w-6" :is="iconsForm['IconPlus']" />
					<span>
						Add Event
					</span>
				</button>
				<button @click="fetchDataTable" :class="'bg-identity-dark hover:bg-gray-700'"
					class="mb-2 flex items-center px-5 py-2 text-sm text-identity capitalize transition-colors duration-200 border rounded-md gap-x-2 dark:text-gray-200 dark:border-gray-200 ">
					<component class="h-6 w-6" :is="iconsForm['IconSync']" />
				</button>
			</div>
			<BaseTable :table="'events'" :data-table="dataTable" :icons-view="isMobile ? [] : ['IconClipboardList']"
				@serach-event-by-id="serachEventById" />
		</div>
	</main>
	<!-- Modal Add Event -->
	<Modal :is-modal-open="isModalOpen" @close-modal="closeModal" :max-height="'max-entity-height'"
		:max-width="'max-w-4xl'">
		<template #icon>
			<component :is="iconsForm['IconPlus']" />
		</template>
		<template #title>
			<h3 class="text-lg font-medium leading-6 text-gray-800 capitalize dark:text-white" id="modal-title">
				Add Event
			</h3>
		</template>
		<template #content>
			<BaseForm :type-form="'event'" @close-modal="closeModal" @send-form="sendForm" />
		</template>
	</Modal>
	<!-- Modal Event by Id -->
	<Modal :is-modal-open="isModalOpenEventById" @close-modal="closeModal" :max-height="'max-entity-height'"
		:max-width="'max-w-4xl'">
		<template #icon>
			<component :is="iconsForm['IconCalendar']" />
		</template>
		<template #title>
			<h3 class="text-lg font-medium leading-6 text-gray-800 capitalize dark:text-white" id="modal-title">
				Event
			</h3>
		</template>
		<template #content>
			<div v-for="(value, key) in eventById" :key="key"
				class="basis-full text-sm font-normal text-center rtl:text-right text-identity dark:text-gray-300">
				<span class="text-lg font-bold text-identity-dark dark:text-gray-300 mr-4">{{ key }}</span>
				<span class="text-lg font-bold text-identity-dark dark:text-gray-300">:</span>
				<span class="text-lg font-bold text-identity-dark dark:text-gray-300 ml-4">{{ value }}</span>
			</div>
		</template>
	</Modal>
</template>
<script setup>
import BaseTable from "@/components/tables/BaseTable.vue";
import BaseForm from "@/components/forms/BaseForm.vue";
import Modal from "@/components/helpers/Modal.vue";
import AppLoader from "@/components/loader/AppLoader.vue";
import { useMainStore } from "@/stores/main"
import { useIconStore } from "@/stores/icons";
import { storeToRefs } from 'pinia';
import { onMounted, ref } from "vue";

const mainStore = useMainStore()

const { isMobile } = storeToRefs(mainStore)

const { getenv } = mainStore

const backendUrl = getenv('APP_BACKEND_URL')

const formIconNames = ref(['IconPlus', 'IconArrowUp', 'IconArrowDown', 'IconCopy', 'IconLockOpen', 'IconLockClosed', 'IconSync', 'IconCalendar']);
const { iconsForm, loadFormIcons } = useIconStore();

onMounted(async () => {
	await loadFormIcons(formIconNames.value);
});

const eventById = ref(null);

const isModalOpen = ref(false);
const isModalOpenEventById = ref(false);

const addEvent = () => {
	isModalOpen.value = true;
};

const closeModal = () => {
	isModalOpen.value = false;
	isModalOpenEventById.value = false;
};

const isCollapsed = ref(true);

const toggleCollapse = () => {
	isCollapsed.value = !isCollapsed.value;
};

const CLIENT_ID = getenv('CLIENT_ID');

const clientToSend = ref('')

const clientCopied = ref('')

const copyToClipboard = () => {
	navigator.clipboard.writeText(CLIENT_ID);
	alert('Client ID copied to clipboard');
};

const lockApplied = ref(false)

const lockClient = () => {
	lockApplied.value = !lockApplied.value
	lockApplied.value ? clientToSend.value = clientCopied.value : clientToSend.value = ''

	if (lockApplied.value) {
		isCollapsed.value = true
	}
}

const dataTable = ref({
	data: {
		columns: [],
		rows: []
	},
	current_page: 1,
	total: 0,
	per_page: 10,
	last_page: 1
})

const fetchDataTable = async () => {
	setLoadingApp(true)
	const url = `${backendUrl}/api/events`

	if (!clientToSend.value) {
		alert('Client ID is required')
		setLoadingApp(false)
		return
	}

	const response = await fetch(url, {
		method: 'GET',
		headers: {
			'Client-ID': clientToSend.value,
			'Content-Type': 'application/json',
			Accept: "application/json",
		},
		mode: 'cors',
	})

	if (response.status === 401) {
		alert(`${response.statusText}, Invalid client credentials - ${response.status}`)
		setLoadingApp(false)
		return
	}

	if (!response.ok) {
		alert('Error fetching data')
		setLoadingApp(false)
		return
	}

	const data = await response.json()
	dataTable.value = data
	setLoadingApp(false)
}

const isLoadingApp = ref(false)

const setLoadingApp = (value) => {
	isLoadingApp.value = value
}

const sendForm = async (dataForm) => {
	setLoadingApp(true)
	try {
		const url = `${backendUrl}/api/events`

		if (!clientToSend.value) {
			alert('Client ID is required')
			setLoadingApp(false)
			return
		}

		const response = await fetch(url, {
			method: "POST",
			headers: {
				'Client-ID': clientToSend.value,
				Accept: "application/json",
			},
			mode: "cors",
			body: JSON.stringify(dataForm),
		});

		if (response.status === 401) {
			alert(`${response.statusText}, Invalid client credentials - ${response.status}`)
			setLoadingApp(false)
			return
		}

		if (!response.ok) {
			alert('Error sending data')
			setLoadingApp(false)
			return
		}

		const data = await response.json();

		dataTable.value.data.rows.unshift(getRow(data));

		if (response.ok) {
			alert('Event added successfully')
		}

		setLoadingApp(false)
	} catch (error) {
		throw error;
	}
};

const getRow = (data) => {
	return {
		...data, actions: [{
			action: "See details",
			key: "view_details",
		}]
	}
};

const serachEventById = async (id) => {
	setLoadingApp(true)

	if (!id) {
		alert('Event ID is required')
		setLoadingApp(false)
		return
	}

	const url = `${backendUrl}/api/events/${id}`

	if (!clientToSend.value) {
		alert('Client ID is required')
		setLoadingApp(false)
		return
	}

	const response = await fetch(url, {
		method: 'GET',
		headers: {
			'Client-ID': clientToSend.value,
			'Content-Type': 'application/json',
			Accept: "application/json",
		},
		mode: 'cors',
	})

	if (response.status === 401) {
		alert(`${response.statusText}, Invalid client credentials - ${response.status}`)
		setLoadingApp(false)
		return
	}

	if (!response.ok) {
		alert('Error getting event.')
		setLoadingApp(false)
		return
	}

	const data = await response.json()
	eventById.value = data
	isModalOpenEventById.value = true
	setLoadingApp(false)
}

</script>

<style scoped>
.home-mobile {
	margin-bottom: 1rem;
}

.home-desktop {
	width: 33%;
	margin-bottom: 1rem;
}

.max-entity-height {
	max-height: 37rem;
}
</style>
