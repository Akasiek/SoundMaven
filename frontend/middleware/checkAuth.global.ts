import { useAuthStore } from "~/store/auth";

export default defineNuxtRouteMiddleware(async (to) => {
  if (import.meta.server) {
    return
  }

  const store = useAuthStore();
  await store.checkAuth();

  if (store.isAuth && to.path === '/login') {
    return navigateTo('/');
  }
})