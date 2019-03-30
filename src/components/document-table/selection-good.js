import {PolymerElement, html} from "../../../node_modules/@polymer/polymer/polymer-element.js";
import '../../../node_modules/@polymer/iron-ajax/iron-ajax.js';
import '../../../node_modules/@polymer/paper-button/paper-button.js';
import '../../../node_modules/@polymer/paper-dialog/paper-dialog.js';
import '../../../node_modules/@polymer/paper-dialog-scrollable/paper-dialog-scrollable.js';
import '../../../node_modules/@polymer/paper-spinner/paper-spinner.js';

class SelectionGood extends PolymerElement {
    static get template() {
        return html`
      <style>
        :host paper-button {
            margin-bottom: 30px;
        }
      </style>
      <slot></slot>
      <paper-button raised on-click="open">Подобрать</paper-button>
        <paper-dialog id="scrolling">
            <h2>Выберите товар</h2>
            <paper-dialog-scrollable>
               
            </paper-dialog-scrollable>
            <div class="buttons">
                <paper-button dialog-dismiss>Отмена</paper-button>
                <paper-button dialog-confirm on-click="confirm">Выбрать</paper-button>
            </div>
        </paper-dialog>
        `;
    }

    static get properties() {
        return {

        }
    }

    constructor() {
        super();
    }

    getThis() {
        return this;
    }

    open() {
        this.$.scrolling.open();
    }
}

customElements.define('selection-good', SelectionGood);