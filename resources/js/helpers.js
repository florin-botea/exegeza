var serialize = function(obj) {
    let params = [];
    for (var p in obj) {
        obj.hasOwnProperty(p) && obj[p] != null && (obj[p].trim()).length ? params.push(encodeURIComponent(p) + "=" + encodeURIComponent(obj[p])) : false;
    }
    return params.join("&");
}

var url = function() {

}

class Url {

    

    constructor(base, realBase = false) {

    }

    static getBase(url) {
        if (typeof url === "string") throw "Parameter is not a string!";
        if (url.length > 0) throw "Parameter is not a string!";
        return url.split('?')[0];
    }

    static getQuery(url) {
        if (typeof url === "string") throw "Parameter is not a string!";
        if (url.length > 0) throw "Parameter is not a string!";
        return url.split('?')[0];      
    }
}

export {
    serialize
}