<template>
    <article>
        <header class="d-flex flex-wrap justify-content-between">
            <a class="h2 w-100 text-dark" :href="articleUrl">{{ article.title }}</a>
            <aside class="">{{ articleTarget }}</aside>
            <span role="float-right" style="visibility:hidden">p</span>
            <a class="">{{ article.author.name }}</a>
        </header>
        <div class="">
            {{ articleSample }}
            <a :href="articleUrl"> ...read more</a>
        </div>
    </article>
</template>

<script>
export default {
    props: {
        article: {type:Object, required:true}
    },
    computed: {
        articleUrl(){
            return '/articles/' + this.article.slug + '?author=' + this.article.author.name;
        },
        articleTarget(){
            return null;
        },
        articleSample(){
            return this.article.sample;
        }
    }
}
</script>