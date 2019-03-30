import {PolymerElement, html} from "../../../node_modules/@polymer/polymer/polymer-element.js";
import '../../../node_modules/@polymer/polymer/lib/elements/dom-repeat.js';
import '../../../node_modules/@polymer/iron-ajax/iron-ajax.js';

class DocumentTable extends PolymerElement {
    static get template() {
        return html`
      <style>
        ::slotted(selected-modal) {
            margin-bottom: 20px;
        }
        
        table {
            margin-bottom: 30px;
            width: 100%;
            border: 1px solid black;
            border-collapse: collapse ;
        }
        thead {
            background-color: lightgrey;
        }
        th {
            padding: 5px;
            border: 1px solid black;
            width: 100px;
        }
        td {
            padding: 5px;
            border: 1px solid grey;
        }
        .header-good {
            width: auto;
        }
        
        td input {
            padding: 5px;
        }
       
      </style>
      <slot name="button"></slot>
      <table>
        <thead>
            <tr>
                <th>№</th>
                <th>Артикул</th>
                <th class="header-good">Товар</th>
                <th>Количество</th>
                <th>Цена</th>
                <th>Сумма</th>
            </tr>            
        </thead>
        <tbody>
            <template is="dom-repeat" items="{{response}}">
                <tr>
                    <td id="numRow">[[getIndex(index)]]</td>
                    <td>
                    {{item.article}}
                    </td>
                    <td>
                    {{item.nameAndColor}}         
                    </td>
                    <td>
                    <input id="qty" type="number" name="qty" value="{{item.qty}}" on-change="changeInput" on-keypress="pressEnter">
                    </td>
                    <td>
                    <input id="price" type="number" name="price" value="{{item.price}}" on-change="changeInput" on-keypress="pressEnter">
                    </td>
                    <td id="sumRow">
                    {{item.sum}}
                    </td>
                </tr>   
            </template>           
        </tbody>    
      </table>
      <slot></slot>
      <iron-ajax id="ajax"
                   url="/api/receipt-item?receipt_id={{documentId}}"                                 
                   handle-as="json"
                   on-response="handleResponse"
                   last-response="{{response}}"
                   ></iron-ajax>
        `;
    }

    static get properties() {
        return {
            documentId: {type: Number, value: 0},
            documentType: String,
        }
    }

    calculateSum(item) {
        return item.qty * item.price;
    }

    calculateTotalDocument() {
        let result = 0;
        if (this.response.length == 1) {
            result = this.calculateSum(this.response[0]);
        } else {
            result = this.response.reduce(function (sum, current) {
                if (typeof sum == 'object') {
                    sum = this.calculateSum(sum)
                }

                return sum + this.calculateSum(current);
            }.bind(this));
        }

        const totalSumElement = this.querySelector('#totalSum');
        totalSumElement.value = result;
    }

    constructor() {
        super();

        const buttonSaveElement = document.querySelector('#buttonSave');
        buttonSaveElement.addEventListener('click', this.saveDocument);
    }

    getIndex(index) {
        return ++index;
    }

    changeInput(evt) {
        const row = evt.currentTarget.parentElement.parentElement;
        let sum = row.querySelector('#sumRow');

        sum.innerHTML = this.calculateSum(evt.model.item);
        console.log(evt);
    }

    handleResponse() {
        for (let i = 0; i < this.response.length; i++) {
            this.response[i].sum = this.response[i].price * this.response[i].qty;
        }
    }

    pressEnter(evt) {
        if (evt.keyCode == 13) {
            evt.target.blur();
        }
    }

    ready() {
        super.ready();
        this.$.ajax.generateRequest();
    }

    saveDocument(evt) {
        evt.preventDefault();
        const documentTable = document.querySelector('document-table');
        //documentTable.$.ajax.body = documentTable.response;
        //documentTable.$.ajax.method = 'POST';
        //documentTable.$.ajax.generateRequest();

        const formData = new FormData(document.querySelector('#w0'));
        formData.append("documentTable", JSON.stringify(documentTable.response));
        formData.append('Receipt[id]', documentTable.documentId);
        const xhr = new XMLHttpRequest();

        xhr.open("POST", "/api/receipt/save");
        xhr.send(formData);
    }
}

customElements.define('document-table', DocumentTable);