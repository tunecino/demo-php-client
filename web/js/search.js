(function() {
  var page = 1;
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
