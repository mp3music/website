$('#e22').select2({
    sortResults: function(results, container, query) {
        if (query.term) {
            // use the built in javascript sort function
            return results.sort(function(a, b) {
                if (a.text.length > b.text.length) {
                    return 1;
                } else if (a.text.length < b.text.length) {
                    return -1;
                } else {
                    return 0;
                }
            });
        }
        return results;
    }
});