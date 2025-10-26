import{a as h,f as b}from"./index-Dod-eeLU.js";import{B as x,i as s,c as m,o as u,d as v,E as g,f as y,u as z,x as $}from"./app-CABCWAMP.js";import{_ as w}from"./_plugin-vue_export-helper-DlAUqK2U.js";var k=`
    .p-textarea {
        font-family: inherit;
        font-feature-settings: inherit;
        font-size: 1rem;
        color: dt('textarea.color');
        background: dt('textarea.background');
        padding-block: dt('textarea.padding.y');
        padding-inline: dt('textarea.padding.x');
        border: 1px solid dt('textarea.border.color');
        transition:
            background dt('textarea.transition.duration'),
            color dt('textarea.transition.duration'),
            border-color dt('textarea.transition.duration'),
            outline-color dt('textarea.transition.duration'),
            box-shadow dt('textarea.transition.duration');
        appearance: none;
        border-radius: dt('textarea.border.radius');
        outline-color: transparent;
        box-shadow: dt('textarea.shadow');
    }

    .p-textarea:enabled:hover {
        border-color: dt('textarea.hover.border.color');
    }

    .p-textarea:enabled:focus {
        border-color: dt('textarea.focus.border.color');
        box-shadow: dt('textarea.focus.ring.shadow');
        outline: dt('textarea.focus.ring.width') dt('textarea.focus.ring.style') dt('textarea.focus.ring.color');
        outline-offset: dt('textarea.focus.ring.offset');
    }

    .p-textarea.p-invalid {
        border-color: dt('textarea.invalid.border.color');
    }

    .p-textarea.p-variant-filled {
        background: dt('textarea.filled.background');
    }

    .p-textarea.p-variant-filled:enabled:hover {
        background: dt('textarea.filled.hover.background');
    }

    .p-textarea.p-variant-filled:enabled:focus {
        background: dt('textarea.filled.focus.background');
    }

    .p-textarea:disabled {
        opacity: 1;
        background: dt('textarea.disabled.background');
        color: dt('textarea.disabled.color');
    }

    .p-textarea::placeholder {
        color: dt('textarea.placeholder.color');
    }

    .p-textarea.p-invalid::placeholder {
        color: dt('textarea.invalid.placeholder.color');
    }

    .p-textarea-fluid {
        width: 100%;
    }

    .p-textarea-resizable {
        overflow: hidden;
        resize: none;
    }

    .p-textarea-sm {
        font-size: dt('textarea.sm.font.size');
        padding-block: dt('textarea.sm.padding.y');
        padding-inline: dt('textarea.sm.padding.x');
    }

    .p-textarea-lg {
        font-size: dt('textarea.lg.font.size');
        padding-block: dt('textarea.lg.padding.y');
        padding-inline: dt('textarea.lg.padding.x');
    }
`,B={root:function(t){var r=t.instance,n=t.props;return["p-textarea p-component",{"p-filled":r.$filled,"p-textarea-resizable ":n.autoResize,"p-textarea-sm p-inputfield-sm":n.size==="small","p-textarea-lg p-inputfield-lg":n.size==="large","p-invalid":r.$invalid,"p-variant-filled":r.$variant==="filled","p-textarea-fluid":r.$fluid}]}},P=x.extend({name:"textarea",style:k,classes:B}),R={name:"BaseTextarea",extends:h,props:{autoResize:Boolean},style:P,provide:function(){return{$pcTextarea:this,$parentInstance:this}}};function i(e){"@babel/helpers - typeof";return i=typeof Symbol=="function"&&typeof Symbol.iterator=="symbol"?function(t){return typeof t}:function(t){return t&&typeof Symbol=="function"&&t.constructor===Symbol&&t!==Symbol.prototype?"symbol":typeof t},i(e)}function I(e,t,r){return(t=S(t))in e?Object.defineProperty(e,t,{value:r,enumerable:!0,configurable:!0,writable:!0}):e[t]=r,e}function S(e){var t=T(e,"string");return i(t)=="symbol"?t:t+""}function T(e,t){if(i(e)!="object"||!e)return e;var r=e[Symbol.toPrimitive];if(r!==void 0){var n=r.call(e,t);if(i(n)!="object")return n;throw new TypeError("@@toPrimitive must return a primitive value.")}return(t==="string"?String:Number)(e)}var f={name:"Textarea",extends:R,inheritAttrs:!1,observer:null,mounted:function(){var t=this;this.autoResize&&(this.observer=new ResizeObserver(function(){requestAnimationFrame(function(){t.resize()})}),this.observer.observe(this.$el))},updated:function(){this.autoResize&&this.resize()},beforeUnmount:function(){this.observer&&this.observer.disconnect()},methods:{resize:function(){this.$el.offsetParent&&(this.$el.style.height="auto",this.$el.style.height=this.$el.scrollHeight+"px",parseFloat(this.$el.style.height)>=parseFloat(this.$el.style.maxHeight)?(this.$el.style.overflowY="scroll",this.$el.style.height=this.$el.style.maxHeight):this.$el.style.overflow="hidden")},onInput:function(t){this.autoResize&&this.resize(),this.writeValue(t.target.value,t)}},computed:{attrs:function(){return s(this.ptmi("root",{context:{filled:this.$filled,disabled:this.disabled}}),this.formField)},dataP:function(){return b(I({invalid:this.$invalid,fluid:this.$fluid,filled:this.$variant==="filled"},this.size,this.size))}}},F=["value","name","disabled","aria-invalid","data-p"];function q(e,t,r,n,l,o){return u(),m("textarea",s({class:e.cx("root"),value:e.d_value,name:e.name,disabled:e.disabled,"aria-invalid":e.invalid||void 0,"data-p":o.dataP,onInput:t[0]||(t[0]=function(){return o.onInput&&o.onInput.apply(o,arguments)})},o.attrs),null,16,F)}f.render=q;const V=v({__name:"DashboardTextarea",props:{modelValue:{default:""},placeholder:{default:""},error:{default:null},disabled:{type:Boolean,default:!1},required:{type:Boolean,default:!1},autofocus:{type:Boolean,default:!1},id:{default:void 0},rows:{default:3},autoResize:{type:Boolean,default:!1},fluid:{type:Boolean,default:!0},class:{default:""}},emits:["update:modelValue","blur","focus"],setup(e,{emit:t}){const r=e,n=t,l=g(()=>{const a=[r.class];return r.error&&a.push("invalid-textarea"),a.push("textarea-no-border"),a.join(" ")}),o=a=>{const d=a.target;n("update:modelValue",d.value)},p=a=>{n("blur",a)},c=a=>{n("focus",a)};return(a,d)=>(u(),y(z(f),{id:a.id,"model-value":a.modelValue,placeholder:a.placeholder,disabled:a.disabled,required:a.required,autofocus:a.autofocus,rows:a.rows,autoResize:a.autoResize,fluid:a.fluid,class:$(l.value),onInput:o,onBlur:p,onFocus:c},null,8,["id","model-value","placeholder","disabled","required","autofocus","rows","autoResize","fluid","class"]))}}),D=w(V,[["__scopeId","data-v-b22880af"]]);export{D};
