var serialize = function(obj) {
    let params = [];
    for (var p in obj) {
        obj.hasOwnProperty(p) && obj[p] != null && (obj[p].trim()).length ? params.push(encodeURIComponent(p) + "=" + encodeURIComponent(obj[p])) : false;
    }
    return params.join("&");
}

class Url {
    constructor(url, realBase = false) {
        if (typeof url !== "string") throw "Parameter 1 must be a string!";
        if (url.length <= 0) throw "Parameter 1 must not be an empty string!";

        this.base = url;
        if (!realBase) {
            this.base = Url.Base(url);
            this.query = Url.Query(url);
        }
    }

    static Base(url) {
        let q = url.indexOf("?");
        if (q > 0) {
            return url.slice(0, q);
        }
        return url;
    }

    static Query(url) {
        let q = url.indexOf("?")+1;
        if (!q) {
            return {};
        }
        let qs = url.slice(q, -1);
        let qo = {};
        qs.split("&").forEach(function(el) {
            let item = el.split("=");
            if (item[0] != "undefined") qo[item[0]] = item[1];
        });
        return qo;
    }

    toString() {
        return this.base + (this.base.includes("?") ? "&" : "?") + this.query.toString();
    }

    set query (qobj) {
        if (typeof qobj !== "object") throw "Parameter 1 must be a key:value object";

        qobj.__proto__.toString = function() {
            let params = [];
            for (var p in this) {
                this.hasOwnProperty(p) ? params.push(encodeURIComponent(p) + "=" + encodeURIComponent(this[p])) : false;
            }
            return params.join("&");
        }

        this._query = qobj;
    }

    get query () {
        return this._query;
    }
}

export {
    serialize, Url
}