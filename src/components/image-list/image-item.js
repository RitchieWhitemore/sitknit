import {PolymerElement, html} from "../../../node_modules/@polymer/polymer/polymer-element.js";
import '../../../node_modules/@polymer/polymer/lib/elements/dom-repeat.js';
import '../../../node_modules/@polymer/paper-toggle-button/paper-toggle-button.js';

//import '../../../node_modules/@polymer/iron-ajax/iron-ajax.js';

class ImageItem extends PolymerElement {
    static get template() {
        return html`
              <style>
            :host {
                margin-right: 25px;
                margin-bottom: 25px;
                padding: 15px;
                padding-bottom: 30px;
                position: relative;
                display: inline-block;
                width: 190px;
                border: 1px solid lightgrey;
                border-radius: 5px;
            }

            :host img {
                margin-bottom: 10px;
                width: 100%;
            }

            :host .remove {
                width: 25px;
                height: 25px;
                position: absolute;
                right: -10px;
                top: -10px;
                background: white;
                border: 1px solid #ededed;
                border-radius: 50%;
                padding: 0;
                margin: 0;
                display: flex;
                align-items: center;
                justify-content: center;
                cursor: pointer;
                box-shadow: 0 2px 2px 0 rgba(0, 0, 0, 0.14), 0 1px 5px 0 rgba(0, 0, 0, 0.12), 0 3px 1px -2px rgba(0, 0, 0, 0.2);
                outline: none;
                font-size: 0;
            }

            :host .remove::after,
            :host .remove::before {
                content: "";
                position: absolute;
                display: block;
                width: 10px;
                height: 2px;
                background: grey;
            }

            :host .remove::before {
                transform: rotate(45deg);
            }

            :host .remove::after {
                transform: rotate(-45deg);
            }

            :host .file-name {
                margin: 0;
                font-size: 12px;
                word-wrap: break-word;
                text-align: center;
            }
        </style>
      
        <img src="[[src]]">
        <button type="button" on-click="removeItem" class="remove" data-name="{{fileName}}">Удалить</button>
        <p class="file-name">{{fileName}}</p>
        <paper-toggle-button on-click="changeMain" id="toggleButton">Основная
        </paper-toggle-button>
       
        <iron-ajax id="ajax" url="/api/image/delete-image?id={{imageId}}">

        </iron-ajax>
        `;
    }

     static get properties() {
         return {
             index: Number,
             goodId: Number,
             fileName: String,
             src: String,
             imageId: Number,
             main: Number,
         }
     }

    constructor() {
        super();
    }

    ready() {
        super.ready();

        if (!this.src) {
            this.src = "/img/goods/" + this.goodId + "/" + this.fileName;

            if (this.main) {
                this.$.toggleButton.checked = true;
            }
        }
    }

    changeMain(event) {

        var formData = new FormData();
        if (event.currentTarget.checked) {
            formData.append("main", 1);
        } else {
            formData.append("main", 0);
        }


        var xhr = new XMLHttpRequest();

        xhr.open("POST", "/api/image/toggle-main?id=" + this.imageId);

        xhr.send(formData);
    }

    removeItem() {
        const imageList = document.querySelector('image-list');

        if (imageList) {
            if (this.parentNode.id == 'old-images') {
                if (confirm('Вы действительно хотите удалить эту картинку с сайта?')) {
                    this.$.ajax.method = 'DELETE';
                    this.$.ajax.generateRequest().completes.then(
                        (request) => {
                            this.parentNode.removeChild(this);
                        },
                        request => console.log('failure', request)
                    );
                }
            } else {
                imageList.removeNewItem(this.index);
                this.parentNode.removeChild(this);
            }
        }
    }
}

customElements
    .define(
        'image-item'
        ,
        ImageItem
    )
;