import './bootstrap';
import './theme';

import Sortable from 'sortablejs';
window.Sortable = Sortable;

import Chart from 'chart.js/auto';
window.Chart = Chart;

import IMask from 'imask';
window.IMask = IMask;

import Alpine from 'alpinejs';
import focus from '@alpinejs/focus';

Alpine.plugin(focus);

window.Alpine = Alpine;
Alpine.start();

// Global Toast Helper
window.toast = (message, type = 'success') => {
    window.dispatchEvent(new CustomEvent('notify', {
        detail: { message, type }
    }));
};
