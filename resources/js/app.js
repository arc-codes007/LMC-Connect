/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Croppie = require('croppie');
window.alertify = require('alertifyjs');
// window.Vue = require('vue').default;

// Vue.component('example-component', require('./components/ExampleComponent.vue').default);

// const app = new Vue({
//     el: '#app',
// });

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(function () {
    $('[data-toggle="tooltip"]').tooltip()
  })


  require('tinymce');
  require('tinymce/themes/silver');
  require('tinymce/icons/default');
  require('tinymce/plugins/paste');
  require('tinymce/plugins/advlist');
  require('tinymce/plugins/autolink');
  require('tinymce/plugins/lists');
  require('tinymce/plugins/link');
  require('tinymce/plugins/image');
  require('tinymce/plugins/charmap');
  require('tinymce/plugins/print');
  require('tinymce/plugins/preview');
  require('tinymce/plugins/anchor');
  require('tinymce/plugins/textcolor');
  require('tinymce/plugins/searchreplace');
  require('tinymce/plugins/visualblocks');
  require('tinymce/plugins/code');
  require('tinymce/plugins/fullscreen');
  require('tinymce/plugins/insertdatetime');
  require('tinymce/plugins/media');
  require('tinymce/plugins/table');
  require('tinymce/plugins/contextmenu');
  require('tinymce/plugins/code');
  require('tinymce/plugins/help');
  require('tinymce/plugins/wordcount');
  require('tinymce/plugins/autoresize');

  $( document ).ready(function() {
    tinymce.init({
        selector: ".tiny",
        // height: 300,
        menubar: false,
        inline: false,
        plugins: [
            'advlist autolink lists link image charmap print preview anchor',
            'searchreplace visualblocks code fullscreen',
            'insertdatetime media table paste code help wordcount',
            'autoresize'
        ],
        autoresize_on_init: true,
        toolbar: 'insert | undo redo |  formatselect | bold italic backcolor  | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help',
        branding: false,
    });
});