<?php

namespace App\Observers;

use App\BibleVersion;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Schema\Blueprint;

class BibleVersionObserver
{/*
    /**
     * Handle the bible version "created" event.
     *
     * @param  \App\BibleVersion  $bibleVersion
     * @return void
     */
    public function created(BibleVersion $bibleVersion)
    {/*
				$this->updateLanguages($bibleVersion, request()->lang);
				
				$table_name = 'v_' . $bibleVersion->id . '_verses';
				if (! Schema::hasTable($table_name)) {
					Schema::create($table_name, function (Blueprint $table) {
						$table->increments('id');
						$table->integer('book_id')->unsigned();
						$table->integer('chapter_id')->unsigned();
						$table->integer('index')->unsigned();
						$table->string('text')->length(900);
					});
				}*/
    }

    /**
     * Handle the bible version "updated" event.
     *
     * @param  \App\BibleVersion  $bibleVersion
     * @return void
     */
    public function updated(BibleVersion $bibleVersion)
    {
				//$this->updateLanguages($bibleVersion, request()->lang);
    }

    /**
     * Handle the bible version "deleted" event.
     *
     * @param  \App\BibleVersion  $bibleVersion
     * @return void
     */
    public function deleted(BibleVersion $bibleVersion)
    {
        //
    }

    /**
     * Handle the bible version "restored" event.
     *
     * @param  \App\BibleVersion  $bibleVersion
     * @return void
     */
    public function restored(BibleVersion $bibleVersion)
    {
        //
    }

    /**
     * Handle the bible version "force deleted" event.
     *
     * @param  \App\BibleVersion  $bibleVersion
     * @return void
     */
    public function forceDeleted(BibleVersion $bibleVersion)
    {
        //
    }
		/*
		private function updateLanguages($bibleVersion, $language) 
		{
				$lang = \App\Language::firstOrCreate(['language'=>$language]);
				\App\ModelHasLanguage::updateOrCreate([
						'model_type' => get_class($bibleVersion), 'model_id' => $bibleVersion->id
				], ['language_id' => $lang->id]);
        }*/
}
