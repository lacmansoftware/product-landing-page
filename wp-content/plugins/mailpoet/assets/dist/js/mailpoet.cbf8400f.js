/*! For license information please see mailpoet.cbf8400f.js.LICENSE.txt */
"use strict";(self.webpackChunkMailPoet3=self.webpackChunkMailPoet3||[]).push([[740],{7463:function(e,t,i){i(57790);var n=i(65311),s=i.n(n);s()((e=>{e(document).on("click",".mailpoet-dismissible-notice .notice-dismiss",(function(){const t=e(this).closest(".mailpoet-dismissible-notice").data("notice");e.ajax(window.ajaxurl,{type:"POST",data:{action:"dismissed_notice_handler",type:t}})}))}));var a=s();a.fn.mailpoetSerializeObject=function(e){var t={},i={true:!0,false:!1,null:null};return a.each(this.serializeArray(),(function(n,s){var a=s.name,r=s.value,l=t,o=0,c=a.split("]["),u=c.length-1;if(/\[/.test(c[0])&&/\]$/.test(c[u])?(c[u]=c[u].replace(/\]$/,""),u=(c=c.shift().split("[").concat(c)).length-1):u=0,e&&(r&&!Number.isNaN(r)?r=+r:"undefined"===r?r=void 0:void 0!==i[r]&&(r=i[r])),u)for(;o<=u;o+=1)l[a=""===c[o]?l.length:c[o]]=o<u?l[a]||(c[o+1]&&isNaN(c[o+1])?{}:[]):r,l=l[a];else Array.isArray(t[a])?t[a].push(r):void 0!==t[a]?t[a]=[t[a],r]:t[a]=r})),t};var r=i(7295),l=i.n(r);s()((e=>{l().addValidator("scheduledAt",{requirementType:"string",validateString:(t,i)=>{const n=e('select[name="afterTimeType"],select#scheduling_time_interval').val();let s=!0;return"hours"===n&&43800<t&&(s=!1),"days"===n&&1825<t&&(s=!1),"weeks"===n&&260<t&&(s=!1),!!s||e.Deferred().reject(i)},messages:{en:"An email can only be scheduled up to 5 years in the future. Please choose a shorter period."}})}))},65311:function(e){e.exports=jQuery}},function(e){e.O(0,[351],(function(){return 7463,e(e.s=7463)})),e.O()}]);