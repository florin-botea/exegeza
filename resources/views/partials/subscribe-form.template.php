<section class="flex mb-4 flex-wrap">
    <div class="w-1/3 self-center hidden md:block">
        <figure class="">
            <img class="w-full" src="/assets/subscribe-pigeon.png">
        </figure>
    </div>
    <div class="px-4 py-16 self-stretch hidden md:block">
        <p class="relative border-2 border-purple-400 shadow" style="height:100%"></p>
    </div>
    <div class="flex-1 flex w-full md:w-auto">
        <div role="box" class="border-4 border-purple-400 w-full self-center rounded shadow-md">
            <p class="inline-block absolute font-extrabold text-xl text-purple-800 ml-8 px-2 bg-white" style="transform:translateY(-60%)"> Subscribe </p>
            <p class="p-4"> Serviciu momentan indisponibil. Inscrierile se pot face in prealabil </p>
            <form class="flex px-4 pb-4" action="{{ route('subscriptions.store') }}" method="POST">
                @csrf
                <input type="email" name="email" placeholder="your@email.com" class="shadow-md input-w-full px-3 py-1 rounded-left border-r-0 border-2 border-purple-800 focus:outline-none text-purple-800 font-bold">
                <button type="submit" class="single-submit-btn shadow-md rounded-right border-l-0 border-2 border-purple-800 bg-purple-800 text-white font-bold">
                    Subscribe <i class="fab fa-telegram-plane"></i>
                </button>
            </form>
        </div>
    </div>
</section>