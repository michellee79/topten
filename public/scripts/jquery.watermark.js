/*
Watermark v2.0 (June 2, 2009) plugin for jQuery
Copyright (c) 2009 Todd Northrop
http://www.speednet.biz/
Licensed under GPL 3, see  <http://www.gnu.org/licenses/>
*/
(function (e) { var c, j = "watermark", g = "watermarkClass", b = "watermarkFocus", h = "watermarkSubmit", d = "watermarkMaxLength", f = "watermarkPassword", k = "watermarkText", a = ":data(" + j + ")", i = ":text,:password,textarea"; e.extend(e.expr[":"], { data: function (m, l, o, q) { var n, p = /^((?:[^=!^$*]|[!^$*](?!=))+)(?:([!^$*]?=)(.*))?$/.exec(o[3]); if (p) { n = e(m).data(p[1]); if (n !== c) { if (p[2]) { n = "" + n; switch (p[2]) { case "=": return (n == p[3]); case "!=": return (n != p[3]); case "^=": return (n.slice(0, p[3].length) == p[3]); case "$=": return (n.slice(-p[3].length) == p[3]); case "*=": return (n.indexOf(p[3]) !== -1) } } return true } } return false } }); e.watermark = { className: "watermark", hide: function (l) { e(l).filter(a).each(function () { e.watermark._hide(e(this)) }) }, _hide: function (o, m) { if (o.val() == o.data(k)) { o.val(""); if (o.data(f)) { if (o.attr("type") === "text") { var n = o.data(f), l = o.parent(); l[0].removeChild(o[0]); l[0].appendChild(n[0]); o = n } } if (o.data(d)) { o.attr("maxLength", o.data(d)); o.removeData(d) } if (m) { o.attr("autocomplete", "off"); window.setTimeout(function () { o.select() }, 0) } } o.removeClass(o.data(g)) }, show: function (l) { e(l).filter(a).each(function () { e.watermark._show(e(this)) }) }, _show: function (q) { var p = q.val(), o = q.data(k); if (((p.length == 0) || (p == o)) && (!q.data(b))) { if (q.data(f)) { if (q.attr("type") === "password") { var n = q.data(f), m = q.parent(); m[0].removeChild(q[0]); m[0].appendChild(n[0]); q = n } } if (q.attr("type") === "text") { var l = q.attr("maxLength"); if ((l > 0) && (o.length > l)) { q.data(d, l); q.attr("maxLength", o.length) } } q.val(o); q.addClass(q.data(g)) } else { e.watermark._hide(q) } }, hideAll: function () { e.watermark.hide(i) }, showAll: function () { e.watermark.show(i) } }; e.fn.watermark = function (o, n) { var m = (typeof (o) === "string"), l = (typeof (n) === "string"); return this.filter(i).each(function () { var s = e(this); if (s.data(j)) { if (m || l) { e.watermark._hide(s); if (m) { s.data(k, o) } if (l) { s.data(g, n) } } } else { s.data(k, m ? o : ""); s.data(g, l ? n : e.watermark.className); s.data(j, 1); if (s.attr("type") === "password") { var p = s.wrap("<span>").parent(); var r = e(p.html().replace(/type=["']?password["']?/i, 'type="text"')); r.data(k, s.data(k)); r.data(g, s.data(g)); r.data(j, 1); r.focus(function () { e.watermark._hide(r, true) }); s.blur(function () { e.watermark._show(s) }); r.data(f, s); s.data(f, r) } else { s.focus(function () { s.data(b, 1); e.watermark._hide(s, true) }).blur(function () { s.data(b, 0); e.watermark._show(s) }) } var q = e(this.form); if (!q.data(h)) { q.data(h, this.form.submit); q.submit(e.watermark.hideAll); this.form.submit = function () { e.watermark.hideAll(); q.data(h).apply(q[0], arguments) } } } e.watermark._show(s) }).end() } })(jQuery);