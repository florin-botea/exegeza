// essentials
import ClassicEditorBase from '@ckeditor/ckeditor5-editor-classic/src/classiceditor';
import ClassicEditor from '@ckeditor/ckeditor5-editor-classic/src/classiceditor';
import EssentialsPlugin from '@ckeditor/ckeditor5-essentials/src/essentials';
import AutoformatPlugin from '@ckeditor/ckeditor5-autoformat/src/autoformat';
// text format
import Title from '@ckeditor/ckeditor5-heading/src/title';
import Font from '@ckeditor/ckeditor5-font/src/font';
import BoldPlugin from '@ckeditor/ckeditor5-basic-styles/src/bold';
import Indent from '@ckeditor/ckeditor5-indent/src/indent';
import ItalicPlugin from '@ckeditor/ckeditor5-basic-styles/src/italic';
import HeadingPlugin from '@ckeditor/ckeditor5-heading/src/heading';
import Underline from '@ckeditor/ckeditor5-basic-styles/src/underline';
import Subscript from '@ckeditor/ckeditor5-basic-styles/src/subscript';
import Code from '@ckeditor/ckeditor5-basic-styles/src/code';
import Strikethrough from '@ckeditor/ckeditor5-basic-styles/src/strikethrough';
import LinkPlugin from '@ckeditor/ckeditor5-link/src/link';
import ListPlugin from '@ckeditor/ckeditor5-list/src/list';
import ParagraphPlugin from '@ckeditor/ckeditor5-paragraph/src/paragraph';
import Superscript from '@ckeditor/ckeditor5-basic-styles/src/superscript';
import Highlight from '@ckeditor/ckeditor5-highlight/src/highlight';

import HorizontalLine from '@ckeditor/ckeditor5-horizontal-line/src/horizontalline';
import ContextualBalloonPlugin from '@ckeditor/ckeditor5-ui/src/panel/balloon/contextualballoon';
import SimpleUploadAdapter from '@ckeditor/ckeditor5-upload/src/adapters/simpleuploadadapter';
import EasyImage from '@ckeditor/ckeditor5-easy-image/src/easyimage';
import ImageCaption from '@ckeditor/ckeditor5-image/src/imagecaption';
import ImageStyle from '@ckeditor/ckeditor5-image/src/imagestyle';
import ImageResize from '@ckeditor/ckeditor5-image/src/imageresize';
import ImageToolbar from '@ckeditor/ckeditor5-image/src/imagetoolbar';
// import MathType from '@wiris/mathtype-ckeditor5';
// import ChemType from '@wiris/mathtype-ckeditor5';
import PageBreak from '@ckeditor/ckeditor5-page-break/src/pagebreak';
import PasteFromOffice from '@ckeditor/ckeditor5-paste-from-office/src/pastefromoffice';
import RemoveFormat from '@ckeditor/ckeditor5-remove-format/src/removeformat';
import Table from '@ckeditor/ckeditor5-table/src/table';
import TableToolbar from '@ckeditor/ckeditor5-table/src/tabletoolbar';
import Alignment from '@ckeditor/ckeditor5-alignment/src/alignment';
import MediaEmbed from '@ckeditor/ckeditor5-media-embed/src/mediaembed';

// export default class ClassicEditor extends ClassicEditorBase {}

// Plugins to include in the build.
ClassicEditor.builtinPlugins = [
	EssentialsPlugin,
	AutoformatPlugin,
	BoldPlugin,
	ItalicPlugin,
	HeadingPlugin,
	LinkPlugin,
	ListPlugin,
	ParagraphPlugin,
	SimpleUploadAdapter,
	EasyImage,
	ImageCaption,
	ImageStyle,
	ImageResize,
	ImageToolbar,
	Underline,
	Subscript,
	Code,
	Strikethrough,
	Superscript,
	Indent,
	//Title,
	Font,
	Highlight,
	HorizontalLine,
	PageBreak,
	PasteFromOffice,
	RemoveFormat,
	Table,
	TableToolbar,
	Alignment,
	MediaEmbed,
	// MathType,
	// ChemType,
	// ContextualBalloonPlugin

	// MyCustomUploadAdapterPlugin,
];

ClassicEditor.defaultConfig = {
	toolbar: [
		"undo", "|", "redo",
		"heading", "fontFamily", "fontSize",// "|",
		"bold", "italic", "underline", "strikethrough", "superscript", "subscript", "removeFormat",// "|",
		"fontColor", "fontBackgroundColor", "highlight",// "|",
		"numberedList", "bulletedList",// "|",
		"indent", "outdent", "alignment", "insertTable", "code",// "|",
		"link",
		"imageUpload",
		"mediaEmbed",
		"horizontalLine",
		"pageBreak",
		// "MathType",
		// "ChemType"
	],
	// title: {
	// placeholder: 'Title here...'
	// },
	highlight: {
		options: [
			{
				model: 'greenMarker',
				class: 'marker-green',
				title: 'Green marker',
				color: 'var(--ck-highlight-marker-green)',
				type: 'marker'
			},
			{
				model: 'redPen',
				class: 'pen-red',
				title: 'Red pen',
				color: 'var(--ck-highlight-pen-red)',
				type: 'pen'
			}
		]
	},
	table: {
		contentToolbar: ['tableColumn', 'tableRow', 'mergeTableCells']
	},
	image: {
		// You need to configure the image toolbar, too, so it uses the new style buttons.
		toolbar: ['imageTextAlternative', '|', 'imageStyle:alignLeft', 'imageStyle:full', 'imageStyle:alignRight'],

		styles: [
			// This option is equal to a situation where no style is applied.
			'full',

			// This represents an image aligned to the left.
			'alignLeft',

			// This represents an image aligned to the right.
			'alignRight'
		]
	},
	// This value must be kept in sync with the language defined in webpack.config.js.
	language: 'en',
	simpleUpload: {
		// The URL that the images are uploaded to.
		uploadUrl: '/upload-photo',

		// Headers sent along with the XMLHttpRequest to the upload server.
		headers: {
			'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content || (console.error('Set csrf token in meta')), //'CSFR-Token'
			Authorization: 'Bearer <JSON Web Token>'
		}
	},
	// cloudServices: {
	// tokenUrl: document.querySelector('meta[name="csrf-token"]').content,
	// uploadUrl: 'https://your-organization-id.cke-cs.com/easyimage/upload/'
	// }
};

$('.ckeditor-classic').each(function (i, el) {
	ClassicEditor
		.create(el)
		.then(editor => {
			el.style.display = 'none';
		})
		.catch(error => {
			console.error(error);
		});
});