import "../css/app.css";
import "./bootstrap";
import "ant-design-vue/dist/reset.css";

import { createInertiaApp } from "@inertiajs/vue3";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";
import { createApp, h } from "vue";
import { ZiggyVue } from "../../vendor/tightenco/ziggy";
import axios from "axios";
import Antd from "ant-design-vue";

const appName = import.meta.env.VITE_APP_NAME || "Laravel";
// ini ambil dari app.blade.php biar bisa post
window.axios.defaults.headers.common["X-CSRF-TOKEN"] =
    document.head.querySelector('meta[name="csrf-token"]').content;
createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob("./Pages/**/*.vue")
        ),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .use(Antd) // daftarin dahulu biar tabelnya muncul
            .mount(el);
    },
    progress: {
        color: "#4B5563",
    },
});
