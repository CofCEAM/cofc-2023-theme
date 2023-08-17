jQuery(document).ready(function ($) {
  // this function allows the select thumbnail button to work when editing the
  // cofc theme featured video widget in Appearance > Widgets > Featured Video Area
  $("body").on("click", "button.featured-video-thumbnail-upload-button", function (e) {
    e.preventDefault();
    // If the media frame already exists, reopen it.
    var frame;
    if (frame) {
      frame.open();
      return;
    }
    const $button = jQuery(this);
    const $urlInput = $button.siblings(".thumbnail-image-url-upload-input");
    const $altInput = $button.siblings(".thumbnail-image-alt-upload-input");
    frame = wp.media({
      title: "Select or Upload Image",
      library: {
        type: "image",
      },
      button: {
        text: "Select Image",
      },
      multiple: false,
    });

    // When an image is selected in the media frame...
    frame.on("select", function () {
      const attachment = frame.state().get("selection").first().toJSON();
      // need to trigger change events to these input fields to
      // re-enable the update button in top right,otherwise remains disabled
      $urlInput.val(attachment.url).change();
      $altInput.val(attachment.alt).change();
    });
    // Open the modal on click
    frame.open();
  });
});
