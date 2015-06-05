$('#checkAll').change(function () {
    $('.chk').prop('checked', this.checked);
});

$(".chk").change(function () {
    if ($(".chk:checked").length == $(".chk").length) {
        $('#checkAll').prop('checked', 'checked');
    } else {
        $('#checkAll').prop('checked', false);
    }
});