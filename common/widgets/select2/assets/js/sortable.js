+function ($) {
    'use strict';

    // CLASS DEFINITION
    // ================

    var DataKey = 'ch.select2Sortable';
    var Default = {};

    /**
     * Объект представления элемента сортировки
     */
    var Element = function (form, wrapper) {
        this.form = form;
        this.wrapper = wrapper;

        this.loadElements();
        this.bindEvents();

        this.form.elements.push(this);
    };

    Element.prototype.loadElements = function () {
        this.input = this.wrapper.find(".expanded-element-id");
        this.titleElement = this.wrapper.find(".title");
        this.closeButton = this.wrapper.find(".expanded-close");
        this.buttonWrapper = this.wrapper.find('.expanded-buttons');
    };

    Element.prototype.bindEvents = function () {
        var element = this;
        this.closeButton.on("click", function (e) {
            e.preventDefault();
            element.wrapper.remove();
            element.form.removeElement(element);
            element.form.updateElements();
        });
    };

    Element.prototype.setId = function (id) {
        this.input.val(id);
    };

    Element.prototype.getId = function () {
        return this.input.val();
    };

    Element.prototype.setTitle = function (title) {
        this.titleElement.html(title);
    };

    Element.prototype.updateButtons = function (id) {
        this.buttonWrapper.find('a').each(function() {
            var href = $(this).attr('href');
            $(this).attr('href', href + id);
        })
    };

    Element.prototype.getTitle = function () {
        return this.titleElement.html();
    };

    /**
     * Объект расширения для Select2
     */
    var Select2Sortable = function (select) {
        // Оригинальный select
        this.select = select;
        this.wrapper = select.closest(".sortable-wrapper");
        this.container = this.wrapper.find(".select2-expanded-container");
        this.elementsContainer = this.container.find(".expanded-container");
        this.elements = [];

        this.loadElements();
        this.initEvents();
        this.initSortable();
    };

    Select2Sortable.prototype.loadElements = function () {
        // Инициализация элементов
        var form = this;
        this.elementsContainer.find(".expanded-elements").each(function () {
            new Element(form, $(this));
        });
        // Очистка лишнего элемента формы
        this.select.attr("name", null);
        // Шаблон элемента
        var template = this.container.find(".expanded-template");
        this.templateElement = template.clone()
            .removeClass("expanded-template")
            .show();
        template.remove();
    };

    Select2Sortable.prototype.initEvents = function () {
        var form = this;
        this.select.on("select2:selecting", function (e) {
            var data = e.params.args.data;
            form.addItem({
                id: data.id,
                title: data.text
            });
        });
    };

    Select2Sortable.prototype.initSortable = function () {
        var form = this;
        this.elementsContainer.sortable({
            items: ".expanded-elements",
            placeholder: "expanded-elements-highlight",
            forcePlaceholderSize: true,
            stop: function () {
                form.updateElements();
            }
        });
    };

    Select2Sortable.prototype.updateElements = function () {
        var $items = this.elementsContainer.find(".expanded-elements");
        $items.each(function (index) {
            $(this).find('input, select').each(function () {
                var newName = $(this).attr("name").replace(/(.*)\[([0-9]*)]/, '$1[' + index + ']');
                $(this).attr("name", newName);
            });
        });
    };

    Select2Sortable.prototype.removeElement = function (element) {
        var ids = [];
        var elements = [];
        this.elements.forEach(function (item) {
            if (element.getId() != item.getId()) {
                ids.push(item.getId());
                elements.push(item);
            }
        });
        this.select.val(ids).trigger("change");
        this.elements = elements;
    };

    Select2Sortable.prototype.addItem = function (item) {
        var template = this.templateElement.clone();
        var element = new Element(this, template);

        element.setId(item.id);
        element.setTitle(item.title);
        element.updateButtons(item.id);

        this.elementsContainer.append(template);
        this.updateElements();
    };

    // PLUGIN DEFINITION
    // =================

    function Plugin(option) {
        return this.each(function () {
            var $this = $(this);
            var data = $this.data(DataKey);

            if (!data) {
                var options = $.extend({}, Default, $this.data(), typeof option == 'object' && option);
                $this.data(DataKey, (data = new Select2Sortable($this, options)));
            }
            if (typeof option == 'string') {
                data[option]();
            }
        });
    }

    var old = $.fn.chSelect2Sortable;

    $.fn.chSelect2Sortable = Plugin;
    $.fn.chSelect2Sortable.Constructor = Select2Sortable;

    // NO CONFLICT
    // ===========

    $.fn.chSelect2Sortable.noConflict = function () {
        $.fn.chSelect2Sortable = old;
        return this;
    };

}(jQuery);
