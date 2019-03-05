import {PolymerElement, html} from '../../node_modules/@polymer/polymer/polymer-element.js';

export class BaseClass extends PolymerElement {

    static get template() {
        return html`
        `;
    }

    spinnerOn() {
        this.$.spinner.active = true;
        this.$.spinner.style.display = 'block';
    }

    spinnerOff() {
        this.$.spinner.active = false;
        this.$.spinner.style.display = 'none';
    }

}

customElements.define('base-class', BaseClass);