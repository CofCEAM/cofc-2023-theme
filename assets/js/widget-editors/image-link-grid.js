var mediaButtonChangeImageHandler = null;
var removeLinkFromImageLinkGridList = null;
var addLinkToImageLinkGridList = null;
jQuery(document).ready(function ($) {
  removeLinkFromImageLinkGridList = ({ button = null }) => {
    button.parentElement.parentElement.remove();
  };

  mediaButtonChangeImageHandler = (btn) => {
    var mediaUrlInputId = btn.dataset.mediaUrlInputId;
    var mediaAltInputId = btn.dataset.mediaAltInputId;

    // escape the square brackets in the IDs
    mediaUrlInputId = mediaUrlInputId.replace(/\[/g, "\\[").replace(/\]/g, "\\]");
    mediaAltInputId = mediaAltInputId.replace(/\[/g, "\\[").replace(/\]/g, "\\]");

    const $urlInput = jQuery(`#${mediaUrlInputId}`);
    const $altInput = jQuery(`#${mediaAltInputId}`);

    frame = wp.media({
      title: "Custom Image",
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
  };

  addLinkToImageLinkGridList = ({ button = null, linksFieldName = "links", linksFieldId = "link" }) => {
    const currentLinkCount =
      button.parentElement.parentElement.parentElement.querySelectorAll(".image-grid-link").length;

    // add a new link to a Rail Link List widget in the admin view when add link is clicked
    let link = document.createElement("div");
    link.classList.add("image-grid-link");
    const newLinkFriendlyIndex = currentLinkCount + 1;
    const newLinkIndex = currentLinkCount;

    const linkHeading = document.createElement("h3");
    linkHeading.textContent = `Link ${newLinkFriendlyIndex}`;
    link.appendChild(linkHeading);

    const label1 = document.createElement("label");
    label1.setAttribute("for", `${linksFieldName}[${newLinkIndex}][label]`);
    label1.textContent = "Link Label";
    const input1 = document.createElement("input");
    input1.classList.add("widefat");
    input1.setAttribute("type", "text");
    input1.setAttribute("name", `${linksFieldName}[${newLinkIndex}][label]`);
    input1.required = true;
    input1.setAttribute("value", "");
    const div1 = document.createElement("div");
    div1.style.display = "block";
    div1.appendChild(label1);
    div1.appendChild(input1);

    const label2 = document.createElement("label");
    label2.setAttribute("for", `${linksFieldName}[${newLinkIndex}][url]`);
    label2.textContent = "Link URL";
    const input2 = document.createElement("input");
    input2.setAttribute("type", "url");
    input2.required = true;
    input2.classList.add("widefat");
    input2.setAttribute("name", `${linksFieldName}[${newLinkIndex}][url]`);
    input2.setAttribute("value", "");
    const div2 = document.createElement("div");
    div2.style.display = "block";
    div2.appendChild(label2);
    div2.appendChild(input2);

    const label3_1 = document.createElement("label");
    label3_1.setAttribute("for", `${linksFieldId}[${newLinkIndex}][new_tab]-yes`);
    label3_1.textContent = "New Tab";
    const input3_1 = document.createElement("input");
    input3_1.setAttribute("type", "radio");
    input3_1.classList.add("widefat");
    input3_1.setAttribute("checked", "checked");
    input3_1.setAttribute("name", `${linksFieldName}[${newLinkIndex}][new_tab]`);
    input3_1.setAttribute("value", "yes");
    input3_1.id = `${linksFieldId}[${newLinkIndex}][new_tab]-yes`;

    const label3_2 = document.createElement("label");
    label3_2.setAttribute("for", `${linksFieldId}[${newLinkIndex}][new_tab]-no`);
    label3_2.textContent = "Same Tab";
    const input3_2 = document.createElement("input");
    input3_2.setAttribute("type", "radio");
    input3_2.classList.add("widefat");
    input3_2.setAttribute("name", `${linksFieldName}[${newLinkIndex}][new_tab]`);
    input3_2.setAttribute("value", "no");
    input3_2.setAttribute("checked", "checked");
    input3_2.id = `${linksFieldId}[${newLinkIndex}][new_tab]-no`;

    const div3 = document.createElement("div");
    div3.style.display = "block";
    div3.appendChild(label3_1);
    div3.appendChild(input3_1);
    div3.appendChild(label3_2);
    div3.appendChild(input3_2);

    const divMedia = document.createElement("div");
    divMedia.classList.add("media-field");
    const mediaLabel = document.createElement("label");
    mediaLabel.setAttribute("for", `${linksFieldName}[${newLinkIndex}][media_url]`);
    mediaLabel.textContent = "Featured Image (best to use a 339x400 image for design consistency)";
    divMedia.appendChild(mediaLabel);

    // input for media URL
    const mediaField = document.createElement("input");
    mediaField.classList.add("widefat");
    mediaField.setAttribute("type", "url");
    // required
    mediaField.required = true;
    mediaField.id = `${linksFieldId}[${newLinkIndex}][media_url]`;
    mediaField.name = `${linksFieldName}[${newLinkIndex}][media_url]`;
    mediaField.value = "";

    divMedia.appendChild(mediaField);

    // hidden input for media alt text
    const hiddenMediaAlt = document.createElement("input");
    hiddenMediaAlt.type = "hidden";
    hiddenMediaAlt.name = `${linksFieldName}[${newLinkIndex}][media_alt]`;
    hiddenMediaAlt.value = "";
    hiddenMediaAlt.id = `${linksFieldId}[${newLinkIndex}][media_alt]`;
    divMedia.appendChild(hiddenMediaAlt);

    // button to open media library
    const mediaButton = document.createElement("button");
    ["media-upload-button", "components-button", "is-primary"].forEach((clsName) => {
      mediaButton.classList.add(clsName);
    });
    mediaButton.dataset.target = `#${linksFieldName}[${newLinkIndex}][media_url]`;
    mediaButton.textContent = "Select Image";
    mediaButton.dataset.mediaUrlInputId = mediaField.id;
    mediaButton.dataset.mediaAltInputId = hiddenMediaAlt.id;
    mediaButton.type = "button";

    divMedia.appendChild(mediaButton);
    // clicking this button should open the media library and allow you to select an image
    // which should then populate the mediaInput field with the URL of the image
    mediaButton.addEventListener("click", (e) => {
      mediaButtonChangeImageHandler(e.target);
    });

    const div6 = document.createElement("div");
    div6.classList.add("text-center");

    const removeLinkbutton = document.createElement("button");
    removeLinkbutton.setAttribute("type", "button");
    removeLinkbutton.classList.add("remove_link");
    removeLinkbutton.classList.add("components-button");
    removeLinkbutton.classList.add("is-secondary");
    removeLinkbutton.textContent = `Remove Link ${newLinkFriendlyIndex}`;
    removeLinkbutton.addEventListener("click", () => {
      removeLinkFromImageLinkGridList({ button: removeLinkbutton });
    });
    div6.appendChild(removeLinkbutton);

    link.appendChild(div1);
    link.appendChild(div2);
    link.appendChild(div3);
    link.appendChild(divMedia);
    link.appendChild(div6);

    const container = button.parentElement.parentElement;

    container.appendChild(link);
  };
});
