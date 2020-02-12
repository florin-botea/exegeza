import {Url} from "./../helpers.js";
import debounce from 'lodash/debounce';

export default function() {
    let el = $(this[0]);
    if (! el) return;
    let content = $(el.find(".list-content")[0]);
    this.list_item_ids = [];
    this.url = new Url(el.data("baseurl"), true);
    this.isLoading = false;
    // loading top ' bottom true false

    let next = (clear = false) => {
        if (this.isLoading) return;
        this.isLoading = true;
        let spinner = el.find('.loading-next')[0];
        if (spinner) spinner.classList.add("is-loading");
        // loaddownbtn hide
        axios.get(this.nextPageUrl).then(res => {
            if (clear) content.empty();
            if (spinner) spinner.classList.remove("is-loading");
            // build js
            let list = $(res.data);
            let _content = list.children('.list-content')[0];console.log(_content)
            $(_content).children().each(function(i, el){
                if (!this.list_item_ids.includes(el.id)) {
                    this.list_item_ids.push(el.id)
                    content.append(el)
                }
            }.bind(this))
            this.isLoading = false;
            //loaddownbtnshow
        }).catch(err => {
            if (spinner) spinner.classList.add("is-error");
            if (spinner) spinner.classList.remove("is-loading");
            this.isLoading = false;
            console.log(err)
            console.log(this.list_item_ids)
        });
    }

    let prev = () => {
        
    }

    let fetch = () => {
        if (this.isLoading) return;
        this.isLoading = true;
        let spinner = el.find('.loading-next')[0];
        if (spinner) spinner.classList.add("is-loading");
        // loaddownbtn hide
        content.empty();
        this.list_item_ids = [];
        axios.get(this.url.toString()).then(res => {
            if (spinner) spinner.classList.remove("is-loading");
            // build js
            let list = $(res.data);
            let _content = list.children('.list-content')[0];
            $(_content).children().each(function(i, el){
                this.list_item_ids.push(el.id)
                content.append(el)
            }.bind(this))
            this.nextPageUrl = 123
            this.isLoading = false;
            //loaddownbtnshow
        }).catch(err => {
            if (spinner) spinner.classList.add("is-error");
            if (spinner) spinner.classList.remove("is-loading");
            this.isLoading = false;
            console.log(err)
            console.log(this.list_item_ids)
        });
    }

    this.next = next;
    this.prev = prev;
    this.fetch = fetch;

    /* FEATURES */
    let filters = el.find(".list-filters")[0];
    if (filters) {
        $(filters).find(".list-filter").on("input", debounce(function() {
            let queryObj = {};
            $(filters).find(".list-filter").each(function(i, el) {
                queryObj[el.name] = el.value;
            });
            console.log(queryObj)
            this.url.query.add(queryObj);
            console.log(this.url.query.toString())
            $(el.find(".list-content")[0]).empty();
            fetch(true);
        }.bind(this), 600));
    }
    /* ENDFEATURES */
    
    return this;
}
