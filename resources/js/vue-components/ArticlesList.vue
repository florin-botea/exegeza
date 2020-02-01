<template>
    <div>
        <div class="filter">
            <h5 class="btn btn-sm btn-outline-warning cursor-pointer" data-toggle="collapse" data-target="#filters">Filtre:</h5>
            <div class="form-row mb-3 collapse" id="filters">
                <div class="form-group mx-1 col-md">
                    <input class="form-control" placeholder="Cuvant cheie">
                </div>
                <div class="form-group mx-1 col-md">
                    <input class="form-control" placeholder="Autor">
                </div>
                <div class="form-group mx-1 col-md">
                    <input class="form-control" placeholder="Referinta">
                </div>
                <div class="form-group mx-1 col-md">
                    <select class="form-control">
                        <option>Ordoneaza dupa:</option>
                    </select>
                </div>
                <div class="form-submit ml-2">
                    <button class="btn btn-primary">Submit</button>
                </div>
            </div>
        </div>

        <ArticleSample v-for="article in articles" :key="article.id"/>
    </div>
</template>

<script>
import ArticleSample from "./Article_sample.vue";

export default {
    components: {ArticleSample},

    props: {
        bible: {type:Number, default:null},
        book: {type:Number, default:null},
        chapter: {type:Number, default:null}
    },
    data: () => ({
        articles: [],
        nextPageUrl: '',
        filters: {
            foo: null,
            bar: null
        },
        spinner: false,
        error: false
    }),
    methods: {
        getArticles() {
            if (this.spinner)
                return;
            this.spinner = true;
            axios.get(this.nextPageUrl).then(res => {
                // set nextPage
                this.spinner = false;
            }).catch(err => {
                this.nextPageUrl = null;
                this.spinner = false;
                this.error = true;
            })
        },
        buildNextPageUrlFromFilters() {
            this.nextPageUrl = '/api/articles?' + this.serialize({
                bible: this.bible,
                book: this.book,
                chapter: this.chapter,
                ...this.filters
            });
        },
        onScrolledAllArticles: function() {},
        serialize(obj) {
            let params = [];
            for (var p in obj) {
                obj.hasOwnProperty(p) && obj[p] != null ? params.push(encodeURIComponent(p) + "=" + encodeURIComponent(obj[p])) : false;
            }
            return params.join("&");
        },
    },
    watch: {
        nextPageUrl(newVal) {
            console.log(newVal)
            if (!newVal) {
                this.onScrolledAllArticles = function() { console.log('nothing to fetch'); }
            } else {
                this.onScrolledAllArticles = this.getArticles;
            }
        },
        filters() {
            this.buildNextPageUrlFromFilters();
            this.getArticles()
        }
    },
    mounted() {
        this.buildNextPageUrlFromFilters();
        this.getArticles();

        window.onscroll = function() {
            let scrolledBottom = (window.innerHeight + window.scrollY) >= document.body.offsetHeight;
            if (scrolledBottom) {
                this.onScrolledAllArticles();
            }
        }.bind(this);
    }
}
</script>