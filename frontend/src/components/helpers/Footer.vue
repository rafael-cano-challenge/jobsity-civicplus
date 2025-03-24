<template>
    <div class="footer flex items-center justify-center p-2">
        <div class="text-identity">
            <strong>José Rafael Cano Pabón ® {{ currentYear }}</strong> |
            <strong>Senior Sofware Developer</strong> |
            <strong>Medellín, Col. 🇨🇴</strong>
        </div>
    </div>
</template>
<script setup>
import { ref, onMounted, computed } from 'vue';
import { useMomentStore } from "@/stores/moment"
import { storeToRefs } from 'pinia';

onMounted(() => { })

const { currentYear, locale } = storeToRefs(useMomentStore())

</script>
<style>
.footer {
    height: 5rem;
    background-color: black;
    bottom: 0;
    position: absolute;
    width: 100%;
    transition: width 0.3s;
    border-top: 2px solid red;
    font-size: large;
}
</style>
