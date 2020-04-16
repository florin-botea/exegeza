<template>
    <div class="">
        {{ comment.text }}
        <div>
            <CommentsSection></CommentsSection>
        </div>
    </div>
</template>

<script>
import CommentsSection from "./CommentsSection.vue";

export default {
    components: {CommentsSection},
    props: {
        comment: {type:Object, required:true}
    }
}
</script>