jQuery(document).ready(function () {
  jQuery("#mc_embed_shell").addClass("email-request");
  jQuery("#mc_embed_signup").addClass("wrapper");
  jQuery("#mc_embed_signup form").wrap('<div class="email-request__content"></div>');
  var header = jQuery("#mc_embed_signup form h2");
  header.replaceWith("<h1>" + $(header).text() + "</h1>");
  jQuery("#mc_embed_signup form").find("div.indicates-required").remove();
  jQuery("#mc_embed_signup form .mc-field-group").addClass("form__field");
  jQuery("#mc_embed_signup form .mc-field-group label").each((el) => {
    let asterisk = $(el).find("span.asterisk");
    console.log(asterisk);
    if (asterisk) {
      $(asterisk).replaceWith('<sup class="required" aria-label="Required">*</sup>');
    }
    $(el).insertAfter(
      `<div class="form__valid-icon">
            <svg class="brei-icon brei-icon-check" focusable="false">
                <use href="#brei-icon-check"></use>
            </svg>
        </div>
        <div class="form__error-icon">
            <svg class="brei-icon brei-icon-warning" focusable="false">
                <use href="#brei-icon-warning"></use>
            </svg>
        </div>
        <div class="form__error-message">Field is required</div>`
    );
  });
  jQuery("#mc_embed_signup form input[type=submit]").addClass("btn btn--primary");
});
