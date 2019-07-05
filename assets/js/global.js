import Tab from './components/tab';

[...document.querySelectorAll('.js-tab')].map(container => new Tab(container));
