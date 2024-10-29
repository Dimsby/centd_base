!function(e){var t={};function o(s){if(t[s])return t[s].exports;var r=t[s]={i:s,l:!1,exports:{}};return e[s].call(r.exports,r,r.exports,o),r.l=!0,r.exports}o.m=e,o.c=t,o.d=function(e,t,s){o.o(e,t)||Object.defineProperty(e,t,{enumerable:!0,get:s})},o.r=function(e){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},o.t=function(e,t){if(1&t&&(e=o(e)),8&t)return e;if(4&t&&"object"==typeof e&&e&&e.__esModule)return e;var s=Object.create(null);if(o.r(s),Object.defineProperty(s,"default",{enumerable:!0,value:e}),2&t&&"string"!=typeof e)for(var r in e)o.d(s,r,function(t){return e[t]}.bind(null,r));return s},o.n=function(e){var t=e&&e.__esModule?function(){return e.default}:function(){return e};return o.d(t,"a",t),t},o.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},o.p="/",o(o.s=48)}({2:function(e,t,o){"use strict";function s(e,t,o,s,r,a,i,n){var l,c="function"==typeof e?e.options:e;if(t&&(c.render=t,c.staticRenderFns=o,c._compiled=!0),s&&(c.functional=!0),a&&(c._scopeId="data-v-"+a),i?(l=function(e){(e=e||this.$vnode&&this.$vnode.ssrContext||this.parent&&this.parent.$vnode&&this.parent.$vnode.ssrContext)||"undefined"==typeof __VUE_SSR_CONTEXT__||(e=__VUE_SSR_CONTEXT__),r&&r.call(this,e),e&&e._registeredComponents&&e._registeredComponents.add(i)},c._ssrRegister=l):r&&(l=n?function(){r.call(this,this.$root.$options.shadowRoot)}:r),l)if(c.functional){c._injectStyles=l;var u=c.render;c.render=function(e,t){return l.call(t),u(e,t)}}else{var d=c.beforeCreate;c.beforeCreate=d?[].concat(d,l):[l]}return{exports:e,options:c}}o.d(t,"a",(function(){return s}))},48:function(e,t,o){e.exports=o(49)},49:function(e,t,o){Vue.component("person-name-source",o(58).default),window.mix={data:{success:!1,formerrors:[],found_date_type:document.getElementById("found_date_type").value,burial_date_type:document.getElementById("burial_date_type").value},methods:{onSubmit:function(){var e=this,t=document.getElementById("personForm"),o=new FormData(t);Object.keys(this.$refs.namesource.uploads).forEach((function(t){var s=e.$refs.namesource.uploads[t];Object.keys(s).forEach((function(e){o.append("sourceUploadFiles["+t+"][]",s[e])}))})),o.append("sourceDeletes",JSON.stringify(this.$refs.namesource.deletes)),o.append("source",JSON.stringify(this.$refs.namesource.rows)),axios.post(t.getAttribute("action"),o).then((function(t){e.formerrors=[],e.success=!0,t.data.success&&t.data.redirect&&location.replace(t.data.redirect)})).catch((function(t){e.formerrors=t.response.data.errors,e.success=!1})).finally((function(){e.isLoading=!1}))}},mounted:function(){}}},58:function(e,t,o){"use strict";o.r(t);var s={name:"nameSource",props:{rowsData:{type:Array,default:function(){return[]}},sourceTypes:{type:Array}},data:function(){return{selected:1,rows:[],uploads:{},deletes:[]}},methods:{addRow:function(){this.rows.push({})},addFile:function(e){this.rows[e].files||Vue.set(this.rows[e],"files",[]),this.rows[e].files.push({})},uploadFile:function(e,t,o){var s=e.target.files[0];return!!s&&(s.size>10485760?(e.preventDefault(),alert("Файл больше 10МБ"),!1):"image/jpeg"!==s.type&&"image/png"!==s.type&&"application/pdf"!==s.type?(e.preventDefault(),alert("Разрешены файлы с расширением jpeg, png или pdf"),!1):(this.uploads[t]||Vue.set(this.uploads,t,[]),e.target.disabled=!0,void this.uploads[t].push(s)))},removeFile:function(e,t,o){void 0!==o&&this.deletes.push(o),Vue.delete(this.rows[e].files,t),this.uploads[e]&&Vue.delete(this.uploads[e],t)},removeRow:function(e){Vue.delete(this.rows,e),this.uploads&&Vue.delete(this.uploads,e)}},mounted:function(){this.rows=this.rowsData}},r=o(2),a=Object(r.a)(s,(function(){var e=this,t=e.$createElement,o=e._self._c||t;return o("div",{attrs:{id:"name-sources"}},[e._l(e.rows,(function(t,s){return o("div",{key:t.id,staticClass:"card mb-3"},[o("input",{directives:[{name:"model",rawName:"v-model",value:t.id,expression:"row.id"}],attrs:{type:"hidden"},domProps:{value:t.id},on:{input:function(o){o.target.composing||e.$set(t,"id",o.target.value)}}}),e._v(" "),o("div",{staticClass:"card-body"},[o("div",{staticClass:"form-group form-row"},[o("label",{staticClass:"col-md-2 col-form-label text-md-right"},[e._v("Источник")]),e._v(" "),o("div",{staticClass:"col-md-5"},[o("select",{directives:[{name:"model",rawName:"v-model",value:t.type_id,expression:"row.type_id"}],staticClass:"form-control",on:{change:function(o){var s=Array.prototype.filter.call(o.target.options,(function(e){return e.selected})).map((function(e){return"_value"in e?e._value:e.value}));e.$set(t,"type_id",o.target.multiple?s:s[0])}}},e._l(e.sourceTypes,(function(t,s){return o("option",{domProps:{value:t.id,selected:0===s}},[e._v(e._s(t.name))])})),0)]),e._v(" "),o("div",{staticClass:"col-md-5"},[o("input",{staticClass:"btn btn-danger float-right",attrs:{type:"button",value:"X"},on:{click:function(t){return e.removeRow(s)}}})])]),e._v(" "),o("div",{staticClass:"form-group form-row"},[o("label",{staticClass:"col-md-2 col-form-label text-md-right"},[e._v("Сведения")]),e._v(" "),o("div",{staticClass:"col-md-10"},[o("textarea",{directives:[{name:"model",rawName:"v-model",value:t.description,expression:"row.description"}],staticClass:"form-control",attrs:{rows:"3"},domProps:{value:t.description},on:{input:function(o){o.target.composing||e.$set(t,"description",o.target.value)}}})])]),e._v(" "),o("div",{staticClass:"form-group form-row"},[o("label",{staticClass:"col-md-2 col-form-label text-md-right"},[e._v("Место хранения первоисточника")]),e._v(" "),o("div",{staticClass:"col-md-10"},[o("textarea",{directives:[{name:"model",rawName:"v-model",value:t.place,expression:"row.place"}],staticClass:"form-control",attrs:{type:"text",rows:"3"},domProps:{value:t.place},on:{input:function(o){o.target.composing||e.$set(t,"place",o.target.value)}}})])]),e._v(" "),o("div",{staticClass:"form-group form-row"},[o("label",{staticClass:"col-md-2  col-form-label text-right"},[e._v("Экспертиза")]),e._v(" "),o("div",{staticClass:"form-check form-check-inline"},[o("input",{directives:[{name:"model",rawName:"v-model",value:t.expertise,expression:"row.expertise"}],attrs:{type:"checkbox"},domProps:{checked:Array.isArray(t.expertise)?e._i(t.expertise,null)>-1:t.expertise},on:{change:function(o){var s=t.expertise,r=o.target,a=!!r.checked;if(Array.isArray(s)){var i=e._i(s,null);r.checked?i<0&&e.$set(t,"expertise",s.concat([null])):i>-1&&e.$set(t,"expertise",s.slice(0,i).concat(s.slice(i+1)))}else e.$set(t,"expertise",a)}}})])]),e._v(" "),t.expertise?o("div",[o("div",{staticClass:"form-group form-row"},[o("label",{staticClass:"col-md-2 col-form-label text-md-right"},[e._v("Дата")]),e._v(" "),o("div",{staticClass:"col-auto"},[o("input",{directives:[{name:"model",rawName:"v-model",value:t.expertise_date,expression:"row.expertise_date"}],staticClass:"form-control",attrs:{type:"date"},domProps:{value:t.expertise_date},on:{input:function(o){o.target.composing||e.$set(t,"expertise_date",o.target.value)}}})])]),e._v(" "),o("div",{staticClass:"form-group form-row"},[o("label",{staticClass:"col-md-2 col-form-label text-md-right"},[e._v("Учреждение")]),e._v(" "),o("div",{staticClass:"col-md-10"},[o("input",{directives:[{name:"model",rawName:"v-model",value:t.expertise_object,expression:"row.expertise_object"}],staticClass:"form-control",attrs:{type:"text"},domProps:{value:t.expertise_object},on:{input:function(o){o.target.composing||e.$set(t,"expertise_object",o.target.value)}}})])]),e._v(" "),o("div",{staticClass:"form-group form-row"},[o("label",{staticClass:"col-md-2 col-form-label text-md-right"},[e._v("Эксперт")]),e._v(" "),o("div",{staticClass:"col-md-10"},[o("input",{directives:[{name:"model",rawName:"v-model",value:t.expertise_person,expression:"row.expertise_person"}],staticClass:"form-control",attrs:{type:"text"},domProps:{value:t.expertise_person},on:{input:function(o){o.target.composing||e.$set(t,"expertise_person",o.target.value)}}})])])]):e._e(),e._v(" "),e._l(t.files,(function(t,r){return o("div",{key:t.id,staticClass:"form-group form-row"},[o("label",{staticClass:"col-md-2 col-form-label text-md-right"},[e._v("#"+e._s(r+1))]),e._v(" "),t.filename?o("div",{staticClass:"col-md-6"},[o("a",{attrs:{href:"/base/public/files/uploads/"+t.filename,target:"_blank"}},["pdf"==t.ext?[e._v("\n                                [pdf]\n                            ")]:[o("img",{attrs:{src:"/base/public/files/uploads/"+t.filename,height:"50px"}})]],2)]):o("div",{staticClass:"col-md-6"},[o("input",{staticClass:"form-control",attrs:{type:"file"},on:{change:function(t){return e.uploadFile(t,s)}}})]),e._v(" "),o("div",{staticClass:"col-auto"},[o("input",{staticClass:"btn btn-danger",attrs:{type:"button",value:"X"},on:{click:function(o){return e.removeFile(s,r,t.id)}}})])])})),e._v(" "),o("input",{staticClass:"btn btn-primary ",attrs:{type:"button",value:"Добавить Файл"},on:{click:function(t){return e.addFile(s)}}})],2)])})),e._v(" "),o("input",{staticClass:"btn btn-primary",attrs:{type:"button",value:"Добавить"},on:{click:e.addRow}})],2)}),[],!1,null,null,null);t.default=a.exports}});