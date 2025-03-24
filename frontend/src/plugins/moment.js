import moment from "moment";
import "moment/locale/es";

export default {
  install(app) {
    moment.updateLocale("es", {
      months:
        "Enero_Febrero_Marzo_Abril_Mayo_Junio_Julio_Agosto_Septiembre_Octubre_Noviembre_Diciembre".split(
          "_"
        ),
      monthsShort: "Ene_Feb_Mar_Abr_May_Jun_Jul_Ago_Sep_Oct_Nov_Dic".split("_"),
      weekdays: "Domingo_Lunes_Martes_Miércoles_Jueves_Viernes_Sábado".split(
        "_"
      ),
      weekdaysShort: "Dom._Lun._Mar._Mié._Jue._Vie._Sáb.".split("_"),
      weekdaysMin: "Do_Lu_Ma_Mi_Ju_Vi_Sá".split("_"),
      longDateFormat: {
        LT: "H:mm",
        LTS: "H:mm:ss",
        L: "DD/MM/YYYY",
        LL: "D [de] MMMM [de] YYYY",
        LLL: "D [de] MMMM [de] YYYY H:mm",
        LLLL: "dddd, D [de] MMMM [de] YYYY H:mm",
      },
      ordinal: (number) => {
        const suffixes = ["º", "º", "º", "º", "º", "º", "º", "º", "º", "º"];
        return `${number}${suffixes[number % 10] || "º"}`;
      },
    });

    app.config.globalProperties.$moment = moment;
  },
};
