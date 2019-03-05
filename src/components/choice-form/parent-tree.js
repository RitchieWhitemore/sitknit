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
                 data-item-id="{{item.id}}">
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
            urlApi: String,
            parent: Object
        }
    }

    constructor() {
        super();
    }

    _runAjax() {
        this.spinnerOn();
        if (this.itemId != 0) {
            this.$.ajax.url = this.urlApi + this.itemId;
        }
        this.$.ajax.generateRequest();

    }

    dblClickFolder(evt) {
        const target = evt.currentTarget;
        const choiceForm = this.parent;

        this.spinnerOn();
        this.itemId = target.dataItemId;
        //this.parent.shadowRoot.querySelector('children-category').itemId = this.itemId;

        if (choiceForm.goodFlag) {
            choiceForm.categoryId = this.entityId;
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
        }

        this.spinnerOff();
    }
}

customElements.define('parent-tree', ParentTree);