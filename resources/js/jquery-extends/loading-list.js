import {serialize} from "./../helpers.js";

export default function() {
    let el = $(this[0]);
    let content = $(el.find(".list-content")[0]);
    this.baseUrl = el.data("baseurl");
    // this.url = new url base

    let next = (clear = false) => {
        let spinner = el.find('loading-next')[0];
        let lastItem = content.children(".list-item").last();
        let lastId = lastItem ? lastItem.dataset.id : 0;
// url.query.next=before|after id=5 url.toString
        if (spinner) spinner.classList.add("is-loading");
        axios.get(this.nextUrl).then(res => {
            if (clear) content.empty();
            if (spinner) spinner.classList.remove("is-loading");
            content.append(res.data); //.show().fadeIn("slow");
           // let lastItem = content.children(".list-item").last();

            //this.nextUrl = content.children(".load-next").last()[0].dataset.href;
            //console.log(this.nextUrl)
        }).catch(err => {
            if (spinner) spinner.classList.add("is-error");
            //console.log(this.nextUrl)
            console.log(err)
        });
    }

    let prev = () => {
        
    }

    this.next = next;
    this.prev = prev;

    /* FEATURES */

    let filters = el.find(".list-filters")[0];
    if (filters) {
        $(filters).find(".list-filter").on("input", function() {
            let queryObj = {};
            $(filters).find(".list-filter").each(function(i, el) {
                queryObj[el.name] = el.value;
            });
            //this.nextUrl = this.baseUrl + "?" + serialize(queryObj);
            // this.url.query.add(qobj)
            $(el.find(".list-content")[0]).empty();

            next(true);
        });
    }

    /* ENDFEATURES */
    
    return this;
}