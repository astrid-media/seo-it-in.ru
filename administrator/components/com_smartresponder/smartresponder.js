$(document).ready(function(){
    var ajaxurl = 'index.php?option=com_smartresponder&ajax_request=true';
    $(document).on('click', 'input[name="sync_btn"]', function(){
        $('.sync_loading').css('display', 'block');
        $('.text-error').text('').css('display', 'none');
        var api_key = $('input[name="api_key"]').val();
        if(api_key.length > 0) {
            var sync_var = {
                phase: 'sync',
                api_key: api_key
            }
            $.getJSON(ajaxurl, sync_var, function(json){
                $('.sync_loading').css('display', 'none');
                if(json.result == '0') {
                    $('.text-error').text(json.error.message).css('display', 'block');
                }
                else {
                    $('.sr-box').append('<input type="hidden" name="uid" value="'+json.id+'">');
                    $('.form_generator').append('<div class="counter_key" style="display: none;"></div>');
                    $('.api_key_li img').attr('src', 'components/com_smartresponder/img/api_key_btn.png', '.png');
                    $('.form_generator_li img').attr('src', 'components/com_smartresponder/img/form_gen_btn_active.png', '.png');
                    $('.export_li img').attr('src', 'components/com_smartresponder/img/export_btn.png', '.png');
                    // Get Deliveries
                    var deliveries_var = {
                        phase: 'get_deliveries'                       
                    }
                    $.ajax({
                        url: ajaxurl,
                        data: deliveries_var,
                        dataType: 'JSON',
                        method: 'POST',
                        success: function(json){
                            $.each(json, function(i1, item1){
                                 $.each(item1, function(i2, item2){
                                     $.each(item2, function(i3, item3){
                                         var id = item3.id;
                                         var title = item3.title;
                                         var counter_key = item3.counter_key;
                                         var mySelect = jQuery('select[name="deliveries_select"]');
                                         mySelect.append(
                                             jQuery('<option style="color:black; background-color:white; "></option>').val(id).html(title)
                                         );
                                         $("select[name='deliveries_select'] option[value='undefined']").each(function() {
                                             $(this).remove();
                                         });
                                         $('.counter_key').append('<input type="hidden" id="'+id+'" value="'+counter_key+'" />');
                                     });
                                 });
                             });
                        }
                    });
                    // Get Tracks
                    var tracks_var = {
                        phase: 'get_tracks'                       
                    }
                    $.ajax({
                        url: ajaxurl,
                        data: tracks_var,
                        dataType: 'JSON',
                        method: 'POST',
                        success: function(json){
                            $.each(json, function(i1, item1){
                                 $.each(item1, function(i2, item2){
                                     $.each(item2, function(i3, item3){
                                         var id = item3.id;
                                         var title = item3.title;
                                         var mySelect = jQuery('select[name="trackId"]');
                                         mySelect.append(
                                             jQuery('<option style="color:black; background-color:white; "></option>').val(id).html(title)
                                         );
                                         $("select[name='trackId'] option[value='undefined']").each(function() {
                                             $(this).remove();
                                         });
                                     });
                                 });
                             });
                        }
                    });
                    $('.sync').css('display', 'none');
                    $('.sync_success p').html('Вы зашли как: '+json.login+' ('+json.name_first+' '+json.name_last+')');
                    $('.sync_success, .form_generator').css('display', 'block');
                }
            });
        }
        else {
            $('.sync_loading').css('display', 'none');
            $('.text-error').text('Введите API-ключ').css('display', 'block');
        }
    });
    $(document).on('click', '.api_key_li a',function(){
        $('.sync_success, .form_generator, .export').css('display', 'none');
        $('.sync').css('display', 'block');
        $('select[name="deliveries_select"] option, select[name="trackId"] option').remove();
        $('select[name="trackId"]').append('<option value="0">выбрать →</option>');
        $('input[name="api_key"]').val('');
        $('.api_key_li img').attr("src", "components/com_smartresponder/img/api_key_btn_active.png", ".png");
        $('.form_generator_li img').attr("src", "components/com_smartresponder/img/form_gen_btn.png", ".png");
        $('.export_li img').attr("src", "components/com_smartresponder/img/export_btn.png", ".png");
    });
    $(document).on('click', '#sr_menu li.form_generator_li', function(){
        if($('.sync').css('display') == 'block') {
            alert('Для использование Генератора Форм Подписки, вам нужно синхронизироваться.')
        } 
        else {
            $('.form_generator').css('display','block');
            $('.export').css('display', 'none');
            $('.api_key_li img').attr("src", "components/com_smartresponder/img/api_key_btn.png", ".png");
            $('.form_generator_li img').attr("src", "components/com_smartresponder/img/form_gen_btn_active.png", ".png");
            $('.export_li img').attr("src", "components/com_smartresponder/img/export_btn.png", ".png");
        }
    });
    // Form Generator
    // Default
    $('.ac-container input:checked ~ article').css('overflow', 'visible');
    $('.ac-container input[type="radio"]').click(function(){
       $('.ac-container article').css('overflow', 'hidden');
       setTimeout(function(){
           $('.ac-container input:checked ~ article').css('overflow', 'visible');
       }, 1000);
    });
    // Form width
    $('input[name="form_width"]').keyup(function(){
        if($.trim($('input[name="form_width"]').val() != '')) {
            var wf = parseInt($.trim($('input[name="form_width"]').val()));
            if(wf >= 200 && wf <=400){
                $('.sr-box').css('width',wf);
                $('#bg_image').css('width',wf);
                var field_name_first = $('input[name="field_name_first"]').css('width');
                $('select[name="field_charset_code"], select[name="field_country_id"]').css('width',field_name_first);
                if(wf >= 200 && wf < 260) {
                    $('input[name="subscribe"]').css('width','150px');
                }
                else {
                    $('input[name="subscribe"]').css('width','208px');
                }
            }
        }
    });
    // Form border
    $('select[name="fBorder"]').change(function(){
        var fBorder = $('select[name="fBorder"] option:selected').val();
        $('.sr-box').css('border',fBorder+'px '+$('#minicolor1').val());
        if($('input[name="f_dashed"]').is(':checked')) {
            $('form[name="SR_form"]').css('border-style', 'dashed');
        } else {
            $('form[name="SR_form"]').css('border-style', 'solid');
        }
    });
    $('INPUT#minicolor1').minicolors({
        animationSpeed: 100,
        animationEasing: 'swing',
        change: function(hex, rgb) {
            $('form[name="SR_form"]').css('border-color',hex);
        },
        changeDelay: 0,
        control: 'hue',
        defaultValue: '',
        hide: null,
        hideSpeed: 100,
        inline: false,
        letterCase: 'lowercase',
        opacity: false,
        position: 'default',
        show: null,
        showSpeed: 100,
        swatchPosition: 'left',
        textfield: true,
        theme: 'default'
    });
    $('INPUT#minicolor2').minicolors({
        animationSpeed: 100,
        animationEasing: 'swing',
        change: function(hex, rgb) {
            $('.sr-box li').css('background-color',hex);
        },
        changeDelay: 0,
        control: 'hue',
        defaultValue: '',
        hide: null,
        hideSpeed: 100,
        inline: false,
        letterCase: 'lowercase',
        opacity: false,
        position: 'default',
        show: null,
        showSpeed: 100,
        swatchPosition: 'left',
        textfield: true,
        theme: 'default'
    });
    // Form border dashed
    $('input[name="f_dashed"]').click(function(){
        var n = $('input[name="f_dashed"]:checked').length;
        if(n == 1) {
            $('form[name="SR_form"]').css('border-style', 'dashed');
        }
        else {
            $('form[name="SR_form"]').css('border-style', 'solid');
        }
    });
    // Show/Hide Form background
    $('input[name="bg_color"]').click(function(){
        var n = $('input[name="bg_color"]:checked').length;
        if(n == 1) {
            var color = $('#minicolor2').val();
            $('.sr-box li').css('background-color',color);
            $('.mc2').show();
        }
        else {
            $('.sr-box li').css('background-color','#FFFFFF');
            $('.mc2').hide();
        }
    });
    // Show/Hide Form head
    $('input[name="element_header"]').click(function(){
        if($('input[name="element_header"]:checked').length == 0) {
            $('.form-header').hide();
        }
        else {
            $('.form-header').show();
        }
    });
    // Element header title
    $('input[name="unique_element_header_title"]').keyup(function(){
        $('.header_title').text($(this).val());
    });
    // Element header font
    $('select[name="unique_element_header_font"]').change(function(){
        var header_font = $('select[name="unique_element_header_font"]').val();
        $('.header_title').css('font-family',header_font);
    });
    // Element header size
    $('select[name="unique_element_header_size"]').change(function(){
        var header_size = $('select[name="unique_element_header_size"]').val();
        $('.header_title').css('font-size',header_size);
    });
    // Element header type
    $('select[name="unique_element_header_type"]').change(function(){
        var header_type = $('select[name="unique_element_header_type"]').val();
        if(header_type == 'normal') {
            $('.header_title').css('font-weight','normal')
                              .css('font-style','normal');
        }
        if(header_type == 'bold') {
            $('.header_title').css('font-weight','bold')
                              .css('font-style','normal');
        }
        if(header_type == 'italic') {
            $('.header_title').css('font-weight','normal')
                              .css('font-style','italic');
        }
    });
    $('INPUT#minicolor3').minicolors({
        animationSpeed: 100,
        animationEasing: 'swing',
        change: function(hex, rgb) {
            $('.header_title').css('color',hex);
        },
        changeDelay: 0,
        control: 'hue',
        defaultValue: '',
        hide: null,
        hideSpeed: 100,
        inline: false,
        letterCase: 'lowercase',
        opacity: false,
        position: 'default',
        show: null,
        showSpeed: 100,
        swatchPosition: 'left',
        textfield: true,
        theme: 'default'
    });
    // Edit type
    $('input[name="edit_type"]').click(function(){
        if($(this).val() == 'field') {
            $('.remove_labels').show();
            $('input[name="field_name_first"], input[name="field_email"]').attr('placeholder','');
            $('.fields').css('height', 'auto');
            $('.sr_initial_field').hide();
            $('.sr_field').show();
        }
        else {
            $('.remove_labels').hide();
            $('input[name="field_name_first"]').attr('placeholder', $('.remove_labels:first').text());
            $('input[name="field_email"]').attr('placeholder', $('.remove_labels:last').text());
            $('.fields').css('height', '66px');
            $('.sr_initial_field').show();
            $('.sr_field').hide();
        }
    });
    // Under Unique Field Initial Forn
    $('select[name="under_unique_field_initial_font"]').change(function(){
        var font = $('select[name="under_unique_field_initial_font"]').val();
        $('.sr-box [type=text], .sr-box select, #sex_table p, #slyle_for_select, #slyle_for_p').css('font-family',font);
        $('input[name="under_field_initial_font"]').val(font);
    });
    // Under Unique Field Initial Size
    $('select[name="under_unique_field_initial_size"]').change(function(){
        var size = $('select[name="under_unique_field_initial_size"]').val();
        $('.sr-box [type=text], .sr-box select, #sex_table p, #slyle_for_select, #style_for_p').css('font-size',size);
        $('input[name="under_field_initial_size"]').val(size);
    });
    // Under Unique Field Initial Type
    $('select[name="under_unique_field_initial_type"]').change(function(){
        var type = $('select[name="under_unique_field_initial_type"]').val();
        if(type == 'normal') {
            $('.sr-box [type=text], .sr-box select, #sex_table p, #style_for_p, #slyle_for_select').css('font-weight','normal')
                                                                                                   .css('font-style','normal');
        }
        if(type == 'bold') {
            $('.sr-box [type=text], .sr-box select, #sex_table p, #style_for_p, #slyle_for_select').css('font-weight','bold')
                                                                                                   .css('font-style','normal');
        }
        if(type == 'italic') {
            $('.sr-box [type=text], .sr-box select, #sex_table p, #style_for_p, #slyle_for_select').css('font-weight','normal')
                                                                                                   .css('font-style','italic');
        }
        $('input[name="under_field_initial_type"]').val(type);
    });
    //add style block to the .sr-box with default placeholder css on page load
    var defaultColor = 'BDBDBD';
    var styleContent = '.sr-box input:-moz-placeholder {color: #' + defaultColor + ';} .sr-box input::-webkit-input-placeholder {color: #' + defaultColor + ';}';
    var styleBlock = '<style id="placeholder-style">' + styleContent + '</style>';
    $('.sr-box').append(styleBlock);
    $('INPUT#minicolor4').minicolors({
        animationSpeed: 100,
        animationEasing: 'swing',
        change: function(hex, rgb) {
            $('.sr-box input[type="text"]').css('color',hex);
            styleContent = '.sr-box input:-moz-placeholder {color: ' + hex + ';} .sr-box input::-webkit-input-placeholder {color: ' + hex + ';}'
            $('#placeholder-style').text(styleContent);
        },
        changeDelay: 0,
        control: 'hue',
        defaultValue: '',
        hide: null,
        hideSpeed: 100,
        inline: false,
        letterCase: 'lowercase',
        opacity: false,
        position: 'default',
        show: null,
        showSpeed: 100,
        swatchPosition: 'left',
        textfield: true,
        theme: 'default'
    });
    // Unique Field Border Weight
    $('select[name="unique_field_border_weight"]').change(function(){
        var border_weight = $('select[name="unique_field_border_weight"]').val();
        $('.sr-box [type=text], .sr-box select, #slyle_for_select').css('border-width',border_weight);
    });
    $('INPUT#minicolor6').minicolors({
        animationSpeed: 100,
        animationEasing: 'swing',
        change: function(hex, rgb) {
            $('.sr-box input[type=text]').css('background',hex);
        },
        changeDelay: 0,
        control: 'hue',
        defaultValue: '',
        hide: null,
        hideSpeed: 100,
        inline: false,
        letterCase: 'lowercase',
        opacity: false,
        position: 'default',
        show: null,
        showSpeed: 100,
        swatchPosition: 'left',
        textfield: true,
        theme: 'default'
    });
    // Over Unique Field Initial Font
    $('select[name="over_unique_field_initial_font"]').change(function(){
        var font = $('select[name="over_unique_field_initial_font"]').val();
        $('.remove_labels, .s_label').css('font-family',font);
        $('input[name="over_field_initial_font"]').val(font);
    });
    // Over Unique Field Initial Size
    $('select[name="over_unique_field_initial_size"]').change(function(){
        var size = $('select[name="over_unique_field_initial_size"]').val();
        $('.remove_labels, .s_label').css('font-size',size);
        $('input[name="over_field_initial_size"]').val(size);
    });
    // Over Unique Field Initial Type
    $('select[name="over_unique_field_initial_type"]').change(function(){
        var type = $('select[name="over_unique_field_initial_type"]').val();
        if(type == 'normal') {
            $('.remove_labels, .s_lebel').css('font-weight','normal')
                                         .css('font-style','normal');
        }
        if(type == 'bold') {
            $('.remove_labels, .s_label').css('font-weight','bold')
                                         .css('font-style','normal');
        }
        if(type == 'italic') {
            $('.remove_labels, .s_label').css('font-weight','normal')
                                         .css('font-style','italic');
        }
        $('input[name="over_field_initial_type"]').val(type);
    });
    $('INPUT#minicolor7').minicolors({
        animationSpeed: 100,
        animationEasing: 'swing',
        change: function(hex, rgb) {
            $('.remove_labels').css('color',hex);
        },
        changeDelay: 0,
        control: 'hue',
        defaultValue: '',
        hide: null,
        hideSpeed: 100,
        inline: false,
        letterCase: 'lowercase',
        opacity: false,
        position: 'default',
        show: null,
        showSpeed: 100,
        swatchPosition: 'left',
        textfield: true,
        theme: 'default'
    });
    // Unique Subscribe Title
    $('input[name="unique_subscribe_title"]').keyup(function(){
        var btn_value = $('input[name="unique_subscribe_title"]').val();
        $('input[name="subscribe"]').val(btn_value);
    });
    // Unique Subscribe font
    $('select[name="unique_subscribe_font"]').change(function(){
        var btn_font_family = $('select[name="unique_subscribe_font"]').val();
        $('input[name="subscribe"]').css('font-family',btn_font_family);
    });
    // Unique Subscribe size
    $('select[name="unique_subscribe_size"]').change(function(){
        var btn_font_size = $('select[name="unique_subscribe_size"]').val();
        $('input[name="subscribe"]').css('font-size',btn_font_size);
        if(parseInt($('input[name="form_width"]').val()) < 260) {
            if($('select[name="unique_subscribe_size"]').val() == '23px' || $('select[name="unique_subscribe_size"]').val() == '24px') {
                $('input[name="subscribe"]').css('width','208px');
            }
            else {
                $('input[name="subscribe"]').css('width','150px');
            }
        }        
    });
    // Unique Subscribe Type
    $('select[name="unique_subscribe_type"]').change(function(){
        var btn_font_weight = $('select[name="unique_subscribe_type"]').val();
        if(btn_font_weight == 'normal') {
            $('input[name="subscribe"]').css('font-weight','normal')
                                        .css('font-style','normal');
        }
        if(btn_font_weight == 'bold') {
            $('input[name="subscribe"]').css('font-weight','bold')
                                        .css('font-style','normal');
        }
        if(btn_font_weight == 'italic') {
            $('input[name="subscribe"]').css('font-weight','normal')
                                        .css('font-style','italic');
        }
    });
    $('INPUT#minicolor8').minicolors({
        animationSpeed: 100,
        animationEasing: 'swing',
        change: function(hex, rgb) {
            $('.sr-box input[name="subscribe"]').css('color',hex);
        },
        changeDelay: 0,
        control: 'hue',
        defaultValue: '',
        hide: null,
        hideSpeed: 100,
        inline: false,
        letterCase: 'lowercase',
        opacity: false,
        position: 'default',
        show: null,
        showSpeed: 100,
        swatchPosition: 'left',
        textfield: true,
        theme: 'default'
    });
    $('INPUT#minicolor9').minicolors({
        animationSpeed: 100,
        animationEasing: 'swing',
        change: function(hex, rgb) {
            $('.sr-box input[name="subscribe"]').attr('style',$('.sr-box input[name="subscribe"]').attr('style')+'border-color: '+hex+' !important;');
        },
        changeDelay: 0,
        control: 'hue',
        defaultValue: '',
        hide: null,
        hideSpeed: 100,
        inline: false,
        letterCase: 'lowercase',
        opacity: false,
        position: 'default',
        show: null,
        showSpeed: 100,
        swatchPosition: 'left',
        textfield: true,
        theme: 'default'
    });
    $('INPUT#minicolor10').minicolors({
        animationSpeed: 100,
        animationEasing: 'swing',
        change: function(hex, rgb) {
            $('.sr-box input[name="subscribe"]').attr('style',$('.sr-box input[name="subscribe"]').attr('style')+'background-color: '+hex+' !important;');
        },
        changeDelay: 0,
        control: 'hue',
        defaultValue: '',
        hide: null,
        hideSpeed: 100,
        inline: false,
        letterCase: 'lowercase',
        opacity: false,
        position: 'default',
        show: null,
        showSpeed: 100,
        swatchPosition: 'left',
        textfield: true,
        theme: 'default'
    });
    // Unique Subscribe Border Weight
    $('select[name="unique_subscribe_border_weight"]').change(function(){
        var btn_border_width = $('select[name="unique_subscribe_border_weight"]').val();
        $('.sr-box input[name="subscribe"]').attr('style',$('.sr-box input[name="subscribe"]').attr('style')+'border-width: '+btn_border_width+'px !important;');
    });
    $('INPUT#minicolor11').minicolors({
        animationSpeed: 100,
        animationEasing: 'swing',
        change: function(hex, rgb) {
            $('#cnt').css('color',hex);
        },
        changeDelay: 0,
        control: 'hue',
        defaultValue: '',
        hide: null,
        hideSpeed: 100,
        inline: false,
        letterCase: 'lowercase',
        opacity: false,
        position: 'default',
        show: null,
        showSpeed: 100,
        swatchPosition: 'left',
        textfield: true,
        theme: 'default'
    });
    $('INPUT#minicolor12').minicolors({
        animationSpeed: 100,
        animationEasing: 'swing',
        change: function(hex, rgb) {
            var uid = $('input[name="uid"]').val();
            var did = $('select[name="deliveries_select"]').val();
            var counter_key = $('#'+did).val();
            var counter_font = $('#nubmer_font').val();
            var counter_size = $('#number_size').val().split('px');
            var counter_color = hex.split('#');
            var counter_bg = $('#minicolor13').val().split('#');
            if($('input[name="number_bg_color"]:checked').length == 0) {
                counter_bg = '0'+counter_bg[1];
            }
            else {
                counter_bg = '1'+counter_bg[1];
            }
            var counter_align = $('#number_alignment').val();
            var counter_img = 'http://smartresponder.ru/dcounter/'+uid+'_'+counter_key+'_'+did+'_1_'+counter_font+'_'+counter_size[0]+'_'+counter_color[1]+'_'+counter_bg+'_'+counter_align+'/counter.gif';
            $('#counter_li img').attr('src', counter_img);
        },
        changeDelay: 0,
        control: 'hue',
        defaultValue: '',
        hide: null,
        hideSpeed: 100,
        inline: false,
        letterCase: 'lowercase',
        opacity: false,
        position: 'default',
        show: null,
        showSpeed: 100,
        swatchPosition: 'left',
        textfield: true,
        theme: 'default'
    });
    $('INPUT#minicolor13').minicolors({
        animationSpeed: 100,
        animationEasing: 'swing',
        change: function(hex, rgb) {
            var uid = $('input[name="uid"]').val();
            var did = $('select[name="deliveries_select"]').val();
            var counter_key = $('#'+did).val();
            var counter_font = $('#nubmer_font').val();
            var counter_size = $('#number_size').val().split('px');
            var counter_color = $('#minicolor12').val().split('#');
            var counter_bg = hex.split('#');
            if($('input[name="number_bg_color"]:checked').length == 0) {
                counter_bg = '0'+counter_bg[1];
            }
            else {
                counter_bg = '1'+counter_bg[1];
            }
            var counter_align = $('#number_alignment').val();
            var counter_img = 'http://smartresponder.ru/dcounter/'+uid+'_'+counter_key+'_'+did+'_1_'+counter_font+'_'+counter_size[0]+'_'+counter_color[1]+'_'+counter_bg+'_'+counter_align+'/counter.gif';
            $('#counter_li img').attr('src', counter_img);
        },
        changeDelay: 0,
        control: 'hue',
        defaultValue: '',
        hide: null,
        hideSpeed: 100,
        inline: false,
        letterCase: 'lowercase',
        opacity: false,
        position: 'default',
        show: null,
        showSpeed: 100,
        swatchPosition: 'left',
        textfield: true,
        theme: 'default'
    });
    // Show/Hide Element counter
    $('input[name="element_counter"]').click(function(){
        if($('input[name="element_counter"]:checked').length == 1){
            var deliveries_length = $('select[name="deliveries_select"] option:selected').length;
            if(deliveries_length == 0){
                alert('Пожалуйста выберите одну рассылку в разделе "Обязательные настройки формы", на которую будет подписывать форма');
                $(this).attr('checked', false);
            }
            else {
                if(deliveries_length > 1){
                    alert('Пожалуйста выберите ОДНУ рассылку в разделе "Обязательные настройки формы", на которую будет подписывать форма');
                    $(this).attr('checked', false);
                }
                else {
                    var uid = $('input[name="uid"]').val();
                    var did = $('select[name="deliveries_select"]').val();
                    var counter_key = $('#'+did).val();
                    var counter_font = $('#number_font').val();
                    var counter_size = $('#number_size').val().split('px');
                    var counter_color = $('#minicolor12').val().split('#');
                    var counter_bg = $('#minicolor13').val().split('#');
                    if($('input[name="number_bg_color"]:checked').length == 0) {
                        counter_bg = '0'+counter_bg[1];
                    }
                    else {
                        counter_bg = '1'+counter_bg[1];
                    }
                    var counter_align = $('#number_alignment').val();
                    var counter_img = 'http://smartresponder.ru/dcounter/'+uid+'_'+counter_key+'_'+did+'_1_'+counter_font+'_'+counter_size[0]+'_'+counter_color[1]+'_'+counter_bg+'_'+counter_align+'/counter.gif';
                    $('#counter_li img').attr('src', counter_img);
                    $('#counter_li').show();
                }
            }
        }
        else {
            $('#counter_li').hide();
        }
    });
    // Number Alignment
    $('#number_alignment').change(function(){
        var counter_title = 'Подписчиков';
        var counter_img_alignment = $('input[name="counter_img_alignment"]').val();
        var img_src = $('#cnt img').attr('src');
        var number_alignment = $('#number_alignment option:selected').val();
        var new_img_src = img_src.replace(counter_img_alignment,number_alignment);
        $('input[name="counter_img_alignment"]').val(number_alignment);
        $('#cnt img').attr('src',new_img_src);
        if(number_alignment == 'top') {
            $('#cnt').html('<img style="vertical-align: middle; " src="'+new_img_src+'"><br>'+counter_title);
            $('#counter_li').css('height','auto');
            $('#cnt').css('height','auto');
            var form_height = $('.sr-box').height();
            $('#bg_image').css('height',form_height);
        }
        if(number_alignment == 'right') {
            $('#cnt').html(counter_title+'<img style="vertical-align: middle; " src="'+new_img_src+'">');
            $('#counter_li').css('height','45px');
            $('#cnt').css('height','60px');
            var form_height = $('.sr-box').height();
            $('#bg_image').css('height',form_height);
        }
        if(number_alignment == 'bottom') {
            $('#cnt').html(counter_title+'<br /><img style="vertical-align: middle; " src="'+new_img_src+'">');
            $('#counter_li').css('height','auto');
            $('#cnt').css('height','auto');
            var form_height = $('.sr-box').height();
            $('#bg_image').css('height',form_height);
        }
        if(number_alignment == 'left') {
            $('#cnt').html('<img style="vertical-align: middle; " src="'+new_img_src+'">'+counter_title);
            $('#counter_li').css('height','45px');
            $('#cnt').css('height','60px');
            var form_height = $('.sr-box').height();
            $('#bg_image').css('height',form_height);
        }
    });
    // Unique Element Counter Font
    $('select[name="unique_element_counter_font"]').change(function(){
        var counter_font = $('select[name="unique_element_counter_font"]').val();
        $('#cnt').css('font-family',counter_font);
    });
    // Unique Element Counter Size
    $('select[name="unique_element_counter_size"]').change(function(){
        var counter_size = $('select[name="unique_element_counter_size"]').val();
        $('#cnt').css('font-size',counter_size);
    });
    // Element Counter Type
    $('select[name="unique_element_counter_type"]').change(function(){
        var counter_type = $('select[name="unique_element_counter_type"]').val();
        if(counter_type == 'normal') {
            $('#cnt').css('font-weight','normal')
                     .css('font-style','normal');
        }
        if(counter_type == 'bold') {
            $('#cnt').css('font-weight','bold')
                     .css('font-style','normal');
        }
        if(counter_type == 'italic') {
            $('#cnt').css('font-weight','normal')
                     .css('font-style','italic');
        }
    });
    // Number Font
    $('#number_font').change(function(){
        var uid = $('input[name="uid"]').val();
        var did = $('select[name="deliveries_select"]').val();
        var counter_key = $('#'+did).val();
        var counter_font = $(this).val();
        var counter_size = $('#number_size').val().split('px');
        var counter_color = $('#minicolor12').val().split('#');
        var counter_bg = $('#minicolor13').val().split('#');
        if($('input[name="number_bg_color"]:checked').length == 0) {
            counter_bg = '0'+counter_bg[1];
        }
        else {
            counter_bg = '1'+counter_bg[1];
        }
        var counter_align = $('#number_alignment').val();
        var counter_img = 'http://smartresponder.ru/dcounter/'+uid+'_'+counter_key+'_'+did+'_1_'+counter_font+'_'+counter_size[0]+'_'+counter_color[1]+'_'+counter_bg+'_'+counter_align+'/counter.gif';
        $('#counter_li img').attr('src', counter_img);
    });
    // Number Size
    $('#number_size').change(function(){
        var uid = $('input[name="uid"]').val();
        var did = $('select[name="deliveries_select"]').val();
        var counter_key = $('#'+did).val();
        var counter_font = $('#nubmer_font').val();
        var counter_size = $(this).val().split('px');
        var counter_color = $('#minicolor12').val().split('#');
        var counter_bg = $('#minicolor13').val().split('#');
        if($('input[name="number_bg_color"]:checked').length == 0) {
            counter_bg = '0'+counter_bg[1];
        }
        else {
            counter_bg = '1'+counter_bg[1];
        }
        var counter_align = $('#number_alignment').val();
        var counter_img = 'http://smartresponder.ru/dcounter/'+uid+'_'+counter_key+'_'+did+'_1_'+counter_font+'_'+counter_size[0]+'_'+counter_color[1]+'_'+counter_bg+'_'+counter_align+'/counter.gif';
        $('#counter_li img').attr('src', counter_img);
    });
    // Number bg color
    $('input[name="number_bg_color"]').click(function(){
        if($('input[name="number_bg_color"]:checked').length == 1) {
            $('.minicolor13').show();
            var uid = $('input[name="uid"]').val();
            var did = $('select[name="deliveries_select"]').val();
            var counter_key = $('#'+did).val();
            var counter_font = $('#nubmer_font').val();
            var counter_size = $('#number_size').val().split('px');
            var counter_color = $('#minicolor12').val().split('#');
            var counter_bg = $('#minicolor13').val().split('#');
            if($('input[name="number_bg_color"]:checked').length == 0) {
                counter_bg = '0'+counter_bg[1];
            }
            else {
                counter_bg = '1'+counter_bg[1];
            }
            var counter_align = $('#number_alignment').val();
            var counter_img = 'http://smartresponder.ru/dcounter/'+uid+'_'+counter_key+'_'+did+'_1_'+counter_font+'_'+counter_size[0]+'_'+counter_color[1]+'_'+counter_bg+'_'+counter_align+'/counter.gif';
            $('#counter_li img').attr('src', counter_img);    
        }
        else {
            $('.minicolor13').hide();
            var uid = $('input[name="uid"]').val();
            var did = $('select[name="deliveries_select"]').val();
            var counter_key = $('#'+did).val();
            var counter_font = $('#nubmer_font').val();
            var counter_size = $('#number_size').val().split('px');
            var counter_color = $('#minicolor12').val().split('#');
            var counter_bg = $('#minicolor13').val().split('#');
            if($('input[name="number_bg_color"]:checked').length == 0) {
                counter_bg = '0'+counter_bg[1];
            }
            else {
                counter_bg = '1'+counter_bg[1];
            }
            var counter_align = $('#number_alignment').val();
            var counter_img = 'http://smartresponder.ru/dcounter/'+uid+'_'+counter_key+'_'+did+'_1_'+counter_font+'_'+counter_size[0]+'_'+counter_color[1]+'_'+counter_bg+'_'+counter_align+'/counter.gif';
            $('#counter_li img').attr('src', counter_img);    
        }
    });
    // Deliveries Select
    $('select[name="deliveries_select"]').on('change', function(){
        $('input[name="did[]"]').remove();
        var deliveries_select = $('select[name="deliveries_select"]').val();
        var deliveries_select_t = [], lis = $('select[name="deliveries_select"] option:selected');
        for(var i=0, im=lis.length; im>i; i++){
            deliveries_select_t.push(lis[i].firstChild.nodeValue);
        }
        $('.subscribe-li').remove();
        if(deliveries_select.length > 1) {
            $('#counter_li').hide();
            $('input[name="element_counter"]').attr('checked', false);
            $('.form-header').after('<li class="subscribe-li" style="height: auto; "><label style="margin-top: 10px; font-size: 13px; color: rgb(189, 189, 189); font-family: arial; font-weight: bold; font-style: normal; height: auto;">Выберите рассылки:</label></li>');
            if(!$('.subscribe-li table').is('#d_tbl')) {
                var width = $('.fields').css('width');
                $('.subscribe-li').append('<table style="display:inline-table; width: '+width+'" cellpadding="4" id="d_tbl"><tbody></tbody></table>');
            }    
            for(var x=0;x<deliveries_select.length;x++) {
                $('input[name="uid"]').after('<input type="hidden" name="did[]" value="'+deliveries_select[x]+'">');
                $("#d_tbl > tbody").append('<tr><td><input type="checkbox" name="delivery_variant" checked="checked" value="'+deliveries_select[x]+'"></td><td>'+deliveries_select_t[x]+'</td></tr>');
            }
            $('.subscribe-li').css('background', $('#minicolor2').val());
        }
        else {
            $('input[name="uid"]').after('<input type="hidden" name="did[]" value="'+$(this).val()+'">');
            var uid = $('input[name="uid"]').val();
            var did = $('select[name="deliveries_select"]').val();
            var counter_key = $('#'+did).val();
            var counter_font = $('#number_font').val();
            var counter_size = $('#number_size').val().split('px');
            var counter_color = $('#minicolor12').val().split('#');
            var counter_bg = $('#minicolor13').val().split('#');
            if($('input[name="number_bg_color"]:checked').length == 0) {
                counter_bg = '0'+counter_bg[1];
            }
            else {
                counter_bg = '1'+counter_bg[1];
            }
            var counter_align = $('#number_alignment').val();
            var counter_img = 'http://smartresponder.ru/dcounter/'+uid+'_'+counter_key+'_'+did+'_1_'+counter_font+'_'+counter_size[0]+'_'+counter_color[1]+'_'+counter_bg+'_'+counter_align+'/counter.gif';
            $('#counter_li img').attr('src', counter_img);
        }
    });
    // Track ID
    $('select[name="trackId"]').change(function(){
        if($(this).val() != '0') {
            if($('input[name="tid"]').length == 0) {
                $('.sr-box').append('<input type="hidden" name="tid" value="'+$(this).val()+'">');
            }
            else {
                $('input[name="tid"]').val($(this).val());
            }
        }
        else {
            $('input[name="tid"]').remove();
        }
    });
    // Checks Level
    $('select[name="checksLevel"]').change(function(){
        switch($(this).val()) {
            case '0': 
                $('input[name="field_name_first"], input[name="field_email"]').removeClass('sr-required').removeClass('2');
            break;
            case '1': 
                $('input[name="field_name_first"], input[name="field_email"]').removeClass('sr-required').removeClass('2').addClass('sr-required');
            break;
            case '2': 
                $('input[name="field_name_first"], input[name="field_email"]').removeClass('sr-required').removeClass('2').addClass('sr-required').addClass('2');
            break;
        }
    });
    // Open Type
    $('input[name="openType"]').click(function(){
        if($(this).val() == '0') {
            $('input[name="for_openType"]').remove();
            $('.sr-subscribe-text').css('display','none');
        }
        else {
            if($('input[name="for_openType"]').length == 0) {
                $('.sr-box').append('<input type="hidden" name="for_openType" value="'+$('input[name="subscribe_text"]').val()+'">');
                $('.sr-subscribe-text').css('display','table-row');
            }
        }
    });
    // Get HTML function
    function get_html_form() {
        $.get('components/com_smartresponder/for_form.html', function(json){
            $('.sr-box').css('margin-top','0px');
            var form_code = $('.scene-editor').html();
            $('.sr-box').css('margin-top','130px');
            $('.modal-body textarea').text(json+form_code);
            $('#myModal').show();
            $('#myModal').css("position","absolute");
            $('#myModal').css("top", Math.max(0, (($(window).height() - 562 - $('#myModal').outerHeight()) / 2) + 
                                                        $(window).scrollTop()) + "px");
            $('#myModal').css("left", Math.max(0, (($(window).width() - $('#myModal').outerWidth()) / 2) + 
                                                        $(window).scrollLeft()) + "px");
            $('body').append('<div class="modal-backdrop fade in"></div>');
        });
    }
    // Get HTML
    $('#get_html').click(function(){
        var deliveries_select = $('select[name="deliveries_select"] option:selected').length;
        if(deliveries_select == 0) {
            alert('Пожалуйста выберите одну рассылку в разделе "Обязательные настройки формы", на которую будет подписывать форма');
            return false;
        }
        else {
            get_html_form();
            return true;
        }
    });
    $('#myModal .close, #myModal .modal-footer button').click(function(){
        $('#myModal').css('display', 'none');
        $('.modal-backdrop').remove();
    });
    $('#number_alignment').change(function(){
        var counter_title = 'Подписчиков';
        var counter_img_alignment = $('input[name="counter_img_alignment"]').val();
        var img_src = $('#cnt img').attr('src');
        var number_alignment = $('#number_alignment option:selected').val();
        var new_img_src = img_src.replace(counter_img_alignment,number_alignment);
        $('input[name="counter_img_alignment"]').val(number_alignment);
        $('#cnt img').attr('src',new_img_src);
        if(number_alignment == 'top') {
            $('#cnt').html('<img style="vertical-align: middle; " src="'+new_img_src+'"><br>'+counter_title);
            $('#counter_li').css('height','auto');
            $('#cnt').css('height','auto');
            var form_height = $('.sr-box').height();
            $('#bg_image').css('height',form_height);
        }
        if(number_alignment == 'right') {
            $('#cnt').html(counter_title+'<img style="vertical-align: middle; " src="'+new_img_src+'">');
            $('#counter_li').css('height','45px');
            $('#cnt').css('height','60px');
            var form_height = $('.sr-box').height();
            $('#bg_image').css('height',form_height);
        }
        if(number_alignment == 'bottom') {
            $('#cnt').html(counter_title+'<br /><img style="vertical-align: middle; " src="'+new_img_src+'">');
            $('#counter_li').css('height','auto');
            $('#cnt').css('height','auto');
            var form_height = $('.sr-box').height();
            $('#bg_image').css('height',form_height);
        }
        if(number_alignment == 'left') {
            $('#cnt').html('<img style="vertical-align: middle; " src="'+new_img_src+'">'+counter_title);
            $('#counter_li').css('height','45px');
            $('#cnt').css('height','60px');
            var form_height = $('.sr-box').height();
            $('#bg_image').css('height',form_height);
        }
    });
    // /Form Generator
    // Export
    $(document).on('click', '#sr_menu li.export_li',function(){
        if($('.sync').css('display') == 'block') {
            alert('Для использование Экспорта зарегистрированных пользователей, вам нужно синхронизироваться.')
        } 
        else {
            $('.api_key_li img').attr("src", "components/com_smartresponder/img/api_key_btn.png", ".png");
            $('.form_generator_li img').attr("src", "components/com_smartresponder/img/form_gen_btn.png", ".png");
            $('.export_li img').attr("src", "components/com_smartresponder/img/export_btn_active.png", ".png");
            $('.form_generator').css('display','none');
            $('.export').css('display', 'block');
            if($('#users_table tbody tr').length == 0) {
                $('#users_table thead input[name="check_all"]').css('display', 'none');
                $('#users_table tbody').append('<tr><td colspan="5" style="text-align: center;"><img src="components/com_smartresponder/img/loading.gif"></td></tr>');
                // Get Deliveries
                var deliveries_var = {
                    phase: 'get_deliveries'                       
                }
                $.ajax({
                    url: ajaxurl,
                    data: deliveries_var,
                    dataType: 'JSON',
                    method: 'POST',
                    success: function(json) {
                        $.each(json, function(i1, item1){
                            $.each(item1, function(i2, item2){
                                $.each(item2, function(i3, item3){
                                    var id = item3.id;
                                    var title = item3.title;
                                    var mySelect = jQuery('#rDestinationId_d');
                                    mySelect.append(
                                        jQuery('<option style="color:black; background-color:white; "></option>').val('d:'+id).html(title)
                                    );
                                    $("#rDestinationId_d option[value='undefined']").each(function() {
                                        $(this).remove();
                                    });
                                });
                            });
                        });
                    }
                });
                // Get Groups
                var getGroupsData = {
                    phase: 'get_groups'
                }
                $.ajax({
                    url: ajaxurl,
                    data: getGroupsData,
                    dataType: 'JSON',
                    method: 'POST',
                    success: function(data) {
                        $.each(data, function(i1, item1){
                            $.each(item1, function(i2, item2){
                                $.each(item2, function(i3, item3){
                                    var id = item3.id;
                                    var title = item3.title;
                                    var mySelect = jQuery('#rDestinationId_g');
                                    mySelect.append(
                                        jQuery('<option style="color:black; background-color:white; "></option>').val('g:'+id).html(title)
                                    );
                                    $("#rDestinationId_g option[value='g:undefined']").each(function() {
                                        $(this).remove();
                                    });
                                });
                            });
                        });
                    }
                });
                // Get Users
                var getUsersData = {
                    phase: 'get_users'
                }
                $.ajax({
                    url : ajaxurl,
                    data : getUsersData,
                    type : 'post',
                    dataType : 'json',
                    success : function(json) {
                        $('.records_on_page').css('display', 'block');
                        $('#users_table thead input[name="check_all"]').css('display', 'block');
                        $('#users_table tbody tr').remove();
                        $.each(json, function(i1, item1){
                            console.log(item1[0])
                            var id = item1[0];
                            var name = item1[1];
                            var email = item1[2];
                            var data = item1[3];
                            $('#users_table tbody').append('<tr class="'+id+' wp_users"><td>'+id+'</td><td class="is_nickname_'+id+'">'+name+'</td><td class="is_email_'+id+'">'+email+'</td><td>'+data+'</td><td><input type="checkbox" name="'+id+'"></td></tr>');
                            $("#users_table tbody tr.undefined").each(function() {
                                $(this).remove();
                            });
                            $('.insales_loading img, #export_form table').css('display', 'none');
                            $('.users_result').css('display', 'block');
                        });
                        $('#users_table thead tr th:first').text('#('+json.length+')');
                    } 
                });
            }
        }
    });
    $("input[name='check_all']").change(function(){
        var a = $("input[name='check_all']");
        if(a.length == a.filter(":checked").length){
            $('#users_table tbody td input[type="checkbox"]').attr('checked', true);
        }
        else {
            $('#users_table tbody td input[type="checkbox"]').attr('checked', false);
        }
    });
    $('#get_deliveries').click(function(){
        $('#get_groups').attr('checked', false);
        if(!$('.get_deliveries_select').is(':visible')) {
            $('input[name="get_groups"]').attr('checked', false);
            $('.get_deliveries_select').show();
            if($('.get_groups_select').is(':visible')) {
                $('.get_groups_select').hide(); 
            }
	}
    });
    $('#get_groups').click(function(){
        $('#get_deliveries').attr('checked', false);
        if(!$('.get_groups_select').is(':visible')) {
            $('input[name="get_deliveries"]').attr('checked', false);
            $('.get_groups_select').show();
            if($('.get_deliveries_select').is(':visible')) {
                $('.get_deliveries_select').hide(); 
            }
	}
    });
    $('#export_sr').click(function(){
        //Get users data
        var ind1 = 0;
        var ind2 = 0;
        var ind3 = 0;
        var checkbox_arr = [];
        var nickname_arr = [];
        var email_arr = [];
        //Get all checked checkbox
        $('#users_table tbody tr input[type="checkbox"]:checked').each(function(){
            checkbox_arr[ind1] = $(this).attr('name');
            ind1++;
        });
        if(checkbox_arr.length == 0) {
            var rDestinationId = 0;
            if($('.import-request-options #get_deliveries:checked').length == 1) {
                rDestinationId = $('#rDestinationId_d').val();
            }
            if($('.import-request-options #get_groups:checked').length == 1) {
                rDestinationId = $('#rDestinationId_g').val();
            }
            if(rDestinationId == 0) {
                alert('Выберите, куда Вы хотите добавить импортируемый список.');
                $('.import-request-options').css('color','red');
                setTimeout(function(){ 
                    $('.import-request-options').css('color','black'); 
                }, 1900);
            }
            else {
                $('.modal-footer span').css('display', 'block');
                //Get id
                var user_id_arr = [];
                $('#users_table tbody tr').each(function(){
                    user_id_arr[ind1] = $(this).attr('class');
                    ind1++;
                });
                $.each(user_id_arr.toString().split(','), function(number, item){
                    //Get nickname 
                    $('.is_nickname_'+item).each(function(){
                        nickname_arr[ind2] = $(this).text();
                        ind2++;
                    });
                    //Get email
                    $('.is_email_'+item).each(function(){
                        email_arr[ind3] = $(this).text();
                        ind3++;
                    }); 
                });
                var rDestination = $('select[name="rDestinationId"]').val();
                var data = {
                    phase: 'import',
                    destination: rDestination,
                    nickname: nickname_arr.toString(),
                    email: email_arr.toString()
                }
                $.ajax({
                    type: 'POST',
                    url: ajaxurl,
                    dataType: 'JSON',
                    data: data,
                    success: function(json) {
                        if(json.result == '0') {
                            $.each(json.error, function(x1, item1) {
                                if (typeof item1.message === 'undefined') {
                                    //
                                }
                                else {
                                    $('.modal-footer span').css('display', 'none');
                                    alert(item1.message);
                                }
                            });
                        }
                        else {
                            var import_key = json.element.import_key;
                            setTimeout(DisplayImportRequest(import_key), 3000);
                        }
                    },
                    error: function() {
                        alert('Ошибка импорта.');
                    }
                });
            }
            
        }
        else {
            var rDestinationId = 0;
            if($('.import-request-options #get_deliveries:checked').length == 1) {
                rDestinationId = $('#rDestinationId_d').val();
            }
            if($('.import-request-options #get_groups:checked').length == 1) {
                rDestinationId = $('#rDestinationId_g').val();
            }
            if(rDestinationId == 0) {
                alert('Выберите, куда Вы хотите добавить импортируемый список.');
                $('.import-request-options').css('color','red');
                setTimeout(function(){ 
                    $('.import-request-options').css('color','black'); 
                }, 1900);
            }
            else {
                $('.modal-footer span').css('display', 'block');
                //Get id
                var user_id_arr = checkbox_arr;
                $.each(user_id_arr.toString().split(','), function(number, item){
                    //Get nickname 
                    $('.is_nickname_'+item).each(function(){
                        nickname_arr[ind2] = $(this).text();
                        ind2++;
                    });
                    //Get email
                    $('.is_email_'+item).each(function(){
                        email_arr[ind3] = $(this).text();
                        ind3++;
                    }); 
                });
                var rDestination = $('select[name="rDestinationId"]').val();
                var data = {
                    phase: 'import',
                    destination: rDestination,
                    nickname: nickname_arr.toString(),
                    email: email_arr.toString()
                }
                $.ajax({
                    type: 'POST',
                    url: ajaxurl,
                    dataType: 'JSON',
                    data: data,
                    success: function(json) {
                        if(json.result == '0') {
                            $.each(json.error, function(x1, item1) {
                                if (typeof item1.message === 'undefined') {
                                    //
                                }
                                else {
                                    $('.modal-footer span').css('display', 'none');
                                    alert(item1.message);
                                }
                            });
                        }
                        else {
                            var import_key = json.element.import_key;
                            setTimeout(DisplayImportRequest(import_key), 3000);
                        }
                    },
                    error: function() {
                        alert('Ошибка импорта.');
                    }
                });
            }    
        }
    });
    function DisplayImportRequest(import_key) {
        var data = {
            phase: 'result',
            import_key: import_key
        }
        $.ajax({
            type: 'POST',
            url: ajaxurl,
            dataType: 'JSON',
            data: data,
            success: function(json) {
                if(json.result == '1') {
                    if(json.element.progress == '100') {
                        $('.modal-footer span').css('display', 'none');
                        alert('Заявка была отправлена. Пожалуйста дождитесь ответа нашего сотрудника. ID заявки: '+json.element.ticket);
                    }
                    else {
                        setTimeout(DisplayImportRequest(import_key), 3000);
                    }
                }
                else {
                    $.each(json, function(x1, item1) {
                        $.each(item1, function(x2, item2) {
                            if (typeof item2.message === 'undefined') {
                                //
                            }
                            else {
                                alert(item2.message);
                            }
                        }); 
                    });
                }
            },
            error: function() {
                alert('Ошибка импорта.');
            } 
        });
    }
    // Users Filter
    $('input[name="users_filter_btn"]').click(function(){
        $('#users_table thead input[name="check_all"]').css('display', 'none');
        $('#users_table tbody tr').remove();
        $('#users_table tbody').append('<tr><td colspan="5" style="text-align: center;"><img src="components/com_smartresponder/img/loading.gif"></td></tr>');
        var period = $('select[name="search[date_mode]"]').val();
        var email = $('input[name="email_filter"]').val();
        // Get Users
        var getUsersData = {
            phase: 'get_users',
            period: period,
            email: email
        }
        $.ajax({
            url : ajaxurl,
            data : getUsersData,
            type : 'POST',
            dataType : 'json',
            success : function(json) {
                if(json.length > 0) {
                    $('.records_on_page').css('display', 'block');
                    $('#users_table thead input[name="check_all"]').css('display', 'block');
                    $('#users_table tbody tr').remove();
                    $.each(json, function(i1, item1){
                        var id = item1[0];
                        var name = item1[1];
                        var email = item1[2];
                        var data = item1[3];
                        $('#users_table tbody').append('<tr class="'+id+' wp_users"><td>'+id+'</td><td class="is_nickname_'+id+'">'+name+'</td><td class="is_email_'+id+'">'+email+'</td><td>'+data+'</td><td><input type="checkbox" name="'+id+'"></td></tr>');
                        $("#users_table tbody tr.undefined").each(function() {
                            $(this).remove();
                        });
                        $('.insales_loading img, #export_form table').css('display', 'none');
                        $('.users_result').css('display', 'block');
                    });
                }
                else {
                    $('.records_on_page').css('display', 'none');
                    $('#users_table thead input[name="check_all"]').css('display', 'none');
                    $('#users_table tbody tr').remove();
                    $('#users_table tbody').append('<tr><td colspan="5" style="text-align: center;">Нет данных</td></tr>');
                }
                $('#users_table thead tr th:first').text('#('+json.length+')');
                var records_on_page = parseInt($('select[name="records_on_page"]').val());
                var users_count = parseInt($('#users_table tbody tr').length);
                $('#users_table').paginateTable({ rowsPerPage: records_on_page });
                if(records_on_page < users_count) {
                    $('.pager').show();
                }
                else {
                    $('.pager').hide();
                }
            } 
        });
    });
    //Pagination
    $('#users_table').paginateTable({ rowsPerPage: 5 });
    $(document).on('change', 'select[name="records_on_page"]', function(){
        $('.wp_users').show();
        var records_on_page = parseInt($('select[name="records_on_page"]').val());
        var users_count = parseInt($('#users_table tbody tr').length);
        console.log(users_count);
        $('#users_table').paginateTable({ rowsPerPage: records_on_page });
        if(records_on_page < users_count) {
            $('.pager').show();
        }
        else {
            $('.pager').hide();
        }
    });
    $('#export_btn').click(function(){
        $('#myModal2').show();
        $('#myModal2').css("position","absolute");
        $('#myModal2').css("top", Math.max(0, (($(window).height() - $('#myModal2').outerHeight()) / 2) + 
                                                    $(window).scrollTop()) + "px");
        $('#myModal2').css("left", Math.max(0, (($(window).width() - $('#myModal2').outerWidth()) / 2) + 
                                                    $(window).scrollLeft()) + "px");
        $('body').append('<div class="modal-backdrop fade in"></div>');
    });
    $('#myModal2 .close, #myModal2 .modal-footer button').click(function(){
        $('#myModal2').css('display', 'none');
        $('.modal-backdrop').remove();
    });
});