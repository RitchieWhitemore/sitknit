import {PolymerElement, html} from '@polymer/polymer/polymer-element.js';
import '@polymer/paper-tabs/paper-tabs.js';
import '@polymer/paper-tabs/paper-tab.js';
import '@polymer/iron-pages/iron-pages.js';

class PageTabs extends PolymerElement {
    static get template() {
        return html`
      <style>
      
      </style>
      <slot></slot>
        `;
    }

    constructor() {
        super();
        const tabs = document.querySelector('.good-form paper-tabs');
        const ironPages = document.querySelector('.good-form iron-pages');
        tabs.addEventListener('click', function() {
            ironPages.selected = tabs.selected;
        });
    }
}

customElements.define('page-tabs', PageTabs);
