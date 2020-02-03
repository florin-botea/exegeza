require('./bootstrap');

import Vue from 'vue';
import vueDebounce from 'vue-debounce';
import ArticlesList from './vue-components/ArticlesList.vue';

Vue.use(vueDebounce, {
	listenTo: ['input', 'keyup', 'change'],
	defaultTime: '500ms'
})

$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})

$('.js-unblur-section').on('click', function(e){
	$('.blured-section').removeClass('blured-section');
	$(e.target).remove();
})

$(".single-submit-btn").on("click", function(e){
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
	$('#login-tab').tab('show')
	$('#loginModal').modal();
}

window.registerModal = function(){
	$('#register-tab').tab('show')
	$('#loginModal').modal();
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

const app = new Vue({
    components: {ArticlesList},
}).$mount('#vue-app-layer');