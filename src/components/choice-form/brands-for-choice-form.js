import {PolymerElement, html} from "../../../node_modules/@polymer/polymer/polymer-element.js";
import '../../../node_modules/@polymer/paper-spinner/paper-spinner.js';
import '../../../node_modules/@polymer/paper-listbox/paper-listbox.js';
import '../../../node_modules/@polymer/iron-ajax/iron-ajax.js';
import '../../../node_modules/@polymer/polymer/lib/elements/dom-repeat.js';

import {BaseClass} from "../base-class.js";

class BrandsForChoiceForm extends BaseClass {
    static get template() {
        return html`
        <link rel="stylesheet" href="/css/gliphicons.min.css">
      <style>
            :host paper-listbox {
                padding-top: 0;
                display: flex;
                flex-direction: column;
            }

            .brand {
                padding: 5px;
                cursor: pointer;
            }
            
            .brand.open {
                cursor: default;
            }

            .brand .glyphicon {
                margin-right: 5px;
                color: #e6ca35;
            }

            paper-spinner-lite {
                display: block;
                margin: 0 auto;
            }
      </style>
      <paper-spinner id="spinner"></paper-spinner>
        <!--<paper-listbox attr-for-selected="item-object" selected="{{itemObject}}"
                       fallback-selection="None">-->
            <template id="domRepeat" is="dom-repeat" items="{{brands}}">
                <div class$="brand [[item.status]]" 
                 data-id$="[[item.id]]" 
                 on-dblclick="dblClickFolder"
                 onselectstart="return false"
                 onmousedown="return false"
                 ><span class$="glyphicon glyphicon-folder-[[getStatusCatalog(item)]]"></span>{{item.name}}
                </div>
            </template>
        <!--</paper-listbox>-->
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

    ready() {
        super.ready();
    }

    _runAjax() {
        this.spinnerOn();
        if (this.itemId > 0) {
            this.$.ajax.url = this.urlApi + '/' + this.itemId;
        } else {
            this.$.ajax.url = this.urlApi;
        }

        this.$.ajax.generateRequest();
    }

    dblClickFolder(evt) {
        const target = evt.currentTarget;
        const choiceForm = this.parent;
        const itemElement = this.parentElement.querySelector('item-element');

        if (this.itemId != target.getAttribute('data-id')) {
            this.itemId = target.getAttribute('data-id');
            itemElement.brandId = this.itemId;
            itemElement._runAjax();
            this.spinnerOn();
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
        if (!Array.isArray(this.response)) {
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