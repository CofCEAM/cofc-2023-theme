var TEMPLATE_METABOX_MAP = [
  {
    filename: "news_aggregate.php",
    display_name: "Filterable News Aggregate",
    metaboxes: [
      "news_aggregate_info_meta_box",
      "news_aggregate_filterable_category_ids_meta_box",
      "news_aggregate_filterable_tag_ids_meta_box",
      "news_aggregate_filterable_years_meta_box",
      "news_aggregate_filter_headline_meta_box",
    ],
  },

  {
    filename: "prefiltered_news_aggregate.php",
    display_name: "Prefiltered News Aggregate",
    metaboxes: [
      "prefiltered_news_aggregate_info_meta_box",
      "prefiltered_news_aggregate_info_meta_box",
      "prefiltered_news_aggregate_category_ids_meta_box",
      "prefiltered_news_aggregate_tag_ids_meta_box",
      "prefiltered_news_aggregate_years_meta_box",
    ],
  },

  {
    filename: "podcast_aggregate.php",
    display_name: "Podcast Aggregate",
    metaboxes: [
      "podcast_aggregate_info_meta_box",
      "podcast_aggregate_filterable_category_ids_meta_box",
      "podcast_aggregate_filterable_tag_ids_meta_box",
      "podcast_aggregate_filterable_years_meta_box",
      "podcast_aggregate_filter_headline_meta_box",
      "podcast_aggregate_podcast_main_filter_meta_box",
    ],
  },
];

jQuery(document).ready(function ($) {
  const getTemplateName = async () => {
    return new Promise((resolve, reject) => {
      var template = $(".edit-post-post-template__form select").val();
      if (template === undefined) {
        template = $("div.edit-post-post-template button").text();
      }
      return resolve(template);
    });
  };

  function toggleMetaBoxes({ templateName = null }) {
    TEMPLATE_METABOX_MAP.forEach((template) => {
      if (template.display_name === templateName || template.filename === templateName) {
        // Show your custom meta boxes
        template.metaboxes.forEach((metabox) => {
          $(`#${metabox}`).show();
        });
      } else {
        // Hide your custom meta boxes
        template.metaboxes.forEach((metabox) => {
          $(`#${metabox}`).hide();
        });
      }
    });
  }

  // Run on page load
  setTimeout(() => {
    getTemplateName()
      .then((template) => {
        toggleMetaBoxes({ templateName: template });
        // if button exists

        try {
          document.querySelector("div.edit-post-post-template button").addEventListener("click", () => {
            // now the select element is present so you can add a listener to it
            // wait for .edit-post-post-template__form select to be added to the DOM
            setTimeout(() => {
              document.querySelector(".edit-post-post-template__form select").addEventListener("change", () => {
                getTemplateName()
                  .then((template) => {
                    toggleMetaBoxes({ templateName: template });
                  })
                  .catch((e) => console.error(e));
              });
            }, 1000);
          });
        } catch (error) {
          console.log(error);
        }
      })
      .catch((e) => console.error(e));
  }, 1000);
});

const updateMainFilterValueSelector = ({ filterType = null }) => {
  const categories_json_input = document.querySelector("#podcast_aggregate_categories_json");
  const tags_json_input = document.querySelector("#podcast_aggregate_tags_json");
  const valueSelector = document.querySelector("#podcast_aggregate_podcast_main_filter_value");
  // clear options from select element
  valueSelector.innerHTML = "";
  const decodeHtml = (html) => {
    var txt = document.createElement("textarea");
    txt.innerHTML = html;
    return txt.value;
  };
  // used by podcast aggregate template's meta boxes
  if (filterType === "category") {
    // get all categories
    // populate the select element with the categories
    const categories = JSON.parse(decodeHtml(categories_json_input.value));
    categories.forEach((category) => {
      let option = document.createElement("option");
      option.value = category.term_id;
      option.text = category.name;
      valueSelector.add(option);
    });
  } else if (filterType === "tag") {
    // get all tags
    // populate the select element with the tags
    const tags = JSON.parse(decodeHtml(tags_json_input.value));

    tags.forEach((tag) => {
      let option = document.createElement("option");
      option.value = tag.term_id;
      option.text = tag.name;
      valueSelector.add(option);
    });
  }
};

const updateMainFilterValue = ({ filterValue = null }) => {
  const filterValueInput = document.querySelector("#podcast_aggregate_podcast_main_filter_value");
  filterValueInput.value = filterValue;
};
