import "./bootstrap";

import {createApp} from "vue";
import Alpine from 'alpinejs';
import Turbolinks from 'turbolinks';
import Toaster from "@meforma/vue-toaster";
import AddToCart from "./components/AddToCart.vue";
import NavbarCart from "./components/NavbarCart.vue";
import ShoppingCart from "./components/ShoppingCart.vue";
import StripeCheckout from "./components/StripeCheckout.vue";

document.addEventListener("turbolinks:load", () => {
    if (document.body.querySelector("#app")) {
        const app = createApp({});

        // Global error handler
        app.config.errorHandler = (err, instance, info) => {
            // Handle the error globally
            console.error("Global error:", err);
            console.log("Vue instance:", instance);
            console.log("Error info:", info);
            // Add code for UI notifications, reporting or other error handling logic
        };

        app.use(Toaster, {
            position: "top-right",
        })
            .provide("toast", app.config.globalProperties.$toast)

        app.component('StripeCheckout', StripeCheckout);
        app.component('ShoppingCart', ShoppingCart);
        app.component("NavbarCart", NavbarCart);
        app.component("AddToCart", AddToCart);
        app.mount("#app");
    }
})


window.Alpine = Alpine;
Alpine.start();
Turbolinks.start();
