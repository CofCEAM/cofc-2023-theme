!(function () {
  "use strict";
  window.matchMedia("(min-width: 400px)"),
    window.matchMedia("(min-width: 768px)"),
    window.matchMedia("(min-width: 1024px)"),
    window.matchMedia("(min-width: 1200px)"),
    window.matchMedia("(min-width: 1440px)"),
    window.matchMedia("(min-width: 1920px)");
  const e = function (e) {
    "loading" !== document.readyState
      ? e()
      : document.addEventListener
      ? document.addEventListener("DOMContentLoaded", e, !1)
      : document.attachEvent("onreadystatechange", function () {
          "complete" === document.readyState && e();
        });
  };
  Object.assign;
  var t = {
    elem: {
      $checkboxes: $(".filter__content"),
      $chips: $("#results_chips"),
      $keywords: $(".filter-keyword"),
      $pagination: $(".pagination"),
      $reset: $(".aggregate__reset"),
      $results: $(".aggregate__results"),
      $selects: $(".filter-selectbox"),
    },
    dataSource: null,
    filters: {},
    initial: !0,
    results: "",
    suggestions: "",
    init: function () {
      (this.dataSource = this.elem.$results.data("src")),
        this.buildFilters(),
        this.getQuery(),
        this.setControls(),
        this.buildChips(),
        this.setQuery(!1, !1),
        (window.onpopstate = this.filterState),
        this.elem.$reset.on("click", this.filterReset);
    },
    bindUIActions: function () {
      this.elem.$checkboxes.find("input").on("change", this.filterCheckbox),
        this.elem.$keywords.find("button").on("click", this.filterKeyword),
        this.elem.$keywords.find("input").on("keydown", this.filterKeyword),
        this.elem.$selects.find("select").on("change", this.filterSelect);
    },
    unbindUIActions: function () {
      this.elem.$checkboxes.find("input").off("change"),
        this.elem.$keywords.find("button").off("click"),
        this.elem.$selects.find("select").off("change", this.filterSelect);
    },
    addChip: function (e, i) {
      var n =
        '<a href="#' +
        e +
        '" class="chip"><span class="chip__close"><span class="show-for-sr">Remove this filter</span><svg class="brei-icon brei-icon-close" focusable="false"><use href="#brei-icon-close"></use></svg></span><span class="chip__label">' +
        i +
        "</span></a>";
      $(".aggregate__chips").prepend(n), $('.chip[href="#' + e + '"]').on("click", t.unfilterChip);
    },
    removeChip: function (e) {
      $('.chip[href="#' + e + '"]').remove();
    },
    unfilterChip: function (e) {
      e.preventDefault();
      var i = e.currentTarget.hash,
        n = i.substr(1);
      "checkbox" === $(i)[0].type && $(i).trigger("click"),
        "search" === $(i)[0].type &&
          ($(e.currentTarget).remove(),
          ($(i)[0].value = ""),
          (t.filters[n] = ""),
          (t.filters.pageindex = 0),
          t.setQuery(!0, !0)),
        "select" === $(i)[0].localName &&
          (($(i)[0].selectedIndex = -1),
          ($(i).siblings(".selectability").find('[role="textbox"]')[0].innerHTML = ""),
          $(i).trigger("change").removeClass("js-selectability--has-value"));
    },
    buildChips: function () {
      for (var e in t.filters) {
        var i = "#" + e,
          n = "";
        if (t.filters.hasOwnProperty(e))
          if (Array.isArray(t.filters[e])) {
            if (t.filters[e].length > 0)
              for (var a = 0; a < t.filters[e].length; a += 1) {
                var s = e + "-" + t.filters[e][a];
                (n = $("#" + s).siblings("label")[0].innerText), t.addChip(s, n);
              }
          } else
            "pageindex" !== e &&
              "pagesize" !== e &&
              "" !== t.filters[e] &&
              ("input" === $(i)[0].localName && (n = $(i)[0].value),
              "select" === $(i)[0].localName && (n = $(i)[0].options[$(i)[0].selectedIndex].text),
              t.addChip(e, n));
      }
    },
    buildFilters: function () {
      t.elem.$keywords.length > 0 && (t.filters.search = ""),
        t.elem.$checkboxes.length > 0 &&
          t.elem.$checkboxes.each(function () {
            t.filters[$(this).find("legend")[0].innerText] = [];
          }),
        t.elem.$keywords.length > 0 &&
          t.elem.$keywords.each(function () {
            t.filters[$(this).find("input")[0].id] = "";
          }),
        t.elem.$selects.length > 0 &&
          t.elem.$selects.each(function () {
            t.filters[$(this).find("select")[0].id] = "";
          }),
        (t.filters.pageindex = 0),
        (t.filters.pagesize = 10);
    },
    buildQuery: function () {
      var e = this.filters,
        t = [];
      for (var i in e)
        e.hasOwnProperty(i) &&
          (Array.isArray(i) && (e[i] = i.toString()), t.push(encodeURIComponent(i) + "=" + encodeURIComponent(e[i])));
      return (t = t.join("&").replace(/%2C/g, ","));
    },
    filterCheckbox: function (e) {
      var i = e.currentTarget.id.substring(0, e.currentTarget.id.indexOf("-")),
        n = e.currentTarget.value,
        a = $(e.currentTarget).siblings("label")[0].innerText;
      e.currentTarget.checked
        ? (t.addChip(i + "-" + n, a), t.filters[i].push(n))
        : (t.removeChip(i + "-" + n), t.filters[i].splice(t.filters[i].indexOf(n), 1)),
        (t.filters.pageindex = 0),
        t.setQuery(!0, !0);
    },
    filterKeyword: function (e) {
      var i = !1,
        n = "";
      if (
        ("keydown" === e.type && 13 === e.keyCode && ((n = $(e.currentTarget)[0].id), (i = !0)),
        "click" === e.type && ((n = $(e.currentTarget).siblings("input")[0].id), (i = !0)),
        i)
      ) {
        e.preventDefault();
        var a = "<span>" + $("#" + n)[0].value.trim() + "</span>",
          s = $(a).text();
        s.length > 0 &&
          (t.removeChip(n), t.addChip(n, s), (t.filters[n] = s), (t.filters.pageindex = 0), t.setQuery(!0, !0));
      }
    },
    filterPagination: function (e) {
      e.preventDefault(), (t.filters.pageindex = e.currentTarget.hash.substr(1)), t.setQuery(!0, !0);
    },
    filterReset: function () {
      t.unbindUIActions(),
        t.elem.$checkboxes.find("input").prop("checked", !1),
        t.elem.$keywords.find("input").val(""),
        t.elem.$selects.length > 0 &&
          ((t.elem.$selects.find("select")[0].selectedIndex = -1),
          t.elem.$selects.find("select").siblings(".selectability").find('[role="textbox"]').html(""),
          t.elem.$selects.find("select").removeClass("js-selectability--has-value")),
        $(".chip").remove(),
        t.buildFilters(),
        t.setQuery(!0, !0);
    },
    filterSelect: function (e) {
      e.preventDefault();
      var i = e.currentTarget.id,
        n = e.currentTarget.value;
      if ((t.removeChip(i), e.currentTarget.selectedIndex > -1)) {
        var a = e.currentTarget.options[e.currentTarget.selectedIndex].text;
        ($(e.currentTarget).siblings(".selectability").find('[role="textbox"]')[0].innerHTML = a), t.addChip(i, a);
      }
      (t.filters[i] = n), (t.filters.pageindex = 0), t.setQuery(!0, !0);
    },
    filterState: function () {
      t.getQuery(), t.setControls(), t.setQuery(!1, !1);
    },
    getData: function (e) {
      var i = $.Deferred();
      return (
        $.ajax({
          url: t.dataSource,
          method: "GET",
          data: e,
          dataType: "html",
          success: function (e) {
            i.resolve(e);
          },
          error: function (e, t, n) {
            console.log(e, n), i.reject(t);
          },
        }),
        i.promise()
      );
    },
    getQuery: function () {
      window.location.search.length > 0 &&
        new URLSearchParams(window.location.search).forEach(function (e, i) {
          "" !== e &&
            void 0 !== t.filters[i] &&
            (Array.isArray(t.filters[i])
              ? ((t.filters[i] = []), (e = e.split(",")), (t.filters[i] = e))
              : (t.filters[i] = e));
        });
    },
    renderCount: function () {
      var e = t.filters.pageindex * t.filters.pagesize + 1;
      e += "-";
      var i = t.filters.pageindex * t.filters.pagesize + 10;
      i > t.results[0].TotalCount && (i = t.results[0].TotalCount),
        (e += i),
        (e += " of "),
        (e += t.results[0].TotalCount),
        (e += " Results"),
        $(".aggregate__count").html(e);
    },
    renderPagination: function () {
      var e = [],
        i = t.filters,
        n = parseInt(i.pageindex),
        a = Math.ceil(parseInt(t.results[0].TotalCount) / parseInt(i.pagesize)) - 1,
        s = '<ul class="pagination__list clearfix" aria-label="Pagination">';
      e.push(0, n - 1, n, n + 1, a),
        n < 2 && e.push(2),
        n > a - 1 && e.push(a - 2),
        (e = (e = e.filter(function (e) {
          return e > -1;
        })).filter(function (e) {
          return e <= a;
        })).sort(function (e, t) {
          return e - t;
        }),
        (s += '<li class="pagination__item pagination__item--prev'),
        0 === n && (s += " pagination__item--disabled"),
        (s +=
          '"><a href="#' +
          (n - 1) +
          '" class="pagination__button btn btn--medium"><span class="btn__icon"><svg class="brei-icon brei-icon-chevron" focusable="false"><use href="#brei-icon-chevron"></use></svg></span><span class="show-for-sr">Previous Page</span></a></li>');
      for (var r = 0; r < e.length; r += 1)
        if (0 === r || e[r] !== e[r - 1])
          if (
            (r > 0 &&
              e[r] - e[r - 1] > 1 &&
              (s +=
                '<li class="pagination__item pagination__item--spacer"><span class="pagination__span">...</span></li>'),
            e[r] === n)
          )
            s +=
              '<li class="pagination__item pagination__item--active"><a href="#' +
              e[r] +
              '" class="pagination__link" tabindex="-1"><span class="show-for-sr">You\'re on page</span> ' +
              (e[r] + 1) +
              "</a></li>";
          else {
            var l = "";
            0 === r && (l = " pagination__item--first"),
              r === e.length - 1 && (l = " pagination__item--last"),
              (s +=
                '<li class="pagination__item' +
                l +
                '"><a href="#' +
                e[r] +
                '" class="pagination__link" aria-label="Page ' +
                (e[r] + 1) +
                '">' +
                (e[r] + 1) +
                "</a></li>");
          }
      (s += '<li class="pagination__item pagination__item--next'),
        n === a && (s += " pagination__item--disabled"),
        (s +=
          '"><a href="#' +
          (n + 1) +
          '" class="pagination__button btn btn--medium"><span class="btn__icon"><svg class="brei-icon brei-icon-chevron" focusable="false"><use href="#brei-icon-chevron"></use></svg></span><span class="show-for-sr">Previous Page</span></a></li></ul>'),
        $(".aggregate__pagination").html(s),
        $(".pagination__button, .pagination__link").on("click", t.filterPagination);
    },
    renderResults: function () {
      $(".aggregate__loading").hide(),
        !1 === t.initial && $(".aggregate__feature").empty(),
        t.results[0].TotalCount > 0
          ? (t.renderCount(),
            $(".aggregate__count").fadeIn(),
            $(".aggregate__results").html(t.results[0].Results).fadeIn(),
            t.results[0].TotalCount > t.filters.pagesize &&
              (t.renderPagination(), $(".aggregate__pagination").fadeIn()))
          : $(".aggregate__results").html('<p class="aggregate__none">No matching results were found.</p>').fadeIn(),
        (t.initial = !1);
    },
    setControls: function () {
      for (var e in (t.unbindUIActions(), t.elem.$checkboxes.find("input").prop("checked", !1), t.filters))
        if (t.filters.hasOwnProperty(e))
          if (Array.isArray(t.filters[e]))
            for (var i = 0; i < t.filters[e].length; i += 1) $("#" + e + "-" + t.filters[e][i]).prop("checked", !0);
          else if ("pageindex" !== e && "pagesize" !== e && "" !== t.filters[e]) {
            var n = "#" + e;
            "input" === $(n)[0].localName && ($(n)[0].value = t.filters[e]),
              "select" === $(n)[0].localName &&
                $(n).val(t.filters[e]).trigger("change").addClass("js-selectability--has-value");
          }
      t.bindUIActions();
    },
    setQuery: function (e, i) {
      var n = t.buildQuery(),
        a = t.getData(n);
      !0 === e && $("html, body").animate({ scrollTop: $(".aggregate__content").offset().top }, 425),
        !0 === i ? history.pushState(null, "", "?" + n) : history.replaceState(null, "", "?" + n),
        $(".aggregate__loading").show(),
        $(".aggregate__count").fadeOut().empty(),
        $(".aggregate__results").fadeOut().empty(),
        $(".aggregate__pagination").fadeOut().empty(),
        $.when(a)
          .done(function (e) {
            setTimeout(function () {
              (t.results = JSON.parse(e)), t.renderResults();
            }, 500);
          })
          .fail(function () {
            console.log("API ERROR: No results were returned");
          });
    },
  };
  function i(e) {
    return (
      (i =
        "function" == typeof Symbol && "symbol" == typeof Symbol.iterator
          ? function (e) {
              return typeof e;
            }
          : function (e) {
              return e && "function" == typeof Symbol && e.constructor === Symbol && e !== Symbol.prototype
                ? "symbol"
                : typeof e;
            }),
      i(e)
    );
  }
  function n(e, t) {
    for (var n = 0; n < t.length; n++) {
      var a = t[n];
      (a.enumerable = a.enumerable || !1),
        (a.configurable = !0),
        "value" in a && (a.writable = !0),
        Object.defineProperty(
          e,
          ((s = a.key),
          (r = void 0),
          (r = (function (e, t) {
            if ("object" !== i(e) || null === e) return e;
            var n = e[Symbol.toPrimitive];
            if (void 0 !== n) {
              var a = n.call(e, t || "default");
              if ("object" !== i(a)) return a;
              throw new TypeError("@@toPrimitive must return a primitive value.");
            }
            return ("string" === t ? String : Number)(e);
          })(s, "string")),
          "symbol" === i(r) ? r : String(r)),
          a
        );
    }
    var s, r;
  }
  var a = (function () {
      function t(e, i) {
        !(function (e, t) {
          if (!(e instanceof t)) throw new TypeError("Cannot call a class as a function");
        })(this, t),
          (this.defaults = { maxlength: $(e).attr("maxlength") ? $(e).attr("maxlength") : 999 }),
          (this.element = e),
          (this.options = $.extend({}, this.defaults, i)),
          (this.enabled = !!$(e).attr("maxlength")),
          this.enabled && this.init();
      }
      var i, a, s;
      return (
        (i = t),
        (a = [
          {
            key: "init",
            value: function () {
              this.appendCount(), this.bindUIActions();
            },
          },
          {
            key: "bindUIActions",
            value: function () {
              var t = this;
              $(this.element).on("keyup", this.onKeyUp.bind(this)),
                $(this.element).on("render", this.render.bind(this)),
                e(function () {
                  $(t.element).trigger("render", [$(t.element).val().length, t.options.maxlength]);
                });
            },
          },
          {
            key: "onKeyUp",
            value: function (e) {
              var t = $(e.target).val().length;
              $(e.target).trigger("render", [t, this.options.maxlength]);
            },
          },
          {
            key: "pad",
            value: function (e) {
              return e < 100 && e >= 10 ? "".concat(e) : e < 10 ? "0".concat(e) : e;
            },
          },
          {
            key: "render",
            value: function (e, t, i) {
              var n = i - t;
              $(e.target)
                .parent(".form__field")
                .find(".form__text-count")
                .empty()
                .text("".concat(this.pad(n), "/").concat(i, " Characters Remaining"));
            },
          },
          {
            key: "appendCount",
            value: function () {
              var e = $(this.element).parent(".form__field");
              e.length > 0 &&
                e.find(".form__text-count").length <= 0 &&
                e.append('<div class="form__text-count"></div>');
            },
          },
        ]) && n(i.prototype, a),
        s && n(i, s),
        Object.defineProperty(i, "prototype", { writable: !1 }),
        t
      );
    })(),
    s = {
      validClass: "form__field--is-valid",
      invalidClass: "form__field--is-invalid",
      elem: { $body: $("body"), $selects: $("select:not([multiple])"), $textarea: $("textarea") },
      init: function () {
        !(function (e, t) {
          var i = arguments.length > 2 && void 0 !== arguments[2] && arguments[2],
            n = "__".concat(e),
            a = $.fn[e];
          ($.fn[e] = function (e) {
            return this.each(function () {
              var i = $(this),
                a = i.data(n);
              a || i.data(n, (a = new t(this, e))), "string" == typeof e && a[e]();
            });
          }),
            i &&
              ($[e] = function (t) {
                return $({})[e](t);
              }),
            ($.fn[e].noConflict = function () {
              return ($.fn[e] = a);
            });
        })("Textarea", a),
          this.bindUIActions(),
          this.selectability();
      },
      bindUIActions: function () {
        this.elem.$body
          .on("click", '.form input[type="submit"], .form button[type="submit"]', this.onClick.bind(this))
          .on("input", "input,textarea", this.input.bind(this))
          .on("change", this.elem.$selects, this.input.bind(this)),
          this.elem.$textarea.Textarea();
      },
      checkFormValid: function () {
        return $(".form [required]:invalid").length <= 0;
      },
      onClick: function (e) {
        var t = this,
          i = $(e.target).parents("form");
        if (!i.hasClass("mobile-search"))
          if ((i.addClass("js-was-submitted"), i.hasClass("js-is-valid") || e.preventDefault(), this.checkFormValid()))
            i.addClass("js-is-valid"), i[0].submit();
          else {
            var n = $("[required]:invalid").first().closest(".form__field");
            $("[required]").each(function (e) {
              t.input($("[required]:eq(".concat(e.toString(), ")")));
            }),
              scrollToTop(n, 425);
          }
      },
      input: function (e) {
        var t = e.length ? e : $(e.target),
          i = "" === t.val();
        t.is(":invalid")
          ? t.parent(".form__field").removeClass(this.validClass).addClass(this.invalidClass)
          : i
          ? t.parent(".form__field").removeClass(this.invalidClass).removeClass(this.validClass)
          : t.parent(".form__field").removeClass(this.invalidClass).addClass(this.validClass);
      },
      selectability: function () {
        this.elem.$selects.length > 0 &&
          (this.elem.$selects.selectability({ position: "above", floatLabel: "true" }),
          $('.selectability[aria-disabled="true"]').attr("tabindex", "-1"));
      },
    },
    r = function () {
      s.init(), t.init();
    };
  e(function () {
    r();
  });
})();
//# sourceMappingURL=aggregate.js.map
