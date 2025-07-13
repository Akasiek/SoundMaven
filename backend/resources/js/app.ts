import '../css/app.css';

import { createInertiaApp } from '@inertiajs/vue3';
import type { DefineComponent } from 'vue';
import { createApp, h } from 'vue';
import { ZiggyVue } from '../../node_modules/ziggy-js';
import VueSelect from "vue-select";
import AppLayout from "@/layouts/AppLayout.vue";

// Extend ImportMeta interface for Vite...
declare module 'vite/client' {
  interface ImportMetaEnv {
    readonly VITE_APP_NAME: string;

    [key: string]: string | boolean | undefined;
  }

  interface ImportMeta {
    readonly env: ImportMetaEnv;
    readonly glob: <T>(pattern: string) => Record<string, () => Promise<T>>;
  }
}

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
  title: (title) => title ? `${title} - ${appName}` : appName,
  resolve: name => {
    const pages = import.meta.glob<DefineComponent>('./pages/**/*.vue', { eager: true });
    let page = pages[`./pages/${name}.vue`]
    page.default.layout = page.default.layout === undefined ? AppLayout : page.default.layout;
    return page
  },
  setup({ el, App, props, plugin }) {
    createApp({ render: () => h(App, props) })
      .use(plugin)
      .use(ZiggyVue)
      .component("v-select", VueSelect)
      .mount(el);
  },
  progress: {
    color: '#4B5563',
  },
});
