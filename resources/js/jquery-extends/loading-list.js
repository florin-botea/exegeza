import {Url} from "./../helpers.js";

export default function() {
    let el = $(this[0]);
    if (! el) return;
    let content = $(el.find(".list-content")[0]);
    this.url = new Url(el.data("baseurl"), true);
    // loading top ' bottom true false

    let next = (clear = false) => {
    	// if not loading.next or not loaded.next
        let spinner = el.find('.loading-next')[0];
        let lastItem = content.children(".list-item").last();
        let lastId = (lastItem && !clear ? lastItem.dataset.id : 0);
        this.url.query.add({next:"after", id:lastId});

        if (spinner) spinner.classList.add("is-loading");
        // fetching true
        // loaddownbtn hide
        axios.get(this.url.toString()).then(res => {
            if (clear) content.empty();
            if (spinner) spinner.classList.remove("is-loading");
            // if no data loaded/moretoload.next/ true
            content.append(res.data); //.show().fadeIn("slow");
            // fetching false
            //loaddownbtnshow
        }).catch(err => {
            if (spinner) spinner.classList.add("is-error");
            console.log(err)
            // fetchijg false
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
            console.log(this.url)
            this.url.query.add(queryObj)
            $(el.find(".list-content")[0]).empty();
// reset loading and loaded
            next(true);
        }.bind(this));
    }

    /* ENDFEATURES */
    
    return this;
}
