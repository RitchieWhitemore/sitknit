import {PolymerElement, html} from "../../../node_modules/@polymer/polymer/polymer-element.js";
import {BaseChoiceForm} from "./base-choice-form.js";


class SelectedModal extends BaseChoiceForm {

    static get inputTemplate() {
        return html``;
    }

    static get inputQtyTemplate() {
        return html`
        <paper-dialog id="qtyModal">
            <h2>Укажите количество</h2>
            <input id="inputQty" type="number" autofocus on-keypress="pressEnter">
            <div class="buttons">
                <paper-button dialog-dismiss>Отмена</paper-button>
                <paper-button dialog-confirm on-click="pressOk">Ок</paper-button>
            </div>
        </paper-dialog>
        `
    }

    static get properties() {
        return {
            typePrice: String,
        }
    }

    constructor() {
        super();
        this.buttonName = 'Подбор';
    }

    ready() {
        super.ready();
    }

    pressEnter(evt) {
        if (evt.keyCode == 13) {
            this.calculateQty(evt.target.value);
            this.confirmQty();
        }
    }

    pressOk() {
        this.$.inputQty.value;
        this.calculateQty(this.$.inputQty.value);
        this.confirmQty();
    }

    calculateQty(qty) {
        this.itemObject.good_id = this.itemObject.id;
        this.itemObject.id = null;
        this.itemObject.qty = qty;
        if (this.itemObject.priceRetail) {
            this.itemObject.price = this.itemObject.priceRetail.price;
            this.itemObject.sum = qty * this.itemObject.price;
        } else if (this.itemObject.priceWholesale) {
            this.itemObject.price = this.itemObject.priceWholesale.price;
            this.itemObject.sum = qty * this.itemObject.price;
        } else {
            this.itemObject.price = 0;
            this.itemObject.sum = 0;
        }
        this.$.qtyModal.close();
        this.$.inputQty.value = '';
    }

    confirmQty() {
        const documentTable = this.parentElement;

        if (documentTable.items == null) {
            documentTable.items = [];
            documentTable.push('items', this.itemObject);
        } else {
            let index = this.findItem(documentTable.items, this.itemObject);
            if (index != null) {
                const qty = +this.itemObject.qty + parseInt(documentTable.items[index].qty);
                documentTable.set('items.'+index+'.qty', qty);
                const sum = qty * parseInt(documentTable.items[index].price);
                documentTable.set('items.'+index+'.sum', sum);
            } else {
                documentTable.push('items', this.itemObject);
            }
        }

        documentTable.calculateTotalDocument();
    }

    findItem(arr, item) {
        for (let i = 0; i < arr.length; i++) {
            if (arr[i].article === item.article) {
                return i;
            }
        }
        return null;
    }

}

customElements.define('selected-modal', SelectedModal);