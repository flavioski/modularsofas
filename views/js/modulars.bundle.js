window.modulars=function(e){function n(o){if(t[o])return t[o].exports;var r=t[o]={i:o,l:!1,exports:{}};return e[o].call(r.exports,r,r.exports,n),r.l=!0,r.exports}var t={};return n.m=e,n.c=t,n.i=function(e){return e},n.d=function(e,t,o){n.o(e,t)||Object.defineProperty(e,t,{configurable:!1,enumerable:!0,get:o})},n.n=function(e){var t=e&&e.__esModule?function(){return e.default}:function(){return e};return n.d(t,"a",t),t},n.o=function(e,n){return Object.prototype.hasOwnProperty.call(e,n)},n.p="",n(n.s=16)}([function(e,n,t){"use strict";function o(e){if(Array.isArray(e)){for(var n=0,t=Array(e.length);n<e.length;n++)t[n]=e[n];return t}return Array.from(e)}function r(e,n,t){var o=this,r=e.id,a=e.closable;this.modal=i(e),this.$modal=c(this.modal.container),this.show=function(){o.$modal.modal()},this.modal.confirmButton.addEventListener("click",n),this.$modal.modal({backdrop:!!a||"static",keyboard:void 0===a||a,closable:void 0===a||a,show:!1}),this.$modal.on("hidden.bs.modal",function(){document.querySelector("#"+r).remove(),t&&t()}),document.body.appendChild(this.modal.container)}function i(e){var n,t=e.id,r=void 0===t?"confirm-modal":t,i=e.confirmTitle,a=e.confirmMessage,c=void 0===a?"":a,u=e.closeButtonLabel,l=void 0===u?"Close":u,s=e.confirmButtonLabel,d=void 0===s?"Accept":s,f=e.confirmButtonClass,m=void 0===f?"btn-primary":f,v=e.customButtons,b=void 0===v?[]:v,h={};return h.container=document.createElement("div"),h.container.classList.add("modal","fade"),h.container.id=r,h.dialog=document.createElement("div"),h.dialog.classList.add("modal-dialog"),h.content=document.createElement("div"),h.content.classList.add("modal-content"),h.header=document.createElement("div"),h.header.classList.add("modal-header"),i&&(h.title=document.createElement("h4"),h.title.classList.add("modal-title"),h.title.innerHTML=i),h.closeIcon=document.createElement("button"),h.closeIcon.classList.add("close"),h.closeIcon.setAttribute("type","button"),h.closeIcon.dataset.dismiss="modal",h.closeIcon.innerHTML="×",h.body=document.createElement("div"),h.body.classList.add("modal-body","text-left","font-weight-normal"),h.message=document.createElement("p"),h.message.classList.add("confirm-message"),h.message.innerHTML=c,h.footer=document.createElement("div"),h.footer.classList.add("modal-footer"),h.closeButton=document.createElement("button"),h.closeButton.setAttribute("type","button"),h.closeButton.classList.add("btn","btn-outline-secondary","btn-lg"),h.closeButton.dataset.dismiss="modal",h.closeButton.innerHTML=l,h.confirmButton=document.createElement("button"),h.confirmButton.setAttribute("type","button"),h.confirmButton.classList.add("btn",m,"btn-lg","btn-confirm-submit"),h.confirmButton.dataset.dismiss="modal",h.confirmButton.innerHTML=d,i?h.header.append(h.title,h.closeIcon):h.header.appendChild(h.closeIcon),h.body.appendChild(h.message),(n=h.footer).append.apply(n,[h.closeButton].concat(o(b),[h.confirmButton])),h.content.append(h.header,h.body,h.footer),h.dialog.appendChild(h.content),h.container.appendChild(h.dialog),h}Object.defineProperty(n,"__esModule",{value:!0}),n.default=r;/**
 * Copyright since 2007 PrestaShop SA and Contributors
 * PrestaShop is an International Registered Trademark & Property of PrestaShop SA
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.md.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/OSL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to https://devdocs.prestashop.com/ for more information.
 *
 * @author    PrestaShop SA and Contributors <contact@prestashop.com>
 * @copyright Since 2007 PrestaShop SA and Contributors
 * @license   https://opensource.org/licenses/OSL-3.0 Open Software License (OSL 3.0)
 */
var a=window,c=a.$},,,function(e,n,t){"use strict";function o(e,n){if(!(e instanceof n))throw new TypeError("Cannot call a class as a function")}Object.defineProperty(n,"__esModule",{value:!0});var r=function(){function e(e,n){for(var t=0;t<n.length;t++){var o=n[t];o.enumerable=o.enumerable||!1,o.configurable=!0,"value"in o&&(o.writable=!0),Object.defineProperty(e,o.key,o)}}return function(n,t,o){return t&&e(n.prototype,t),o&&e(n,o),n}}(),i=t(0),a=function(e){return e&&e.__esModule?e:{default:e}}(i),c=window,u=c.$,l=function(){function e(){o(this,e)}return r(e,[{key:"extend",value:function(e){var n=this;e.getContainer().on("click",".js-submit-row-action",function(t){t.preventDefault();var o=u(t.currentTarget),r=o.data("confirmMessage"),i=o.data("title"),a=o.data("method");if(i)n.showConfirmModal(o,e,r,i,a);else{if(r.length&&!window.confirm(r))return;n.postForm(o,a)}})}},{key:"postForm",value:function(e,n){var t=["GET","POST"].includes(n),o=u("<form>",{action:e.data("url"),method:t?n:"POST"}).appendTo("body");t||o.append(u("<input>",{type:"_hidden",name:"_method",value:n})),o.submit()}},{key:"showConfirmModal",value:function(e,n,t,o,r){var i=this,c=e.data("confirmButtonLabel"),u=e.data("closeButtonLabel"),l=e.data("confirmButtonClass");new a.default({id:n.getId()+"-grid-confirm-modal",confirmTitle:o,confirmMessage:t,confirmButtonLabel:c,closeButtonLabel:u,confirmButtonClass:l},function(){return i.postForm(e,r)}).show()}}]),e}();n.default=l},function(e,n,t){"use strict";function o(e,n){if(!(e instanceof n))throw new TypeError("Cannot call a class as a function")}Object.defineProperty(n,"__esModule",{value:!0});var r=function(){function e(e,n){for(var t=0;t<n.length;t++){var o=n[t];o.enumerable=o.enumerable||!1,o.configurable=!0,"value"in o&&(o.writable=!0),Object.defineProperty(e,o.key,o)}}return function(n,t,o){return t&&e(n.prototype,t),o&&e(n,o),n}}(),i=window,a=i.$,c=function(){function e(){o(this,e)}return r(e,[{key:"extend",value:function(e){this.handleBulkActionCheckboxSelect(e),this.handleBulkActionSelectAllCheckbox(e)}},{key:"handleBulkActionSelectAllCheckbox",value:function(e){var n=this;e.getContainer().on("change",".js-bulk-action-select-all",function(t){var o=a(t.currentTarget),r=o.is(":checked");r?n.enableBulkActionsBtn(e):n.disableBulkActionsBtn(e),e.getContainer().find(".js-bulk-action-checkbox").prop("checked",r)})}},{key:"handleBulkActionCheckboxSelect",value:function(e){var n=this;e.getContainer().on("change",".js-bulk-action-checkbox",function(){e.getContainer().find(".js-bulk-action-checkbox:checked").length>0?n.enableBulkActionsBtn(e):n.disableBulkActionsBtn(e)})}},{key:"enableBulkActionsBtn",value:function(e){e.getContainer().find(".js-bulk-actions-btn").prop("disabled",!1)}},{key:"disableBulkActionsBtn",value:function(e){e.getContainer().find(".js-bulk-actions-btn").prop("disabled",!0)}}]),e}();n.default=c},function(e,n,t){"use strict";function o(e,n){if(!(e instanceof n))throw new TypeError("Cannot call a class as a function")}Object.defineProperty(n,"__esModule",{value:!0});var r=function(){function e(e,n){for(var t=0;t<n.length;t++){var o=n[t];o.enumerable=o.enumerable||!1,o.configurable=!0,"value"in o&&(o.writable=!0),Object.defineProperty(e,o.key,o)}}return function(n,t,o){return t&&e(n.prototype,t),o&&e(n,o),n}}(),i=window,a=i.$,c=function(){function e(){var n=this;return o(this,e),{extend:function(e){return n.extend(e)}}}return r(e,[{key:"extend",value:function(e){var n=this;e.getContainer().find(".js-grid-table").on("click",".ps-togglable-row",function(e){var t=a(e.currentTarget);t.hasClass("ps-switch")||e.preventDefault(),a.post({url:t.data("toggle-url")}).then(function(e){if(e.status)return window.showSuccessMessage(e.message),void n.toggleButtonDisplay(t);window.showErrorMessage(e.message)}).catch(function(e){var n=e.responseJSON;window.showErrorMessage(n.message)})})}},{key:"toggleButtonDisplay",value:function(e){var n=e.hasClass("grid-toggler-icon-valid"),t=n?"grid-toggler-icon-not-valid":"grid-toggler-icon-valid",o=n?"grid-toggler-icon-valid":"grid-toggler-icon-not-valid",r=n?"clear":"check";e.removeClass(o),e.addClass(t),e.hasClass("material-icons")&&e.text(r)}}]),e}();n.default=c},function(e,n,t){"use strict";function o(e,n){if(!(e instanceof n))throw new TypeError("Cannot call a class as a function")}Object.defineProperty(n,"__esModule",{value:!0});var r=function(){function e(e,n){for(var t=0;t<n.length;t++){var o=n[t];o.enumerable=o.enumerable||!1,o.configurable=!0,"value"in o&&(o.writable=!0),Object.defineProperty(e,o.key,o)}}return function(n,t,o){return t&&e(n.prototype,t),o&&e(n,o),n}}(),i=window,a=i.$,c=function(){function e(){o(this,e)}return r(e,[{key:"extend",value:function(e){var n=this;e.getHeaderContainer().on("click",".js-common_show_query-grid-action",function(){return n.onShowSqlQueryClick(e)}),e.getHeaderContainer().on("click",".js-common_export_sql_manager-grid-action",function(){return n.onExportSqlManagerClick(e)})}},{key:"onShowSqlQueryClick",value:function(e){var n=a("#"+e.getId()+"_common_show_query_modal_form");this.fillExportForm(n,e);var t=a("#"+e.getId()+"_grid_common_show_query_modal");t.modal("show"),t.on("click",".btn-sql-submit",function(){return n.submit()})}},{key:"onExportSqlManagerClick",value:function(e){var n=a("#"+e.getId()+"_common_show_query_modal_form");this.fillExportForm(n,e),n.submit()}},{key:"fillExportForm",value:function(e,n){var t=n.getContainer().find(".js-grid-table").data("query");e.find('textarea[name="sql"]').val(t),e.find('input[name="name"]').val(this.getNameFromBreadcrumb())}},{key:"getNameFromBreadcrumb",value:function(){var e=a(".header-toolbar").find(".breadcrumb-item"),n="";return e.each(function(e,t){var o=a(t),r=o.find("a").length>0?o.find("a").text():o.text();n.length>0&&(n=n.concat(" > ")),n=n.concat(r)}),n}}]),e}();n.default=c},function(e,n,t){"use strict";function o(e,n){if(!(e instanceof n))throw new TypeError("Cannot call a class as a function")}Object.defineProperty(n,"__esModule",{value:!0});var r=function(){function e(e,n){for(var t=0;t<n.length;t++){var o=n[t];o.enumerable=o.enumerable||!1,o.configurable=!0,"value"in o&&(o.writable=!0),Object.defineProperty(e,o.key,o)}}return function(n,t,o){return t&&e(n.prototype,t),o&&e(n,o),n}}(),i=t(17),a=function(e){return e&&e.__esModule?e:{default:e}}(i),c=window,u=c.$,l=function(){function e(){o(this,e)}return r(e,[{key:"extend",value:function(e){e.getContainer().on("click",".js-reset-search",function(e){(0,a.default)(u(e.currentTarget).data("url"),u(e.currentTarget).data("redirect"))})}}]),e}();n.default=l},function(e,n,t){"use strict";function o(e,n){if(!(e instanceof n))throw new TypeError("Cannot call a class as a function")}Object.defineProperty(n,"__esModule",{value:!0});var r=function(){function e(e,n){for(var t=0;t<n.length;t++){var o=n[t];o.enumerable=o.enumerable||!1,o.configurable=!0,"value"in o&&(o.writable=!0),Object.defineProperty(e,o.key,o)}}return function(n,t,o){return t&&e(n.prototype,t),o&&e(n,o),n}}(),i=window,a=i.$,c=function(){function e(){o(this,e)}return r(e,[{key:"extend",value:function(e){this.initRowLinks(e),this.initConfirmableActions(e)}},{key:"initConfirmableActions",value:function(e){e.getContainer().on("click",".js-link-row-action",function(e){var n=a(e.currentTarget).data("confirm-message");n.length&&!window.confirm(n)&&e.preventDefault()})}},{key:"initRowLinks",value:function(e){a("tr",e.getContainer()).each(function(){var e=a(this);a(".js-link-row-action[data-clickable-row=1]:first",e).each(function(){var n=a(this),t=n.closest("td"),o=a("td.clickable",e).not(t),r=!1;o.addClass("cursor-pointer").mousedown(function(){a(window).mousemove(function(){r=!0,a(window).unbind("mousemove")})}),o.mouseup(function(){var e=r;if(r=!1,a(window).unbind("mousemove"),!e){var t=n.data("confirm-message");t.length&&!window.confirm(t)||(document.location=n.attr("href"))}})})})}}]),e}();n.default=c},function(e,n,t){"use strict";function o(e,n){if(!(e instanceof n))throw new TypeError("Cannot call a class as a function")}Object.defineProperty(n,"__esModule",{value:!0});var r=function(){function e(e,n){for(var t=0;t<n.length;t++){var o=n[t];o.enumerable=o.enumerable||!1,o.configurable=!0,"value"in o&&(o.writable=!0),Object.defineProperty(e,o.key,o)}}return function(n,t,o){return t&&e(n.prototype,t),o&&e(n,o),n}}(),i=function(){function e(){o(this,e)}return r(e,[{key:"extend",value:function(e){e.getHeaderContainer().on("click",".js-common_refresh_list-grid-action",function(){window.location.reload()})}}]),e}();n.default=i},function(e,n,t){"use strict";function o(e,n){if(!(e instanceof n))throw new TypeError("Cannot call a class as a function")}Object.defineProperty(n,"__esModule",{value:!0});var r=function(){function e(e,n){for(var t=0;t<n.length;t++){var o=n[t];o.enumerable=o.enumerable||!1,o.configurable=!0,"value"in o&&(o.writable=!0),Object.defineProperty(e,o.key,o)}}return function(n,t,o){return t&&e(n.prototype,t),o&&e(n,o),n}}(),i=t(18),a=function(e){return e&&e.__esModule?e:{default:e}}(i),c=function(){function e(){o(this,e)}return r(e,[{key:"extend",value:function(e){var n=e.getContainer().find("table.table");new a.default(n).attach()}}]),e}();n.default=c},function(e,n,t){"use strict";function o(e,n){if(!(e instanceof n))throw new TypeError("Cannot call a class as a function")}Object.defineProperty(n,"__esModule",{value:!0});var r=function(){function e(e,n){for(var t=0;t<n.length;t++){var o=n[t];o.enumerable=o.enumerable||!1,o.configurable=!0,"value"in o&&(o.writable=!0),Object.defineProperty(e,o.key,o)}}return function(n,t,o){return t&&e(n.prototype,t),o&&e(n,o),n}}(),i=t(0),a=function(e){return e&&e.__esModule?e:{default:e}}(i),c=window,u=c.$,l=function(){function e(){var n=this;return o(this,e),{extend:function(e){return n.extend(e)}}}return r(e,[{key:"extend",value:function(e){var n=this;e.getContainer().on("click",".js-bulk-action-submit-btn",function(t){n.submit(t,e)})}},{key:"submit",value:function(e,n){var t=u(e.currentTarget),o=t.data("confirm-message"),r=t.data("confirmTitle");void 0!==o&&o.length>0?void 0!==r?this.showConfirmModal(t,n,o,r):window.confirm(o)&&this.postForm(t,n):this.postForm(t,n)}},{key:"showConfirmModal",value:function(e,n,t,o){var r=this,i=e.data("confirmButtonLabel"),c=e.data("closeButtonLabel"),u=e.data("confirmButtonClass");new a.default({id:n.getId()+"-grid-confirm-modal",confirmTitle:o,confirmMessage:t,confirmButtonLabel:i,closeButtonLabel:c,confirmButtonClass:u},function(){return r.postForm(e,n)}).show()}},{key:"postForm",value:function(e,n){var t=u("#"+n.getId()+"_filter_form");t.attr("action",e.data("form-url")),t.attr("method",e.data("form-method")),t.submit()}}]),e}();n.default=l},function(e,n,t){"use strict";function o(e,n){if(!(e instanceof n))throw new TypeError("Cannot call a class as a function")}Object.defineProperty(n,"__esModule",{value:!0});var r=function(){function e(e,n){for(var t=0;t<n.length;t++){var o=n[t];o.enumerable=o.enumerable||!1,o.configurable=!0,"value"in o&&(o.writable=!0),Object.defineProperty(e,o.key,o)}}return function(n,t,o){return t&&e(n.prototype,t),o&&e(n,o),n}}(),i=window,a=i.$,c=function(){function e(){var n=this;return o(this,e),{extend:function(e){return n.extend(e)}}}return r(e,[{key:"extend",value:function(e){var n=this;e.getHeaderContainer().on("click",".js-grid-action-submit-btn",function(t){n.handleSubmit(t,e)})}},{key:"handleSubmit",value:function(e,n){var t=a(e.currentTarget),o=t.data("confirm-message");if(!(void 0!==o&&o.length>0)||window.confirm(o)){var r=a("#"+n.getId()+"_filter_form");r.attr("action",t.data("url")),r.attr("method",t.data("method")),r.find('input[name="'+n.getId()+'[_token]"]').val(t.data("csrf")),r.submit()}}}]),e}();n.default=c},function(e,n,t){"use strict";function o(e,n){if(!(e instanceof n))throw new TypeError("Cannot call a class as a function")}Object.defineProperty(n,"__esModule",{value:!0});var r=function(){function e(e,n){for(var t=0;t<n.length;t++){var o=n[t];o.enumerable=o.enumerable||!1,o.configurable=!0,"value"in o&&(o.writable=!0),Object.defineProperty(e,o.key,o)}}return function(n,t,o){return t&&e(n.prototype,t),o&&e(n,o),n}}(),i=window,a=i.$,c=function(){function e(n){o(this,e),this.id=n,this.$container=a("#"+this.id+"_grid")}return r(e,[{key:"getId",value:function(){return this.id}},{key:"getContainer",value:function(){return this.$container}},{key:"getHeaderContainer",value:function(){return this.$container.closest(".js-grid-panel").find(".js-grid-header")}},{key:"addExtension",value:function(e){e.extend(this)}}]),e}();n.default=c},,,function(e,n,t){"use strict";Object.defineProperty(n,"__esModule",{value:!0});var o=t(13),r=t.n(o),i=t(9),a=t.n(i),c=t(5),u=t.n(c),l=t(6),s=t.n(l),d=t(7),f=t.n(d),m=t(10),v=t.n(m),b=t(8),h=t.n(b),g=t(12),w=t.n(g),p=t(11),y=t.n(p),k=t(4),_=t.n(k),C=t(3),B=t.n(C);(0,window.$)(function(){var e=new r.a("modular");e.addExtension(new a.a),e.addExtension(new u.a),e.addExtension(new s.a),e.addExtension(new f.a),e.addExtension(new v.a),e.addExtension(new h.a),e.addExtension(new w.a),e.addExtension(new y.a),e.addExtension(new _.a),e.addExtension(new B.a)})},function(e,n,t){"use strict";Object.defineProperty(n,"__esModule",{value:!0});/**
 * Copyright since 2007 PrestaShop SA and Contributors
 * PrestaShop is an International Registered Trademark & Property of PrestaShop SA
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.md.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/OSL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to https://devdocs.prestashop.com/ for more information.
 *
 * @author    PrestaShop SA and Contributors <contact@prestashop.com>
 * @copyright Since 2007 PrestaShop SA and Contributors
 * @license   https://opensource.org/licenses/OSL-3.0 Open Software License (OSL 3.0)
 */
var o=window,r=o.$,i=function(e,n){r.post(e).then(function(){return window.location.assign(n)})};n.default=i},function(e,n,t){"use strict";function o(e,n){if(!(e instanceof n))throw new TypeError("Cannot call a class as a function")}Object.defineProperty(n,"__esModule",{value:!0});var r=function(){function e(e,n){for(var t=0;t<n.length;t++){var o=n[t];o.enumerable=o.enumerable||!1,o.configurable=!0,"value"in o&&(o.writable=!0),Object.defineProperty(e,o.key,o)}}return function(n,t,o){return t&&e(n.prototype,t),o&&e(n,o),n}}(),i=window,a=i.$,c=function(){function e(n){o(this,e),this.selector=".ps-sortable-column",this.columns=a(n).find(this.selector)}return r(e,[{key:"attach",value:function(){var e=this;this.columns.on("click",function(n){var t=a(n.delegateTarget);e.sortByColumn(t,e.getToggledSortDirection(t))})}},{key:"sortBy",value:function(e,n){var t=this.columns.is('[data-sort-col-name="'+e+'"]');if(!t)throw new Error('Cannot sort by "'+e+'": invalid column');this.sortByColumn(t,n)}},{key:"sortByColumn",value:function(e,n){window.location=this.getUrl(e.data("sortColName"),"desc"===n?"desc":"asc",e.data("sortPrefix"))}},{key:"getToggledSortDirection",value:function(e){return"asc"===e.data("sortDirection")?"desc":"asc"}},{key:"getUrl",value:function(e,n,t){var o=new URL(window.location.href),r=o.searchParams;return t?(r.set(t+"[orderBy]",e),r.set(t+"[sortOrder]",n)):(r.set("orderBy",e),r.set("sortOrder",n)),o.toString()}}]),e}();n.default=c}]);
