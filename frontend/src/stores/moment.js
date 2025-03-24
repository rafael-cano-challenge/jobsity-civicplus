import { ref, computed, getCurrentInstance } from "vue";
import { defineStore } from "pinia";

export const useMomentStore = defineStore("moment", () => {
  const { proxy } = getCurrentInstance();
  const $moment = proxy.$moment;

  const now = $moment();
  const today = ref(now.format("YYYY-MM-DD"));
  const tomorrow = ref(now.add(1, "days").format("YYYY-MM-DD"));
  const yesterday = ref(now.subtract(1, "days").format("YYYY-MM-DD"));
  const currentYear = ref($moment().year());

  const addDays = (date, days) => {
    return $moment(date).add(days, "days").format("YYYY-MM-DD");
  };

  const subtractDays = (date, days) => {
    return $moment(date).subtract(days, "days").format("YYYY-MM-DD");
  };

  const formatPrettyDate = (date) => {
    const dateParsed = parseStoreDate(date);
    return $moment(dateParsed).format("MMM Do YYYY");
  };

  const formatPrettyDates = (dates) => {
    return dates.reduce((acc, date, index) => {
      const formattedDate = formatPrettyDate(date);
      return index === dates.length - 1
        ? acc + formattedDate
        : acc + formattedDate + " - ";
    }, "");
  };

  const formatStoreDate = (date) => {
    return $moment(date).format("YYYY-MM-DD");
  };

  const parseStoreDate = (dateString) => {
    return $moment(dateString, "YYYY-MM-DD").toDate();
  };

  const compareRangeDates = (date, startDate, endDate) => {
    return (
      $moment(date).isSameOrAfter(startDate) &&
      $moment(date).isSameOrBefore(endDate)
    );
  };

  const locale = ref($moment.locale());

  return {
    today,
    tomorrow,
    yesterday,
    currentYear,
    addDays,
    subtractDays,
    formatPrettyDate,
    formatPrettyDates,
    formatStoreDate,
    parseStoreDate,
    compareRangeDates,
    locale,
  };
});
