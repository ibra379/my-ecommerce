import './bootstrap';

import Alpine from 'alpinejs';
import Turbolinks from 'turbolinks'

let isFirstRender = true
document.addEventListener('turbolinks:load', () => {
    if (!isFirstRender && window.plausible) {
        window.plausible('pageview')
    }
    isFirstRender = false;
})
document.addEventListener('turbolinks:click', e => {
    const anchorElement = e.target
    const isSamePageAnchor =
        anchorElement.hash &&
        anchorElement.origin === window.location.origin &&
        anchorElement.pathname === window.location.pathname

    if (isSamePageAnchor) {
        Turbolinks.controller.pushHistoryWithLocationAndRestorationIdentifier(e.data.url, Turbolinks.uuid())
        e.preventDefault()
        window.dispatchEvent(new Event('hashchange'))
    }
})


window.Alpine = Alpine;

Alpine.start();

Turbolinks.start();
