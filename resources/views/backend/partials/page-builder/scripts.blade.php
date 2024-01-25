<script src="{{asset('assets/backend/js/jquery-ui.min.js')}}"></script>
<script src="{{asset('assets/backend/js/summernote-bs4.js')}}"></script>
<script src="{{asset('assets/backend/js/jquery.nice-select.min.js')}}"></script>
<script src="{{asset('assets/backend/js/spectrum.min.js')}}"></script>

<script>
    (function ($) {
        "use strict";

        $(document).ready(function () {
            /* ---------------------------------
            *   PREVIEW IMAGE
            * --------------------------------*/
            $(document).on('mouseover','.all-addons-wrapper ul.ui-sortable li.widget-handler',function (e){
                var imgUrl = $(this).find('a').attr('href');
                $(this).append('<div class="imageupshow"><img src="'+imgUrl+'" alt=""></div>');
            });
            $(document).on('mouseout','.all-addons-wrapper ul.ui-sortable li.widget-handler',function (e){
                $(this).find('.imageupshow').remove();
            });

            $(document).on('change','.addon_advertisement_size',function(e){
                e.preventDefault();
                alert(1);
            });
            /*----------------------------------
            *   SEARCH WIDGETS
            * ---------------------------------*/
            $(document).on('keyup','#search_addon_field',function (){
                var searchText = $(this).val();
                var allWidgets = $('.available-form-field.sortable_02 li > h4');

                $.each(allWidgets,function (index,value){
                    var text = $(this).text();
                    var found = text.toLowerCase().match(searchText.toLowerCase().trim());
                    if (!found){
                        $(this).parent().hide();
                    }else{
                        $(this).parent().show();
                    }
                });
            });
            /*-----------------------------------
            *   RANGE SCRIPT
            * ---------------------------------*/
            $(document).on('change','.page-builder-area-wrapper input[type="range"]',function (e){
                e.preventDefault();
                var el = $(this);
                el.next('.range-val').text(el.val()+el.data('unit-type'));
            });
            /*-----------------------------------
            *   PAGE BUILDER CORE SCRIPT
            * ---------------------------------*/
            $(".sortable").sortable({
                handle: "h4.top-part",
                axis: "y",
                placeholder: "sortable-placeholder",
                receive: function (event, ui) {
                    resetOrder(this.id);
                },
                stop: function (event, ui) {
                    resetOrder(this.id);
                }
            });

            $(".sortable_02").sortable({
                handle: "h4.top-part",
                connectWith: '.sortable_widget_location',
                helper: "clone",
                remove: function (e, li) {
                    var addonClass = li.item.attr('data-name');
                    var namespace = li.item.attr('data-namespace');
                    var markup = '';
                    $.ajax({
                        'url': "{{route('admin.page.builder.get.addon.markup')}}",
                        'type': "POST",
                        'data': {
                            '_token': "{!! csrf_token() !!}",
                            'addon_class': addonClass,
                            'addon_namespace': namespace,
                            @if(isset($dynamicPage) && $dynamicPage)
                            'addon_page_id': '{{$page->id}}',
                            'addon_page_type': 'dynamic_page',
                            'addon_location': 'dynamic_page',
                            @else
                            'addon_page_id': '',
                            'addon_page_type': 'static',
                            'addon_location': "{{ $location }}",
                            @endif
                        },
                        async: false,
                        success: function (data) {
                            markup = data;
                        }
                    });
                    li.item.clone()
                        .html(markup)
                        .insertAfter(li.item);
                    $(this).sortable('cancel');

                    return markup;
                }
            }).disableSelection();

            $('body').on('click', '.remove-widget', function (e) {
                //swal alert
                Swal.fire({
                    title: '{{__("Are you sure to make this addon?")}}',
                    text: '{{__("it will remove this addon with all data, you will not able to revert it again.")}}',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: "{{__('Yes, Accept it!')}}"
                }).then((result) => {
                    if (result.isConfirmed) {
                       
                       $(this).parent().remove();
                        $(".sortable_02").sortable("refreshPositions");
                        var parent = $(this).parent();
                        var widgetType = parent.find('input[name="addon_type"]').val();
                        resetOrder();
        
                        if (widgetType === 'update') {
                            var widget_id = parent.find('input[name="id"]').val();
                            $.ajax({
                                'url': "{{route('admin.page.builder.delete')}}",
                                'type': "POST",
                                'data': {
                                    '_token': "{!! csrf_token() !!}",
                                    'id': widget_id
                                },
                                success: function (data) {
                                }
                            });
                        }
                        
                    }
                });
            });

            $('body').on('click', '.expand', function (e) {
                $(this).parent().find('.content-part').toggleClass('show');
                var expand = $(this).children('i');
                var parent = $(this).parent();
                var classname = $(this).parent().data('name');
                if (expand.hasClass('ti-angle-down')) {
                    expand.attr('class', 'ti-angle-up');
                    $('body .nice-select').niceSelect();
                    $('.note-editable').trigger('focus');
                    var colorPickerNode = $('li[data-name="'+classname+'"] .color_picker');
                    colorPickerInit(colorPickerNode);

                    var summerNote = $('li[data-name="'+classname+'"] .summernote');

                    summerNote.summernote({
                        disableDragAndDrop: true,
                        height: 200,   //set editable area's height
                        codeviewFilter: true,
                        codeviewIframeFilter: true,
                        toolbar: [
                            // [groupName, [list of button]]
                            ['style', ['bold', 'italic', 'underline', 'clear']],
                            ['font', ['strikethrough', 'superscript', 'subscript']],
                            ['fontsize', ['fontsize']],
                            ['color', ['color']],
                            ['para', ['ul', 'ol', 'paragraph']],
                            ['height', ['height']],
                            ['Insert', ['link','table','video','picture']],
                        ],
                        styleTags: [
                            'p',
                            { title: 'Blockquote', tag: 'blockquote', className: 'blockquote', value: 'blockquote' },
                            'pre', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6'
                        ],
                        codemirror: { // codemirror options
                            theme: 'monokai'
                        },
                        callbacks: {
                            onPaste: function (e) {
                                var bufferText = ((e.originalEvent || e).clipboardData || window.clipboardData).getData('Text');
                                e.preventDefault();
                                document.execCommand('insertText', false, bufferText);
                            }
                        }
                    });

                    flatpickr('.flatpickr ', {
                        enableTime: true,
                        altInput: true,
                        altFormat: "F j, Y H:i:s",
                        dateFormat: "Y-m-d H:i:s",
                    });
                } else {
                    expand.attr('class', 'ti-angle-down');
                    $('body .color_picker').spectrum('destroy');
                    $('body .nice-select').niceSelect('destroy');
                    $('li[data-name="'+classname+'"] .summernote').summernote('destroy');
                }
                $('body .icp-dd').iconpicker('destroy');
                $('body .icp-dd').iconpicker();

            });

            $('body').on('click', '.widget_save_change_button', function (e) {
                e.preventDefault();
                var parent = $(this).parent().find('.widget_save_change_button');
                parent.text('{{__('Saving...')}}').attr('disabled', true);
                var form = $(this).parent();
                var widgetType = $(this).parent().find('input[name="addon_type"]').val();
                var formAction = $(this).parent().attr('action');
                var udpateId = '';
                var formContainer = $(this).parent();

                $.ajax({
                    type: "POST",
                    url: formAction,
                    data: form.serializeArray(),
                    success: function (data) {
                        udpateId = data.id;
                        if (widgetType === 'new') {
                            formContainer.attr('action', "{{route('admin.page.builder.update')}}")
                            formContainer.find('input[name="addon_type"]').val('update');
                            formContainer.prepend('<input type="hidden" name="id" value="' + udpateId + '">');
                        }

                        if (data === 'ok') {
                            form.append('<span class="text-success">{{__('data saved success')}}</span>');
                        }
                        setTimeout(function () {
                            form.find('span.text-success').remove();
                        }, 2000);
                    }
                });

                parent.text('saved..');
                setTimeout(function () {
                    parent.text('{{__('Save Changes')}}').attr('disabled', false);
                }, 1000);
            });

            /**
             * reset order function
             * */
            function resetOrder(dropedOn) {
                var allItems = $('#' + dropedOn + ' li');
                $.each(allItems, function (index, value) {
                    $(this).find('input[name="widget_order"]').val(index + 1);
                    $(this).find('input[name="widget_location"]').val(dropedOn);
                    var id = $(this).find('input[name="id"]').val();
                    var widget_order = index + 1;
                    if (typeof id != 'undefined') {
                        reset_db_order(id, widget_order);
                    }
                });
            }

            /**
             * reorder function
             * */
            function reset_db_order(id, addon_order) {
                $.ajax({
                    type: "POST",
                    url: "{{route('admin.page.builder.update.addon.order')}}",
                    data: {
                        _token: "{{csrf_token()}}",
                        id: id,
                        addon_order: addon_order
                    },
                    success: function (data) {
                        //response ok if it saved success
                    }
                });
            }

            $(document).on('click', '.widget-area-expand', function (e) {
                e.preventDefault();
                var widgetbody = $(this).parent().parent().find('.widget-area-body');
                widgetbody.toggleClass('hide');
                var expand = $(this).children('i');
                if (expand.hasClass('ti-angle-down')) {
                    expand.attr('class', 'ti-angle-up');
                } else {
                    expand.attr('class', 'ti-angle-down');
                    var allWidgets = $(this).parent().parent().find('.widget-area-body ul li');
                    $.each(allWidgets, function (value) {
                        $(this).find('.content-part').removeClass('show');
                    });
                }
            });
            /*-----------------------------------
            *  COLOR Picker INIT FUnction
            * ---------------------------------*/
            function colorPickerInit(selector) {
                $.each(selector,function (index,value){
                    var el = $(this);
                    el.spectrum({
                        showAlpha: true,
                        showPalette: true,
                        cancelText : '',
                        showInput: true,
                        allowEmpty:true,
                        chooseText : '',
                        maxSelectionSize: 2,
                        color: el.next('input').val(),
                        change: function(color) {
                            el.next('input').val( color ? color.toRgbString() : '');
                            el.css({
                                'background-color' : color ? color.toRgbString() : ''
                            });
                        },
                        move: function(color) {
                            el.next('input').val( color ? color.toRgbString() : '');
                            el.css({
                                'background-color' : color ? color.toRgbString() : ''
                            });
                        },
                        palette: [
                            [
                                "{{get_static_option('site_color')}}",
                                "{{get_static_option('site_main_color_two')}}",
                                @if(isset($dynamicPage) && $dynamicPage)
                                    "{{get_static_option('site_secondary_color')}}",
                                    "{{get_static_option('site_heading_color')}}",
                                    "{{get_static_option('site_paragraph_color')}}",
                                    "{{get_static_option('portfolio_home_color')}}",
                                    "{{get_static_option('logistics_home_color')}}",
                                    "{{get_static_option('industry_home_color')}}",
                                    "{{get_static_option('construction_home_color')}}",
                                    "{{get_static_option('lawyer_home_color')}}",
                                    "{{get_static_option('political_home_color')}}",
                                    "{{get_static_option('medical_home_color')}}",
                                    "{{get_static_option('medical_home_color_two')}}",
                                    "{{get_static_option('fruits_home_color')}}",
                                    "{{get_static_option('fruits_home_heading_color')}}",
                                    "{{get_static_option('portfolio_home_dark_color')}}",
                                    "{{get_static_option('portfolio_home_dark_two_color')}}",
                                    "{{get_static_option('charity_home_color')}}",
                                    "{{get_static_option('dagency_home_color')}}",
                                    "{{get_static_option('cleaning_home_color')}}",
                                    "{{get_static_option('cleaning_home_two_color')}}",
                                    "{{get_static_option('grocery_home_two_color')}}",
                                    "{{get_static_option('grocery_home_color')}}"
                                @endif
                            ]
                        ]
                    });

                    el.on("dragstop.spectrum", function(e, color) {
                        el.next('input').val( color.toRgbString());
                        el.css({
                            'background-color' : color.toHexString()
                        });
                    });
                });
            }
            /*------------------------------------------
            *   ICON PICKET INIT
            * ----------------------------------------*/
            $('.icp-dd').iconpicker();
            $('body').on('iconpickerSelected','.icp-dd', function (e) {
                var selectedIcon = e.iconpickerValue;
                $(this).parent().parent().children('input').val(selectedIcon);
                $('body .dropdown-menu.iconpicker-container').removeClass('show');
            });
            /*-------------------------------------------
            *   REPEATER SCRIPT
            * ------------------------------------------*/
            $(document).on('click','.all-field-wrap .action-wrap .add',function (e){
                e.preventDefault();

                var el = $(this);
                var parent = el.parent().parent();
                var container = $('.all-field-wrap');
                var clonedData = parent.clone();
                var containerLength = container.length;
                clonedData.find('#myTab').attr('id','mytab_'+containerLength);
                clonedData.find('#myTabContent').attr('id','myTabContent_'+containerLength);
                var allTab =  clonedData.find('.tab-pane');
                allTab.each(function (index,value){
                    var el = $(this);
                    var oldId = el.attr('id');
                    el.attr('id',oldId+containerLength);
                });
                var allTabNav =  clonedData.find('.nav-link');
                allTabNav.each(function (index,value){
                    var el = $(this);
                    var oldId = el.attr('href');
                    el.attr('href',oldId+containerLength);
                });

                parent.parent().append(clonedData);

                if (containerLength > 0){
                    parent.parent().find('.remove').show(300);
                }
                // parent.parent().find('.iconpicker-popover').remove();
                parent.parent().find('.icp-dd').iconpicker('destroy');
                parent.parent().find('.icp-dd').iconpicker();

            });

            $(document).on('click','.all-field-wrap .action-wrap .remove',function (e){
                e.preventDefault();
                var el = $(this);
                var parent = el.parent().parent();
                var container = $('.all-field-wrap');

                if (container.length > 1){
                    el.show(300);
                    parent.hide(300);
                    parent.remove();
                }else{
                    el.hide(300);
                }
            });
        });
    })(jQuery);
</script>
