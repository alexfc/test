;
$(function () {
    var selectors = {
        'body': 'body',
        'content': '.content',
        'filtersForm': '.filters form'
    };

    function init() {
        $.get('/api/projects', function (response) {
            var content = '';
            $.each(response, function (key, project) {
                content += render(project);
            });
            $(selectors.content).html(content);
        }, 'json');
    };

    function render(project) {
        return `
        <div class="project" data-id="${project.id}">
                <div class="project-header">
                    <h2>${project.subject}</h2>
                </div>
                <div class="project-body">
                    <div class="project-image">
                        <img src="https://placeimg.com/320/240/any?${project.id}" alt="${project.subject}" />
                    </div>
                    <div class="project-info">
                        <div class="project-description">
                            ${project.description}
                        </div>
                        <div class="project-status">
                            Дата начала: ${project.start_date}<br>
                        </div>
                    </div>
                </div>
            </div>
        `;
    };

    function filter(e) {
        e.preventDefault();
        $.post('/api/projects/filter', $('.filters form').serialize(), function (response) {
            var content = '';
            $.each(response, function (key, project) {
                content += render(project);
            });
            $(selectors.content).html(content);
        }, 'json');
    };

    $(selectors.filtersForm).on('submit', filter);

    init();
});