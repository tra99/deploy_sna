"use strict";(self.webpackChunkpos=self.webpackChunkpos||[]).push([[147],{7147:(x,y,o)=>{o.r(y),o.d(y,{AuthModule:()=>Y});var s=o(9132),w=o(4466),m=o(364),v=o(6895),B=o(363),t=o(4650);let S=(()=>{class a{}return a.\u0275fac=function(e){return new(e||a)},a.\u0275mod=t.oAB({type:a}),a.\u0275inj=t.cJS({imports:[v.ez,B.q]}),a})();var c=o(4006),T=o(8951),D=o(3574),Z=o(1059),F=o(4859),b=o(9549),L=o(7392),M=o(4144),O=o(1572);function U(a,r){1&a&&(t.TgZ(0,"mat-error",17),t._uU(1," \u179f\u17bc\u1798\u1794\u1789\u17d2\u1785\u17bc\u179b\u179b\u17c1\u1781\u1791\u17bc\u179a\u179f\u17d0\u1796\u17d2\u1791 "),t.qZA())}function P(a,r){1&a&&t._UZ(0,"mat-icon",24),2&a&&t.Q6J("svgIcon","heroicons_solid:eye-off")}function J(a,r){1&a&&t._UZ(0,"mat-icon",24),2&a&&t.Q6J("svgIcon","heroicons_solid:eye")}function j(a,r){1&a&&(t.TgZ(0,"span",25),t._uU(1," \u1785\u17bc\u179b\u1794\u17d2\u179a\u1796\u17d0\u1793\u17d2\u1792"),t.qZA())}function E(a,r){1&a&&t._UZ(0,"mat-progress-spinner",26),2&a&&t.Q6J("diameter",24)("mode","indeterminate")}const N=[{path:"login",component:(()=>{class a{constructor(e,l,i,u,g){this._authService=e,this._myProfielService=l,this._formBuilder=i,this._router=u,this._snackBar=g,this.isShowAlert=!1,this.isLoading=!1}ngOnInit(){this.logInForm=this._formBuilder.group({username:["087544835",[c.kI.required]],password:["123456",c.kI.required]})}login(){this.isLoading=!0,this._authService.login(this.logInForm.value).subscribe(e=>{e.user&&(localStorage.setItem("user",JSON.stringify({id:e.user.id,name:e.user.name,avatar:e.user.avatar,phone:e.user.phone,email:e.user.email})),localStorage.setItem("role",e.role)),this._router.navigateByUrl("/dashboard")},e=>{this.isLoading=!1,this._snackBar.openSnackBar("Username or Password is not correct.","error")})}}return a.\u0275fac=function(e){return new(e||a)(t.Y36(T.e),t.Y36(D.c),t.Y36(c.QS),t.Y36(s.F0),t.Y36(Z.o))},a.\u0275cmp=t.Xpm({type:a,selectors:[["app-login"]],decls:36,vars:9,consts:[[1,"flex","items-start","sm:items-center","mx-auto","min-w-full","overflow-y-hidden"],[1,"background","w-full","md:w-2/12","md:min-w-100"],[1,"max-w-120","md:max-w-90","min-h-full","m-auto","p-2","pt-18","sm:h-full","rounded-3xl"],[1,"flex","flex-col","justify-center","items-center"],["src","assets/images/logo/pos-none-text.png","alt","image",1,"flex","min-w-24","max-w-24","mb-4","justify-center","items-center"],[1,"text-4xl","text-blue-800","font-bold","text-center"],[1,"text-2xl","text-blue-700","font-bold","text-center"],[1,"text-3xl","text-black","justify-start","items-start","mt-14"],[1,"mt-8","custom-form",3,"formGroup"],["appearance","outline",1,"w-full","mb-6"],["id","username","matInput","",3,"formControlName"],["matSuffix","","svgIcon","mat_outline:smartphone",1,"mr-2"],["class","min-h-6 mt-2.5 text-sm",4,"ngIf"],["id","password","matInput","","type","password",3,"formControlName"],["passwordField",""],["mat-icon-button","","type","button","matSuffix","",1,"-top-0.5",3,"click"],["class","icon-size-5",3,"svgIcon",4,"ngIf"],[1,"min-h-6","mt-2.5","text-sm"],["mat-flat-button","",1,"w-full","mt-6","py-6","rounded-md","custom-button",3,"disabled","click"],["class","text-lg",4,"ngIf"],[3,"diameter","mode",4,"ngIf"],[1,"relative","hidden","md:flex","flex-auto","w-10/12","h-full","overflow-hidde","justify-center","items-center","bg-slate-50"],["src","assets/images/backgrounds/POS-image3D.png","alt","image",1,"image","min-h-[400px]","h-[400px]","w-[600px]","min-w-[600px]"],[1,"z-10","w-full","custom-position"],[1,"icon-size-5",3,"svgIcon"],[1,"text-lg"],[3,"diameter","mode"]],template:function(e,l){if(1&e){const i=t.EpF();t.TgZ(0,"div",0)(1,"div",1)(2,"div",2)(3,"div",3),t._UZ(4,"img",4),t.TgZ(5,"p",5),t._uU(6,"\u1794\u17d2\u179a\u1796\u17d0\u1793\u17d2\u1792\u1782\u17d2\u179a\u1794\u17cb\u1782\u17d2\u179a\u1784\u1780\u17b6\u179a\u179b\u1780\u17cb"),t.qZA(),t.TgZ(7,"p",6),t._uU(8,"POS Management System"),t.qZA(),t.TgZ(9,"p",6),t._uU(10,"HIEK LYMONYRATANAK"),t.qZA(),t.TgZ(11,"p",7),t._uU(12,"\u1785\u17bc\u179b\u1782\u178e\u1793\u17b8\u179a\u1794\u179f\u17cb\u17a2\u17d2\u1793\u1780"),t.qZA()(),t.TgZ(13,"form",8)(14,"mat-form-field",9)(15,"mat-label"),t._uU(16,"\u179b\u17c1\u1781\u1791\u17bc\u179a\u179f\u17d0\u1796\u17d2\u1791"),t.qZA(),t._UZ(17,"input",10)(18,"mat-icon",11),t.YNc(19,U,2,0,"mat-error",12),t.qZA(),t.TgZ(20,"mat-form-field",9)(21,"mat-label"),t._uU(22,"\u179b\u17c1\u1781\u179f\u1798\u17d2\u1784\u17b6\u178f\u17cb"),t.qZA(),t._UZ(23,"input",13,14),t.TgZ(25,"button",15),t.NdJ("click",function(){t.CHM(i);const g=t.MAs(24);return t.KtG(g.type="password"===g.type?"text":"password")}),t.YNc(26,P,1,1,"mat-icon",16),t.YNc(27,J,1,1,"mat-icon",16),t.qZA(),t.TgZ(28,"mat-error",17),t._uU(29," \u179f\u17bc\u1798\u1794\u1789\u17d2\u1785\u17bc\u179b\u179b\u17c1\u1781\u179f\u1798\u17d2\u1784\u17b6\u178f\u17cb "),t.qZA()(),t.TgZ(30,"button",18),t.NdJ("click",function(){return l.login()}),t.YNc(31,j,2,0,"span",19),t.YNc(32,E,1,2,"mat-progress-spinner",20),t.qZA()()()(),t.TgZ(33,"div",21),t._UZ(34,"img",22)(35,"div",23),t.qZA()()}if(2&e){const i=t.MAs(24);t.xp6(13),t.Q6J("formGroup",l.logInForm),t.xp6(4),t.Q6J("formControlName","username"),t.xp6(2),t.Q6J("ngIf",l.logInForm.get("username").hasError("required")),t.xp6(4),t.Q6J("formControlName","password"),t.xp6(3),t.Q6J("ngIf","password"===i.type),t.xp6(1),t.Q6J("ngIf","text"===i.type),t.xp6(3),t.Q6J("disabled",l.logInForm.invalid||l.isLoading),t.xp6(1),t.Q6J("ngIf",!l.isLoading),t.xp6(1),t.Q6J("ngIf",l.isLoading)}},dependencies:[v.O5,c._Y,c.Fj,c.JJ,c.JL,c.sg,c.u,F.lW,b.TO,b.KE,b.hX,b.R9,L.Hw,M.Nt,O.Ou],styles:[".background[_ngcontent-%COMP%]{justify-content:start;align-items:start;height:100vh;background-image:url(art_login.fd878c814c525cfc.png);background-repeat:no-repeat;background-size:contain;background-position:top center}.image[_ngcontent-%COMP%]{width:100%;height:100%;object-fit:cover}.custom-position[_ngcontent-%COMP%]{position:absolute;top:0;left:0;padding-top:6rem;padding-left:3rem}.custom-position[_ngcontent-%COMP%]   p[_ngcontent-%COMP%]{font-size:2em;color:#fff;text-shadow:4px 4px 5px white}.background-custom[_ngcontent-%COMP%]{height:100vh}"],data:{animation:m.F}}),a})()}];let Y=(()=>{class a{}return a.\u0275fac=function(e){return new(e||a)},a.\u0275mod=t.oAB({type:a}),a.\u0275inj=t.cJS({imports:[s.Bz.forChild(N),w.m,S]}),a})()},1059:(x,y,o)=>{o.d(y,{o:()=>m});var s=o(4650),w=o(7009);let m=(()=>{class n{constructor(p){this.snackbar=p}openSnackBar(p,h){this.snackbar.open(p,"","error"===h?{horizontalPosition:"right",verticalPosition:"bottom",duration:3e3,panelClass:["black-snackbar"]}:{horizontalPosition:"right",verticalPosition:"bottom",duration:3e3,panelClass:["green-snackbar"]})}}return n.\u0275fac=function(p){return new(p||n)(s.LFG(w.ux))},n.\u0275prov=s.Yz7({token:n,factory:n.\u0275fac,providedIn:"root"}),n})()}}]);