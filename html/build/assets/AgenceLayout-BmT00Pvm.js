import{x as v,k,i as $,c as p,o as n,a as e,b as g,g as o,u as r,P as t,n as l,j as u,d as i,t as f,h as d,p as y}from"./app-DMTjTVQZ.js";import{V as B}from"./VisitorBreadcrumbs-D33gSTMY.js";import{_ as A}from"./_plugin-vue_export-helper-DlAUqK2U.js";const V={class:"agence-layout"},C={class:"agence-header"},D={class:"header-content"},N={class:"header-left"},S={class:"container"},w={class:"sidebar-nav"},E={class:"user-info"},L={key:0,class:"user-name"},P={class:"agence-main"},T={class:"agence-footer"},j={__name:"AgenceLayout",setup(z){const m=v(),b=k(()=>m.props.breadcrumbs||[]),c=$(!1),h=()=>{c.value=!c.value};return(s,a)=>(n(),p("div",V,[e("header",C,[e("div",D,[e("div",N,[g(r(t),{href:s.route("home"),class:"logo-link"},{default:o(()=>a[0]||(a[0]=[e("img",{src:"/logo.svg",alt:"Logo de l'Agence",class:"agence-logo"},null,-1)])),_:1},8,["href"]),a[1]||(a[1]=e("span",{class:"agence-brand"},"Espace Agence",-1))]),a[3]||(a[3]=e("div",{class:"header-right"},null,-1)),e("div",{class:l(["hamburger-icon",{open:c.value}]),onClick:h},a[2]||(a[2]=[e("span",{class:"line line1"},null,-1),e("span",{class:"line line2"},null,-1),e("span",{class:"line line3"},null,-1)]),2)])]),e("div",S,[e("aside",{class:l(["agence-sidebar",{"sidebar-open":c.value}])},[e("nav",w,[e("div",E,[a[4]||(a[4]=e("span",{class:"user-icon"},"👤",-1)),s.$page.props.auth.agence?(n(),p("span",L,f(s.$page.props.auth.agence.raison_sociale),1)):i("",!0)]),s.$page.props.auth.agence?(n(),u(r(t),{key:0,href:s.route("agence.dashboard"),class:l(["sidebar-item",{active:s.$page.url===s.route().current("agence.dashboard")}])},{default:o(()=>a[5]||(a[5]=[e("i",{class:"fas fa-chart-line sidebar-icon"},null,-1),d(" Dashboard ")])),_:1},8,["href","class"])):i("",!0),s.$page.props.auth.agence?(n(),u(r(t),{key:1,href:s.route("agence.biens.index"),class:l(["sidebar-item",{active:s.$page.url.startsWith(s.route("agence.biens.index"))}])},{default:o(()=>a[6]||(a[6]=[e("i",{class:"fas fa-home sidebar-icon"},null,-1),d(" Biens ")])),_:1},8,["href","class"])):i("",!0),s.$page.props.auth.agence?(n(),u(r(t),{key:2,href:s.route("agence.mon-compte"),class:l(["sidebar-item",{active:s.$page.url===s.route().current("agence.mon-compte")}])},{default:o(()=>a[7]||(a[7]=[e("i",{class:"fas fa-user-cog sidebar-icon"},null,-1),d(" Mon Profil ")])),_:1},8,["href","class"])):i("",!0),s.$page.props.auth.agence?(n(),u(r(t),{key:3,href:s.route("agence.chat.index"),class:l(["sidebar-item",{active:s.$page.url===s.route().current("agence.chat.index")}])},{default:o(()=>a[8]||(a[8]=[e("i",{class:"fas fa-comments sidebar-icon"},null,-1),d(" Chat ")])),_:1},8,["href","class"])):i("",!0),s.$page.props.auth.agence?(n(),u(r(t),{key:4,href:s.route("agence.deconnexion"),method:"post",as:"button",class:"dropdown-item"},{default:o(()=>a[9]||(a[9]=[e("i",{class:"fas fa-user-cog logout-button"},null,-1),d(" Déconnexion ")])),_:1},8,["href"])):i("",!0)])],2),e("main",P,[g(B,{breadcrumbs:b.value},null,8,["breadcrumbs"]),y(s.$slots,"default",{},void 0,!0)])]),e("footer",T,[e("p",null,"© "+f(new Date().getFullYear())+" Espace Agence. Tous droits réservés.",1)])]))}},O=A(j,[["__scopeId","data-v-3b1848c1"]]);export{O as A};
