(()=>{"use strict";const e=window.wp.element,t=window.wp.blockEditor,a=window.wp.components,l=window.wp.blocks,n=JSON.parse('{"u2":"cofctheme/media-carousel"}'),i=({attributes:t})=>{console.log(t);const{title:a,description:l,mediaItems:n,includeLink:i,linkUri:c,linkText:r,linkNewTab:o}=t;return(0,e.createElement)("section",{className:"media  media--wide media--gallery component js-has-carousel"},(0,e.createElement)("div",{className:"media__container"},(0,e.createElement)("div",{className:"media__header"},(0,e.createElement)("h2",{className:"media__title font-h2"},a)),(0,e.createElement)("div",{className:"media__wrapper"},(0,e.createElement)("div",{id:"media_items",className:"media__items"},n.length>0?n.map((t=>{if(console.log(t),"video"===t.type){const a=`https://img.youtube.com/vi/${(e=>{let t="";const a=e.match(/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|[^#]*[?&]v=|youtu\.be\/|embed\/?|\/v\/|\/e\/|watch\?v=|[^#]*[?&]v=))([a-zA-Z0-9_-]{11})/);return a&&a[1]&&(t=a[1]),t})(t.url)}/hqdefault.jpg`;return(0,e.createElement)("figure",{"data-itemid":t.id,className:"media__imagery media__imagery--with-video"},(0,e.createElement)("img",{src:a,alt:t.title,className:"media__image",width:"836",height:"627"}),(0,e.createElement)("a",{href:t.url,className:"btn btn--xlarge btn--round play-button"},(0,e.createElement)("span",{className:"btn__icon"},(0,e.createElement)("svg",{className:"brei-icon brei-icon-play",focusable:"false"},(0,e.createElement)("use",{href:"#brei-icon-play"}))),(0,e.createElement)("span",{className:"show-for-sr"},"Play video")),(0,e.createElement)("figcaption",null,t.caption))}if("image"===t.type)return(0,e.createElement)("figure",{"data-itemid":t.id,className:"media__imagery"},(0,e.createElement)("img",{src:t.url,alt:t.alt,className:"media__image",width:"836",height:"627"}),(0,e.createElement)("figcaption",null,t.caption))})):""),(0,e.createElement)("div",{className:"media__controls","data-id":"media_controls"},(0,e.createElement)("div",{"data-id":"next"},(0,e.createElement)("a",{href:"#","aria-label":"See Next",className:"btn btn--medium"},(0,e.createElement)("span",{className:"btn__icon"},(0,e.createElement)("svg",{className:"brei-icon brei-icon-chevron",focusable:"false"},(0,e.createElement)("use",{href:"#brei-icon-chevron"}))))),(0,e.createElement)("div",{className:"media-amount"}),(0,e.createElement)("div",{"data-id":"prev"},(0,e.createElement)("a",{href:"#","aria-label":"See Next",className:"btn btn--medium"},(0,e.createElement)("span",{className:"btn__icon"},(0,e.createElement)("svg",{className:"brei-icon brei-icon-chevron",focusable:"false"},(0,e.createElement)("use",{href:"#brei-icon-chevron"})))))),(0,e.createElement)("div",{className:"media__caption font-caption","aria-hidden":"true"})),(0,e.createElement)("div",{id:"media_footer",className:"media__footer"},(0,e.createElement)("div",{className:"media__controls","data-id":"media_controls_sm"},(0,e.createElement)("div",{"data-id":"prev"},(0,e.createElement)("a",{href:"#","aria-label":"See Next",className:"btn btn--medium"},(0,e.createElement)("span",{className:"btn__icon"},(0,e.createElement)("svg",{className:"brei-icon brei-icon-chevron",focusable:"false"},(0,e.createElement)("use",{href:"#brei-icon-chevron"}))))),(0,e.createElement)("div",{className:"media-amount"}),(0,e.createElement)("div",{"data-id":"next"},(0,e.createElement)("a",{href:"#","aria-label":"See Next",className:"btn btn--medium"},(0,e.createElement)("span",{className:"btn__icon"},(0,e.createElement)("svg",{className:"brei-icon brei-icon-chevron",focusable:"false"},(0,e.createElement)("use",{href:"#brei-icon-chevron"})))))),l&&(0,e.createElement)("p",{className:"media__copy font-body-lite"},l),i?(0,e.createElement)("a",{href:c,className:"btn btn-tertiary btn-tertiary-left"},(0,e.createElement)("span",{className:"text"},r||"View More"),(0,e.createElement)("span",{className:"text-arrow"},(0,e.createElement)("svg",{className:"brei-icon brei-icon-arrows",focusable:"false"},(0,e.createElement)("use",{href:"#brei-icon-arrows"})),(0,e.createElement)("svg",{className:"brei-icon brei-icon-arrows-arrow",focusable:"false"},(0,e.createElement)("use",{href:"#brei-icon-arrows-arrow"})))):"")))},c=window.React;(0,l.registerBlockType)(n.u2,{title:"CofC Media Carousel",edit:({attributes:l,setAttributes:n,isSelected:r})=>{const[o,s]=(0,c.useState)(!1),[m,d]=(0,c.useState)(""),[u,E]=(0,c.useState)([]),[b,h]=(0,c.useState)(""),[p,v]=(0,c.useState)(""),[g,N]=(0,c.useState)(""),[f,_]=(0,c.useState)(""),{title:k,description:y,mediaItems:w,includeLink:C,linkUri:T,linkText:x,linkNewTab:S}=l;(0,c.useEffect)((()=>{if(w.length>0){const e=w.filter((e=>e.id===b));if(e.length>0){const t=e[0];console.log("video match!"),console.log(t),_(t.caption),N(t.title),v(t.url)}}}),[b]);const I=()=>{s(!1),d("")},B=e=>{const t=[...w];t.splice(e,1),n({mediaItems:t})},V=(0,t.useBlockProps)({className:"custom-block "+(r?"is-selected":"")});return(0,e.createElement)("div",V,(0,e.createElement)(t.InspectorControls,null,(0,e.createElement)(a.PanelBody,{title:"Block Settings",initialOpen:!0},(0,e.createElement)("p",null,"Your carousel can include both images and videos. Videos must be stored on YouTube to be used in the carousel."),(0,e.createElement)(a.TextControl,{label:"Title",help:"What should the heading above the carousel say?",value:k,onChange:e=>{n({title:e})}}),(0,e.createElement)(a.TextareaControl,{label:"Description",help:"What should the description below the carousel say?",value:y,onChange:e=>{n({description:e})}}),(0,e.createElement)(a.ToggleControl,{label:"Include a link below the carousel to another page?",checked:C,onChange:e=>{n({includeLink:e})}}),C?(0,e.createElement)(e.Fragment,null,(0,e.createElement)(a.ToggleControl,{label:"Open in a New Tab?",checked:S,onChange:e=>{n({linkNewTab:e})}}),(0,e.createElement)(a.TextControl,{label:"Link Text",help:"What text should display for the link?",onChange:e=>{n({linkText:e})},value:x}),(0,e.createElement)(a.TextControl,{label:"Link URI",help:"Provide the URL to link to",onChange:e=>{n({linkUri:e})},type:"url",value:T})):"",w.length>0?(0,e.createElement)("div",{class:"carousel-preview"},(0,e.createElement)("h3",null,"Carousel Items:"),(0,e.createElement)("hr",null),w.map(((t,l)=>(0,e.createElement)("div",{key:l,"data-itemid":t.id},"image"===t.type&&(0,e.createElement)("div",null,(0,e.createElement)("img",{src:t.url,alt:"Selected Image"}),(0,e.createElement)(a.Button,{onClick:()=>B(l)},(0,e.createElement)(a.Dashicon,{icon:"trash"}),"Remove Image")),"video"===t.type&&(0,e.createElement)("div",null,(0,e.createElement)("video",{id:`video-${t.id}`,src:t.url,controls:!0}),(0,e.createElement)(a.Button,{onClick:()=>B(l)},(0,e.createElement)(a.Dashicon,{icon:"trash"}),"Remove Video")))))):(0,e.createElement)("p",null,"No items in carousel."),(0,e.createElement)("div",{style:{textAlign:"center"}},(0,e.createElement)(a.Button,{className:"components-button is-primary",style:{margin:".5rem"},onClick:()=>{s(!0)}},"Add Item to Carousel"),(0,e.createElement)(t.MediaUploadCheck,null,o&&(0,e.createElement)("div",{className:"media-dialog"},(0,e.createElement)("h3",null,"Select Media Type"),(0,e.createElement)(a.Button,{onClick:()=>d("image")},"Image"),(0,e.createElement)(a.Button,{onClick:()=>d("video")},"Video"),"image"===m&&(0,e.createElement)(t.MediaUpload,{onSelect:e=>{n({mediaItems:[...w,...e]}),I()},allowedTypes:["image"],multiple:!0,gallery:!1,value:null,render:({open:t})=>(0,e.createElement)("div",{style:{margin:"0.5rem",display:"block"}},(0,e.createElement)("br",null),(0,e.createElement)(a.Button,{className:"components-button is-primary",onClick:t},(0,e.createElement)(a.Dashicon,{icon:"format-image"}),"Select Image"))}),(0,e.createElement)(a.Button,{onClick:I},"Cancel"))),"video"===m&&(0,e.createElement)("div",{className:"video-fields",style:{display:"block",margin:"1rem"}},(0,e.createElement)(a.TextControl,{type:"url",label:"Video Link",placeholder:"Enter YouTube Video link",value:p,onChange:e=>{v(e)}}),(0,e.createElement)(a.TextareaControl,{label:"Video Caption",value:f,onChange:e=>{_(e)}}),(0,e.createElement)(a.TextControl,{label:"Video Title",value:g,onChange:e=>{N(e)}}),(0,e.createElement)(a.Button,{className:"components-button is-primary",onClick:()=>((e,t,a)=>{const l=Math.floor(1e4*Math.random()),i={id:l,url:e,type:"video",caption:t||"",title:a||""};n({mediaItems:[...w,i]}),h(l),I()})(p,f,g)},"Add Video"))))),(0,e.createElement)("div",{className:"block-preview wp-block",style:{border:"1px solid black",margin:"0.3rem"}},(0,e.createElement)(i,{attributes:l})))},save:({attributes:t})=>(0,e.createElement)(i,{attributes:t})})})();