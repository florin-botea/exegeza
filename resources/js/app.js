require('./bootstrap');

import {serialize} from "./helpers.js";
/*
import Vue from 'vue';
import vueDebounce from 'vue-debounce';
import ArticlesList from './vue-components/ArticlesList.vue';

Vue.use(vueDebounce, {
	listenTo: ['input', 'keyup', 'change'],
	defaultTime: '500ms'
})
*/
$(function () {
  // $('[data-toggle="tooltip"]').tooltip()
})

$(".single-submit-btn").on("click", function(e) {
	e.target.classList.add("submitting")
	$(".single-submit-btn").off("click");
	$(".single-submit-btn").on("click", function(){
		return false;
	});
});

/**
 * AUTENTIFICARE
 * ========================================================================== 
 */
window.loginModal = function(){
	$('#authModal').tabs("option", "active", 0);
	$('#authModal').modal({
		fadeDuration: 250
	});
}

window.registerModal = function(){
	$('#authModal').tabs("option", "active", 1);
	$('#authModal').modal({
		fadeDuration: 250
	});
}

$('#loginBtn').on('click', function(){
	loginModal();
})
$('#registerBtn').on('click', function(){
	registerModal();
})

/* endAUTENTIFICARE */

/**
 * Manage Bibles
 * ========================================================================
 */
$('.js-modal-controller').on('click', function(e) {
	if (! e.target.dataset.target) {
		return;
	}
	$(e.target.dataset.target).modal({
		fadeDuration: 250
	});
});


$('#js-preview-verses-action').on('click', function(){
	let regex = $('#js-preview-verses_regex');
	let verses = $('#js-preview-verses_verses');
	let preview = $('#js-preview-verses-container');
	preview.empty()
	if (!regex || !verses) return;
	axios.post('/api/verses-preview', {
		regex: regex.val(),
		verses: verses.val()
	}).then(res=>{
		res.data.forEach((verse, i)=>{
			preview.append($('<p>'+(i+1+'. ')+verse+'</p>'))
		})
	})
})
/**
 * end Manage Bibles
 * ========================================================================
 */

/**
 * ARTICOLE sample
 * ========================================================================== 
 */
/*
import loadingList from './jquery-extends/loading-list.js';
jQuery.fn.loadingList = loadingList;

var articlesList = $('#js_articlesList').loadingList();
if (articlesList) {
	articlesList.get();
	window.onscroll = function() {
		let scrolledBottom = (window.innerHeight + window.scrollY) >= document.body.offsetHeight;
		if (scrolledBottom) {
			articlesList.get();
		}
	}
}*/

/**
 * end ARTICOLE sample
 * ========================================================================
 */

/**
 * Photo upload
 * ========================================================================== 
 */

$(".upload-on-change").on("change", function() {
	if (!this.dataset.url) throw("No url was set for uploading file");
	let progressBar = this.dataset.progress_bar;
	let preview = this.dataset.preview;
	console.log(preview)
	if (preview && this.files && this.files[0]) {
		var reader = new FileReader();
		reader.onload = function(e) {
			$(preview).attr('src', e.target.result);
		}
		reader.readAsDataURL(this.files[0]);
	}
});

/* end */