"use strict";(self.webpackChunkpos=self.webpackChunkpos||[]).push([[592],{3574:(u,i,s)=>{s.d(i,{c:()=>p});var r=s(529),n=s(4707),h=s(2340),o=s(4650);let p=(()=>{class e{constructor(t){this.http=t,this.url=h.N.apiUrl,this.httpOptions={headers:(new r.WM).set("Content-Type","application/json")},this._user=new n.t,this._refresh=new n.t}getProfile(){return this.http.get(this.url+"/my-profiles",this.httpOptions)}updateProfile(t){return this.http.post(this.url+"/my-profiles",t,this.httpOptions)}updatePassword(t){return this.http.post(this.url+"/my-profiles/change-password",t,this.httpOptions)}set user(t){this._user.next(t)}get user$(){return this._user.asObservable()}set token(t){this._refresh.next(t)}get token$(){return this._refresh.asObservable()}}return e.\u0275fac=function(t){return new(t||e)(o.LFG(r.eN))},e.\u0275prov=o.Yz7({token:e,factory:e.\u0275fac,providedIn:"root"}),e})()}}]);