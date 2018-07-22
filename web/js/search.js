(function() {
  var page = 1;
  var scrollPercetToLoadData = 90;

  var loadBtn = $('#loadBtn');
  var loader = $('#loader');
  var container = $('#list-view-container');
  var query = $('input[name=query-value]').val() || '';
  var path = loadBtn.attr('action');
  var loading = false;

  loadBtn.bind('click', function(e) {
    if (loading === false) {
      loadNext();
    }
  });

  $(window).scroll(function() {
    /**
     * calculate the percentage the user has scrolled down the page
     */
    var scrollPercent =
      (100 * $(window).scrollTop()) /
      ($(document).height() - $(window).height());
    /**
     * We will only load more data when reaching 90% of page scroll. (could be changed within scrollPercetToLoadData var)
     */
    if (loading === false && scrollPercent > scrollPercetToLoadData) {
      scrollPercent = 0;
      loadNext();
    }
  });

  var loadNext = function() {
    loading = true;
    loadBtn.hide();
    loader.show();
    $.ajax({
      url: path,
      type: 'get',
      data: {
        page: page,
        keywords: query
      },
      success: function(response) {
        page++;
        container.append(response);
        loadBtn.show();
        loader.hide();
        loading = false;
      },
      error: function(request, status, error) {
        loadBtn.show();
        loader.hide();
        loading = false;
        throw new Error(request.responseText);
      }
    });
  };
})();
