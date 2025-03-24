import { ref, computed, watch } from "vue";
import { defineStore } from "pinia";

export const useMainStore = defineStore("main", () => {
  const mobileBreakpoint = ref(768);
  const isSidebarCollapsed = ref(true);
  const currentScreenWidth = ref(window.innerWidth);
  const currentBackground = ref("/videos/0323.webm");

  const isMobile = computed(
    () => currentScreenWidth.value < mobileBreakpoint.value
  );

  const getenv = (name) => {
    return import.meta.env[`VITE_${name}`];
  };

  const updateScreenWidth = () => {
    currentScreenWidth.value = window.innerWidth;
  };

  return {
    mobileBreakpoint,
    isSidebarCollapsed,
    isMobile,
    currentBackground,
    currentScreenWidth,
    updateScreenWidth,
    getenv,
  };
});
