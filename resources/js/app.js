import './bootstrap';
import './theme';
import './auth-forms';
import './masks';
import './cep-lookup';

import Sortable from 'sortablejs';
import Chart from 'chart.js/auto';
import IMask from 'imask';

import Alpine from 'alpinejs';
import focus from '@alpinejs/focus';

Alpine.plugin(focus);

window.Alpine = Alpine;
window.Sortable = Sortable;
window.Chart = Chart;
window.IMask = IMask;

Alpine.start();

// Tooltip Directive
document.addEventListener('alpine:init', () => {
    Alpine.directive('tooltip', (el, { expression }, { evaluate }) => {
        let tooltipEl = null;

        const show = () => {
            const text = evaluate(expression);
            if (!text) return;

            tooltipEl = document.createElement('div');
            tooltipEl.textContent = text;
            tooltipEl.className = 'fixed z-[99999] px-2 py-1 bg-slate-800 text-white text-xs rounded shadow-lg pointer-events-none transform -translate-x-1/2 -translate-y-full mt-[-8px] whitespace-nowrap';
            document.body.appendChild(tooltipEl);

            const rect = el.getBoundingClientRect();
            tooltipEl.style.left = `${rect.left + rect.width / 2}px`;
            tooltipEl.style.top = `${rect.top}px`;
        };

        const hide = () => {
            if (tooltipEl) {
                tooltipEl.remove();
                tooltipEl = null;
            }
        };

        el.addEventListener('mouseenter', show);
        el.addEventListener('mouseleave', hide);
    });
});

// Global Toast Helper
window.toast = (message, type = 'success') => {
    window.dispatchEvent(new CustomEvent('notify', {
        detail: { message, type }
    }));
};
