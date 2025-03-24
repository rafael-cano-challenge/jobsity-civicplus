<template>
    <AppLoader v-if="isLoadingApp" />
    <div v-else class="w-full py-8 rounded-lg custom-shadow"
        :class="isMobile ? 'border-color-identity-dark-gold' : 'border-color-identity-dark-gold'">
        <div v-if="props.iconsView.length > 0"
            class="flex justify-center items-center -mt-16 md:-mt-28 md:justify-end md:mb-4">
            <!-- Icono Form -->
            <component v-if="viewIcons[props.iconsView[0]]" :is="viewIcons[props.iconsView[0]]"
                class="p-4 w-20 h-20 md:w-24 md:h-24 md:mr-1/4 border-color-identity-dark-gold-thick rounded-full dark:border-gray-300"
                :class="isDarkMode ? 'bg-black text-gray-300' : 'bg-identity-dark text-identity'" />
        </div>
        <div class="flex flex-row flex-wrap">
            <!-- Header -->
            <slot name="form-header">
            </slot>
            <br v-if="$slots['form-header']">
            <hr class="mx-4 border-color-identity-dark dark:border-gray-200" v-if="$slots['form-header']">
            <br v-if="$slots['form-header']">
            <!-- Form -->
            <form class="w-full">
                <!-- Fields -->
                <slot name="form-fields">
                    <div class="flex flex-row flex-wrap justify-center">
                        <!-- Field -->
                        <div v-for="(field, index) in  fieldsData " :key="field.id"
                            :class="[!isMobile ? (isDarkMode ? 'border-color-identity' : 'border-color-identity-dark-gold') : '', field.cols_mobile, field.cols_desktop, field.class]"
                            v-show="field.show" class="p-2 md:p-4 rounded-lg">
                            <!-- Label -->
                            <div class="flex flex-row items-center">
                                <div
                                    :class="[field.can_add && (props.actionSelected === 'save') ? 'basis-4/5' : 'basis-full']">
                                    <label :for="field.name"
                                        class="block text-sm text-identity-dark dark:text-gray-300 max-w-full">
                                        <div class="flex flex-row max-w-full">
                                            <span v-if="field.required" class="relative flex h-2 w-2 mt-1.5 max-w-full">
                                                <span
                                                    class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                                                <span
                                                    class="relative inline-flex rounded-full h-2 w-2 bg-red-500"></span>
                                            </span>
                                            <span class="ml-1 max-w-full truncate"> {{ field.label }} :</span>
                                        </div>
                                    </label>
                                </div>
                            </div>
                            <!-- Inputs Types -->
                            <div class="mt-2 max-w-full">
                                <div class="flex flex-row justify-center">
                                    <div
                                        :class="[field.can_add && (props.actionSelected === 'save') ? 'basis-4/5' : 'basis-full']">
                                        <!-- Type Text -->
                                        <input v-if="field.type_element === 'text'" v-model="formData[field.name]"
                                            :disabled="isFieldDisabled(field)" type="text" :placeholder="field.label"
                                            :class="isFieldDisabled(field) ? 'bg-gray-400' : 'bg-white'"
                                            class="block w-full rounded-lg px-5 py-2.5 placeholder-gray-400/70 text-gray-700 border border-gray-200 dark:border-gray-600 focus:border-indigo-600 dark:focus:border-indigo-300 focus:ring-indigo-300 focus:outline-none focus:ring focus:ring-opacity-40" />

                                        <!-- Type Textarea -->
                                        <textarea v-else-if="field.type_element === 'textarea'"
                                            v-model="formData[field.name]" :placeholder="field.label"
                                            :disabled="isFieldDisabled(field)"
                                            :class="isFieldDisabled(field) ? 'bg-gray-400' : 'bg-white'"
                                            class="block w-full max-w€-full rounded-lg  px-4 h-20 py-2.5 placeholder-gray-400/70 text-gray-700 border border-gray-200 dark:border-gray-600 focus:border-indigo-600 dark:focus:border-indigo-300 focus:ring-indigo-300 focus:outline-none focus:ring focus:ring-opacity-40"></textarea>

                                        <!-- Type Number -->
                                        <input v-else-if="field.type_element === 'number'"
                                            v-model="formData[field.name]" type="number" :placeholder="field.label"
                                            max="9999999999" :disabled="isFieldDisabled(field)"
                                            :class="isFieldDisabled(field) ? 'bg-gray-400' : 'bg-white'"
                                            class="block w-full rounded-lg px-5 py-2.5 placeholder-gray-400/70 text-gray-700 border border-gray-200 dark:border-gray-600 focus:border-indigo-600 dark:focus:border-indigo-300 focus:ring-indigo-300 focus:outline-none focus:ring focus:ring-opacity-40" />

                                        <!-- Type Date -->
                                        <VueDatePicker v-else-if="field.type_element === 'date'"
                                            :ref="element => datePickerRefs[field.name] = element"
                                            v-model="formData[field.name]" :placeholder="field.label" locale="es"
                                            :enable-time-picker="false" auto-apply :disabled="isFieldDisabled(field)"
                                            :min-date="field.restrict_past_dates ? new Date() : null"
                                            :format="formatPrettyDate"
                                            class="block w-full rounded-lg placeholder-gray-400/70 text-gray-700 border border-gray-200 dark:border-gray-600 focus:border-indigo-600 dark:focus:border-indigo-300 focus:ring-indigo-300 focus:outline-none focus:ring focus:ring-opacity-40">
                                        </VueDatePicker>

                                        <!-- Type Time -->
                                        <VueDatePicker v-else-if="field.type_element === 'time'"
                                            v-model="formData[field.name]" time-picker :is-24="false"
                                            :placeholder="field.label" :disabled="isFieldDisabled(field)"
                                            class="block w-full rounded-lg placeholder-gray-400/70 text-gray-700 border border-gray-200 dark:border-gray-600 focus:border-indigo-600 dark:focus:border-indigo-300 focus:ring-indigo-300 focus:outline-none focus:ring focus:ring-opacity-40" />

                                        <!-- Others -->
                                        <h1 v-else>
                                            In development...
                                        </h1>
                                    </div>
                                </div>
                                <p v-if="formErrors[field.name]" class="text-xs text-red-400">
                                    {{ formErrors[field.name] }}
                                </p>
                            </div>
                        </div>
                    </div>
                </slot>
            </form>
            <!-- Footer -->
            <br v-if="$slots['form-footer']">
            <hr class="mx-4 border-color-identity-dark dark:border-gray-200" v-if="$slots['form-footer']">
            <br v-if="$slots['form-footer']">
            <slot name="form-footer">
            </slot>
            <!-- Actions -->
            <slot name="form-actions">
                <div class="flex justify-center md:justify-end p-4 w-full">
                    <div class="flex flex-col justify-center">
                        <button @click="handleSubmit"
                            class="flex justify-center items-center px-4 py-2 font-medium tracking-wide text-white capitalize transition-colors duration-300 transform bg-red-600 rounded-lg hover:bg-red-500 focus:outline-none focus:ring focus:ring-red-300 focus:ring-opacity-80">
                            <component :is="iconsForm['IconSubmit']" v-if="!isLoadingForm" />
                            <component :is="iconsForm['IconLoading']" v-else />
                            <span class="mx-1">{{ titleActionButton }}</span>
                        </button>
                        <p v-if="!emptyErrors" class="text-xs text-red-400">
                            There are errors in the form.
                        </p>
                    </div>
                </div>
            </slot>
        </div>
    </div>
</template>
<script setup>

import { ref, onMounted, computed, markRaw, watch, onUnmounted, defineEmits } from "vue";
import AppLoader from "../loader/AppLoader.vue";
import { storeToRefs } from "pinia";
import { useMainStore } from "@/stores/main";
import { useMomentStore } from "@/stores/moment";
import { useIconStore } from "@/stores/icons";
import formsHelper from "@/helpers/forms.js";
import fieldsHelper from "@/helpers/fields";
import { showErrorMessage } from "@/helpers/errors";
import { HttpError } from "@/helpers/errors";

const props = defineProps({
    iconsView: {
        type: Array,
        required: false,
        default: []
    },
    typeForm: {
        type: String,
        required: true,
    },
    actionSelected: {
        type: String,
        required: false,
        default: 'save'
    },
    rowSelected: {
        type: Object,
        required: false,
        default: null
    },
});
const formIconNames = ref(['IconRefresh', 'IconLoading', 'IconPlus', 'IconAdd', 'IconUpload', 'IconSubmit', 'IconEmail']);

const emit = defineEmits(["closeModal", "updateRow", "sendForm"]);

const { isDarkMode, isMobile } = storeToRefs(useMainStore())
const { formatStoreDate, formatPrettyDate, formatStoreTime } = useMomentStore()
const { loadFormIcons, iconsForm } = useIconStore()

onMounted(async () => {
    try {
        await loadFormData()
    } catch (error) {
        showErrorMessage(error)
    }
});

const loadFormData = async () => {
    setLoadingApp(true)
    await getFormFields(props.typeForm);
    await loadFormIcons(formIconNames.value);
    await loadViewIcons(props.iconsView);
    setLoadingApp(false, 1000)
};

onUnmounted(() => {
    clearComponentData()
});
const clearComponentData = () => {
    fields.value = []
    fieldsData.value = []
    formData.value = {}
    clearFormErrors()
}

const formData = ref({})
const formErrors = ref({})

const emptyErrors = computed(() => {
    return Object.keys(formErrors.value).length === 0
})
const isLoadingApp = ref(false)

const setLoadingApp = (value, delay = 0) => {
    if (delay > 0) {
        setTimeout(() => {
            isLoadingApp.value = value
        }, delay);
    } else {
        isLoadingApp.value = value
    }
}
const isLoadingForm = ref(false)

const setLoadingForm = (value, delay = 0) => {
    if (delay > 0) {
        setTimeout(() => {
            isLoadingForm.value = value
        }, delay);
    } else {
        isLoadingForm.value = value
    }
}

const viewIcons = ref({})
const datePickerRefs = ref([]);
const titleActionButton = ref('Guardar')

const loadViewIcons = async (iconsName) => {
    try {
        if (iconsName.length === 0) return;

        const promises = iconsName.map(iconName => import(`@/components/icons/${iconName}.vue`));
        const loadedIcons = await Promise.all(promises);

        iconsName.forEach((iconName, index) => {
            viewIcons.value[iconName] = markRaw(loadedIcons[index].default);
        });
    } catch (error) {
        throw new Error('Failed to load form icons.');
    }
}
const fields = ref([]);
const fieldsData = ref([]);

const getFormFields = async (typeForm) => {
    fields.value = fieldsHelper.getFormFields(typeForm);
    await createFields(fields.value);
};
const createFields = async (fields) => {
    fieldsData.value = await formsHelper.createFields(fields);
};

const isFieldDisabled = (field) => {
    return field.disabled || (props.actionSelected === 'edit' && !field.can_edit)
}

const getIdObject = (object) => {
    return object ? object.id : null;
};


const findFieldDataIndexByName = (name) => {
    return fieldsData.value.findIndex(field => field.name === name);
};

const watchForAttributes = ref([]);

watchForAttributes.value.forEach(attribute => {
    watch(
        () => formData.value[attribute],
        async (newValue, oldValue) => {
            if (newValue != oldValue) { }
        },
        { immediate: false }
    );
});

const handleSubmit = async () => {
    await validateForm()

    if (emptyErrors.value) {
        const structureData = structureJsonData(formData.value);

        setLoadingForm(true)
        try {
            emit(actionsForm[props.actionSelected], structureData);

            clearFormErrors()
            emit("closeModal")

        } catch (error) {
            showErrorMessage(error)
        }
        setLoadingForm(false)
    }
};

const actionsForm = {
    save: 'sendForm',
};

const handlersStructureJsonData = {
    hora: value => value ? formatStoreTime(value.hours, value.minutes, value.seconds) : null,
    fecha: value => value ? formatStoreDate(value) : null,
    object: value => ('id' in value) ? value.id : value,
    default: value => value
};

const getHandlerKey = (key, value) => {
    const index = findFieldDataIndexByName(key);
    const field = fieldsData.value[index];
    return field && field.show ?
        field.type_element === 'time' ? 'hora' :
            field.type_element === 'date' ? 'fecha' :
                value === null ? 'default' :
                    typeof value === 'object' ? 'object' :
                        'default' : 'default';
};

const structureJsonData = (formData) => {
    const structuredData = {};
    Object.entries(formData).forEach(([key, value]) => {
        const handlerKey = getHandlerKey(key, value);
        const handler = handlersStructureJsonData[handlerKey];
        structuredData[key] = handler(value);
    });
    return structuredData;
};

const clearFormErrors = () => {
    formErrors.value = {};
};
const validateForm = () => {
    clearErrors()
    for (const field of fieldsData.value) {
        if (field.show) {
            isFieldEmpty(field)
        }
    }
}
const isFieldEmpty = (field) => {
    if (field.required && (formData.value[field.name] === null || formData.value[field.name] === undefined || (typeof formData.value[field.name] !== 'boolean' && !formData.value[field.name]))) {
        formErrors.value[field.name] = 'Field required.'
        return
    } else {
        delete formErrors.value[field.name]
        return
    }
}

const clearErrors = () => {
    formErrors.value = {}
}
</script>
<style>
.custom-shadow {
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2),
        0 -8px 16px rgba(0, 0, 0, 0.2),
        8px 0 16px rgba(0, 0, 0, 0.2),
        -8px 0 16px rgba(0, 0, 0, 0.2);
}

.max-entity-height {
    max-height: 37rem;
}

input:checked~.dot {
    transform: translateX(100%);
}

.dot {
    transition: all 0.3s ease-in-out;
}
</style>
