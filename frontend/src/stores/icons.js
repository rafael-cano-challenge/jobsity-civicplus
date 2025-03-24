import { ref, defineAsyncComponent, markRaw } from "vue";
import { defineStore } from "pinia";

export const useIconStore = defineStore("icons", () => {
  const iconsForm = ref({});

  const loadFormIcons = async (formIconNames) => {
    try {
      const iconsToLoad = formIconNames.filter(
        (iconName) => !iconsForm.value[iconName]
      );

      if (iconsToLoad.length === 0) return;

      const promises = iconsToLoad.map((iconName) =>
        defineAsyncComponent(() => import(`@/components/icons/${iconName}.vue`))
      );

      const loadedIcons = await Promise.all(promises);

      iconsToLoad.forEach((iconName, index) => {
        iconsForm.value[iconName] = markRaw(loadedIcons[index]);
      });
    } catch (error) {
      console.error("Failed to load form icons:", error);
      throw new Error("Failed to load form icons.");
    }
  };

  return {
    iconsForm,
    loadFormIcons,
  };
});
