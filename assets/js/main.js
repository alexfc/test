;
var app = {
    selectors: {
        'body': 'body',
        'content': '.content',
        'project': '.project',
        'projectTemplate': 'script'
    },
    init: function () {
        var self = this;
        $.get('/api/projects', function(response) {
            $.each(response, function(key, project) {
                self.render(project);
            });
        }, 'json');
    },
    render: function (project) {
        $(this.selectors.body)
    }
};

$(function() {
    // $('.project').hover(function(e) {
    //     var $el = $(e.currentTarget);
    //     var data = $el.data('id');
    // });
    app.init();
    $(window).on('hashchange', function(){
        console.log('hash changed');
    });
});