/* allow live reloading in preview environment */
(function ($) {
  let baseUrl = `${window.location.origin}/${window.location.pathname.split("/")[1]}`;

  wp.customize("header_background_color", function (value) {
    value.bind(function (newval) {
      // Update the header background color
      document.querySelector("div.header__identity").style.backgroundColor = newval;
    });
  });

  wp.customize("footer_background_color", function (value) {
    value.bind(function (newval) {
      // Update the footer background color
      document.querySelector(".footer__content").style.backgroundColor = newval;
    });
  });

  wp.customize("footer_bar_background_color", function (value) {
    value.bind(function (newval) {
      // Update the footer bar background color
      document.querySelector(".footer__bar").style.backgroundColor = newval;
    });
  });

  wp.customize("footer_bar_text_color", function (value) {
    value.bind(function (newval) {
      // Update the footer bar text color
      document.querySelectorAll(".footer__bar svg").forEach((el) => {
        el.style.color = newval;
      });
      document.querySelector(".footer__bar .footer__copyright").style.color = newval;
    });
  });

  wp.customize("footer_text_color", function (value) {
    value.bind(function (newval) {
      // Update the footer text color
      document.querySelector(".footer__content").style.color = newval;
      document.querySelectorAll(".footer__content a").forEach((el) => {
        el.style.color = newval;
      });
      document.querySelectorAll(".footer__content span.link-divider").forEach((el) => {
        el.style.backgroundColor = newval;
      });
    });
  });

  wp.customize("top_nav_text_color", function (value) {
    value.bind(function (newval) {
      // Update the footer text color
      document.querySelectorAll(".nav-primary li.nav-primary__item.menu-item span.text").forEach((el) => {
        el.style.color = newval;
      });
      document.querySelector(
        "#global-header > div.header__identity > div > div > div > button > svg.brei-icon.brei-icon-search"
      ).style.color = newval;
    });
  });

  // site_logo
  wp.customize("site_logo", function (value) {
    value.bind(function (newval) {
      // new val is image ID, need source
      fetch(`${baseUrl}/wp-json/wp/v2/media/${newval}`)
        .then((response) => response.json())
        .then((data) => data.source_url)
        .then((source_url) => {
          document.querySelector(".header__identity img").src = source_url;
          document.querySelector(".footer__content .footer__logo img").src = source_url;
        });
    });
  });

  wp.customize("primary_contact_name", function (value) {
    value.bind(function (newval) {
      document.querySelector("#primary-contact--name").innerHTML = newval;
    });
  });
  wp.customize("primary_contact_address", function (value) {
    value.bind(function (newval) {
      document.querySelector("#primary-contact--address").innerHTML = newval;
    });
  });
  wp.customize("primary_contact_phone", function (value) {
    value.bind(function (newval) {
      document.querySelector("#primary-contact--phone").innerHTML = newval;
    });
  });
  wp.customize("primary_contact_email", function (value) {
    value.bind(function (newval) {
      document.querySelector("#primary-contact--email").innerHTML = newval;
    });
  });

  // facebook, twitter, linkedin, youtube, instagram, email, rss
  ["facebook", "twitter", "linkedin", "youtube", "instagram", "tiktok", "email", "rss"].forEach((social) => {
    wp.customize(`${social}`, function (value) {
      value.bind(function (newval) {
        // update footer social links
        let footerQuery = `#social-media-footer-link-${social}`;
        if (newval === "") {
          document.querySelector(footerQuery).style.display = "none";
        } else {
          document.querySelector(footerQuery).style.display = "inline-flex";
          document.querySelector(`${footerQuery} > a`).href = newval;
        }

        let railQuery = `#social-media-widget-link-${social}`;
        if (newval === "") {
          document.querySelector(railQuery).style.display = "none";
        } else {
          document.querySelector(`${railQuery} > a`).href = newval;
        }
      });
    });
  });

  wp.customize("display_page_date", function (value) {
    value.bind(function (newval) {
      if (newval === "yes") {
        document.querySelector(".article-header__data.page__date").style.display = "block";
      } else {
        document.querySelector(".article-header__data.page__date").style.display = "none";
      }
    });
  });
  wp.customize("display_page_byline", function (value) {
    value.bind(function (newval) {
      if (newval === "yes") {
        document.querySelector(".article-header__data.page__byline").style.display = "block";
      } else {
        document.querySelector(".article-header__data.page__byline").style.display = "none";
      }
    });
  });
  wp.customize("display_page_excerpt", function (value) {
    value.bind(function (newval) {
      if (newval === "yes") {
        document.querySelector(".article-header__intro.page__excerpt").style.display = "block";
      } else {
        document.querySelector(".article-header__intro.page__excerpt").style.display = "none";
      }
    });
  });

  wp.customize("display_post_date", function (value) {
    value.bind(function (newval) {
      if (newval === "yes") {
        document.querySelector(".article-header__data.post__date").style.display = "block";
      } else {
        document.querySelector(".article-header__data.post__date").style.display = "none";
      }
    });
  });
  wp.customize("display_post_byline", function (value) {
    value.bind(function (newval) {
      if (newval === "yes") {
        document.querySelector(".article-header__data.post__byline").style.display = "block";
      } else {
        document.querySelector(".article-header__data.post__byline").style.display = "none";
      }
    });
  });

  wp.customize("display_post_excerpt", function (value) {
    value.bind(function (newval) {
      if (newval === "yes") {
        document.querySelector(".article-header__intro.post__excerpt").style.display = "block";
      } else {
        document.querySelector(".article-header__intro.post__excerpt").style.display = "none";
      }
    });
  });

  wp.customize("display_post_categories_list", function (value) {
    value.bind(function (newval) {
      if (newval === "yes") {
        document.querySelector(".article-header__data.post__categories-list").style.display = "block";
      } else {
        document.querySelector(".article-header__data.post__categories-list").style.display = "none";
      }
    });
  });

  ["spotify", "apple", "iheart", "stitcher", "google"].forEach((platform) => {
    let key = `podcast_platform__${platform}`;
    wp.customize(key, function (value) {
      value.bind(function (newval) {
        let elem = document.querySelector(`.rail-podcast__item.${key}`);
        if (newval === "") {
          elem.style.display = "none";
        } else {
          elem.style.display = "block";
          elem.querySelector("a").href = newval;
        }
      });
    });
  });
})(jQuery);
