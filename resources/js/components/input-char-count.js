document.createElement('input-char-count');

document.querySelectorAll('input-char-count').forEach( function(el) {
    let id = el.getAttribute("for");
    if (!id) return;
    document.querySelector("#"+id).addEventListener("input", function(e) {
        el.innerHTML = e.target.value.length;
    })
});