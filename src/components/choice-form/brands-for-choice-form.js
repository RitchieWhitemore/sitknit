import {PolymerElement, html} from "../../../node_modules/@polymer/polymer/polymer-element.js";
import '../../../node_modules/@polymer/paper-spinner/paper-spinner.js';
import '../../../node_modules/@polymer/paper-listbox/paper-listbox.js';
import '../../../node_modules/@polymer/iron-ajax/iron-ajax.js';
import '../../../node_modules/@polymer/polymer/lib/elements/dom-repeat.js';

import {BaseClass} from "../base-class.js";
import "./group-good-for-choice-form.js";

class BrandsForChoiceForm extends BaseClass {
    static get template() {
        return html`
        <link rel="stylesheet" href="/css/gliphicons.min.css">
      <style>
            .list-catalog {
                padding: 5px;
                cursor: pointer;
            }
            
            .list-catalog.open {
                cursor: default;
            }

            .list-catalog .glyphicon {
                margin-right: 5px;
                color: #e6ca35;
            }

            paper-spinner-lite {
                display: block;
                margin: 0 auto;
            }
      </style>
      <paper-spinner id="spinner"></paper-spinner>
            <template id="domRepeat" is="dom-repeat" items="{{brands}}">
                <div class$="list-catalog [[item.status]]" 
                 data-id$="[[item.id]]" 
                 on-dblclick="dblClickFolder"
                 onselectstart="return false"
                 onmousedown="return false"
                 ><span class$="glyphicon glyphicon-folder-[[getStatusCatalog(item)]]"></span>{{item.name}}
                </div>
            </template>
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
            brands: {type: Array, value: []},
            categoryId: Number,
            itemId: {type: Number, observer: '_runAjax'},
            itemObject: Object,
            urlApi: String,
        }
    }

    constructor() {
        super();
    }

    _runAjax() {
        this.spinnerOn();
        if (this.itemId > 0) {
            this.$.ajax.url = this.urlApi + '/' + this.itemId;
        } else {
            this.$.ajax.url = this.urlApi;
        }
        if (this.categoryId) {
            this.$.ajax.params = {
                categoryId: this.categoryId,
            }
        }
        this.getGroupGood();
        this.$.ajax.generateRequest();
    }

    getGroupGood() {
        const groupGood = this.parentElement.querySelector('group-good-for-choice-form');
        groupGood.brandId = this.itemId;
        groupGood.categoryId = this.categoryId;
        groupGood.itemName = undefined;
    }

    dblClickFolder(evt) {
        const target = evt.currentTarget;
        const itemElement = this.parentElement.querySelector('item-element');

        if (this.itemId != target.getAttribute('data-id')) {
            this.itemId = target.getAttribute('data-id');
            this.getGroupGood();
            this.spinnerOn();
        }

        if (this.itemId == 0) {
            itemElement.brandId = this.itemId;
            itemElement._runAjax();
        }
    }

    getStatusCatalog(item) {
        if (item.status) {
            return item.status;
        }

        return 'close';
    }

    handleResponse() {
        this.brands = [];
        if (this.response && !Array.isArray(this.response)) {
            this.push('brands', {id: 0, name: 'Все бренды', status: 'close'});
            this.response.status = 'open';
            this.push('brands', this.response);
        } else {
            this.brands = this.response;
        }
        this.spinnerOff();
    }

}

customElements.define('brands-for-choice-form', BrandsForChoiceForm);