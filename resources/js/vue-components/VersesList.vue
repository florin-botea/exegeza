<ul class="list-unstyled text-justify">
    <Verse v-for="verse in verses"/>
</ul>

<script>
import Verse from './Verse';

export default {
    components: {Verse},
    props: {
        verses: Array
    }
}
</script>