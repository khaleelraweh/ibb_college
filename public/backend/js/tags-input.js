// npm package: jquery-tags-input
// github link: https://github.com/xoxco/jQuery-Tags-Input

$(function() {
  'use strict';

  $('#tags').tagsInput({
    'width': '100%',
    'height': '75%',
    'interactive': true,
    'defaultText': 'Add More',
    'removeWithBackspace': true,
    'minChars': 0,
    'maxChars': 20,
    'placeholderColor': '#666666'
  });

  $('#tags1').tagsInput({
    'width': '100%',
    'height': '75%',
    'interactive': true,
    'defaultText': 'اضافة اكثر',
    'removeWithBackspace': true,
    'minChars': 0,
    'maxChars': 20,
    'placeholderColor': '#666666'
  });
  
  $('#tags2').tagsInput({
    'width': '100%',
    'height': '75%',
    'interactive': true,
    'defaultText': 'Add More',
    'removeWithBackspace': true,
    'minChars': 0,
    'maxChars': 20,
    'placeholderColor': '#666666'
  });

});