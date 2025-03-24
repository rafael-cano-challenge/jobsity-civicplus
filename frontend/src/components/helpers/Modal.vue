<template>
    <transition enter-active-class="transition ease-out duration-300"
        enter-from-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        enter-to-class="opacity-100 translate-y-0 sm:scale-100" leave-active-class="transition ease-in duration-200"
        leave-from-class="opacity-100 translate-y-0 sm:scale-100"
        leave-to-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
        <div v-if="isModalOpen" class="fixed inset-0 flex items-center justify-center z-50 bg-gray-900 bg-opacity-50">
            <div
                class="flex items-end justify-center min-h-screen px-4 pt-4 pb-modal text-center sm:block sm:p-0 w-full">
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>

                <div class="relative inline-block px-4 pt-5 pb-4 text-left align-bottom transition-all transform bg-gray-200 rounded-lg shadow-xl rtl:text-right dark:bg-gray-900 sm:my-8 sm:align-middle w-full sm:p-6"
                    :class="[maxHeight, maxWidth, 'border-color-identity-dark dark:border-gray-300 overflow-y-auto']">

                    <!-- Botón de Cierre -->
                    <button @click="emit('closeModal')"
                        class="absolute top-6 right-6 text-gray-200 hover:text-gray-600">
                        <IconX class="text-identity-dark dark:text-gray-200 w-5 h-5" />
                    </button>

                    <!-- Icono -->
                    <div class="flex items-center justify-center text-identity-dark dark:text-gray-200">
                        <slot name="icon">
                        </slot>
                    </div>

                    <!-- Title -->
                    <div class="m-4 text-center">
                        <slot name="title">
                        </slot>
                    </div>

                    <!-- Main -->
                    <div class="text-center">
                        <slot name="content">
                        </slot>
                    </div>

                    <!-- Footer -->
                    <div class="mt-5 sm:flex sm:items-center sm:justify-between">
                        <slot name="footer">
                        </slot>
                    </div>
                </div>
            </div>
        </div>
    </transition>
</template>
<script setup>
import IconX from "@/components/icons/IconX.vue"

const props = defineProps({
    isModalOpen: Boolean,
    maxHeight: {
        type: String,
        default: "max-h-96"
    },
    maxWidth: {
        type: String,
        default: "max-w-2xl"
    }
})
const emit = defineEmits(["closeModal"])

</script>
<style>
.pb-modal {
    padding-bottom: 5.5rem;
}
</style>