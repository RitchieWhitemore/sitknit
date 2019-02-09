import {PolymerElement, html} from "../../../node_modules/@polymer/polymer/polymer-element.js";
import '../../../node_modules/@polymer/paper-spinner/paper-spinner.js';
import '../../../node_modules/@polymer/paper-listbox/paper-listbox.js';
import '../../../node_modules/@polymer/iron-ajax/iron-ajax.js';

class ChildrenCategory extends PolymerElement {
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

            :host paper-item .glyphicon {
                margin-right: 5px;
                color: #e69f54;
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
        <paper-listbox attr-for-selected="item-category" selected="{{itemCategory}}"
                       fallback-selection="None">
            <template id="domRepeat" is="dom-repeat" items="{{response}}">
                <paper-item item-category="{{item}}"
                            data-entity-id="{{item.id}}"
                            on-dblclick="dblClickFolder"
                            onselectstart="return false"
                            onmousedown="return false"><span
                        class="glyphicon glyphicon-folder-close"></span>{{item.name}}
                </paper-item>
            </template>
        </paper-listbox>
        <slot></slot>
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
            'entityId': {type: Number, observer: '_runAjax'},
            'itemCategory': {type: Object, observer: 'selectCategory'},
        }
    }

    constructor() {
        super();
    }

    _runAjax() {
        this.spinnerOn();
        this.$.ajax.params = {
            'parent_id': this.entityId,
        };
        this.$.ajax.generateRequest();
    }

    dblClickFolder(evt) {
        const target = evt.currentTarget;
        const choiceForm = this.parent;

        this.entityId = target.dataEntityId;
        this.parent.shadowRoot.querySelector('parent-tree').entityId = this.entityId;

        if (choiceForm.goodFlag) {
            choiceForm.categoryId = this.entityId;
        }

        this.spinnerOn();
    }

    handleResponse() {
        this.spinnerOff();
    }

    selectCategory() {
        const choiceForm = this.parent;
        choiceForm.itemCategory = this.itemCategory;
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

customElements.define('children-category', ChildrenCategory);