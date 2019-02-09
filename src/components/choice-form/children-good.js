import {PolymerElement, html} from "../../../node_modules/@polymer/polymer/polymer-element.js";
import '../../../node_modules/@polymer/polymer/lib/elements/dom-repeat.js';
import '../../../node_modules/@polymer/paper-spinner/paper-spinner.js';
import '../../../node_modules/@polymer/paper-listbox/paper-listbox.js';
import '../../../node_modules/@polymer/iron-ajax/iron-ajax.js';

class ChildrenGood extends PolymerElement {
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

            :host .good-list paper-item .glyphicon {
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
      <paper-spinner-lite id="spinner"></paper-spinner-lite>
        <paper-listbox id="goodList" class="good-list" attr-for-selected="item-good" selected="{{itemGood}}"
                       fallback-selection="None">
            <template id="domRepeat" is="dom-repeat" items="{{response}}">
                <paper-item item-good="{{item}}"
                            data-good-id="{{item.id}}"
                            onselectstart="return false"
                            onmousedown="return false">
                    <span class="glyphicon glyphicon-file"></span>{{item.article}} {{item.nameAndColor}}
                </paper-item>
            </template>
        </paper-listbox>
        <slot></slot>
        <iron-ajax id="ajax"
                   url="/api/good/category"
                   handle-as="json"
                   on-response="handleResponse"
                   last-response="{{response}}"
                   debounce-duration="300"></iron-ajax>
        `;
    }

    static get properties() {
        return {
            'categoryId': {type: Number, observer: '_runAjax'},
            'itemGood': {type: Object, observer: 'selectGood'},
        }
    }

    constructor() {
        super();
    }

    _runAjax() {
        this.spinnerOn();

        this.$.ajax.params = {
            'category_id': this.categoryId,
        };
        this.$.ajax.generateRequest();

    }

    handleResponse() {
        this.spinnerOff();
    }

    selectGood() {
        const choiceForm = this.parent;
        choiceForm.itemGood = this.itemGood
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

customElements.define('children-good', ChildrenGood);