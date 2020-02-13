import {Url} from "./../helpers.js";
import debounce from 'lodash/debounce';

export default function() {
    let el = $(this[0]);
    if (! el) return;
    let content = $(el.find(".list-content")[0]);
    this.list_item_ids = [];
    this.url = new Url(el.data("baseurl"), true);
    this.isLoading = false;
    this.pagesUrl = {next:null, prev:null};
    // loading top ' bottom true false

    /* FEATURES */
    this.filters = el.find(".list-filters")[0];
    if (this.filters) {
        $(this.filters).find(".list-filter").on("input", debounce(function() {
            applyFilters();
            this.list_item_ids = [];
            $(el.find(".list-content")[0]).empty();
            this.get();
        }.bind(this), 600));
    }

    let applyFilters = () => {
        let queryObj = {};
        $(this.filters).find(".list-filter").each(function(i, el) {
            queryObj[el.name] = el.value;
        });
        this.url.query.add(queryObj);
        this.pagesUrl = {next: this.url.toString(), prev: null};
    }
    applyFilters();
    /* ENDFEATURES */

    this.setLoading = (_spinner, isLoading, isError = false) => {
        this.isLoading = isLoading;
        let spinner = el.find(".loading-" + _spinner)[0];
        if (spinner) {
            isLoading ? spinner.classList.add("is-loading") : spinner.classList.remove("is-loading");
            if (isError) spinner.classList.add("is-error");
        }
    }

    this.get = (dirrection = "next") => {
        if (! this.pagesUrl[dirrection] || !this.pagesUrl[dirrection].length || this.isLoading) return;
        this.setLoading(dirrection, true);
        axios.get(this.pagesUrl[dirrection]).then(res => {
            this.setLoading(dirrection, false);
            let list = $(res.data);
            let _content = list.children('.list-content')[0];
            $(_content).children().each((i, el) => {
                this.list_item_ids.push(el.id)
                content.append(el)
            });
            this.pagesUrl[dirrection] = (list.children("#" + dirrection + "-page-url")[0] || {}).href;
            //loaddownbtnshow
        }).catch(err => {
            this.setLoading(dirrection, false, true);
            this.pagesUrl[dirrection] = null;
            console.log(err)
        });
    }
    
    return this;
}
