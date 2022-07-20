require('./bootstrap');

import "bootstrap";
import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/inertia-vue3';
import { InertiaProgress } from '@inertiajs/progress';
import VueGoogleMaps from '@fawmi/vue-google-maps';

const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Harmonyxs';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => require(`./Pages/${name}.vue`),
    setup({ el, app, props, plugin }) {
        return createApp({ render: () => h(app, props) })
            .use(VueGoogleMaps, {
                load: {
                    key: 'API_KEY',
                    libraries: "places",
                },installComponents: true,})
            .use(plugin)
            .mixin({ methods: { route } })
            .mount(el);
    },

});

InertiaProgress.init({ color: '#08D9D6' });
