import { PolymerElement, html } from "../../../node_modules/@polymer/polymer/polymer-element.js";
import "../../../node_modules/@polymer/paper-tabs/paper-tabs.js";
import "../../../node_modules/@polymer/paper-tabs/paper-tab.js";
import "../../../node_modules/@polymer/iron-pages/iron-pages.js";

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
