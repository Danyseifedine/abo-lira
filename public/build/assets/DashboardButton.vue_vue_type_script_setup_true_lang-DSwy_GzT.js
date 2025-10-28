import{_ as C}from"./index-DqoYVAWA.js";import{c as o}from"./createLucideIcon-2Wjojt7r.js";import{d as M,a1 as z,E as n,f as h,o as a,u as I,x as p,w as L,c as s,F as d,e as i,p as f,t as k,r as m}from"./app-BhBziGTL.js";/**
 * @license lucide-vue-next v0.468.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const D=o("CircleDotIcon",[["circle",{cx:"12",cy:"12",r:"10",key:"1mglay"}],["circle",{cx:"12",cy:"12",r:"1",key:"41hilf"}]]);/**
 * @license lucide-vue-next v0.468.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const B=o("CogIcon",[["path",{d:"M12 20a8 8 0 1 0 0-16 8 8 0 0 0 0 16Z",key:"sobvz5"}],["path",{d:"M12 14a2 2 0 1 0 0-4 2 2 0 0 0 0 4Z",key:"11i496"}],["path",{d:"M12 2v2",key:"tus03m"}],["path",{d:"M12 22v-2",key:"1osdcq"}],["path",{d:"m17 20.66-1-1.73",key:"eq3orb"}],["path",{d:"M11 10.27 7 3.34",key:"16pf9h"}],["path",{d:"m20.66 17-1.73-1",key:"sg0v6f"}],["path",{d:"m3.34 7 1.73 1",key:"1ulond"}],["path",{d:"M14 12h8",key:"4f43i9"}],["path",{d:"M2 12h2",key:"1t8f8n"}],["path",{d:"m20.66 7-1.73 1",key:"1ow05n"}],["path",{d:"m3.34 17 1.73-1",key:"nuk764"}],["path",{d:"m17 3.34-1 1.73",key:"2wel8s"}],["path",{d:"m11 13.73-4 6.93",key:"794ttg"}]]);/**
 * @license lucide-vue-next v0.468.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const q=o("Disc3Icon",[["circle",{cx:"12",cy:"12",r:"10",key:"1mglay"}],["path",{d:"M6 12c0-1.7.7-3.2 1.8-4.2",key:"oqkarx"}],["circle",{cx:"12",cy:"12",r:"2",key:"1c9p78"}],["path",{d:"M18 12c0 1.7-.7 3.2-1.8 4.2",key:"1eah9h"}]]);/**
 * @license lucide-vue-next v0.468.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const y=o("LoaderCircleIcon",[["path",{d:"M21 12a9 9 0 1 1-6.219-8.56",key:"13zald"}]]);/**
 * @license lucide-vue-next v0.468.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const R=o("RefreshCwIcon",[["path",{d:"M3 12a9 9 0 0 1 9-9 9.75 9.75 0 0 1 6.74 2.74L21 8",key:"v9h5vc"}],["path",{d:"M21 3v5h-5",key:"1q7to0"}],["path",{d:"M21 12a9 9 0 0 1-9 9 9.75 9.75 0 0 1-6.74-2.74L3 16",key:"3uifl3"}],["path",{d:"M8 16H3v5",key:"1cv678"}]]);/**
 * @license lucide-vue-next v0.468.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const T=o("RotateCwIcon",[["path",{d:"M21 12a9 9 0 1 1-9-9c2.52 0 4.93 1 6.74 2.74L21 8",key:"1p45f6"}],["path",{d:"M21 3v5h-5",key:"1q7to0"}]]),S={key:1},$={key:0},Z=M({__name:"DashboardButton",props:{variant:{default:"default"},size:{default:"default"},loading:{type:Boolean,default:!1},loadingText:{default:void 0},loadingPosition:{default:"after"},loadingIcon:{default:"circle"},class:{default:""},disabled:{type:Boolean,default:!1},type:{default:"button"}},setup(v){const t=v,c=z(),b=n(()=>t.disabled||t.loading),r=n(()=>{var u,g;if(t.loadingText)return t.loadingText;const e=(u=c.default)==null?void 0:u.call(c);return(g=e==null?void 0:e[0])!=null&&g.children&&e[0].children.trim()||null}),l=n(()=>{switch(t.loadingIcon){case"circle":return y;case"spinner":return y;case"rotate":return T;case"refresh":return R;case"gear":return B;case"dot":return D;case"disc":return q;case"none":return null;default:return y}}),w=n(()=>{switch(t.variant){case"success":return"bg-green-600 hover:bg-green-700 text-white border-green-600 hover:border-green-700";case"warning":return"bg-orange-500 hover:bg-orange-600 text-white border-orange-500 hover:border-orange-600";case"gradient":return"bg-gradient-to-r from-primary to-primary/80 hover:from-primary/90 hover:to-primary/70 text-primary-foreground border-0 shadow-lg hover:shadow-xl";case"glass":return"bg-black/5 backdrop-blur-md border border-black/10 hover:bg-black/10 text-foreground shadow-lg hover:shadow-xl dark:bg-white/10 dark:border-white/20 dark:hover:bg-white/20";default:return""}}),x=n(()=>{switch(t.size){case"xs":return"h-7 px-2 py-1 text-xs [&]:h-7 [&]:px-2 [&]:py-1 [&]:text-xs";case"xl":return"h-12 px-10 py-3 text-base font-medium [&]:h-12 [&]:px-10 [&]:py-3 [&]:text-base";default:return""}});return(e,u)=>(a(),h(I(C),{variant:["success","warning","gradient","glass"].includes(e.variant)?"default":e.variant,size:["xs","xl"].includes(e.size)?"default":e.size,type:e.type,disabled:b.value,class:p(["relative transition-all duration-200 disabled:cursor-not-allowed",w.value,x.value,t.class])},{default:L(()=>[e.loading?(a(),s(d,{key:0},[e.loadingPosition==="before"?(a(),s(d,{key:0},[l.value?(a(),h(f(l.value),{key:0,class:p(["animate-spin",r.value?"mr-2":"",e.size==="xs"?"h-3 w-3":e.size==="xl"?"h-5 w-5":"h-4 w-4"])},null,8,["class"])):i("",!0),r.value?(a(),s("span",S,k(r.value),1)):i("",!0)],64)):(a(),s(d,{key:1},[r.value?(a(),s("span",$,k(r.value),1)):i("",!0),l.value?(a(),h(f(l.value),{key:1,class:p(["animate-spin",r.value?"ml-2":"",e.size==="xs"?"h-3 w-3":e.size==="xl"?"h-5 w-5":"h-4 w-4"])},null,8,["class"])):i("",!0)],64))],64)):(a(),s(d,{key:1},[m(e.$slots,"icon"),m(e.$slots,"default")],64))]),_:3},8,["variant","size","type","disabled","class"]))}});export{y as L,Z as _};
