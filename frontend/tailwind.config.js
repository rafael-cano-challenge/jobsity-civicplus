/** @type {import('tailwindcss').Config} */
export default {
  content: ["./index.html", "./src/**/*.{vue,js,ts,jsx,tsx}"],
  theme: {
    extend: {
      margin: {
        "1/2": "50%", // Añade 50% de margen
        "1/4": "25%", // Añade 25% de margen
        "1/3": "33.33%", // Añade 30% de margen
        "3/4": "75%", // Añade 75% de margen
        "1/6": "16.666667%", // Añade 16.67% de margen
        "5/12": "41.666667%", // Añade 41.67% de margen
      },
    },
  },
  plugins: [],
  darkMode: "selector",
};
