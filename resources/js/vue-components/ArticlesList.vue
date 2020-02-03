<template>
    <div>
        <div class="filter">
            <h5 class="btn btn-sm btn-outline-warning cursor-pointer" data-toggle="collapse" data-target="#filters">Filtre:</h5>
            <div class="form-row mb-3 collapse" id="filters">
                <div class="form-group mx-1 col-md">
                    <input class="form-control" placeholder="Cuvant cheie" v-debounce:600ms="setKeyWord">
                </div>
                <div class="form-group mx-1 col-md">
                    <input class="form-control" placeholder="User" v-debounce:600ms="setUser">
                </div>
                <div class="form-group mx-1 col-md">
                    <input class="form-control" placeholder="Autor" v-debounce:600ms="setAuthor">
                </div>
                <div class="form-group mx-1 col-md">
                    <select class="form-control" v-debounce:600ms="setLanguage">
                        <option value="default">language</option>
                        <option value="all">---</option>
                        <option v-for="language in languages" value="language">{{ language }}</option>
                    </select>
                </div>
                <div class="form-group mx-1 col-md">
                    <select class="form-control" v-debounce:600ms="setLanguage">
                        <option value="default">confession</option>
                        <option value="all">---</option>
                        <option v-for="confession in confessions" value="confession">{{ confession }}</option>
                    </select>
                </div>
                <div class="form-group mx-1 col-md">
                    <select class="form-control" v-debounce:600ms="setOrdering">
                        <option value="date-asc">Data postarii - crescator:</option>
                        <option value="date-desc">Data postarii - descrescator:</option>
                    </select>
                </div>
            </div>
        </div>

        <ArticleSample v-for="article in articles" :article="article" :key="article.id"/>

        <div class="display-flex justify-content-center">
            <Loading v-show="loading" :error="error" class="mx-auto"/>
        </div>
    </div>
</template>

<script>
import ArticleSample from "./Article_sample.vue";
import Loading from './Loading_engines.vue';

export default {
    components: {ArticleSample,Loading},

    props: {
        bible: {type:Number, default:null},
        book: {type:Number, default:null},
        chapter: {type:Number, default:null},
        languages: {type:Array, default:[]},
        confessions: {type:Array, default:[]}
    },
    data: () => ({
        articles: [],
        nextPageUrl: '',
        filters: {
            keyWord: null,
            user: null,
            author: null,
            ordering: null,
            language: null
        },
        loading: false,
        error: false
    }),
    methods: {
        getArticles() {
            if (this.loading)
                return;
            this.loading = true;
            axios.get(this.nextPageUrl).then(res => {
                this.articles = this.articles.concat(res.data.data);
                this.nextPageUrl = res.data.next_page_url;
                this.loading = false;
            }).catch(err => {
                this.nextPageUrl = null;
                this.loading = false;
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
        setKeyWord(val) {
            this.filters.keyWord = val;
        },
        setUser(val) {
            this.filters.user = val;
        },
        setAuthor(val) {
            this.filters.author = val;
        },
        setOrdering(val) {
            this.filters.ordering = val;
        },
        setLanguage(val) {
            this.filters.language = val;
        }
    },
    watch: {
        nextPageUrl(newVal) {
            if (!newVal) {
                this.onScrolledAllArticles = function() { console.log('nothing to fetch'); }
            } else {
                this.onScrolledAllArticles = this.getArticles;
            }
        },
        filters: {
            deep: true,
            handler() {
                this.articles = [];
                this.buildNextPageUrlFromFilters();
                this.getArticles()
            }
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