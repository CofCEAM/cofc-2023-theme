(()=>{"use strict";const e=window.wp.element,t=window.wp.blockEditor,l=window.wp.data,o=window.wp.components,a=window.wp.blocks,n=JSON.parse('{"u2":"cofctheme/post-grid"}');window.React,(0,a.registerBlockType)(n.u2,{title:"CofC Post Grid",edit:({attributes:a,setAttributes:n,isSelected:i})=>{const r=(0,l.useSelect)((e=>e("core").getEntityRecords("taxonomy","category",{per_page:-1})),[]),s=(0,l.useSelect)((e=>e("core").getEntityRecords("taxonomy","post_tag",{per_page:-1})),[]),{categories:c,tags:m,limit:d,offset:h,columns:p,useFullWidth:u,title:g,includeLink:C,linkUri:b,linkText:E,linkNewTab:k,displayExcerpt:w,displayPublishDate:y,displayAuthor:T}=a,x=(0,t.useBlockProps)({className:"custom-block "+(i?"is-selected":"")});return(0,e.createElement)("div",x,(0,e.createElement)(t.InspectorControls,null,(0,e.createElement)(o.PanelBody,{title:"Block Settings",initialOpen:!0},(0,e.createElement)(o.TextControl,{label:"Title",help:"What should the heading above this grid of posts say?",value:g,onChange:e=>{n({title:e})}}),(0,e.createElement)(o.ToggleControl,{label:"Full Screen Width",help:"Should each item in the grid take up the full width of the grid?",checked:u,onChange:e=>{n({useFullWidth:e})}}),(0,e.createElement)(o.ToggleControl,{label:"Display Post Excerpts?",checked:w,onChange:e=>{n({displayExcerpt:e})}}),(0,e.createElement)(o.ToggleControl,{label:"Display Post Publish Dates?",checked:y,onChange:e=>{n({displayPublishDate:e})}}),(0,e.createElement)(o.ToggleControl,{label:"Display Post Authors?",checked:T,onChange:e=>{n({displayAuthor:e})}}),(0,e.createElement)(o.ToggleControl,{label:"Include a link below the post grid to another page?",checked:C,onChange:e=>{n({includeLink:e})}}),C?(0,e.createElement)(e.Fragment,null,(0,e.createElement)(o.ToggleControl,{label:"Open in a New Tab?",checked:k,onChange:e=>{n({linkNewTab:e})}}),(0,e.createElement)(o.TextControl,{label:"Link Text",help:"What text should display for the link?",onChange:e=>{n({linkText:e})},value:E}),(0,e.createElement)(o.TextControl,{label:"Link URI",help:"Provide the URL to link to",onChange:e=>{n({linkUri:e})},type:"url",value:b})):"",(0,e.createElement)(o.SelectControl,{label:"Categories",multiple:!0,help:"Hold CTRL (or CMD) to select multiple categories",value:c,options:r?r.map((e=>({value:e.id,label:e.name}))):[],onChange:e=>{n({categories:e})},menuPlacement:"bottom",menuPosition:"fixed",style:{height:"200px"},filterOption:(e,t)=>e.label.toLowerCase().includes(t.toLowerCase()),isSearchable:!0}),(0,e.createElement)(o.SelectControl,{label:"Tags",multiple:!0,help:"Hold CTRL (or CMD) to select multiple tags",value:m,options:s?s.map((e=>({value:e.id,label:e.name}))):[],onChange:e=>{n({tags:e})},menuPlacement:"bottom",menuPosition:"fixed",style:{height:"200px"},filterOption:(e,t)=>e.label.toLowerCase().includes(t.toLowerCase()),isSearchable:!0}),(0,e.createElement)(o.RangeControl,{label:"Limit",value:d,min:0,max:10,onChange:e=>{n({limit:e})}}),(0,e.createElement)(o.RangeControl,{label:"Offset",value:h,min:0,max:10,onChange:e=>{n({offset:e})}}),(0,e.createElement)(o.RangeControl,{label:"Columns",value:p,min:1,max:4,onChange:e=>{n({columns:e})}}))),(0,e.createElement)("div",{className:"block-preview wp-block",style:{border:"1px solid black",margin:"0.3rem"}},(0,e.createElement)("div",null,(0,e.createElement)("code",null,'PREVIEW PAGE TO VIEW POST GRID "',g,'"'))))}})})();