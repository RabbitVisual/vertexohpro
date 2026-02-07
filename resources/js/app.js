import './bootstrap';
import './theme';
// import './auth-forms'; // Assuming these exist or will be
// import './masks';
// import './cep-lookup';

import Alpine from 'alpinejs';
import Sortable from 'sortablejs';
import Chart from 'chart.js/auto';
import IMask from 'imask';

window.Alpine = Alpine;
window.Sortable = Sortable;
window.Chart = Chart;
window.IMask = IMask;

Alpine.start();
