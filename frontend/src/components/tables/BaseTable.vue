<template>
    <AppLoader v-if="isLoadingApp" />
    <div v-else class="w-full py-8 md:p-8 rounded-lg custom-shadow bg-gray-200"
        :class="isMobile ? 'border-color-identity-dark-gold' : 'border-color-identity-dark-gold'">
        <div v-if="props.iconsView.length > 0"
            class="flex justify-center items-center -mt-16 md:-mt-28 md:justify-end md:mb-4">
            <!-- Icon Form -->
            <component v-if="viewIcons[props.iconsView[0]]" :is="viewIcons[props.iconsView[0]]"
                class="p-4 w-20 h-20 md:w-24 md:h-24 md:mr-1/6 border-color-identity-dark-gold-thick rounded-full dark:border-gray-300"
                :class="'bg-identity-dark text-identity'" />
        </div>
        <div class="flex flex-row flex-wrap">
            <section class="container">
                <!-- Search -->
                <div class="relative flex items-center my-2 md:my-0 md:px-6 lg:px-8 justify-end">
                    <div class="basis-full md:basis-1/3 relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                            <component :is="iconsForm['IconSearch']" class="text-gray-300 w-8 h-8" />
                        </span>
                        <input v-model="searchEvent" type="text" placeholder="Search by Event ID" :class="'bg-white'"
                            class="block w-full py-2.5 rounded-lg pl-11 pr-5 rtl:pr-11 rtl:pl-5 placeholder-gray-400/70 text-gray-700 border border-gray-200 dark:border-gray-600 focus:border-indigo-600 dark:focus:border-indigo-300 focus:ring-indigo-300 focus:outline-none focus:ring focus:ring-opacity-40">
                    </div>
                    <button @click="emit('serachEventById', searchEvent)"
                        class="ml-2 p-1 bg-identity-dark rounded-lg inset-y-0 right-0 flex items-center justify-center pr-3">
                        <component :is="iconsForm['IconSearch']" class="text-gray-300 w-8 h-8" />
                    </button>
                </div>
                <!-- Div Table -->
                <div class="flex flex-col">
                    <div class="overflow-x-auto">
                        <div class="inline-block min-w-full align-middle py-2 md:px-6 lg:px-8">
                            <div class="overflow-hidden border border-gray-700 dark:border-gray-200 md:rounded-lg">
                                <!-- Table -->
                                <table class="min-w-full divide-y divide-gray-700 dark:divide-gray-200 table-fixed">
                                    <thead class="bg-identity-dark dark:bg-gray-900">
                                        <tr>
                                            <th v-for="column in filterHeaders()" :key="column.key"
                                                class="py-3.5 px-4 text-sm font-normal text-center rtl:text-right text-identity dark:text-gray-300">
                                                <span>
                                                    {{ column.header }}
                                                </span>
                                            </th>
                                        </tr>
                                    </thead>
                                    <transition-group tag="tbody" name="fade" mode="out-in"
                                        class="divide-y divide-gray-700 dark:divide-gray-200">
                                        <tr v-for="(row, index_row) in filterTable()" :key="index_row">
                                            <td v-for="(column, index_colum) in filterColumns()" :key="column.key"
                                                class=" px-2 py-2 text-sm text-center font-medium text-gray-700 dark:text-gray-200 overflow-auto">

                                                <!-- "Actions" -->
                                                <template v-if="column.key === 'actions'">
                                                    <div class="flex flex-row flex-wrap justify-center">
                                                        <button v-for="action in row.actions" :key="action.key"
                                                            @click="clickAction(action.key, row)" :title="action.action"
                                                            v-tooltip="action.action"
                                                            :class="['m-1 p-1 rounded-md shadow-xl', actionIconClass(action.key), 'custom-shadow']">
                                                            <component :class="['w-5 h-5', actionIconText(action.key)]"
                                                                :is="actionsIcon(action.key)" />
                                                        </button>
                                                    </div>
                                                </template>

                                                <!-- "Id" -->
                                                <template v-else-if="column.key === 'id'">
                                                    <div class="flex flex-row flex-wrap justify-center">
                                                        <span class="text-identity-dark dark:text-gray-300">
                                                            {{ row[column.key] }}
                                                        </span>
                                                        <button @click="copyToClipboard(row[column.key])"
                                                            :class="'bg-identity-dark hover:bg-gray-700'"
                                                            class="flex items-center px-2 py-2 text-sm text-identity capitalize transition-colors duration-200 border rounded-md gap-x-2 dark:text-gray-200 dark:border-gray-200 ">
                                                            <component class="h-4 w-6" :is="iconsForm['IconCopy']" />
                                                        </button>
                                                    </div>
                                                </template>

                                                <!-- Date -->
                                                <template v-else-if="column.key.endsWith('Date')">
                                                    <div v-if="row[column.key]">
                                                        <span class="text-identity-dark dark:text-gray-300">
                                                            {{ formatPrettyDate(row[column.key]) }}
                                                        </span>
                                                    </div>
                                                    <div v-else>
                                                        <span class="text-identity-dark dark:text-gray-300">
                                                            No date.
                                                        </span>
                                                    </div>
                                                </template>

                                                <!-- Show the value of the cell for other columns -->
                                                <template v-else>
                                                    {{ row[column.key] }}
                                                </template>
                                            </td>
                                        </tr>
                                    </transition-group>
                                </table>
                                <div v-if="filteredRows.length === 0"
                                    class="flex justify-center items-center bg-red-300 w-full h-16 text-center">
                                    <span class="text-identity-dark">
                                        Not found results.
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
    <!-- Modal Action-->
    <Modal :is-modal-open="isActionModalOpen" @close-modal="closeActionModal" max-height="max-entity-height"
        max-width="max-w-5xl">
        <template #icon>
            <component :class="['w-9 h-9']" :is="actionsIcon(actionSelected)" />
        </template>
        <template #title>
            <h3 class="text-lg font-medium leading-6 text-gray-800 capitalize dark:text-white" id="modal-title">
                {{ modalActionTitle }}
            </h3>
        </template>
        <template #content>
            <div v-if="actionSelected === 'view_details'">
                <table v-if="!isMobile" class="min-w-full divide-y divide-gray-700 dark:divide-gray-200"
                    :class="!isMobile ? 'table-fixed' : 'flex flex-col'">
                    <thead class="bg-identity-dark dark:bg-gray-900">
                        <tr>
                            <th v-for="column in filterDetailsColumns()" :key="column.key"
                                class="py-3.5 px-4 text-sm font-normal text-center rtl:text-right text-identity dark:text-gray-300">
                                <span>
                                    {{ column.header }}
                                </span>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-700 dark:divide-gray-200">
                        <tr>
                            <td v-for="column in filterDetailsColumns()" :key="column.key"
                                class=" px-2 py-2 text-sm text-center font-medium text-gray-700 dark:text-gray-200 overflow-auto">

                                <!-- Date -->
                                <template v-if="column.key.endsWith('Date')">
                                    <div v-if="rowSelected[column.key]">
                                        <span class="text-identity-dark dark:text-gray-300">
                                            {{ formatPrettyDate(rowSelected[column.key]) }}
                                        </span>
                                    </div>
                                    <div v-else>
                                        <span class="text-identity-dark dark:text-gray-300">
                                            No date.
                                        </span>
                                    </div>
                                </template>

                                <template v-else>
                                    {{ rowSelected[column.key] }}
                                </template>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div v-if="isMobile">
                    <div v-for="column in filterDetailsColumns()" :key="column.key"
                        class="basis-full p-2 text-sm font-normal text-center rtl:text-right text-identity dark:text-gray-300">
                        <div class="mb-1 bg-identity-dark dark:bg-gray-200">
                            <span class="text-identity dark:text-gray-900">
                                {{ column.header }}
                            </span>
                        </div>

                        <!-- Date -->
                        <template v-if="column.key.endsWith('Date')">
                            <div v-if="rowSelected[column.key]" class="py-1">
                                <span class="text-identity-dark dark:text-gray-300">
                                    {{ formatPrettyDate(rowSelected[column.key]) }}
                                </span>
                            </div>
                            <div v-else>
                                <span class="text-identity-dark dark:text-gray-300">
                                    Sin fecha.
                                </span>
                            </div>
                        </template>

                        <template v-else>
                            <div class="py-1">
                                <span class="text-identity-dark dark:text-gray-300">
                                    {{ rowSelected[column.key] }}
                                </span>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
        </template>
    </Modal>
</template>
<script setup>
import { ref, onMounted, computed, markRaw, watch, defineAsyncComponent, nextTick, defineEmits } from "vue";
import { storeToRefs } from "pinia";
import { useMainStore } from "@/stores/main";
import { useMomentStore } from "@/stores/moment";
import { useIconStore } from "@/stores/icons";
import AppLoader from "../loader/AppLoader.vue";
import Modal from "@/components/helpers/Modal.vue"
import { HttpError, showErrorMessage } from "@/helpers/errors";

const { isMobile } = storeToRefs(useMainStore())
const { getenv } = useMainStore()
const { formatPrettyDate, compareRangeDates } = useMomentStore()


const props = defineProps({
    table: {
        type: String,
        required: true
    },
    dataTable: {
        type: Object,
        required: true
    },
    iconsView: {
        type: Array,
        required: true
    }
});

const emit = defineEmits(['serachEventById'])

const formIconNames = ref(['IconSearch', 'IconCalendar', 'IconX'])
const { iconsForm, loadFormIcons } = useIconStore();

onMounted(async () => {
    try {
        await loadTableData()
    } catch (error) {
        showErrorMessage(error)
    }
})

const loadTableData = async () => {
    setLoadingApp(true)
    await loadFormIcons(formIconNames.value)
    await loadViewIcons(props.iconsView)
    setLoadingApp(false, 1000)
}

const typeTableForm = computed(() => {
    return props.table.slice(0, -1)
})

watch(() => props.dataTable, async () => {
    if (props.dataTable) {
        dataTable.value = props.dataTable
    }
})

const isLoadingApp = ref(false)
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
const viewIcons = ref({})
const search = ref('')
const searchEvent = ref('')

const loadViewIcons = async (iconsName) => {
    try {
        const promises = iconsName.map(iconName => import(`@/components/icons/${iconName}.vue`));
        const loadedIcons = await Promise.all(promises);

        iconsName.forEach((iconName, index) => {
            viewIcons.value[iconName] = markRaw(loadedIcons[index].default);
        });
    } catch (error) {
        throw new Error('Failed to load icons')
    }
}
//Actions
const copyToClipboard = (value) => {
    navigator.clipboard.writeText(value)
    alert('Copied to clipboard')
}
const actionsIconMap = {
    view_details: 'IconEye',
};

const actionsIcon = (action) => {
    const iconName = getActionIcon(action)
    return defineAsyncComponent(() => import(`@/components/icons/${iconName}.vue`));
}

const getActionIcon = (action) => {
    return actionsIconMap[action] || 'IconWarning'
}

const actionIconClass = (action) => ({
    'bg-yellow-100 border border-yellow-600': action === 'view_details',
    'text-identity-dark bg-gray-100/80': action === null
});

const actionIconText = (action) => ({
    'text-yellow-800': action === 'view_details',
})
const actionSelected = ref(null)
const rowSelected = ref(null)

const clickAction = (action, row) => {
    actionSelected.value = action
    rowSelected.value = row
    modalActionTitle.value = modalActionTitles[action]
    isActionModalOpen.value = true
}
const modalActionTitles = {
    view_details: 'Details',
}
const modalActionTitle = ref('')
const isActionModalOpen = ref(false)

const closeActionModal = () => {
    isActionModalOpen.value = false
    clearSelection()
}
const clearSelection = () => {
    actionSelected.value = null
    rowSelected.value = null
}

const searchDateRange = ref([])

const applyNowRange = ref(false)


const excludColumnsMap = {
    event: [],
}

const filterDetailsColumns = () => {
    if (dataTable.value.data.columns.length === 0) return []

    if (excludColumnsMap[typeTableForm.value]) {
        return isMobile.value ? dataTable.value.data.columns.filter(column => !excludColumnsMap[typeTableForm.value].includes(column.key) && column.key !== 'actions' && column.key !== 'selectable') :
            dataTable.value.data.columns.filter(column => !excludColumnsMap[typeTableForm.value].includes(column.key) && column.key !== 'actions' && column.key !== 'selectable')
    }

    return dataTable.value.data.columns.filter(column => column.key !== "actions" && column.key !== "id" && column.key !== "selectable");
}
const filterHeaders = () => {
    if (dataTable.value.data.columns.length === 0) return []

    if (isMobile.value) {
        return dataTable.value.data.columns.filter((column, index) => index <= 1 || column.key === "actions")
    }
    if (excludColumnsMap[typeTableForm.value]) {
        return dataTable.value.data.columns.filter(column => !excludColumnsMap[typeTableForm.value].includes(column.key))
    }
    return dataTable.value.data.columns
}

const filteredRows = ref([])

const filterTable = () => {
    if (searchDateRange.value?.length > 0 && applyNowRange.value) {

        filteredRows.value = dataTable.value.data.rows.filter(row => {
            const dateKey = Object.keys(row).find(key => key.endsWith('Date'))
            return dateKey ? compareRangeDates(row[dateKey], searchDateRange.value[0], searchDateRange.value[1]) : false
        })
        return filteredRows.value
    }

    if (!search.value && searchDateRange.value?.length === 0) {
        filteredRows.value = dataTable.value.data.rows
        return filteredRows.value
    }

    const searchValue = search.value.trim().toString().toLowerCase();

    filteredRows.value = dataTable.value.data.rows.filter(row => {
        return Object.keys(row).some(key => {
            if (key === "actions" || key.endsWith('Date')) return false;

            return row[key]?.toString().toLowerCase().includes(searchValue);
        });
    });
    return filteredRows.value
};

const filterColumns = () => {
    if (dataTable.value.data.columns.length === 0) return []

    if (isMobile.value) {
        return dataTable.value.data.columns.filter((column, index) => index <= 1 || column.key === "actions")
    }
    if (excludColumnsMap[typeTableForm.value]) {
        return dataTable.value.data.columns.filter(column => !excludColumnsMap[typeTableForm.value].includes(column.key))
    }
    return dataTable.value.data.columns
}

const setLoadingApp = (value, delay = 0) => {
    if (delay > 0) {
        setTimeout(() => {
            isLoadingApp.value = value
        }, delay);
    } else {
        isLoadingApp.value = value
    }
}
</script>
<style>
.custom-shadow {
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2),
        0 8px 24px rgba(0, 0, 0, 0.2);
}
</style>
<style scoped>
/* Animaciones para la transición */
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.3s ease;
}

.fade-enter,
.fade-leave-to

/* .fade-leave-active en versiones anteriores a 2.1.8 */
    {
    opacity: 0;
}

.table-fixed {
    table-layout: fixed;
    width: 100%;
}

.custom-shadow {
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2),
        0 8px 24px rgba(0, 0, 0, 0.2);
    /* Ajusta los valores según tus necesidades */
}
</style>