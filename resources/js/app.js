import './bootstrap';
import './theme';
import './auth-forms';
import './masks';
import './cep-lookup';

import Sortable from 'sortablejs';
window.Sortable = Sortable;

import Chart from 'chart.js/auto';
window.Chart = Chart;

import Alpine from 'alpinejs';
window.Alpine = Alpine;
Alpine.start();
