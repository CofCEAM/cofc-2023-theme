(()=>{"use strict";const e=window.wp.element,t=window.wp.blockEditor,a=(window.wp.data,window.wp.components),n=window.wp.blocks,l=JSON.parse('{"u2":"cofctheme/testimonial"}'),o=({attributes:t})=>(0,e.createElement)("div",{class:"wysiwyg  component"},(0,e.createElement)("div",{class:"wysiwyg__inner  user-markup"},(0,e.createElement)("div",{class:"quote component"},(0,e.createElement)("div",{class:"quote__wrapper"},(0,e.createElement)("div",{class:"quote__image"})),(0,e.createElement)("blockquote",{class:"quote__inner"},(0,e.createElement)("p",{class:"quote__copy"},t.quote),(0,e.createElement)("cite",{class:"quote__cite"},t.name," - ",function(e){const t=new Date(e);return`${["January","February","March","April","May","June","July","August","September","October","November","December"][t.getMonth()]} ${t.getDate()}, ${t.getFullYear()}`}(t.date))))));(0,n.registerBlockType)(l.u2,{title:"CofC Testimonial",edit:({attributes:n,setAttributes:l,isSelected:r})=>{const{quote:s,name:c,date:i}=n,m=(0,t.useBlockProps)({className:"custom-block "+(r?"is-selected":"")});return(0,e.createElement)("div",m,(0,e.createElement)(t.InspectorControls,null,(0,e.createElement)(a.PanelBody,{title:"Block Settings",initialOpen:!0},(0,e.createElement)(a.TextareaControl,{value:s,onChange:e=>{l({quote:e})},help:"What is the testimonial? Do not wrap the content in quotation marks.",label:"Testimonial"}),(0,e.createElement)(a.TextControl,{value:c,help:"Who said this? Provide a full name.",onChange:e=>{l({name:e})},label:"Name"}),(0,e.createElement)(a.DatePicker,{value:i,onChange:e=>{l({date:e})},label:"Date",help:"When did they say this?"}))),(0,e.createElement)("div",{className:"block-preview wp-block",style:{border:"1px solid black",margin:"0.3rem"}},(0,e.createElement)(o,{attributes:n})))},save:({attributes:t})=>(0,e.createElement)(o,{attributes:t})})})();