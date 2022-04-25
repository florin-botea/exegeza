<template is="layouts/app">
    <card>
        <tabs :tabs="['general' => 'General']" :value="request('tab', 'general')">
            <div slot="tab-pane">
                <section class="row">
                    <div p-logged="$user->id" class="col-12 text-end">
                        <a :href="'/users/'.auth()->id().'/edit'" class="btn btn-sm btn-primary py-1 my-2">
                            Edit <i class="fas fa-edit"></i>
                        </a>
                    </div>
                    <div class="col-sm-6">
                        <figure class="bg-secondary">
                            <img class="mx-auto w-100" :src="$user->profilePicture">
                        </figure>
                    </div>
                    <div class="col-sm-6">
                        <table class="w-full h5">
                            <tr>
                                <td> Nume: </td>
                                <td>{{ $user->name }}</td>
                            </tr>
                            <tr>
                                <td> Email: </td>
                                <td>{{ $user->email }}</td>
                            </tr>
                            <tr>
                                <td> Bio: </td>
                            </tr>
                            <tr>
                                <td colspan="2">{{ $user->bio }}</td>
                            </tr>
                        </table>
                    </div>
                </section>
    <!-- 
    @if ($user->details && $user->details->description && $user->details->description->content)
    <section class="px-4">
        <div class="ck-content break-normal">{!! $user->details->description->content !!}</div>
    </section>
    @endif  

    @if (isset($articles) && count($articles))
    <section class="px-2">
        <section role="articles-samples-list" class="bg-gray-100">
            <h2 class="inline text-xl font-serif font-semibold text-purple-900"> Articole postate de utilizator </h2>
            <div role="articles-list" class="p-2">
                @foreach ($articles as $article)
                    @include('components.article-sample', ['article' => $article])
                    <hr class="my-4">
                @endforeach
            </div>
        </section>
    </section>
    @endif

    @if (isset($unpublished) && count($unpublished) && auth()->user() && (auth()->user()->can('publish articles') || auth()->user()->id === $user->id))
    <section class="px-2">
        <section role="articles-samples-list" class="bg-gray-100">
            <h2 class="inline text-xl font-serif font-semibold text-purple-900"> Articole nepublicate </h2>
            <div role="articles-list" class="p-2">
                @foreach ($unpublished as $article)
                    <article class="">
                        <header>
                            <h2 class="font-semibold text-lg hover:underline inline text-blue-900 mb-2">
                                <a href="{{ route('articles.show', [$article->slug]) }}">{{ $article->title }}</a>
                            </h2>
                        </header>
                        <footer class="flex justify-between">
                            <div class="hover:underline">
                                <a href="">
                                    {{ $article->book->name.($article->chapter_index ? ", $article->chapter_index" : '') }} ({{ $article->bible->name }})
                                </a>
                            </div>
                            <div>{{ $article->created_at }}</div>
                        </footer>
                    </article>
                    <hr class="my-4">
                @endforeach
            </div>
        </section>
    </section>
    @endif
    -->
            </div>
        </tabs>
    </card>
</template>