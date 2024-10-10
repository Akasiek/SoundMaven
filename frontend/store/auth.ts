import type { FetchContext, FetchResponse } from "ofetch";
import type { R } from "unplugin-vue-router/types-CEBdfPkN";

export const useAuthStore = defineStore('auth', {
  state: () => ({
    isAuth: false,
  }),
  actions: {
    async login(user: { email: string, password: string }) {
      const config = useRuntimeConfig();

      await $fetch(`${config.public.apiUrl}/sanctum/csrf-cookie`, { credentials: 'include' });

      const csrf = useCookie('XSRF-TOKEN');

      let isOk = false;
      await $fetch(`${config.public.apiUrl}/login`, {
        method: 'POST',
        credentials: 'include',
        headers: {
          'Content-Type': 'application/json',
          'X-XSRF-TOKEN': csrf.value as string,
        },
        body: JSON.stringify(user),
        onResponse(context: FetchContext & { response: FetchResponse<R> }): Promise<void> | void {
          isOk = context.response.ok;
        },
      });

      this.isAuth = isOk;
    },
    async checkAuth() {
      const config = useRuntimeConfig();

      let isOk = false;

      try {
        await $fetch(`${config.public.apiUrl}/user`, {
          credentials: 'include',
          ignoreResponseError: true,
          onResponse(context: FetchContext & { response: FetchResponse<R> }): Promise<void> | void {
            isOk = context.response.ok;
          },
        });
      } catch {
        /* empty */
      }

      this.isAuth = isOk;
    },
    async logout() {
      const config = useRuntimeConfig();

      await $fetch(`${config.public.apiUrl}/sanctum/csrf-cookie`, {
        credentials: 'include',
      });

      const csrf = useCookie('XSRF-TOKEN');

      let statusCode = 0;

      await $fetch(`${config.public.apiUrl}/logout`, {
        method: 'POST',
        credentials: 'include',
        ignoreResponseError: true,
        headers: {
          'X-XSRF-TOKEN': csrf.value as string,
        },
        body: '{}',
        onResponse(context: FetchContext & { response: FetchResponse<R> }): Promise<void> | void {
          statusCode = context.response.status;
        },
      });

      // alert("Logout: " + statusCode);

      if (statusCode === 204) {
        this.isAuth = false;
      }
    },
  },
  persist: true
})
