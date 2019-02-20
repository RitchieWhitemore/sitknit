import {PolymerElement, html} from "../../../node_modules/@polymer/polymer/polymer-element.js";
import '../../../node_modules/@polymer/polymer/lib/elements/dom-repeat.js';
import '../../../node_modules/@polymer/iron-ajax/iron-ajax.js';
import '../../../node_modules/@polymer/paper-button/paper-button.js';
import '../../../node_modules/@polymer/paper-dialog/paper-dialog.js';
import '../../../node_modules/@polymer/paper-dialog-scrollable/paper-dialog-scrollable.js';
import '../../../node_modules/@polymer/paper-spinner/paper-spinner.js';

import './parent-tree.js';
import './children-category.js';
import './children-good.js';

class ChoiceForm extends PolymerElement {
    static get template() {
        return html`
      <style>
            :host {
                margin-bottom: 20px;
                display: flex;
                flex-direction: row;
                align-items: flex-end;
                width: 100%;
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
            <span class="article">{{article}}</span>
            <slot name="input"></slot>
            <div class="field-choice">{{name}}
            <paper-spinner id="spinner"></paper-spinner></div>
        </div>
        <paper-button raised id="deleteButton" class="visually-hidden" on-click="delete">Очистить</paper-button>
        <paper-button raised on-click="open">Выбрать</paper-button>
        <paper-dialog id="scrolling">
            <h2>Выберите товар</h2>
            <paper-dialog-scrollable>
                <parent-tree parent="[[getThis()]]" entity-id="{{entityId}}"></parent-tree>
                <children-category parent="[[getThis()]]" entity-id="{{entityId}}"></children-category>
                <children-good parent="[[getThis()]]" category-id="{{categoryId}}"></children-good>
            </paper-dialog-scrollable>
            <div class="buttons">
                <paper-button dialog-dismiss>Отмена</paper-button>
                <paper-button dialog-confirm on-click="confirm">Выбрать</paper-button>
            </div>
        </paper-dialog>
        <iron-ajax id="ajax"
                   url="/api/category/parent"
                   handle-as="json"
                   on-response="handleResponse"
                   last-response="{{response}}"
                   debounce-duration="300"></iron-ajax>
        `;
    }

    static get properties() {
        return {
            'article': String,
            'id': {'type': Number, 'observer': 'setInputValue'},
            'placeholder': String,
            'label': String,
            'model': String,
            'entityId': Number,
            'goodFlag': Boolean,
            'goodId': Number,
            'categoryId': {type: Number, value: 0},
            'name': String,
            'itemCategory': Object,
            'itemGood': Object,
        }
    }

    constructor() {
        super();
    }

    confirm() {
        const input = this.querySelector('input');
        if (this.goodFlag) {
            this.name = this.itemGood.name;
            this.id = this.itemGood.id;
            this.article = this.itemGood.article;
        } else {
            this.name = this.itemCategory.name;
            this.id = this.itemCategory.id;
            this.article = this.itemCategory.article;
        }

    }

    delete() {
        this.spinnerOn();
        this.$.ajax.url = '/api/good/delete-main-good';
        this.$.ajax.method = 'DELETE';
        this.$.ajax.params = {
            'id': this.goodId,
        };
        this.$.ajax.generateRequest().completes.then(
            (request) => {
                this.id = null;
                this.name = this.placeholder;
                this.article = '';
                this.$.deleteButton.classList.add('visually-hidden');
                this.spinnerOff();
            },
            request => console.log('failure', request)
        );
    }

    getThis() {
        return this;
    }

    handleResponse() {
        this.spinnerOff();
    }

    findGood() {
        this.$.ajax.url = '/api/goods/' + this.entityId;
        this.$.ajax.generateRequest().completes.then(
            (request) => {
                this.id = request.response.id;
                this.name = request.response.name;
                this.article = request.response.article;
                this.entityId = request.response.category.id;
                this.categoryId = request.response.category.id;
                this.spinnerOff();
                this.$.deleteButton.classList.remove('visually-hidden');
            },
            request => console.log('failure', request)
        );
    }

    findEntity() {
        this.$.ajax.url = '/api/'+ this.model +'/' + this.entityId;
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

        if (this.entityId == 0) {
            this.name = this.placeholder;
        } else {
            this.spinnerOn();
            if (this.goodFlag) {
                this.findGood();
            } else {
                this.findEntity();
            }
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

customElements.define('choice-form', ChoiceForm);