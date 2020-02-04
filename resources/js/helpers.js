var serialize = function(obj) {
    let params = [];
    for (var p in obj) {
        obj.hasOwnProperty(p) && obj[p] != null && (obj[p].trim()).length ? params.push(encodeURIComponent(p) + "=" + encodeURIComponent(obj[p])) : false;
    }
    return params.join("&");
}

export {
    serialize
}