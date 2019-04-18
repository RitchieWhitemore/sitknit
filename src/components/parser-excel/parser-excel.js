import {PolymerElement, html} from "../../../node_modules/@polymer/polymer/polymer-element.js";
import '../../../node_modules/@polymer/iron-ajax/iron-ajax.js';
import '../../../node_modules/@polymer/paper-spinner/paper-spinner.js';

class ParserExcel extends PolymerElement {
    static get template() {
        return html`
      <style>
        :host .messages {
            padding: 10px;
            height: 100px;
            border: 1px solid grey;
            overflow: scroll;
        }
        
        :host paper-spinner {
            position: absolute;
            top: 50%;
            left: 50%;
            width: 100px;
            height: 100px;
        }
      </style>
      <slot></slot>
      <div id="messages" class="messages">

    </div>
    <paper-spinner id="spinner"></paper-spinner>
      <iron-ajax id="ajax"
                   url="/api/price/set-price"
                   method="POST"
                   handle-as="json"
                   on-response="handleResponse"
                   last-response="{{response}}"
                ></iron-ajax>
        `;
    }

    static get properties() {
        return {
            sessionStep: {type: Number, value: 0},
            csv: Object,
        }
    }

    constructor() {
        super();
        const button = this.querySelector('#buttonSuccess');
        button.addEventListener('click', this.onParse.bind(this));

        const fileInput = this.querySelector('#setpriceajaxform-file_input_price');
        fileInput.addEventListener('change', this.addFile);
    }

    handleResponse() {
        const p = document.createElement('p');

        if (this.response.count != 'Прайс загружен') {
            this.sessionStep = +this.response.count;
            this.buildString();
            p.innerHTML = 'Загружено ' + this.response.count + ' записей';
        } else {
            p.innerHTML = this.response.count;
            this.$.spinner.active = false;
        }
        this.$.messages.insertBefore(p, this.$.messages.firstChild);
    }

    onParse(e) {
        e.preventDefault();

        const percent = this.querySelector('#setpriceajaxform-percent_change');
        const inputFile = this.querySelector('#setpriceajaxform-file_input_price');

        if (percent.value == '') {
            alert('Установите процент наценки');
            return;
        }

        if (inputFile.value == '') {
            alert('Выберите прайс-лист');
            return;
        }

        const fileInput = this.querySelector('#setpriceajaxform-file_input_price').files[0];

        this.buildString();

        const p = document.createElement('p');
        p.innerHTML = 'Загрузка началась c ' + this.sessionStep + ' элемента';
        this.$.messages.insertBefore(p, this.$.messages.firstChild);

        this.$.spinner.active = true;

    }

    buildString() {
        const form = this.querySelector('#w0');
        const formData = new FormData(form);
        //const beginStep = step;
        const endStep = +this.sessionStep + 1000;

        this.pack = [];
        const data = this.csv.data;


        for (let i = this.sessionStep; i < endStep; i++) {
            if (i == 0) continue;
            if (data.length > this.sessionStep) {
                if (data[i] != undefined && data[i].length > 1) {
                    const arrayToString = data[i].join('|');
                    this.pack.push(arrayToString);
                }

            }
        }

        formData.append('SetPriceAjaxForm[stringPackCsv]', this.pack.join(';'));
        formData.append('SetPriceAjaxForm[beginStep]', this.sessionStep);
        this.$.ajax.body = formData;

        this.$.ajax.generateRequest()
    }


    addFile(e) {
        const fileInput = e.target.files[0];
        const reader = new FileReader();

        reader.addEventListener('load', function(e) {
            const parserExcel = document.querySelector('parser-excel');
            const result = e.target.result;
            Papa.parse(result, {
                delimiter: ';',
                complete: function(results) {
                    parserExcel.csv = results;
            }
            });
        });
        reader.readAsText(fileInput, 'CP1251');
    }
}

customElements.define('parser-excel', ParserExcel);