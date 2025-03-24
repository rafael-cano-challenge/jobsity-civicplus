<template>
    <div class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50">
        <div class="loader"></div>
    </div>
</template>
<style>
/* HTML: <div class="loader"></div> */
.loader {
    width: 5px;
    /* Aumentado un 25% (de 4px a 5px) */
    color: #F6EEEA;
    aspect-ratio: 1;
    border-radius: 50%;
    box-shadow:
        23.75px -23.75px 0 0px, 47.5px -23.75px 0 0px, 71.25px -23.75px 0 0px,
        /* Aumentado un 25% */
        23.75px 0 0 6.25px, 47.5px 0 0 6.25px, 71.25px 0 0 6.25px,
        /* Aumentado un 25% */
        23.75px 23.75px 0 0px, 47.5px 23.75px 0 0px, 71.25px 23.75px 0 0px;
    /* Aumentado un 25% */
    transform: translateX(-47.5px);
    /* Aumentado un 25% */
    animation: l26 2s infinite linear;
}

@keyframes l26 {
    12.5% {
        box-shadow:
            23.75px -23.75px 0 0px, 47.5px -23.75px 0 0px, 71.25px -23.75px 0 6.25px,
            /* Aumentado un 25% */
            23.75px 0 0 6.25px, 47.5px 0 0 0px, 71.25px 0 0 6.25px,
            /* Aumentado un 25% */
            23.75px 23.75px 0 0px, 47.5px 23.75px 0 0px, 71.25px 23.75px 0 0px
            /* Aumentado un 25% */
    }

    25% {
        box-shadow:
            23.75px -23.75px 0 6.25px, 47.5px -23.75px 0 0px, 71.25px -23.75px 0 6.25px,
            /* Aumentado un 25% */
            23.75px 0 0 0px, 47.5px 0 0 0px, 71.25px 0 0 0px,
            /* Aumentado un 25% */
            23.75px 23.75px 0 0px, 47.5px 23.75px 0 6.25px, 71.25px 23.75px 0 0px
            /* Aumentado un 25% */
    }

    50% {
        box-shadow:
            23.75px -23.75px 0 6.25px, 47.5px -23.75px 0 6.25px, 71.25px -23.75px 0 0px,
            /* Aumentado un 25% */
            23.75px 0 0 0px, 47.5px 0 0 0px, 71.25px 0 0 0px,
            /* Aumentado un 25% */
            23.75px 23.75px 0 0px, 47.5px 23.75px 0 0px, 71.25px 23.75px 0 6.25px
            /* Aumentado un 25% */
    }

    62.5% {
        box-shadow:
            23.75px -23.75px 0 0px, 47.5px -23.75px 0 0px, 71.25px -23.75px 0 0px,
            /* Aumentado un 25% */
            23.75px 0 0 6.25px, 47.5px 0 0 0px, 71.25px 0 0 0px,
            /* Aumentado un 25% */
            23.75px 23.75px 0 0px, 47.5px 23.75px 0 6.25px, 71.25px 23.75px 0 6.25px
            /* Aumentado un 25% */
    }

    75% {
        box-shadow:
            23.75px -23.75px 0 0px, 47.5px -23.75px 0 6.25px, 71.25px -23.75px 0 0px,
            /* Aumentado un 25% */
            23.75px 0 0 0px, 47.5px 0 0 0px, 71.25px 0 0 6.25px,
            /* Aumentado un 25% */
            23.75px 23.75px 0 0px, 47.5px 23.75px 0 0px, 71.25px 23.75px 0 6.25px
            /* Aumentado un 25% */
    }

    87.5% {
        box-shadow:
            23.75px -23.75px 0 0px, 47.5px -23.75px 0 6.25px, 71.25px -23.75px 0 0px,
            /* Aumentado un 25% */
            23.75px 0 0 0px, 47.5px 0 0 6.25px, 71.25px 0 0 0px,
            /* Aumentado un 25% */
            23.75px 23.75px 0 6.25px, 47.5px 23.75px 0 0px, 71.25px 23.75px 0 0px
            /* Aumentado un 25% */
    }
}
</style>