import { createRouter, createWebHistory } from "vue-router";

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL || "/"),
  routes: [
    {
      path: "/404",
      name: "404",
      component: () => import("../views/404/404.vue"),
    },
    {
      path: "/",
      redirect: () => {
        return "/home";
      },
    },
    {
      path: "/home",
      name: "home",
      component: () => import("../views/home/Home.vue"),
    },
  ],
});

router.beforeEach((to, from, next) => {
  let validRoutes = router.options.routes.map((route) => route.path);

  if (to.path === "/") {
    return next("/home");
  }

  if (!validRoutes.includes(to.path)) {
    return next("/404");
  }
  next();
});

export default router;
