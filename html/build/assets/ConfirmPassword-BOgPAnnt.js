import{C as n,j as l,o as d,g as t,b as e,a as r,u as a,m as p,f as u,n as f,h as c}from"./app-B4jHxjza.js";import{_ as w}from"./GuestLayout-ChU71dyC.js";import{_,a as b,b as g}from"./TextInput-LT2H-cuN.js";import{P as x}from"./PrimaryButton-CQuU8lNY.js";import"./ApplicationLogo-CzeJotCc.js";import"./_plugin-vue_export-helper-DlAUqK2U.js";const y={class:"mt-4 flex justify-end"},h={__name:"ConfirmPassword",setup(C){const s=n({password:""}),i=()=>{s.post(route("password.confirm"),{onFinish:()=>s.reset()})};return(P,o)=>(d(),l(w,null,{default:t(()=>[e(a(p),{title:"Confirm Password"}),o[2]||(o[2]=r("div",{class:"mb-4 text-sm text-gray-600"}," This is a secure area of the application. Please confirm your password before continuing. ",-1)),r("form",{onSubmit:u(i,["prevent"])},[r("div",null,[e(_,{for:"password",value:"Password"}),e(b,{id:"password",type:"password",class:"mt-1 block w-full",modelValue:a(s).password,"onUpdate:modelValue":o[0]||(o[0]=m=>a(s).password=m),required:"",autocomplete:"current-password",autofocus:""},null,8,["modelValue"]),e(g,{class:"mt-2",message:a(s).errors.password},null,8,["message"])]),r("div",y,[e(x,{class:f(["ms-4",{"opacity-25":a(s).processing}]),disabled:a(s).processing},{default:t(()=>o[1]||(o[1]=[c(" Confirm ")])),_:1},8,["class","disabled"])])],32)]),_:1}))}};export{h as default};
