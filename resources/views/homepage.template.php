<extends template="layouts/app"/>

<card>
    <div class="list-group">
      <a p-foreach="$books as $book" :href="$book->url" class="list-group-item list-group-item-action list-group-flush">
        {{ $book->name }}
      </a>
    </div>
	<!-- div class="flex">
		<section role="info" class="p-2">
			<p class="">
				Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
			</p>
		</section>
		<section role="info" class="p-2">
			<p class="">
				Lorem Ipsum is simply dumgmy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
			</p>
		</section>
	</div -->
</card>
