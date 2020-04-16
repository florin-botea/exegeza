<nav class="navbar navbar-dark bg-primary px-5 py-1">
	<ul class="ml-auto m-0" style="list-style: none;">
		<li class="nav-item dropdown ml-auto">
			<a class="nav-link py-0 text-white" href="#" id="articlesManageDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				<i class="fas fa-book"></i> Articles
			</a>
			<div class="dropdown-menu dropdown-menu-right" aria-labelledby="articlesManageDropdown">
				<a class="dropdown-item" href="{{ route('pending-articles.index') }}">
					<i class="fas fa-plus"></i> Pending 
				</a>
				<a class="dropdown-item" href="{{ route('bible-versions.books.create', ['bible_version'=>request()->bible_version]) }}">
					<i class="fas fa-plus"></i> Gestioneaza carti 
				</a>
				<a class="dropdown-item" href="{{ route('bible-versions.books.chapters.create', ['bible_version'=>request()->bible_version, 'book'=>request()->book]) }}">
					<i class="fas fa-plus"></i> Gestioneaza capitole 
				</a>
			</div>
		</li>
	</ul>
	<ul class="ml-auto m-0" style="list-style: none;">
		<li class="nav-item dropdown ml-auto">
			<a class="nav-link py-0 text-white" href="#" id="navbarDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				<i class="fas fa-book"></i> Biblie
			</a>
			<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
				<a class="dropdown-item" href="{{ route('bible-versions.create') }}">
					<i class="fas fa-plus"></i> Gestioneaza versiuni 
				</a>
				<a class="dropdown-item" href="{{ route('bible-versions.books.create', ['bible_version'=>request()->bible_version]) }}">
					<i class="fas fa-plus"></i> Gestioneaza carti 
				</a>
				<a class="dropdown-item" href="{{ route('bible-versions.books.chapters.create', ['bible_version'=>request()->bible_version, 'book'=>request()->book]) }}">
					<i class="fas fa-plus"></i> Gestioneaza capitole 
				</a>
			</div>
		</li>
	</ul>
</nav>