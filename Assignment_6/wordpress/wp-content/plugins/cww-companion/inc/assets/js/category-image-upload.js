jQuery(document).ready(function($) {
  var file_frame;
  var wp_media_post_id = wp.media.model.settings.post.id;
  var set_to_post_id = 0;

  $('#category-image-upload-button').on('click', function(event) {
      event.preventDefault();

      if (file_frame) {
          file_frame.uploader.uploader.param('post_id', set_to_post_id);
          file_frame.open();
          return;
      } else {
          wp.media.model.settings.post.id = set_to_post_id;
      }

      file_frame = wp.media.frames.file_frame = wp.media({
          title: 'Select an image to upload',
          button: {
              text: 'Use this image',
          },
          multiple: false
      });

      file_frame.on('select', function() {
          var attachment = file_frame.state().get('selection').first().toJSON();
          $('#category-image-id').val(attachment.id);
          $('#category-image-wrapper').html('<img src="' + attachment.url + '" style="max-width:100%;"/>');

          wp.media.model.settings.post.id = wp_media_post_id;
      });

      file_frame.open();
  });

  $('#category-image-remove-button').on('click', function() {
      $('#category-image-id').val('');
      $('#category-image-wrapper').html('');
  });

  $('a.add_media').on('click', function() {
      wp.media.model.settings.post.id = wp_media_post_id;
  });
});
