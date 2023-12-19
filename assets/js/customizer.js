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
  ["facebook", "twitter", "linkedin", "youtube", "instagram", "email", "rss"].forEach((social) => {
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
          document.querySelector(railQuery).style.display = "flex";
          document.querySelector(`${railQuery} > a`).href = newval;
        }
      });
    });
  });
})(jQuery);
