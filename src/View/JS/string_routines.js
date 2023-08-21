var Base64 = {};
Base64.code = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=";
Base64.encode = function (e, t) {
    t = typeof t === "undefined" ? false : t;
    var n, r, i, s, o, u, a, f, l = [], c = "", h, p, d;
    var v = Base64.code;
    p = t ? Utf8.encode(e) : e;
    h = p.length % 3;
    if (h > 0) {
        while (h++ < 3) {
            c += "=";
            p += "\0"
        }
    }
    for (h = 0; h < p.length; h += 3) {
        n = p.charCodeAt(h);
        r = p.charCodeAt(h + 1);
        i = p.charCodeAt(h + 2);
        s = n << 16 | r << 8 | i;
        o = s >> 18 & 63;
        u = s >> 12 & 63;
        a = s >> 6 & 63;
        f = s & 63;
        l[h / 3] = v.charAt(o) + v.charAt(u) + v.charAt(a) + v.charAt(f)
    }
    d = l.join("");
    d = d.slice(0, d.length - c.length) + c;
    return d
};
Base64.decode = function (e, t) {
    t = typeof t === "undefined" ? false : t;
    var n, r, i, s, o, u, a, f, l = [], c, h;
    var p = Base64.code;
    h = t ? Utf8.decode(e) : e;
    for (var d = 0; d < h.length; d += 4) {
        s = p.indexOf(h.charAt(d));
        o = p.indexOf(h.charAt(d + 1));
        u = p.indexOf(h.charAt(d + 2));
        a = p.indexOf(h.charAt(d + 3));
        f = s << 18 | o << 12 | u << 6 | a;
        n = f >>> 16 & 255;
        r = f >>> 8 & 255;
        i = f & 255;
        l[d / 4] = String.fromCharCode(n, r, i);
        if (a === 64)l[d / 4] = String.fromCharCode(n, r);
        if (u === 64)l[d / 4] = String.fromCharCode(n)
    }
    c = l.join("");
    return t ? Utf8.decode(c) : c
};
var Utf8 = {};
Utf8.encode = function (e) {
    var t = e.replace(/[\u0080-\u07ff]/g, function (e) {
        var t = e.charCodeAt(0);
        return String.fromCharCode(192 | t >> 6, 128 | t & 63)
    });
    t = t.replace(/[\u0800-\uffff]/g, function (e) {
        var t = e.charCodeAt(0);
        return String.fromCharCode(224 | t >> 12, 128 | t >> 6 & 63, 128 | t & 63)
    });
    return t
};
Utf8.decode = function (e) {
    var t = e.replace(/[\u00e0-\u00ef][\u0080-\u00bf][\u0080-\u00bf]/g, function (e) {
        var t = (e.charCodeAt(0) & 15) << 12 | (e.charCodeAt(1) & 63) << 6 | e.charCodeAt(2) & 63;
        return String.fromCharCode(t)
    });
    t = t.replace(/[\u00c0-\u00df][\u0080-\u00bf]/g, function (e) {
        var t = (e.charCodeAt(0) & 31) << 6 | e.charCodeAt(1) & 63;
        return String.fromCharCode(t)
    });
    return t
};
