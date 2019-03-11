import {PolymerElement, html} from "../../../node_modules/@polymer/polymer/polymer-element.js";
import '../../../node_modules/@polymer/iron-ajax/iron-ajax.js';
import '../../../node_modules/@polymer/polymer/lib/elements/dom-repeat.js';
import {BaseClass} from "../base-class.js";

class ParentTree extends BaseClass {
    static get template() {
        return html`
        <link rel="stylesheet" href="/css/gliphicons.min.css">
      <style>
      :host {
                position: relative;
                width: 100%;
                display: block;
                min-height: 50px;
            }

            :host .parent-folder .glyphicon {
                margin-right: 5px;
                color: #e69f54;
            }

            :host .parent-folder {
                margin-bottom: 5px;
                cursor: pointer;
            }

            :host paper-spinner {
                position: absolute;
                top: 0;
                left: 50%;
                transform: translateX(-50%);
                display: block;
                margin: 0 auto;
            }
      </style>
      <paper-spinner id="spinner"></paper-spinner>
        <template id="domRepeat" is="dom-repeat" items="{{parentCategories}}">
            <div class="parent-folder"
                 on-dblclick="dblClickFolder"
                 onselectstart="return false"
                 onmousedown="return false"
                 data-item-id$="{{item.id}}">
                {{item.offset}}<span class="glyphicon glyphicon-folder-open"></span>{{item.name}}
            </div>
        </template>
        <slot></slot>
        <iron-ajax id="ajax"
                   handle-as="json"
                   on-response="handleResponse"
                   last-response="{{response}}"
                   debounce-duration="300"></iron-ajax>
        `;
    }

    static get properties() {
        return {
            itemId: {type: Number, observer: '_runAjax'},
            parentCategories: Array,
            urlApi: String
        }
    }

    constructor() {
        super();
    }

    _runAjax() {
        this.spinnerOn();
        if (this.itemId != 0) {
            this.$.ajax.url = this.urlApi + '/' + this.itemId;
        } else {
            this.$.ajax.url = this.urlApi;
        }
        this.$.ajax.generateRequest();

    }

    dblClickFolder(evt) {
        const target = evt.currentTarget;
        const choiceForm = this.parentElement;

        this.spinnerOn();
        this.itemId = target.getAttribute('data-item-id');

        const brandsForChoiceForm = choiceForm.querySelector('brands-for-choice-form');
        const groupGoodList = choiceForm.querySelector('group-good-for-choice-form');
        const itemElement = choiceForm.querySelector('item-element');
        if (this.itemId != 0) {
            brandsForChoiceForm.itemId = 0;
            if (brandsForChoiceForm.itemId == 0) {
                brandsForChoiceForm._runAjax();
            }
            brandsForChoiceForm.categoryId = this.itemId;

        } else {
            brandsForChoiceForm.brands = [];
            groupGoodList.groupGood = [];
            itemElement.response = [];

        }
    }

    handleResponse() {

        this.parentCategories = [
            {
                'id': 0,
                'name': 'Корневая директория',
                'offset': '',
            }
        ];

        if (this.itemId != 0) {
            if (this.response.parent != null) {
                this.push('parentCategories', {
                    'id': this.response.parent.id,
                    'name': this.response.parent.name,
                    'offset': '--',
                });
            }
            this.push('parentCategories', {
                'id': this.response.id,
                'name': this.response.name,
                'offset': '--'
            });
        } else {
            this.unshift('response', {
                'id': 0,
                'name': 'Корневая директория',
                'offset': '',
            });
            this.parentCategories = this.response;

            for (let i=0; i < this.parentCategories.length; i++) {
                if (i > 0) {
                    this.parentCategories[i].offset = '--';
                }
            }
        }

        this.spinnerOff();
    }
}

customElements.define('parent-tree', ParentTree);