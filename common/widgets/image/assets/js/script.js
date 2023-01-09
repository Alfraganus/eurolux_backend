$(document).ready(function () {
    let $widgetImageContainer = $('body').find('.ocs-widget-images'),
        $widgetContainer = $widgetImageContainer.closest('.ocs-widget-images-container'),
        $modal = $widgetContainer.find('.modal'),
        createUrl = $widgetImageContainer.data('create-url'),
        updateUrl = $widgetImageContainer.data('update-url'),
        deleteUrl = $widgetImageContainer.data('delete-url'),
        imageColumnSize = $widgetImageContainer.data('image-column-size'),
        imageHeight = $widgetImageContainer.data('image-height'),
        confirmDeleteText = $widgetImageContainer.data('confirm_delete_text');
    fadeInOutContainer();
    $widgetImageContainer.each(function () {
        let $widget = $(this);
        $widget.on('click', '.item', function () {
            let item_id = parseInt($(this).find('.img-responsive').data('id').toString());
            if (item_id > 0) {
                $.ajax({
                    url: updateUrl + (~updateUrl.indexOf('?') ? `&` : `?`) + `id=${item_id}`,
                    type: 'POST',
                    success: function (data) {
                        $modal.find('.modal-body').html(data);
                        $modal.modal('show');
                    },
                    error: function (msg) {
                        console.log(msg);
                    }
                });
            }

        });

        $widget.on('click', '.delete-image', function () {
            if (confirm(confirmDeleteText)) {
                let deleteBtn = $(this),
                    imageContainer = deleteBtn.closest('.image-item-container'),
                    img = imageContainer.find('img.img-responsive'),
                    item_id = img.attr('data-id');
                $.ajax({
                    url: deleteUrl + (~deleteUrl.indexOf('?') ? `&` : `?`) + `id=${item_id}`,
                    type: 'POST',
                    success: function () {
                        imageContainer.remove();
                        fadeInOutContainer();
                    },
                    error: function (msg) {
                        console.log(msg);
                    }
                });
            }
        });


        $modal.on('beforeSubmit', 'form', function () {
            let $fileInput = $modal.find('.file-input');
            if (!$fileInput.hasClass('has-error')) {
                let $progressBarWrap = '<div class="progress progress-striped active"><div class="progress-bar" role="progressbar" style="width: 25%">25%</div></div>';
                $modal.find('.form-group:last').html($progressBarWrap);
                let form = $(this),
                    formAction = form.attr('action'),
                    formData = new FormData(form[0]),
                    formMethod = 'POST';
                setProgress(50);
                $.ajax({
                    type: formMethod,
                    url: formAction,
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function (data) {
                        setProgress(75);
                        let image = $(`img[data-id="${data.id}"]`);
                        if (data.text) {
                            let caption = image.closest('.image-item').find('.caption');
                            caption.html(data.text);
                        }
                        if (image.length) {
                            image.attr('src', data.src);
                        } else {
                            let imageHtml = `<div class="col-md-${imageColumnSize} image-item-container"><div class="thumbnail image-item"><div class="item"><div class="img"><img src="${data.src}" class="img-responsive" style="height: ${imageHeight}px;" data-id="${data.id}"></div><div class="item-content"><i class="glyphicon glyphicon-pencil"></i></div></div><span class="caption">${data.text ? data.text : ''}</span><button type="button" class="btn btn-danger btn-block delete-image"><i class="glyphicon glyphicon-trash"></i></button></div></div>`;
                            $widget.append(imageHtml);
                        }
                        setProgress(100);
                        $modal.modal('hide');
                        fadeInOutContainer();
                    },
                    error: function (msg) {
                        console.log(msg);
                    }
                });
            }
            return false;
        });

        $widgetContainer.on('click', '.widget-image-btn-add', function () {
            $.ajax({
                url: createUrl,
                type: 'POST',
                success: function (data) {
                    $modal.find('.modal-body').html(data);
                    $modal.modal('show');
                },
                error: function (msg) {
                    console.log(msg);
                }
            });
        });
    });

    function setProgress(percent) {
        let $progressBar = $modal.find('.progress-bar');
        $progressBar.css(`width`, `${percent}%`);
        $progressBar.html(`${percent}%`);
    }

    function fadeInOutContainer() {
        let $imageItems = $('.image-item-container');
        if (!$imageItems.length) {
            $widgetImageContainer.hide();
        } else {
            $widgetImageContainer.show();
        }
    }
});