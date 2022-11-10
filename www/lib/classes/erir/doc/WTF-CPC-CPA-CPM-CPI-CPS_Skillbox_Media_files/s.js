try {
    var R=[
        // I
        [{
          id: 219,
          idS: '219',
          s: function(cb){ld('https://dmp.sbermarketing.ru/?dmpkit_cid=9064fc6c-76fe-4a6d-aea6-92ef3f343257&dmpkit_evid=a6647x1rw09v5nypdh4lka0hhhahhm1e&user_adr='+encodeURIComponent(cid), cb)},
          t: 24
        },{
          id: 19,
          idS: '19_2',
          s: function(cb){ld('https://an.yandex.ru/mapuid/adriveris/' + encodeURIComponent(cid), cb)},
          t: 0.01,
          bl: 1
        },{
          id: 207,
          idS: '207',
          s: function(cb){ld('https://cm.g.doubleclick.net/pixel?google_nid=adriver_adh&google_hm=' + uid, cb)},
          t: 24,
          bl: 1
        },{
          id: 16,
          idS: '20',
          s: function(cb){ld('//adriver-sync.rutarget.ru/sync', cb)},
          t: 24,
          bl: 1
         },{
          id: 33,
          idS: '33',
          c: cid && cookiestate == 0,
          s: function(cb){ld('https://ad.adriver.ru/cgi-bin/rle.cgi?sid=1&ad=608223&bt=21&pid=3136519&bid=7007242&bn=7007242&rnd='+rnd, cb)},
          t: 24,
          bl: 1
        }],
        // II
        [{
          id: 1,
          idS: '10',
          s: function(cb){
            function base64(str) {
              var b64chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefg'+'hijklmnopqrstuvwxyz0123456789+/=';
              var b64encoded = '';
              var chr1, chr2, chr3;
              var enc1, enc2, enc3, enc4;
              for (var i=0; i<str.length;) {
                chr1 = str.charCodeAt(i++);
                chr2 = str.charCodeAt(i++);
                chr3 = str.charCodeAt(i++);
                enc1 = chr1 >> 2;
                enc2 = ((chr1 & 3) << 4) | (chr2 >> 4);
                enc3 = isNaN(chr2) ? 64:(((chr2 & 15) << 2) | (chr3 >> 6));
                enc4 = isNaN(chr3) ? 64:(chr3 & 63);
                b64encoded += b64chars.charAt(enc1) + b64chars.charAt(enc2) + b64chars.charAt(enc3) + b64chars.charAt(enc4);
              }
              return encodeURIComponent(b64encoded);
            };
            ld('https://cm.g.doubleclick.net/pixel?google_nid=ADR&google_hm='+base64(cid), cb)
          },
          t: 24,
          bl: 1
        },{
          id: 36,
          idS: '19_1',
          s: function(cb){ld('//ssp.adriver.ru/cgi-bin/sync.cgi?dsp_id=109', cb)},
          t: 24,
          bl: 1
        },{
          id: 4,
          idS: '3',
          c: cid && cookiestate == 0,
          s: function(cb){ld('//ads.betweendigital.com/match?bidder_id=3&external_user_id='+encodeURIComponent(cid)+'&callback_url=%2F%2Fssp.adriver.ru%2Fcgi-bin%2Fsync.cgi%3Fssp_id%3D3%26external_id%3D%24%7BUSER_ID%7D', cb)},
          t: 24
        },{
          id: 5,
          idS: '100',
          s: function(cb){ld('//dm.hybrid.ai/match?id=20', cb)},
          t: 24
        },{
          id: 6,
          idS: '20316',
          s: function(cb){ld('//x01.aidata.io/0.gif?pid=ADRIVER&id='+encodeURIComponent(cid), cb)},
          t: 24
        },{
          id: 7,
          idS: '117',
          s: function(cb){ld('//dmg.digitaltarget.ru/1/123/i/i?a=123&e='+encodeURIComponent(cid)+'&i='+rnd, cb)},
          t: 24
        },{
          id: 10,
          idS: '5_2',
          s: function(cb){ld('https://redirect.frontend.weborama.fr/rd?url=https%3A%2F%2Fssp.adriver.ru%2Fcgi-bin%2Fsync.cgi%3Fdsp_id%3D20323%26external_id%3D%7BWEBO_CID%7D', cb)},        
          t: 24
        },{
          id: 11,
          idS: '5',
          s: function(cb){ld('https://profile.ssp.rambler.ru/sync2.302?pid=89&anket_id='+encodeURIComponent(cid), cb)},
          t: 24
        },{
          id: 17,
          idS: '112',
          s: function(cb){ld('//px.adhigh.net/p/cm/adriver?u='+encodeURIComponent(cid), cb)},
          t: 24
        },{
          id: 18,
          idS: '135',
          s: function(cb){ld('https://sync.1dmp.io/pixel.gif?cid=7287fde7-f83f-4ff9-ace2-07c8fef0a289&pid=w&uid='+encodeURIComponent(cid), cb)},
          t: 24
        },{
          id: 20,
          idS: '7_1',
          s: function(cb){ld('//ad.adriver.ru/cgi-bin/rle.cgi?sid=1&ad=608223&bt=21&pid=2527627&bid=4950956&bn=4950956&rnd='+rnd, cb)},
          t: 24
        },{
          id: 66,
          idS: '66',
          s: function(cb){ld('//inv-nets.admixer.net/adxcm.aspx?ssp=AA391812-3D60-4352-AC90-6449D7D09A7A&rurl=https%3A%2F%2Fssp.adriver.ru%2Fcgi-bin%2Fsync.cgi%3Fssp_id%3D66%26external_id%3D%24%24visitor_cookie%24%24', cb)},
          t: 24
        },{
          id: 68,
          idS: '5_3',
          s: function(cb){ld('https://redirect.frontend.weborama.fr/rd?url=https%3A%2F%2Fssp.adriver.ru%2Fcgi-bin%2Fsync.cgi%3Fssp_id%3D20323%26external_id%3D%7BWEBO_CID%7D', cb)},
          t: 24
        },{
          id: 46,
          idS: '146',
          c: cid && cookiestate == 0,
          s: function(cb){ld('//exchange.buzzoola.com/cookiesync/dsp/soloway-video?uid='+encodeURIComponent(cid), cb)},
          t: 24
        },{
          id: 209,
          idS: '209',
          c: cid && cookiestate == 0,
          s: function(cb){ld('https://sm.rtb.mts.ru/p?ssp=adriver&id='+encodeURIComponent(cid), cb)},
          t: 24
        },{
          id: 148,
          idS: '148',
          s: function(cb){ld('https://ads.betweendigital.com/match?bidder_id=43205&callback_url=https%3A%2F%2Fssp.adriver.ru%2Fcgi-bin%2Fsync.cgi%3Fdsp_id%3D148%26external_id%3D${USER_ID}', cb)},
          t: 24
        },{
          id: 149,
          idS: '149',
          s: function(cb){ld('https://match.new-programmatic.com/userbind?src=adr&id='+encodeURIComponent(cid), cb)},
          t: 24
        },{
          id: 150,
          idS: '150',
          s: function(cb){ld('https://sync.upravel.com/adriver/sync', cb)},
          t: 24
        },{
          id: 208,
          idS: '208',
          s: function(cb){ld('https://sync.rambler.ru/set?partner_id=soloway&id='+encodeURIComponent(cid).substr(1), cb)},
          t: 24
        },{
          id: 154,
          idS: '154',
          s: function(cb){ld('https://d.wi-fi.ru/b/v1/sync?cb=adriver', cb)},
          t: 24
        },{
          id: 1541,
          idS: '154_1',
          s: function(cb){ld('//inv-nets.admixer.net/adxcm.aspx?ssp=894F2FE0-81B1-4B3D-9CBF-84756D5545BE&rurl=https%3A%2F%2Fssp.adriver.ru%2Fcgi-bin%2Fsync.cgi%3Fdsp_id%3D154%26external_id%3D%24%24visitor_cookie%24%24', cb)},
          t: 24
         },{
          id: 153,
          idS: '15_3',
          c: cid && cookiestate == 0,
          s: function(cb){ld('https://www.acint.net/rmatch?dp=85&euid='+encodeURIComponent(cid)+'&r=https%3A%2F%2Fssp.adriver.ru%2Fcgi-bin%2Fsync.cgi%3Fdsp_id%3D153%26external_id%3D%24%7BUSER_ID%7D', cb)},
          t: 24
        },{
          id: 155,
          idS: '155',
          s: function(cb){ld('https://'+encodeURIComponent(cid)+'-adr.ops.beeline.ru/p?ssp=adr&id='+encodeURIComponent(cid), cb)},
          t: 24
        },{
          id: 3,
          idS: '1000',
          c: cid && cookiestate == 0,
          s: function(cb){ld('https://ad.adriver.ru/cgi-bin/rle.cgi?sid=1&ad=608223&bt=21&pid=3136519&bid=6985966&bn=6985966&rnd='+rnd, cb)},
          t: 24,
          bl: 1
        },{
          id: 144,
          idS: '144',
          s: function(cb){ld('https://sync.dmp.otm-r.com/match/adriver_ssp', cb)},
          t: 24 
        },{
          id: 156,
          idS: '156',
          s: function(cb){ld('https://sync.bumlam.com/?src=adr2&uid='+encodeURIComponent(cid), cb)},
          t: 24 
        },{
          id: 157,
          idS: '157',
          s: function(cb){ld('https://exchange.buzzoola.com/cookiesync/redirect/adriver?redirect_url=http%3A%2F%2Fssp.adriver.ru%2Fcgi-bin%2Fsync.cgi%3Fdsp_id%3D157%26external_id%3D%24%7BUUID%7D', cb)},
          t: 24 
        },{
          id: 158,
          idS: '158',
          s: function(cb){ld('https://sync.republer.com/match?src=soloway&id='+encodeURIComponent(cid), cb)},
          t: 24 
        },{
          id: 159,
          idS: '159',
          s: function(cb){ld('https://z.cdn.adtarget.me/smc?s=63&u='+encodeURIComponent(cid), cb)},
          t: 24 
        },{
          id: 218,
          idS: '218',
          s: function(cb){ld('https://ad.adriver.ru/cgi-bin/rle.cgi?sid=1&ad=608223&bt=21&pid=3365665&rnd='+rnd, cb)},
          t: 24 
        },{
          id: 65,
          idS: '65',
          s: function(cb){ld('https://ad.mail.ru/cm.gif?p=23&id='+encodeURIComponent(cid), cb)},
          t: 24 
        },{
          id: 161,
          idS: '161',
          s: function(cb){ld('https://sync.dmp.melvad.com/match/1?ssp_id=6&user_id='+encodeURIComponent(cid)+'&rt=%2F%2Fssp.adriver.ru%2Fcgi-bin%2Fsync.cgi%3Fssp_id%3D161%26external_id%3D%7B%7Boui%7D%7D&gdpr=0', cb)},
          t: 24
        }
        ]
      ];
      
      if(uid == 27384237356 || uid == 20050884996 || uid == 19175897844){sC('cid', 0, 1000*60);}  
     
function ld(t,n){var r=!1,e=document.createElement("img");function o(t){r||(r=!0,t(),this.onload=this.onerror=this.onreadystatechange=null)}e.onload=e.onerror=function(){o.call(this,n)},e.onreadystatechange=function(){/loaded|complete/.test(this.readyState)&&o.call(this,n)},e.src=t,document.body.appendChild(e)}function log(t){try{console.warn(t)}catch(t){}}function validate(t){for(var n=[],r=0,e=t.length;r<e;r++)for(var o,a=0,i=(o=t[r]).length;a<i;a++){var u=[],c=o[a];c.hasOwnProperty("id")?"number"!=typeof c.id&&u.push('The "id" attribute must be number.'):u.push('Set up the "id" attribute.'),c.hasOwnProperty("s")?"function"!=typeof c.s&&u.push('The "s" attribute must be function.'):u.push('Set up the "s" attribute.'),c.hasOwnProperty("idS")||u.push('Set up the "idS" attribute in '+c.id+"."),c.hasOwnProperty("t")&&"number"!=typeof c.t&&u.push('The "t" attribute must be number.'),u.length&&n.push(u.join(" "))}return n.length&&log(n.join("\n")),n.length}var calledI,calledOneII,cAll,Rt=function(t){var o=t.cN||"sc",f=t.mS||5,l=t.mNS||288e5,h=t.compN;function p(){return Math.floor(+new Date/1e3/60/60)}function r(){var n;try{n=JSON.parse(gC(o))||{o:{},b:0}}catch(t){n={o:{},b:0}}return(n=n).b=parseInt(n.b),isNaN(n.b)&&(n.b=0),n.o=function(t){var n,r={};for(n in t)t.hasOwnProperty(n)&&(r[n]=parseInt(t[n]));return r}(n.o),n}function v(){var t,n=r();for(t in n.o)n.o.hasOwnProperty(t)&&(n.o[t]=n.o[t]+n.b);return n.o}function g(t,n,r,e){for(var o,a=[],i=0,u=t.length;i<u;i++){o=t[i],a[i]||(a[i]=[]);for(var c=0,l=o.length;c<l;c++){var s=o[c],d=n[s.id],d=!d||p()-d>=s.t,f=r?s.bl:!s.bl;s.c&&f&&d&&!function(t,n){for(var r=0,e=t.length;r<e;r++)if(t[r].id===n)return 1}(e,s.id)&&a[i].push(s)}}return a}function m(t,r){function n(t,n,r){return t.length<n&&r.length}function e(t,n){r=0,e=t.length;var r,e=Math.floor(Math.random()*(e-r))+r;n.push(t[e]),t.splice(e,1)}function o(t,n){return r[t.id]>r[n.id]?1:r[t.id]<r[n.id]?-1:0}for(var a,i=[],u=f,c=0,l=t.length;c<l;c++){var s=t[c],d=!s.length;if(u-=i.length,!d){if(!u)break;if(u<=function(t,n){for(var r=0,e=0,o=t.length;e<o;e++)n[t[e].id]||(r+=1);return r}(s,r))for(;n(i,f,s);)e(s,i);else for(s.sort(o);n(i,f,s);)i.push((a=s)[0]),a.splice(0,1)}}return i}function b(t){for(var n=0,r=t.length;n<r;n++){var e=t[n];(0,e.s)(function(e){return function(){var t=p();n=e,t=t,(r=v())[n]=t;var t=function(t){var n,r=-1;for(n in t)t.hasOwnProperty(n)&&(-1===r||t[n]<r)&&(r=t[n]);return r}(n=r),n=function(t,n){for(var r in t)t.hasOwnProperty(r)&&(t[r]=t[r]-n);return t}(n,t),n=JSON.stringify({o:n,b:t}),r=(sC(o,"old",-1),sC(o,n,31536e7),y());sC(h,"old",-1),r?sC(h,1,1e3*r*60*60):sC(h,0,-1e3)}}(e.id))}}function y(){for(var t,n=v(),r=0,e=R.length;r<e;r++)for(var o,a=0,i=(o=R[r]).length;a<i;a++){var u=o[a],c=n[u.id];if(!c||p()-c>=u.t)return!1;c=c+u.t-p();(!t||c<t)&&(t=c)}return l<t?l:t}return{st:function(t){f=(t=t||{}).mS||f;for(var n=t.bl||0,r=t.R||R,t=t.wo||[],e=r,o={t:168,c:cid&&0==cookiestate},a=0,i=e.length;a<i;a++)for(var u,c=0,l=(u=e[a]).length;c<l;c++){var s=u[c];s.hasOwnProperty("t")||(s.t=o.t),s.hasOwnProperty("c")||(s.c=o.c)}var d=v();return b(r=m(g(r,d,n,t),d)),r.length||(n=y(),sC(h,"old",-1),n?sC(h,1,1e3*n*60*60):sC(h,0,-1e3)),r},addTL:function(t){var e=t.called||[],n=t.tl||5,o=t.freqLog||100,a=t.url||"";function i(t,n){return n<t?1:t<n?-1:0}setTimeout(function(){var t=function(t){var n,r=[],e=v();for(n in t)t.hasOwnProperty(n)&&(!e.hasOwnProperty(t[n].id)||p()-e[t[n].id]>=t[n].t)&&r.push(t[n]);return r}(e);if(t.length){var n,r=document.getElementsByTagName("img");for(n in r)r.hasOwnProperty(n)&&(r[n].onload=r[n].onerror=r[n].onreadystatechange=null);document.all?document.execCommand("Stop"):window.stop(),tr(o)&&ld(a+"&custom="+encodeURIComponent("1="+function(t){var n,r=[];for(n in t)t.hasOwnProperty(n)&&r.push(t[n].idS);return r}(t).sort(i).join(","))+"&rnd="+rnd,function(){})}},1e3*n)}}}({cN:"sn",mS:50,mNS:4,compN:window.compN});sC("sc",0,-1e3),sC("scCo",0,-1e3),sC("scCom",0,-1e3),validate(R)||(calledI=Rt.st({bl:1}),calledOneII=Rt.st({mS:50,R:[R[1]],wo:calledI}),+_all&&(cAll=function(){var t=calledI.concat(calledOneII),n=Rt.st({mS:50,wo:t});Rt.addTL({called:t.concat(n),tl:5,freqLog:1,url:"//ad.adriver.ru/cgi-bin/rle.cgi?sid=1&ad=340241&bt=21&pid=2429011&bid=5071447&bn=5071447"})},pL?cAll():window.addEventListener("message",function(t){isPL(t)&&cAll()})));
} catch (a) {}