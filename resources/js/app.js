import './bootstrap';
import './theme';
import './auth-forms';
import './masks';
import './cep-lookup';

import Alpine from 'alpinejs';
import trap from '@alpinejs/trap';
import focus from '@alpinejs/focus';

Alpine.plugin(trap);
Alpine.plugin(focus);

window.Alpine = Alpine;
Alpine.start();

// Global Toast Helper
window.toast = (message, type = 'success') => {
    window.dispatchEvent(new CustomEvent('notify', {
        detail: { message, type }
    }));
};
