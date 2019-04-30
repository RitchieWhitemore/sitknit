import {PolymerElement, html} from "../../../node_modules/@polymer/polymer/polymer-element.js";
import '../../../node_modules/@polymer/paper-spinner/paper-spinner.js';
import '../../../node_modules/@polymer/paper-listbox/paper-listbox.js';
import '../../../node_modules/@polymer/iron-ajax/iron-ajax.js';
import '../../../node_modules/@polymer/polymer/lib/elements/dom-repeat.js';

import {BaseClass} from "../base-class.js";

class GroupGoodForChoiceForm extends BaseClass {
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
            <template id="domRepeat" is="dom-repeat" items="{{groupGood}}">
                <div class$="list-catalog [[item.status]]" 
                 data-name$="[[item.name]]" 
                 on-dblclick="dblClickGroup"
                 onselectstart="return false"
                 onmousedown="return false"
                 >--<span class$="glyphicon glyphicon-folder-[[getStatusCatalog(item)]]"></span>{{item.name}}
                </div>
            </template>
        <slot></slot>
        <iron-ajax id="ajax"
                   url="/api/good/group-by-name"
                   handle-as="json"
                   on-response="handleResponse"
                   last-response="{{response}}"
                   debounce-duration="300"></iron-ajax>
        `;
    }

    static get properties() {
        return {
            groupGood: {type: Array, value: []},
            categoryId: Number,
            brandId: Number,
            itemName: String,
            itemObject: Object,
            urlApi: String,
        }
    }

    static get observers() {
        return [
            '_runAjax(brandId, categoryId, itemName)',
        ]
    }

    constructor() {
        super();
    }

    _runAjax() {
        this.spinnerOn();
        this.$.ajax.params = {
            categoryId: this.categoryId,
            brandId: this.brandId,
            groupName: this.itemName,
        };

        this.$.ajax.generateRequest();
    }

    dblClickGroup(evt) {
        const target = evt.currentTarget;
     //   const itemElement = this.parentElement.querySelector('item-element');

        if (this.itemName != target.getAttribute('data-name')) {
            this.itemName = target.getAttribute('data-name');
           // itemElement.groupName = this.itemName;
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
        this.groupGood = [];
        const itemElement = this.parentElement.querySelector('item-element');
        if (this.response && this.response.length == 1) {
            this.groupGood = this.response;
            this.groupGood[0].status = 'open';
            this.unshift('groupGood', {name: 'Все группы', status: 'close'});
            itemElement.categoryId = this.categoryId;
            itemElement.brandId = this.brandId;
            itemElement.groupName = this.groupGood[1].name;
            itemElement.typePrice = this.parentElement.typePrice;
            itemElement._runAjax();
        } else {
            this.groupGood = this.response;
            itemElement.response = [];
        }
        this.spinnerOff();
    }

}

customElements.define('group-good-for-choice-form', GroupGoodForChoiceForm);