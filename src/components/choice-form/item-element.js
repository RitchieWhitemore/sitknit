import {PolymerElement, html} from "../../../node_modules/@polymer/polymer/polymer-element.js";

import '../../../node_modules/@polymer/polymer/lib/elements/dom-repeat.js';
import '../../../node_modules/@polymer/paper-spinner/paper-spinner.js';
import '../../../node_modules/@polymer/paper-listbox/paper-listbox.js';
import '../../../node_modules/@polymer/iron-ajax/iron-ajax.js';

import {BaseClass} from '../base-class.js'

class ItemElement extends BaseClass {
    static get template() {
        return html`
       <link rel="stylesheet" href="/css/gliphicons.min.css">
        <style>
            :host paper-listbox {
                padding-top: 0;
                display: flex;
                flex-direction: column;
            }

            :host paper-listbox paper-item {
                padding: 5px;
                cursor: pointer;
            }

            :host .item-list paper-item .glyphicon {
                margin-right: 5px;
                color: #79c5b4;
            }

            :host paper-spinner-lite {
                display: block;
                margin: 0 auto;
            }

            :host paper-listbox .iron-selected {
                background: lightgrey;
            }
      </style>
      <paper-spinner id="spinner"></paper-spinner>
        <paper-listbox class="item-list" attr-for-selected="item-object" selected="{{itemObject}}"
                       fallback-selection="None">
            <template id="domRepeat" is="dom-repeat" items="{{response}}">
                <paper-item item-object="{{item}}"
                            onselectstart="return false"
                            onmousedown="return false">
                    <span class="glyphicon glyphicon-file"></span>[[getName(item)]]
                </paper-item>
            </template>
        </paper-listbox>
        <slot></slot>
        <iron-ajax id="ajax"
                   url="{{urlApi}}"
                   handle-as="json"
                   on-response="handleResponse"
                   last-response="{{response}}"
                   debounce-duration="300"></iron-ajax>
        `;
    }

    static get properties() {
        return {
            brandId: Number,
            itemObject: {type: Object, observer: 'selectItem'},
            categoryId: Number,
            groupName: String,
            urlApi: String,
        }
    }

    constructor() {
        super();
    }

    _runAjax() {
        this.spinnerOn();
        if (this.categoryId) {
            this.$.ajax.url = this.urlApi;
            this.$.ajax.params = {
                'category_id': this.categoryId,
                'brand_id': this.brandId,
                'name': this.groupName,
            }
        }
        this.$.ajax.generateRequest();
    }

    findByParent() {
        this.spinnerOn();
        this.$.ajax.url = this.urlApi + '/' + this.categoryId;
    }

    handleResponse() {
        this.spinnerOff();
    }

    selectItem() {
        const choiceForm = this.parentElement;
        choiceForm.itemObject = this.itemObject
    }

    getName(item) {
        if (item.nameAndColor) {
            return item.nameAndColor
        }

        return item.name;
    }
}

customElements.define('item-element', ItemElement);