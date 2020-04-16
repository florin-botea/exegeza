require('./bootstrap');

import {serialize} from "./helpers.js";

/*
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

/* ============================ COMMENTS SECTION ============================ */

var commentsSectionIni = $("#commentsSection-ini");
if (commentsSectionIni.length && commentsSectionIni.data("href")) {
	axios.get(commentsSectionIni.data("href")).then( res => {
		commentsSectionIni.after($(res.data));
		//commentsSection.append( $(res.data) );
		// commentsSectionIni.after append res.data
		// commentsSectionIni.delete
	});

	

	$(document).on("submit", function(e) {
		try {
			if (! e.target.className.includes("_add-comment-form")) return;
			let form = $(e.target);
			let comments = $(form.data("target"));
			
			let loadDown = comments.find("._load-down")[0];
			let content = form.find("[name='content']")[0];
			if (!content) { alert("no content"); return false; }
			if (!loadDown) { alert("no loadDown"); return false; }

			axios.post(loadDown.dataset.href, {
				content: content.value
			}).then( res => {
				console.log(comments)
				// form.find load-down and delete it
				content.value = "";
				comments.append( $(res.data) );
			});
			
		} catch(e) {
			alert(e)
			return false;
		}
		return false;

		let commentsSection = $(e.target).parent();
		axios.get(e.target.dataset.href).then( res => {
			commentsSection.append( $(res.data) );
		});
	});
}

var commentsContainer = $('#comments-container');
if (commentsContainer.length) {
	let src = commentsContainer.data("src");
	$('#comments-container').comments({
		enableNavigation: false,
		defaultNavigationSortKey: 'oldest',
		profilePictureURL: $('#authenticated-user-image').attr('src') || 'https://viima-app.s3.amazonaws.com/media/public/defaults/user-icon.png',
		
		getComments: function(success, error) {
			axios.get(src).then(res => {
				success(res.data);
			});
		},

		postComment: function(commentJSON, success, error) {
			axios.post(src, commentJSON).then(res => {
				success(res.data)
			})
		},

		fieldMappings: {
			id: 'id',
			parent: 'parent',
			created: 'created_at',
			modified: 'updated_at',
			content: 'content',
			file: 'file',
			fileURL: 'file_url',
			fileMimeType: 'file_mime_type',
			pings: 'pings',
			creator: 'creator',
			fullname: 'author',
			profileURL: 'profile_url',
			profilePictureURL: 'profile_picture_url',
			isNew: 'is_new',
			createdByAdmin: 'created_by_admin',
			createdByCurrentUser: 'created_by_current_user',
			upvoteCount: 'upvote_count',
			userHasUpvoted: 'user_has_upvoted'
		},
	});
}

/* -------------------------------------------------------------------------- */