<script type="text/javascript">
    //search datatable when clicks on filter sub task icon
    $('body').on('click', '.filter-sub-task-button', function () {
        var table = $('#task-table');
        var value = $(this).attr('main-task-id');
        table.DataTable().search(value).draw();
        table.closest(".dataTables_wrapper").find("input[type=search]").val(value).focus().select();
        $(this).removeClass("filter-sub-task-button");
        $(this).addClass("remove-filter-button sub-task-filter-active");
        table.DataTable().order([1, 'asc']).draw();
    });
    $('body').on('click', '.remove-filter-button', function () {
        var table = $('#task-table');
        table.DataTable().search('').draw();
        $(this).removeClass("remove-filter-button sub-task-filter-active");
        $(this).addClass("filter-sub-task-button");
    });

    //search sub tasks after clicking on filter sub task icon
    $('body').on('click', '.filter-sub-task-kanban-button', function (e) {
        //stop the default modal anchor action
        e.stopPropagation();
        e.preventDefault();

        var value = $(this).attr('main-task-id');
        if ($(".custom-filter-search").val() === value) { //toggle search value
            value = "";
        }

        $(".custom-filter-search").val(value).focus().select();

        var key = $.Event("keyup", {keyCode: 13});
        $(".custom-filter-search").trigger(key);
    });
</script>