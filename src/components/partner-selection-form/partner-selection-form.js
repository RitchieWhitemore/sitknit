import {PolymerElement, html} from "../../../node_modules/@polymer/polymer/polymer-element.js";
import '../../../node_modules/@polymer/polymer/lib/elements/dom-repeat.js';
import '../../../node_modules/@polymer/iron-ajax/iron-ajax.js';
import '../../../node_modules/@polymer/paper-button/paper-button.js';
import '../../../node_modules/@polymer/paper-dialog/paper-dialog.js';
import '../../../node_modules/@polymer/paper-dialog-scrollable/paper-dialog-scrollable.js';
import '../../../node_modules/@polymer/paper-spinner/paper-spinner.js';

import './partner-element.js';

class PartnerSelectionForm extends PolymerElement {
    static get template() {
        return html`
      <style>
            :host {
                margin: 20px 0;
                display: flex;
                flex-direction: row;
                align-items: flex-end;
                width: 100%;
            }
            
            :host label {
            margin-bottom: 5px;
            display: block;
                font-weight: bold;
            }

            :host .field-choice {
                margin: 0;
                padding: 10px 20px;
                border: solid 1px grey;
                min-width: 200px;
            }

            :host paper-dialog {
                top: 0;
                padding: 0 25px;
                z-index: 9999;
            }

            :host paper-spinner {
                display: none;
                margin: 0 auto;
            }
            
            :host .visually-hidden {
                display: none;
            }
        </style>
        <div class="field-wrapper">
            <label>{{label}}</label>
            <slot name="input"></slot>
            <div class="field-choice">{{name}}
            <paper-spinner id="spinner"></paper-spinner></div>
        </div>
        <paper-button raised on-click="open">Выбрать</paper-button>
        <paper-dialog id="scrolling">
            <h2>Выберите контрагента</h2>
            <paper-dialog-scrollable>
                <partner-element parent="[[getThis()]]" partner-id="{{partnerId}}"></partner-element>
            </paper-dialog-scrollable>
            <div class="buttons">
                <paper-button dialog-dismiss>Отмена</paper-button>
                <paper-button dialog-confirm on-click="confirm">Выбрать</paper-button>
            </div>
        </paper-dialog>
        <iron-ajax id="ajax"
                   url="/api/partners/{{partnerId}}"
                   handle-as="json"
                   on-response="handleResponse"
                   last-response="{{response}}"
                   debounce-duration="300"></iron-ajax>
        `;
    }

    static get properties() {
        return {
            'id': {'type': Number, 'observer': 'setInputValue'},
            'itemPartner': Object,
            'label': String,
            'name': String,
            'partnerId': {type: Number, value: 0},
            'placeholder': String,
        }
    }

    constructor() {
        super();
    }

    confirm() {
        this.name = this.itemPartner.name;
        this.id = this.itemPartner.id;
    }

    getThis() {
        return this;
    }

    handleResponse() {
        this.spinnerOff();
    }

    findPartner() {
        this.$.ajax.url = '/api/partners/' + this.partnerId;
        this.$.ajax.generateRequest().completes.then(
            (request) => {
                this.id = request.response.id;
                this.name = request.response.name;
                this.spinnerOff();
            },
            request => console.log('failure', request)
        );
    }

    open() {
        this.$.scrolling.open();
    }

    ready() {
        super.ready();

        if (this.partnerId != 0) {
            this.spinnerOn();
            this.findPartner();
        } else {
            this.name = this.placeholder;
        }

    }

    setInputValue() {
        const input = this.querySelector('input');
        input.value = this.id;
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

customElements.define('partner-selection-form', PartnerSelectionForm);