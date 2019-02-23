import {PolymerElement, html} from "../../../node_modules/@polymer/polymer/polymer-element.js";
import '../../../node_modules/@polymer/polymer/lib/elements/dom-repeat.js';
import '../../../node_modules/@polymer/paper-spinner/paper-spinner.js';
import '../../../node_modules/@polymer/paper-listbox/paper-listbox.js';
import '../../../node_modules/@polymer/iron-ajax/iron-ajax.js';

class PartnerElement extends PolymerElement {
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
      <paper-spinner-lite id="spinner"></paper-spinner-lite>
        <paper-listbox class="item-list" attr-for-selected="item-partner" selected="{{itemPartner}}"
                       fallback-selection="None">
            <template id="domRepeat" is="dom-repeat" items="{{response}}">
                <paper-item item-partner="{{item}}"
                            onselectstart="return false"
                            onmousedown="return false">
                    <span class="glyphicon glyphicon-file"></span>{{item.name}}
                </paper-item>
            </template>
        </paper-listbox>
        <slot></slot>
        <iron-ajax id="ajax"
                   url="/api/partners"
                   handle-as="json"
                   on-response="handleResponse"
                   last-response="{{response}}"
                   debounce-duration="300"></iron-ajax>
        `;
    }

    static get properties() {
        return {
            'partnerId': {type: Number, observer: '_runAjax'},
            'itemPartner': {type: Object, observer: 'selectPartner'},
        }
    }

    constructor() {
        super();
    }

    _runAjax() {
        this.spinnerOn();

        this.$.ajax.generateRequest();

    }

    handleResponse() {
        this.spinnerOff();
    }

    selectPartner() {
        const choiceForm = this.parent;
        choiceForm.itemPartner = this.itemPartner
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

customElements.define('partner-element', PartnerElement);