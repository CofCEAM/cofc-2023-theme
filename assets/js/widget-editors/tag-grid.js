const createTagSpecificField = ({ tag, form }) => {
  const { term_id, name, media_url, media_alt, label } = tag;
  const tagSpecificField = document.createElement("div");
  tagSpecificField.classList.add("tag-specific-field");
  tagSpecificField.dataset.termId = term_id;
  tagSpecificField.dataset.tagName = name;
  tagSpecificField.id = "tag-" + term_id + "-details";

  const tagHeader = document.createElement("h4");
  tagHeader.textContent = "Tag: " + name;
  tagSpecificField.appendChild(tagHeader);

  const mediaField = document.createElement("div");
  mediaField.classList.add("media-field");
  const mediaLabel = document.createElement("label");
  mediaLabel.setAttribute("for", "media-field-for-tag-" + term_id);
  mediaLabel.textContent = "Featured Image (best to use a 339x400 image for design consistency)";
  mediaField.appendChild(mediaLabel);

  const mediaInput = document.createElement("input");
  mediaInput.classList.add("widefat");
  mediaInput.id = "media-field-for-tag-" + term_id;
  mediaInput.name = "media-field-for-tag-" + term_id;
  mediaInput.value = media_url === undefined ? "" : media_url;
  mediaField.appendChild(mediaInput);

  const hiddenMediaAlt = document.createElement("input");
  hiddenMediaAlt.type = "hidden";
  hiddenMediaAlt.name = "media-field-for-tag-" + term_id + "-alt";
  hiddenMediaAlt.value = media_alt === undefined ? "" : media_alt;
  mediaField.appendChild(hiddenMediaAlt);

  const mediaButton = document.createElement("button");
  ["media-upload-button", "components-button", "is-primary"].forEach((clsName) => {
    mediaButton.classList.add(clsName);
  });
  mediaButton.dataset.target = "#media-field-for-tag-" + term_id;
  mediaButton.textContent = "Upload";
  mediaField.appendChild(mediaButton);
  // clicking this button should open the media library and allow you to select an image
  // which should then populate the mediaInput field with the URL of the image
  mediaButton.addEventListener("click", (e) => {
    e.preventDefault();
    var custom_uploader = wp
      .media({
        title: "Custom Image",
        button: {
          text: "Select Image",
        },
        multiple: false, // Set this to true to allow multiple files to be selected
      })

      .on("select", function () {
        var attachment = custom_uploader.state().get("selection").first().toJSON();
        mediaInput.value = attachment.url;
        hiddenMediaAlt.value = attachment.alt;

        // update the selectedTags JSON in the hidden field
        let selectedTags = getHiddenPostTagsJson({ form });
        selectedTags = selectedTags.map((tag) => {
          if (tag.term_id === term_id) {
            return {
              ...tag,
              media_url: attachment.url,
              media_alt: attachment.alt,
            };
          }
          return tag;
        });
        updateHiddenPostTagsJson({ selectedTags, form: form });
      })
      .open();
  });

  tagSpecificField.appendChild(mediaField);
  const labelField = document.createElement("div");
  labelField.classList.add("label-field");
  const labelLabel = document.createElement("label");
  labelLabel.setAttribute("for", "label-field-for-tag-" + term_id);
  labelLabel.textContent = "Label";
  labelField.appendChild(labelLabel);

  const labelInput = document.createElement("input");
  labelInput.classList.add("widefat");
  labelInput.id = "label-field-for-tag-" + term_id;
  labelInput.name = "label-field-for-tag-" + term_id;
  labelInput.value = label === undefined ? "" : label;
  labelInput.addEventListener("change", (e) => {
    // update the selectedTags JSON in the hidden field
    let selectedTags = getHiddenPostTagsJson({ form });
    selectedTags = selectedTags.map((tag) => {
      if (tag.term_id === term_id) {
        return {
          ...tag,
          label: e.target.value,
        };
      }
      return tag;
    });
    updateHiddenPostTagsJson({ selectedTags, form: form });
  });
  labelField.appendChild(labelInput);
  tagSpecificField.appendChild(labelField);
  return tagSpecificField;
};

const updateTagDetailsArea = ({ selectedTags, form }) => {
  console.log("updateTagDetailsArea");
  console.log("selectedTags", selectedTags);

  var tagDetailsContainer = form.querySelector("#selected-tag-details-container");
  selectedTags.forEach((tag) => {
    // Check if fields for this tag already exist, if not, add them
    if (form.querySelector(`#tag-${tag.term_id}-details`) === null) {
      // Add media and text fields for this tag
      const tagSpecificField = createTagSpecificField({ tag, form: form });
      console.log("tagSpecificField", tagSpecificField);
      tagDetailsContainer.append(tagSpecificField);
    }
  });
  // Remove fields for unselected tags
  form.querySelectorAll(".tag-specific-field").forEach((el) => {
    const fieldTagId = el.dataset.termId;
    if (selectedTags.filter((tag) => tag.term_id === fieldTagId).length === 0) {
      console.log("selectedTags.filter((tag) => tag.term_id === fieldTagId).length === 0");
      console.log("tag", tag);
      console.log("fieldTagId", fieldTagId);
      console.log("removing", el);

      // Remove media and text fields for this tag
      el.remove();
    }
  });
};

const tagSelectionChangeHandler = (e) => {
  var selectedTags = [];
  // get parent form
  var form = e.target.closest("form");
  var options = e.target.options;
  for (var i = 0; i < options.length; i++) {
    if (options[i].selected) {
      const tagName = options[i].dataset.tagName;
      const tagId = options[i].value;
      const tagLabel = options[i].dataset.tagLabel;
      const tagDescription = options[i].dataset.tagDescription;
      const tagSlug = options[i].dataset.tagSlug;
      selectedTags.push({
        term_id: tagId,
        label: tagLabel,
        name: tagName,
        description: tagDescription,
        slug: tagSlug,
      });
    }
  }
  updateTagDetailsArea({ selectedTags, form: form });
  updateHiddenPostTagsJson({ selectedTags, form: form });
};

const decodeHtml = (html) => {
  var txt = document.createElement("textarea");
  txt.innerHTML = html;
  return txt.value;
};

const encodeHtml = (str) => {
  var txt = document.createElement("textarea");
  txt.textContent = str;
  return txt.innerHTML;
};

const getHiddenPostTagsJson = ({ form }) => {
  var hiddenPostTags = form.querySelector(".post_tags_json");
  try {
    const encodedJson = hiddenPostTags.value;
    const decodedJson = decodeHtml(encodedJson);
    const postTags = JSON.parse(decodedJson);
    return postTags;
  } catch (e) {
    return [];
  }
};

const updateHiddenPostTagsJson = ({ form, selectedTags }) => {
  var hiddenPostTags = form.querySelector(".post_tags_json");
  const stringified = JSON.stringify(selectedTags);
  const encoded = encodeHtml(stringified);
  // escape quotes
  hiddenPostTags.value = encoded;
};

// initialize as well whenever the widget is opened
jQuery(document).ready(function ($) {
  // wait 3 seconds for the widget to load...
  setTimeout(() => {
    // initialize the form with the current selected tags
    document.querySelectorAll("div.tag-grid-widget-form-container").forEach((form) => {
      let selectedTags = getHiddenPostTagsJson({ form });
      updateTagDetailsArea({ selectedTags, form: form });
    });
  }, 3000);
});
