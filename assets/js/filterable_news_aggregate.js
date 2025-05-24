const applyFilters = ({ baseUrl = "" }) => {
  try {
    let tagFilter = [];
    let catFilter = [];
    let yearFilter = [];
    $('input[name="tagFilter[]"]:checked').each(function () {
      tagFilter.push($(this).val());
    });

    $('input[name="catFilter[]"]:checked').each(function () {
      catFilter.push($(this).val());
    });

    $('input[name="yearFilter[]"]:checked').each(function () {
      yearFilter.push($(this).val());
    });

    // create a query string from the filters
    let queryString = "";
    if (tagFilter.length > 0) {
      queryString += "tagFilter=" + tagFilter.join(",") + "&";
    }
    if (catFilter.length > 0) {
      queryString += "catFilter=" + catFilter.join(",") + "&";
    }
    if (yearFilter.length > 0) {
      queryString += "yearFilter=" + yearFilter.join(",") + "&";
    }
    // remove trailing ampersand
    queryString = queryString.slice(0, -1);

    // reload the page with the query string
    window.location.href = `${baseUrl}?${queryString}`;
  } catch (error) {
    console.error(error);
  }
};
