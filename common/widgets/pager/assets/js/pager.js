$('.page-size-dropdown select').on('change', function (e) {
    console.log($(this).val());
    window.location.replace($(this).val());
});