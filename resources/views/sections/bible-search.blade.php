<section class="">
	<!--SEARCH FILTERS-->
	<strong>Cautare:</strong>
	<form action="/bible-versions/search" method="get">
		<div class="mb-2">
			<label for="words" class="font-semibold">Cuvantul sau expresia:</label>
			<input type="text" class="w-full border rounded px-2 focus:shadow-lg border-gray-400" name="words" id="words">
		</div>
<!-----><hr/>
		<div class="mb-2">
			<p class="font-semibold">Flexibilitate:</p>
			<div>
				<input type="radio" name="flexibility" id="strict_words" value="rigorous" checked>
				<label for="strict_words">
					Cuvinte exacte
				</label>
			</div>
			<div>
				<input type="radio" name="flexibility" id="relative_words" value="relative" checked>
				<label for="relative_words">
					Cuvinte cu aproximatie
				</label>
			</div>
		</div>
<!-----><hr/>
		<div class="mb-2">
			<p class="font-semibold">Ce caut?</p>
			<div>
				<input type="radio" name="eager" id="all_words_separate" value="all" checked>
				<label for="all_words_separate">
					Toate cuvintele
				</label>
			</div>
			<div>
				<input type="radio" name="eager" id="all_words" value="expression" checked>
				<label for="all_words">
					Ca si expresie
				</label>
			</div>
			<div>
				<input type="radio" name="eager" id="at_least_one_word" value="flexible" checked>
				<label for="at_least_one_word">
					Cel putin unul din cuvinte
				</label>
			</div>
		</div>
<!-----><hr/>
		<div class="mb-2">
			<p>In cartea</p>
			<search-book/>
		</div>
<!-----><hr/>
		<div class="mb-2">
			<p>Traducere</p>
			<select class="text-sm" name="translation" id="search-criteria-version">
				@foreach($bibles as $version)
					<option value="{{$version->slug}}">
						{{ $version->name }}
					</option>
				@endforeach
			</select>
		</div>
<!-----><hr/>
		<div class="flex justify-end">
			<button type="submit" class="rounded right-0 px-2 py-1 font-semibold text-white bg-gray-900 hover:bg-black">
				Cauta
			</button>
		</div>
	</form>
</section>