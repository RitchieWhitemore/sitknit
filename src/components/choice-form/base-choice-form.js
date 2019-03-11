import {PolymerElement, html} from "../../../node_modules/@polymer/polymer/polymer-element.js";
import '../../../node_modules/@polymer/polymer/lib/elements/dom-repeat.js';
import '../../../node_modules/@polymer/iron-ajax/iron-ajax.js';
import '../../../node_modules/@polymer/paper-button/paper-button.js';
import '../../../node_modules/@polymer/paper-dialog/paper-dialog.js';
import '../../../node_modules/@polymer/paper-dialog-scrollable/paper-dialog-scrollable.js';
import '../../../node_modules/@polymer/paper-spinner/paper-spinner.js';

import {BaseClass} from '../base-class.js'

export class BaseChoiceForm extends BaseClass {
    static get template() {
        return  html`
                <style>
            :host {
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
                padding: 6px 20px;
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
                position: absolute;
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
        <paper-button raised id="deleteButton" class="visually-hidden" on-click="delete">Очистить</paper-button>
        <paper-button raised on-click="open">Выбрать</paper-button>        
        <paper-dialog id="scrolling">
            <slot name="title-dialog"></slot>
            <paper-dialog-scrollable>
                <slot name="parent-tree" item-id="{{parentId}}"></slot>
                <slot name="brands"></slot>
                <slot name="group-good"></slot>
                <slot name="item-element" item-id="{{itemId}}"></slot>
            </paper-dialog-scrollable>
            <div class="buttons">
                <paper-button dialog-dismiss>Отмена</paper-button>
                <paper-button dialog-confirm on-click="confirm">Выбрать</paper-button>
            </div>
        </paper-dialog>
        <iron-ajax id="ajax"
                   url="{{urlApi}}{{itemId}}"
                   handle-as="json"
                   on-response="handleResponse"
                   last-response="{{response}}"
                   debounce-duration="300"></iron-ajax>
`;
    }

    static get properties() {
        return {
            categoryId: Number,
            id: {'type': Number, 'observer': 'setInputValue'},
            itemObject: Object,
            label: String,
            name: String,
            itemId: {type: Number, value: 0},
            model: String,
            placeholder: String,
            urlApi: String,
        }
    }

    constructor() {
        super();
    }

    confirm() {
        if (this.model == 'good') {
            this.name = this.itemObject.nameAndColor;
        } else {
            this.name = this.itemObject.name;
        }
        this.id = this.itemObject.id;
    }

    delete() {
        if (this.model == 'good') {
            this.deleteMainGood();
        }

    }

    deleteMainGood() {
        this.spinnerOn();
        this.$.ajax.url = '/api/good/delete-main-good';
        this.$.ajax.method = 'DELETE';
        this.$.ajax.params = {
            'id': this.itemId,
        };
        this.$.ajax.generateRequest().completes.then(
            (request) => {
                this.id = null;
                this.name = this.placeholder;
                this.$.deleteButton.classList.add('visually-hidden');
                this.spinnerOff();
            },
            request => console.log('failure', request)
        );
    }

    handleResponse() {
        this.spinnerOff();
    }

    findItem() {
        this.$.ajax.url = this.urlApi + this.itemId;
        this.$.ajax.generateRequest().completes.then(
            (request) => {
                this.id = request.response.id;
                this.name = this.getName(request.response);
                this.spinnerOff();
                if (this.model == 'good') {
                    this.$.deleteButton.classList.remove('visually-hidden');
                }
            },
            request => console.log('failure', request)
        );
    }

    getName(response) {
        if (this.model == 'good') {
            return response.nameAndColor;
        } else {
            return response.name;
        }
    }

    setInputValue() {
        const input = this.querySelector('input');
        input.value = this.id;
    }

    open() {
        this.$.scrolling.open();

        if (this.model == 'good') {
            const parentTree = this.querySelector('parent-tree');
            const brandsForChoiceForm = this.querySelector('brands-for-choice-form');

            if (this.response) {
                //parentTree.itemId = this.response.category.id;
                brandsForChoiceForm.itemId = this.response.brand.id;
            }
        } else {
            const itemElement = this.querySelector('item-element');
            itemElement._runAjax();
        }
    }

    ready() {
        super.ready();

        if (this.itemId != 0) {
            this.spinnerOn();
            this.findItem();
        } else {
            this.name = this.placeholder;
        }

    }



}
customElements.define('base-choice-form', BaseChoiceForm);