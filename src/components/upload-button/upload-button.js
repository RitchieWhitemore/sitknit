import {PolymerElement, html} from '../../../node_modules/@polymer/polymer/polymer-element.js';


class UploadButton extends PolymerElement {
    static get template() {
        return html`
            <link rel="stylesheet" href="/css/style.css">
          <style>
            :host {
                    margin-bottom: 40px;
                    display: inline-block;
                    position: relative;
                    box-sizing: border-box;
            }
    
            :host input {
                    position: absolute;
                    top: 0;
                    left: 0;
                    width: 100%;
                    height: 100%;
                    z-index: 1;
                    opacity: 0;
                    cursor: pointer;
                }
          </style>
          <button type="button" id="add-image" class="btn">Добавить</button>
          <input type="file" name="Image[imageFile]" on-change="addImage" accept=".jpg, .jpeg, .png" multiple>
        `;
    }

    constructor() {
        super();
    }

    addImage(e) {
        const imageList = document.querySelector('image-list');

        if (imageList) {
            const fileList = e.target.files;

            imageList.addItems(fileList);
        }
    }

    searchInArray(arr, item) {
        for (let j = 0; j < arr.length; j++) {
            if (arr[j].name === item.name) {
                return false;
            }
        }
        return true;
    }
}

customElements.define('upload-button', UploadButton);