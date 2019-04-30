import {PolymerElement, html} from "../../../node_modules/@polymer/polymer/polymer-element.js";
import '../../../node_modules/@polymer/polymer/lib/elements/dom-repeat.js';
import '../../../node_modules/@polymer/iron-ajax/iron-ajax.js';

class DocumentTable extends PolymerElement {
    static get template() {
        return html`
        <link rel="stylesheet" href="/css/gliphicons.min.css">
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
        
        .btn {
            background: transparent;
            border: none;
            cursor: pointer;
        }
        
        .glyphicon-remove {
            color: #ff2e49;
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
                <th></th>
            </tr>            
        </thead>
        <tbody>
            <template is="dom-repeat" items="{{items}}">
                <tr>
                    <td id="numRow">[[getIndex(index)]]</td>
                    <td>
                    {{item.article}}
                    </td>
                    <td>
                    {{item.nameAndColor}}         
                    </td>
                    <td>
                    <input type="number" name="qty" value="{{item.qty}}" on-change="changeInput" on-keypress="pressEnter">
                    </td>
                    <td>
                    <input type="number" name="price" value="{{item.price}}" on-change="changeInput" on-keypress="pressEnter">
                    </td>
                    <td id="sumRow">
                    {{item.sum}}
                    </td>
                    <td><button type="button" class="btn" on-click="deleteItem" data-index$="{{index}}"><span class="glyphicon glyphicon-remove"></span></button></td>
                </tr>   
            </template>           
        </tbody>    
      </table>
      <slot></slot>
      <slot name="button-bottom"></slot>
      <iron-ajax id="ajax"                                               
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
            items: {type: Array, observer: 'calculateTotalDocument'}
        }
    }

    calculateSum(item) {
        return item.qty * item.price;
    }

    calculateTotalDocument() {
        let result = 0;
        if (this.items.length == 1) {
            result = this.calculateSum(this.items[0]);
        } else if (this.items.length > 1) {
            result = this.items.reduce(function (sum, current) {
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

    deleteItem(evt) {
        if (this.items[evt.model.index]) {
            this.splice('items', evt.model.index, 1);

            this.calculateTotalDocument();
        }
    }

    getIndex(index) {
        return ++index;
    }

    getTableDocument() {
        if (this.documentType === 'receipt') {
            this.$.ajax.url = "/api/receipt-item";
            this.$.ajax.params = {
                'receipt_id': this.documentId,
            }
        } else if (this.documentType === 'order') {
            this.$.ajax.url = "/api/order-item";
            this.$.ajax.params = {
                'order_id': this.documentId,
            }
        }

        this.$.ajax.generateRequest();
    }

    changeInput(evt) {
        const row = evt.currentTarget.parentElement.parentElement;
        let price, qty;
        const index = evt.model.index;
        if (evt.currentTarget.name === 'qty') {
            qty = +evt.currentTarget.value;
            price = parseInt(this.items[index].price);
        }

        if (evt.currentTarget.name === 'price') {
            qty = parseInt(this.items[index].qty);
            price = +evt.currentTarget.value;
        }

        this.set('items.' + index + '.qty', qty);
        this.set('items.' + index + '.price', price);
        const sum = qty * price;
        this.set('items.' + index + '.sum', sum);

        this.calculateTotalDocument();
    }

    handleResponse() {
        if (this.response === null) return;

        if ('errorInfo' in this.response) {
            for (let key in this.response.errorInfo) {
                alert(this.response.errorInfo[key][0]);
                return;
            }
        }

        if (this.response.status && window.location.pathname.indexOf('/trade/receipts/create') != -1) {
            alert('Документ успешно сохранен!');
            window.location.href = '/trade/receipts/update?id=' + this.response.id;
        } else if (this.response.status && window.location.pathname.indexOf('/trade/orders/create') != -1) {
                alert('Документ успешно сохранен!');
                window.location.href = '/trade/orders/update?id=' + this.response.id;
        } else if (this.response.status ) {
            alert('Документ успешно сохранен!');
        } else {
            this.items = this.response;
            this.items.sort(function(a, b) {
                if (a.nameAndColor > b.nameAndColor) return 1;
                if (a.nameAndColor < b.nameAndColor) return -1;
            });
            for (let i = 0; i < this.items.length; i++) {
                this.items[i].sum = this.items[i].price * this.items[i].qty;
            }
        }
    }

    pressEnter(evt) {
        if (evt.keyCode == 13) {
            evt.target.blur();
        }
    }

    ready() {
        super.ready();
        this.getTableDocument();
    }

    saveDocument(evt) {
        evt.preventDefault();
        const documentTable = document.querySelector('document-table');


        const formData = new FormData(document.querySelector('#w0'));
        formData.append("documentTable", JSON.stringify(documentTable.items));

        if (documentTable.documentType === 'receipt') {
            formData.append('Receipt[id]', documentTable.documentId);
            documentTable.$.ajax.url = '/api/receipt/save';
        } else if (documentTable.documentType === 'order') {
            formData.append('Order[id]', documentTable.documentId);
            documentTable.$.ajax.url = '/api/order/save';
        }
        documentTable.$.ajax.body = formData;
        documentTable.$.ajax.params = {};
        documentTable.$.ajax.method = 'POST';
        documentTable.$.ajax.generateRequest();
    }
}

customElements.define('document-table', DocumentTable);