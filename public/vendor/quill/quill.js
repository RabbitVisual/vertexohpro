class Quill {
    constructor(selector, options) {
        this.selector = selector;
        this.options = options;
        this.root = document.querySelector(selector);
        console.log('Quill initialized on', selector);
    }
    on(event, callback) {
        console.log('Quill event registered:', event);
    }
}
