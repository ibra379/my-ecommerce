import './bootstrap';

import Alpine from 'alpinejs';
import Turbolinks from 'turbolinks'
import {createApp} from "vue";
import AddToCart from "./components/AddToCart.vue";
import NavbarCart from "./components/NavbarCart.vue";

if (document.body.querySelector('#app')) {
    document.addEventListener('turbolinks:load', () => {
        const app = createApp({});

        // Global error handler
        app.config.errorHandler = (err, instance, info) => {
            // Handle the error globally
            console.error("Global error:", err);
            console.log("Vue instance:", instance);
            console.log("Error info:", info);
            // Add code for UI notifications, reporting or other error handling logic
        };

        app.component('AddToCart', AddToCart);
        app.component('NavbarCart', NavbarCart);
        app.mount('#app');
    })
}


window.Alpine = Alpine;
Alpine.start();
Turbolinks.start();
