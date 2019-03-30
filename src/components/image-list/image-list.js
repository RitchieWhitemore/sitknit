import {PolymerElement, html} from "../../../node_modules/@polymer/polymer/polymer-element.js";
import '../../../node_modules/@polymer/polymer/lib/elements/dom-repeat.js';
import '../../../node_modules/@polymer/iron-ajax/iron-ajax.js';
import '../upload-button/upload-button.js';
import './image-item.js';

class ImageList extends PolymerElement {
    static get template() {
        return html`
        <link rel="stylesheet" href="/css/style.css">
      <style>
      :host .hidden {
        display: none;
      }
      </style>
      <iron-ajax id="ajax"
                   auto
                   url="/api/goods/{{goodId}}?expand=images"
                   handle-as="json"
                   on-response="handleResponse"
                   last-response="{{response}}"
                   debounce-duration="300"></iron-ajax>
        <h2>Уже загруженые изображения</h2>
        <div id="old-images" class="list">

            <template is="dom-repeat" items="{{resp}}">
                <image-item good-id="{{item.good_id}}" index="{{index}}"
                            file-name="{{item.file_name}}" image-id="{{item.id}}" main="{{item.main}}">

                </image-item>
            </template>

        </div>
        <hr>
      <upload-button parent="[[getThis()]]"></upload-button>
      <div id="new-list" class="list">
            <template id="domRepeat" is="dom-repeat" items="{{images}}">
                <image-item good-id="{{item.good_id}}" src="{{item.src}}" index="{{index}}"
                            file-name="{{item.name}}">

                </image-item>
            </template>
        </div>
        <button id="buttonSave" type="submit" on-click="upload" class="btn btn-success hidden">Сохранить картинки</button>
        `;
    }

    static get properties() {
        return {
            goodId: Number,
            images: {value: [], type: Array},
            resp: Array,
        }
    }

    constructor() {
        super();
    }

     handleResponse(event, response) {
         this.resp = [];
         this.$.domRepeat.render();
         this.resp = event.detail.response.images;

     }

     getThis() {
        return this;
     }

    addItems(files) {

        const postLoad = function(item, event) {
            item.goodId = this.goodId;
            item.src = event.currentTarget.result;

            this.push('images', item);

            if (this.images.length > 0) {
                this.$.buttonSave.classList.remove('hidden');
            }

        };

        Array.from(files).forEach(function(item) {
            if (!this.searchInArray(this.images, item)) {
                const reader = new FileReader();
                reader.addEventListener('load', postLoad.bind(this, item));
                reader.readAsDataURL(item);
            }
        }.bind(this));

    }

    removeNewItem(index) {
        this.splice('images', index, 1);
        if (this.images.length == 0) {
            this.$.buttonSave.classList.add('hidden');
        }
    }

    searchInArray(arr, item) {
        for (let j = 0; j < arr.length; j++) {
            if (arr[j].name == item.name) {
                return true;
            }
        }
        return false;
    }

    upload(e) {
        e.preventDefault();

        if (this.images.length > 0) {
            this.images.forEach(function(item) {
                const formData = new FormData();
                formData.append("good_id", this.goodId);
                formData.append("Image[imageFile]", item);

                const xhr = new XMLHttpRequest();

                xhr.onloadend = function() {
                    this.images = [];
                    this.$.buttonSave.classList.add('hidden');

                    setTimeout(function() {
                        this.$.ajax.generateRequest();
                    }.bind(this), 1000);
                }.bind(this);

                xhr.open("POST", "/api/images");
                xhr.send(formData);

            }.bind(this))
        }
    }
}

customElements.define('image-list', ImageList);