<?php

defined('_JEXEC') or die('Restricted access');
if(isset($_GET['ajax_request'])) {
    require('components/com_smartresponder/smartresponder_phases.php');
    exit;
}

//Toolbar
jimport('joomla.application.component.view');
JToolbarHelper::title(JText::_('Smartresponder'), 'generic');

?>
<!-- Include Style -->
<html>
    <head>
        <link rel="stylesheet" href="components/com_smartresponder/include/jquery-miniColors-master/jquery.minicolors.css" type="text/css">
        <link rel="stylesheet" href="components/com_smartresponder/smartresponder.css" type="text/css">
        <!-- Include JavaScript -->
        <script src="components/com_smartresponder/include/jquery.min.js" type="text/javascript"></script>
        <script src="components/com_smartresponder/include/jquery-miniColors-master/jquery.minicolors.js" type="text/javascript"></script>
        <script src="components/com_smartresponder/include/mattpage-jquery.paginateTable/jquery.paginatetable.js" type="text/javascript"></script>
        <script src="components/com_smartresponder/smartresponder.js" type="text/javascript"></script>
    </head>
    <body>
        <div class="smartresponder">
            <div class="container">
                <div class="sync_success">
                    <p class="text-success"></p>
                </div>
                <!-- SR Menu -->
                <ul id="sr_menu">
                    <li class="api_key_li"><a href="javascript:void(0)"><img src="components/com_smartresponder/img/api_key_btn_active.png" /></a></li>
                    <li class="form_generator_li"><a href="javascript:void(0)"><img src="components/com_smartresponder/img/form_gen_btn.png" /></a></li>
                    <li class="export_li"><a href="javascript:void(0)"><img src="components/com_smartresponder/img/export_btn.png" /></a></li>
                </ul>
                <!-- Synchronization -->
                <div class="sync">
                    <div class="input-append">
                        <input class="span2" id="appendedInputButton" name="api_key" type="text" placeholder="Введите API-ключ">
                        <input class="btn" name="sync_btn" type="button" value="Синхронизировать">
                    </div>
                    <div class="sync_loading"><img src="components/com_smartresponder/img/loading.gif"></div>
                    <p class="text-error"></p>
                </div>
                <!-- Form Generator -->
                <div class="form_generator">
                    <div class="leftCol">
                        <div class="scene-editor">
                            <link rel="stylesheet" href="components/com_smartresponder/for_form.css" type="text/css" />
                            <form class="sr-box" method="post" action="https://smartresponder.ru/subscribe.html" target="_blank" name="SR_form" style="z-index: 1;width: 250px; border: 1px solid rgb(188, 188, 188); margin: 0 auto; margin-top: 130px; border-top-left-radius: 0px; border-top-right-radius: 0px; border-bottom-right-radius: 0px; border-bottom-left-radius: 0px; ">
                                <ul class="sr-box-list ui-sortable" style="background: white;">
                                    <li class="form-header" style="text-align: center; border-top-left-radius: 0px; border-top-right-radius: 0px; border-bottom-right-radius: 0px; border-bottom-left-radius: 0px; border: 0px solid rgb(0, 0, 0); ">
                                        <label class="header_title" style="width: 100%; height: auto; line-height: 25px; margin-top: 10px; font-size: 16px; color: rgb(0, 0, 0); font-family: arial; font-weight: bold; font-style: normal; ">Подписка на рассылку</label>
                                        <input type="hidden" name="element_header" value="" style="font-family: Arial; color: rgb(0, 0, 0); font-size: 12px; font-style: normal; font-weight: normal; border: none; " />
                                    </li>
                                    <li class="fields" style="border-top-left-radius: 0px; border-top-right-radius: 0px; border-bottom-right-radius: 0px; border-bottom-left-radius: 0px; height: 60px; text-align: center; background-position: initial initial; background-repeat: initial initial; ">                                                                                                                                            
                                        <label style="font-family: arial; color: rgb(0, 0, 0); font-size: 12px; font-style: normal; font-weight: normal; display: none; margin-top: 10px; " class="remove_labels">Ваше имя</label>
                                        <input type="text" name="field_name_first" class="sr-required" value="" placeholder="Ваше имя" style="margin-top: 10px; background-image: none; font-family: arial; color: rgb(189, 189, 189); font-size: 13px; font-style: normal; font-weight: bold; border: 1px solid rgb(188, 188, 188); border-top-left-radius: 0px; border-top-right-radius: 0px; border-bottom-right-radius: 0px; border-bottom-left-radius: 0px; height: 40px; -webkit-box-shadow: 0 0 0 0; " />
                                    </li>
                                    <li class="fields" style="border-top-left-radius: 0px; border-top-right-radius: 0px; border-bottom-right-radius: 0px; border-bottom-left-radius: 0px; height: 60px; text-align: center; background-position: initial initial; background-repeat: initial initial; ">
                                        <label style="font-family: arial; color: rgb(0, 0, 0); font-size: 12px; font-style: normal; font-weight: normal; display: none; margin-top: 10px; " class="remove_labels">Ваш email-адрес</label>
                                        <input type="text" name="field_email" class="sr-required" value="" placeholder="Ваш email-адрес" style="margin-top: 10px; background-image: none; font-family: arial; color: rgb(189, 189, 189); font-size: 13px; font-style: normal; font-weight: bold; border: 1px solid rgb(188, 188, 188); border-top-left-radius: 0px; border-top-right-radius: 0px; border-bottom-right-radius: 0px; border-bottom-left-radius: 0px; height: 40px; -webkit-box-shadow: 0 0 0 0; " />
                                    </li>
                                    <li class="subscribe" style="border-top-left-radius: 0px; border-top-right-radius: 0px; border-bottom-right-radius: 0px; border-bottom-left-radius: 0px; text-align: center; background-color: none; border: 0px; height: 75px; background-position: initial initial; background-repeat: initial initial; ">            
                                        <input type="submit" name="subscribe" disabled value="Подписаться" style="cursor: pointer; background-image: none !important; font-family: arial; color: rgb(255, 255, 255); font-size: 15px; font-style: normal; font-weight: bold; border: 1px solid rgb(99, 129, 18) !important; margin-top: 10px; width: 150px; background-color: rgb(153, 192, 48) !important; height: 40px; background-position: 0% 50%; background-repeat: repeat repeat; padding: 0; border-top: 0; -webkit-box-shadow: 0 0 0 0; text-shadow: none; " />
                                    </li>
                                    <li id="counter_li" style="display: none; text-align: center; height: 45px; border-top-left-radius: 0px; border-top-right-radius: 0px; border-bottom-right-radius: 0px; border-bottom-left-radius: 0px; ">
                                        <label id="cnt" style="font-size: 13px; color: rgb(173, 166, 173); font-family: arial; font-weight: bold; font-style: normal; height: 40px;">
                                            Подписчиков
                                            <img style="vertical-align: middle; " src="">
                                        </label>
                                    </li>
                                </ul>
                            </form>
                        </div>
                        <br />
                        <!-- Link to trigger modal -->
                        <div class="form-actions">
                            <a href="#myModal" id="get_html" data-toggle="modal" class="sr-btn sr-btn-default">Получить HTML код</a>
                        </div>
                        <!-- Modal -->
                        <div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                <h3 id="myModalLabel">HTML код формы</h3>
                            </div>
                            <div class="modal-body">
                                <textarea></textarea>
                            </div>
                            <div class="modal-footer">
                                <button class="btn" data-dismiss="modal" aria-hidden="true">Закрыть</button>
                            </div>
                        </div>
                    </div>
                    <div class="rightCol">
                        <div class="ac_div">
                            <section class="ac-container">
                                <div>
                                    <input id="ac-1" name="accordion-1" type="radio" checked />
                                    <label for="ac-1">Обязательные настройки формы</label>
                                    <article class="ac-small">
                                        <p><span class="red">1.</span> Форма подписывает на рассылки:</p>
                                        <select size="4" multiple="" name="deliveries_select"></select>
                                        <p><span class="red">2.</span> Размеры и внешний вид формы:</p>
                                        <table border="0" cellspacing="0" cellpadding="0" style="margin-left: 20px;">
                                            <tbody>
                                                <tr>
                                                    <td colspan="4">Ширина: <input type="text" name="form_width" maxlength="3" class="textbox" value="250" style="width: 50px;"> в пикселях</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">&nbsp;</td>
                                                </tr>
                                                <tr>
                                                    <td width="65px">Граница:</td>
                                                    <td>
                                                        <select name="fBorder" style="border-top-left-radius: 0px; border-top-right-radius: 0px; border-bottom-right-radius: 0px; border-bottom-left-radius: 0px;">
                                                            <option value="0">0</option>
                                                            <option value="1" selected>1</option>
                                                            <option value="2">2</option>
                                                            <option value="3">3</option>
                                                            <option value="4">4</option>
                                                            <option value="5">5</option>
                                                            <option value="6">6</option>
                                                            <option value="7">7</option>
                                                        </select>
                                                        <input type="checkbox" name="f_dashed" value="1" style="margin-right: 5px; margin-left: 10px; vertical-align: middle; display: inline; " />пунктир
                                                    </td>
                                                    <td align="right">&nbsp;&nbsp;&nbsp;Цвет:</td>
                                                    <td align="left">&nbsp;
                                                        <span class="minicolors minicolors-theme-default minicolors-swatch-position-left minicolors-swatch-left minicolors-position-default">
                                                            <input class="minicolors minicolors-input" id="minicolor1" type="text" value="#c8c8c8" size="7" maxlength="7">
                                                            <span class="minicolors-panel minicolors-slider-hue" style="display: none;">
                                                                <span class="minicolors-slider">
                                                                    <span class="minicolors-picker" style="top: 67.88461538461539px;"></span>
                                                                </span>
                                                                <span class="minicolors-opacity-slider">
                                                                    <span class="minicolors-picker"></span>
                                                                </span>
                                                                <span class="minicolors-grid" style="background-color: rgb(0, 183, 255);">
                                                                    <span class="minicolors-grid-inner"></span>
                                                                    <span class="minicolors-picker" style="top: 38px; left: 104px;">
                                                                        <span></span>
                                                                    </span>
                                                                </span>
                                                            </span>
                                                        </span>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <p><span class="red">3.</span> Фон формы:</p>
                                        <table border="0" cellspacing="0" cellpadding="0">
                                            <tbody>
                                                <tr>
                                                    <td style="white-space: nowrap;">
                                                        <input type="checkbox" name="bg_color" value="color" checked="checked"> Цвет:
                                                    </td>
                                                    <td>&nbsp;
                                                        <span class="minicolors minicolors-theme-default minicolors-swatch-position-left minicolors-swatch-left minicolors-position-default mc2">
                                                            <input class="minicolors minicolors-input" id="minicolor2" type="text" value="#ffffff" size="7" maxlength="7">
                                                            <span class="minicolors-panel minicolors-slider-hue" style="display: none;">
                                                                <span class="minicolors-slider">
                                                                    <span class="minicolors-picker" style="top: 67.88461538461539px;"></span>
                                                                </span>
                                                                <span class="minicolors-opacity-slider">
                                                                    <span class="minicolors-picker"></span>
                                                                </span>
                                                                <span class="minicolors-grid" style="background-color: rgb(0, 183, 255);">
                                                                    <span class="minicolors-grid-inner"></span>
                                                                    <span class="minicolors-picker" style="top: 38px; left: 104px;">
                                                                        <span></span>
                                                                    </span>
                                                                </span>
                                                            </span>
                                                        </span>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </article>
                                </div>
                                <div>
                                    <input id="ac-2" name="accordion-1" type="radio" />
                                    <label for="ac-2">Дополнительные настройки формы</label>
                                    <article class="ac-medium">
                                        <p><span class="red">4.</span> Канал подписки, связанный с формой:</p>
                                        <select name="trackId">
                                            <option value="0">выбрать →</option>    
                                        </select>
                                        <p><span class="red">5.</span> Проверка заполнения полей формы:</p>
                                        <select name="checksLevel">
                                            <option value="0">не проверять</option>
                                            <option value="1" selected="">минимальная</option>
                                            <option value="2">максимальная</option>
                                        </select>
                                        <p><span class="red">6.</span> Динамичность формы:</p>
                                        <table border="0" cellspacing="0" cellpadding="0">
                                            <tbody>
                                                <tr class="tr-small">
                                                    <td valign="top" width="25px">
                                                        <input type="radio" checked="checked" name="openType" value="0" style="display: inline;">
                                                    </td>
                                                    <td valign="top">перенаправлять на страницу подписки</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">&nbsp;</td>
                                                </tr>
                                                <tr>
                                                    <td valign="top" width="25px">
                                                        <input type="radio" name="openType" value="1" style="display: inline;">
                                                    </td>
                                                    <td valign="top">отправлять активационное письмо без<br>переадресации </td>
                                                </tr>
                                                <tr>
                                                    <td>&nbsp;</td>
                                                </tr>
                                                <tr class="sr-subscribe-text" style="display: none;">
                                                    <td colspan="2">Текст, который появиться вместо кнопки:</td>
                                                </tr>
                                                <tr class="sr-subscribe-text" style="display: none;">
                                                    <td colspan="2">
                                                        <input type="text" name="subscribe_text" value="Спасибо! Проверьте свой email и подтвердите подписку" maxlength="350" style="margin: 0;">
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </article>
                                </div>
                                <div>
                                    <input id="ac-3" name="accordion-1" type="radio" />
                                    <label for="ac-3">Настройки шапки формы</label>
                                    <article class="ac-large">
                                        <p><span class="red">7.</span> Элемент формы:</p>
                                        <table border="0" cellspacing="0" cellpadding="0">
                                            <tbody>
                                                <tr>
                                                    <td id="form_elements" style="white-space: nowrap;">
                                                        <input type="checkbox" name="element_header" checked="checked" style="display: inline;">&nbsp;&nbsp;Хэдер 
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <p><span class="red">8.</span> Название шапки:</p>
                                        <input type="text" id="title" name="unique_element_header_title" value="Подписка на рассылку" style="margin-left: 20px;">
                                        <p><span class="red">9.</span> Форматирование текста шапки:</p>
                                        <table border="0" cellspacing="0" cellpadding="0" style="">
                                            <tbody>
                                                <tr>
                                                    <td colspan="3">
                                                        Шрифт:
                                                        <select id="font" name="unique_element_header_font" style="border-top-left-radius: 0px; border-top-right-radius: 0px; border-bottom-right-radius: 0px; border-bottom-left-radius: 0px;">
                                                            <option value="arial">Arial</option>
                                                            <option value="courier">Courier</option>
                                                            <option value="times new roman">Times New Roman</option>
                                                            <option value="verdana">Verdana</option>
                                                        </select>
                                                    </td>
                                                    <td align="right" colspan="2">&nbsp;&nbsp;Цвет:</td>                        
                                                    <td>&nbsp;
                                                        <span class="minicolors minicolors-theme-default minicolors-swatch-position-left minicolors-swatch-left minicolors-position-default">
                                                            <input class="minicolors minicolors-input" id="minicolor3" type="text" value="#000000" size="7" maxlength="7">
                                                            <span class="minicolors-panel minicolors-slider-hue" style="display: none;">
                                                                <span class="minicolors-slider">
                                                                    <span class="minicolors-picker" style="top: 67.88461538461539px;"></span>
                                                                </span>
                                                                <span class="minicolors-opacity-slider">
                                                                    <span class="minicolors-picker"></span>
                                                                </span>
                                                                <span class="minicolors-grid" style="background-color: rgb(0, 183, 255);">
                                                                    <span class="minicolors-grid-inner"></span>
                                                                    <span class="minicolors-picker" style="top: 38px; left: 104px;">
                                                                        <span></span>
                                                                    </span>
                                                                </span>
                                                            </span>
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="3">&nbsp;</td>
                                                </tr>
                                                <tr style="display: table-row;">
                                                    <td colspan="6">
                                                        Размер:
                                                        <select id="size" name="unique_element_header_size" style="border-top-left-radius: 0px; border-top-right-radius: 0px; border-bottom-right-radius: 0px; border-bottom-left-radius: 0px;">
                                                            <option value="8px">8</option>
                                                            <option value="9px">9</option>
                                                            <option value="10px">10</option>
                                                            <option value="11px">11</option>
                                                            <option value="12px">12</option>
                                                            <option value="13px">13</option>
                                                            <option value="14px">14</option>
                                                            <option value="15px">15</option>
                                                            <option value="16px" selected>16</option>
                                                            <option value="17px">17</option>
                                                            <option value="18px">18</option>
                                                            <option value="19px">19</option>
                                                            <option value="20px">20</option>
                                                            <option value="21px">21</option>
                                                            <option value="22px">22</option>
                                                            <option value="23px">23</option>
                                                            <option value="24px">24</option>
                                                        </select>
                                                        &nbsp;&nbsp;
                                                        Тип:
                                                        <select id="type" name="unique_element_header_type" style="border-top-left-radius: 0px; border-top-right-radius: 0px; border-bottom-right-radius: 0px; border-bottom-left-radius: 0px;">
                                                            <option value="normal">Обычный</option>
                                                            <option value="bold" selected>Жирный</option>
                                                            <option value="italic">Курсив</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </article>
                                </div>
                                <div>
                                    <input id="ac-4" name="accordion-1" type="radio" />
                                    <label for="ac-4">Настройки полей формы</label>
                                    <article class="ac-large">
                                        <p><span class="red">10.</span> Отображение названия поля:</p>
                                        <table cellspacing="0" cellpadding="0" border="0" style="display: table;">
                                            <tbody>
                                                <tr>
                                                    <td width="20px">
                                                        <input type="radio" value="field" name="edit_type" style="display: inline; ">
                                                    </td>
                                                    <td>Над полем</td>
                                                    <td>&nbsp;&nbsp;&nbsp;</td>
                                                    <td width="20px">
                                                        <input type="radio" value="initial_field" checked="checked" name="edit_type" style="display: inline; ">
                                                    </td>
                                                    <td>Внутри поля</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <p class="sr_initial_field"><span class="red">11.</span> Форматирование текста в поле:</p>
                                        <table class="sr_initial_field" id="under_text-table" border="0" cellspacing="0" cellpadding="0" style="display: table; margin-top: 10px; margin-left: 20px;">
                                            <tbody>
                                                <tr>
                                                    <td colspan="3">
                                                        Шрифт:
                                                        <select id="under_initial_font" name="under_unique_field_initial_font" style="border-top-left-radius: 0px; border-top-right-radius: 0px; border-bottom-right-radius: 0px; border-bottom-left-radius: 0px; ">
                                                            <option value="arial">Arial</option>
                                                            <option value="courier">Courier</option>
                                                            <option value="times new roman">Times New Roman</option>
                                                            <option value="verdana">Verdana</option>    
                                                        </select>
                                                    </td>
                                                    <td align="right" colspan="2">&nbsp;&nbsp;Цвет:</td>
                                                    <td>&nbsp;
                                                        <span class="minicolors minicolors-theme-default minicolors-swatch-position-left minicolors-swatch-left minicolors-position-default">
                                                            <input class="minicolors minicolors-input" id="minicolor4" type="text" value="#bdbdbd" size="7" maxlength="7">
                                                            <span class="minicolors-panel minicolors-slider-hue" style="display: none;">
                                                                <span class="minicolors-slider">
                                                                    <span class="minicolors-picker" style="top: 67.88461538461539px;"></span>
                                                                </span>
                                                                <span class="minicolors-opacity-slider">
                                                                    <span class="minicolors-picker"></span>
                                                                </span>
                                                                <span class="minicolors-grid" style="background-color: rgb(0, 183, 255);">
                                                                    <span class="minicolors-grid-inner"></span>
                                                                    <span class="minicolors-picker" style="top: 38px; left: 104px;">
                                                                        <span></span>
                                                                    </span>
                                                                </span>
                                                            </span>
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="3">&nbsp;<td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6">
                                                        Размер:
                                                        <input type="hidden" name="under_field_initial_font" value="Arial">
                                                        <input type="hidden" name="under_field_initial_size" value="13px">
                                                        <input type="hidden" name="under_field_initial_type" value="bold">
                                                        <input type="hidden" name="under_field_initial_color" value="#BDBDBD">
                                                        <select id="under_initial_size" name="under_unique_field_initial_size" style="border-top-left-radius: 0px; border-top-right-radius: 0px; border-bottom-right-radius: 0px; border-bottom-left-radius: 0px; ">
                                                            <option value="8px">8</option>
                                                            <option value="9px">9</option>
                                                            <option value="10px">10</option>
                                                            <option value="11px">11</option>
                                                            <option value="12px">12</option>
                                                            <option value="13px" selected="">13</option>
                                                            <option value="14px">14</option>
                                                            <option value="15px">15</option>
                                                            <option value="16px">16</option>
                                                            <option value="17px">17</option>
                                                            <option value="18px">18</option>
                                                            <option value="19px">19</option>
                                                            <option value="20px">20</option>
                                                            <option value="21px">21</option>
                                                            <option value="22px">22</option>
                                                            <option value="23px">23</option>
                                                            <option value="24px">24</option>
                                                        </select>
                                                        &nbsp;&nbsp;
                                                        Тип:
                                                        <select id="under_initial_type" name="under_unique_field_initial_type" style="border-top-left-radius: 0px; border-top-right-radius: 0px; border-bottom-right-radius: 0px; border-bottom-left-radius: 0px; ">
                                                            <option value="normal">Обычный</option>
                                                            <option value="bold" selected="">Жирный</option>
                                                            <option value="italic">Курсив</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <p class="sr_field" style="display: none;"><span class="red">11.</span> Форматирование текста над полем:</p>
                                        <table class="sr_field" id="over_text-table" border="0" cellspacing="0" cellpadding="0" style="display: none; margin-top: 10px; margin-left: 20px;">
                                            <tbody>
                                                <tr>
                                                    <td colspan="3">
                                                        Шрифт:
                                                        <select id="over_initial_font" name="over_unique_field_initial_font" class="listbox" style="border-top-left-radius: 0px; border-top-right-radius: 0px; border-bottom-right-radius: 0px; border-bottom-left-radius: 0px; ">
                                                            <option value="arial">Arial</option>
                                                            <option value="courier">Courier</option>
                                                            <option value="times new roman">Times New Roman</option>
                                                            <option value="verdana">Verdana</option>    
                                                        </select>
                                                    </td>
                                                    <td align="right" colspan="2">&nbsp;&nbsp;Цвет:</td>
                                                    <td>&nbsp;
                                                        <span class="minicolors minicolors-theme-default minicolors-swatch-position-left minicolors-swatch-left minicolors-position-default">
                                                            <input class="minicolors minicolors-input" id="minicolor7" type="text" value="#000000" size="7" maxlength="7">
                                                            <span class="minicolors-panel minicolors-slider-hue" style="display: none;">
                                                                <span class="minicolors-slider">
                                                                    <span class="minicolors-picker" style="top: 67.88461538461539px;"></span>
                                                                </span>
                                                                <span class="minicolors-opacity-slider">
                                                                    <span class="minicolors-picker"></span>
                                                                </span>
                                                                <span class="minicolors-grid" style="background-color: rgb(0, 183, 255);">
                                                                    <span class="minicolors-grid-inner"></span>
                                                                    <span class="minicolors-picker" style="top: 38px; left: 104px;">
                                                                        <span></span>
                                                                    </span>
                                                                </span>
                                                            </span>
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="3">&nbsp;<td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6">
                                                        Размер:
                                                        <input type="hidden" name="over_field_initial_font_h" value="Arial">
                                                        <input type="hidden" name="over_field_initial_size_h" value="12px">
                                                        <input type="hidden" name="over_field_initial_type_h" value="normal">
                                                        <input type="hidden" name="over_field_initial_color_h" value="#000000">
                                                        <select id="initial_size" name="over_unique_field_initial_size" class="listbox" style="border-top-left-radius: 0px; border-top-right-radius: 0px; border-bottom-right-radius: 0px; border-bottom-left-radius: 0px; ">
                                                            <option value="8px">8</option>
                                                            <option value="9px">9</option>
                                                            <option value="10px">10</option>
                                                            <option value="11px">11</option>
                                                            <option value="12px" selected>12</option>
                                                            <option value="13px">13</option>
                                                            <option value="14px">14</option>
                                                            <option value="15px">15</option>
                                                            <option value="16px">16</option>
                                                            <option value="17px">17</option>
                                                            <option value="18px">18</option>
                                                            <option value="19px">19</option>
                                                            <option value="20px">20</option>
                                                            <option value="21px">21</option>
                                                            <option value="22px">22</option>
                                                            <option value="23px">23</option>
                                                            <option value="24px">24</option>
                                                        </select>
                                                        &nbsp;&nbsp;
                                                        Тип:
                                                        <select id="initial_type" name="over_unique_field_initial_type" class="listbox" style="border-top-left-radius: 0px; border-top-right-radius: 0px; border-bottom-right-radius: 0px; border-bottom-left-radius: 0px; ">
                                                            <option value="normal">Обычный</option>
                                                            <option value="bold">Жирный</option>
                                                            <option value="italic">Курсив</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <p><span class="red">12.</span> Форматирование поля:</p>
                                        <table border="0" cellspacing="0" cellpadding="0" style="margin-top: 10px; margin-left: 20px;">
                                            <tbody>
                                                <tr>
                                                    <td>Граница:&nbsp;</td>
                                                    <td>
                                                        <select id="border_weight" name="unique_field_border_weight" style="border-top-left-radius: 0px; border-top-right-radius: 0px; border-bottom-right-radius: 0px; border-bottom-left-radius: 0px; ">
                                                            <option value="0">0</option>
                                                            <option value="1" selected="">1</option>
                                                            <option value="2">2</option>
                                                            <option value="3">3</option>
                                                            <option value="4">4</option>
                                                            <option value="5">5</option>
                                                            <option value="6">6</option>
                                                            <option value="7">7</option>
                                                        </select>
                                                    </td>
                                                    <td style="width: 120px; ">&nbsp;&nbsp;

                                                    </td>
                                                    <td>
                                                        Фон:
                                                    </td>
                                                    <td>&nbsp;
                                                        <span class="minicolors minicolors-theme-default minicolors-swatch-position-left minicolors-swatch-left minicolors-position-default">
                                                            <input class="minicolors minicolors-input" id="minicolor6" type="text" value="#ffffff" size="7" maxlength="7">
                                                            <span class="minicolors-panel minicolors-slider-hue" style="display: none;">
                                                                <span class="minicolors-slider">
                                                                    <span class="minicolors-picker" style="top: 67.88461538461539px;"></span>
                                                                </span>
                                                                <span class="minicolors-opacity-slider">
                                                                    <span class="minicolors-picker"></span>
                                                                </span>
                                                                <span class="minicolors-grid" style="background-color: rgb(0, 183, 255);">
                                                                    <span class="minicolors-grid-inner"></span>
                                                                    <span class="minicolors-picker" style="top: 38px; left: 104px;">
                                                                        <span></span>
                                                                    </span>
                                                                </span>
                                                            </span>
                                                        </span>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </article>
                                </div>
                                <div>
                                    <input id="ac-5" name="accordion-1" type="radio" />
                                    <label for="ac-5">Настройки кнопки формы</label>
                                    <article class="ac-large">
                                        <p><span class="red">13.</span> Название кнопки:</p>
                                        <input type="text" id="title" name="unique_subscribe_title" value="Подписаться" style="margin-left: 20px;">
                                        <p><span class="red">14.</span> Форматирование текста кнопки:</p>
                                        <table border="0" cellspacing="0" cellpadding="0" style="margin-top: 10px; margin-left: 20px;">
                                            <tbody>
                                                <tr>
                                                    <td colspan="3">
                                                        Шрифт:
                                                        <select id="font" name="unique_subscribe_font" style="border-top-left-radius: 0px; border-top-right-radius: 0px; border-bottom-right-radius: 0px; border-bottom-left-radius: 0px; ">
                                                            <option value="arial">Arial</option>
                                                            <option value="courier">Courier</option>
                                                            <option value="times new roman">Times New Roman</option>
                                                            <option value="verdana">Verdana</option>    
                                                        </select>
                                                    </td>
                                                    <td align="right" colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;Цвет:</td>                      
                                                    <td>&nbsp;
                                                        <span class="minicolors minicolors-theme-default minicolors-swatch-position-left minicolors-swatch-left minicolors-position-default">
                                                            <input class="minicolors minicolors-input" id="minicolor8" type="text" value="#ffffff" size="7" maxlength="7">
                                                            <span class="minicolors-panel minicolors-slider-hue" style="display: none;">
                                                                <span class="minicolors-slider">
                                                                    <span class="minicolors-picker" style="top: 67.88461538461539px;"></span>
                                                                </span>
                                                                <span class="minicolors-opacity-slider">
                                                                    <span class="minicolors-picker"></span>
                                                                </span>
                                                                <span class="minicolors-grid" style="background-color: rgb(0, 183, 255);">
                                                                    <span class="minicolors-grid-inner"></span>
                                                                    <span class="minicolors-picker" style="top: 38px; left: 104px;">
                                                                        <span></span>
                                                                    </span>
                                                                </span>
                                                            </span>
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="3">&nbsp;</td>
                                                </tr>
                                                <tr style="display: table-row; ">
                                                    <td colspan="6">
                                                        Размер:
                                                        <select id="size" name="unique_subscribe_size" style="border-top-left-radius: 0px; border-top-right-radius: 0px; border-bottom-right-radius: 0px; border-bottom-left-radius: 0px; ">
                                                            <option value="8px">8</option>
                                                            <option value="9px">9</option>
                                                            <option value="10px">10</option>
                                                            <option value="11px">11</option>
                                                            <option value="12px">12</option>
                                                            <option value="13px">13</option>
                                                            <option value="14px">14</option>
                                                            <option value="15px" selected>15</option>
                                                            <option value="16px">16</option>
                                                            <option value="17px">17</option>
                                                            <option value="18px">18</option>
                                                            <option value="19px">19</option>
                                                            <option value="20px">20</option>
                                                            <option value="21px">21</option>
                                                            <option value="22px">22</option>
                                                            <option value="23px">23</option>
                                                            <option value="24px">24</option>
                                                        </select>
                                                        &nbsp;&nbsp;Тип:
                                                        <select id="type" name="unique_subscribe_type" style="border-top-left-radius: 0px; border-top-right-radius: 0px; border-bottom-right-radius: 0px; border-bottom-left-radius: 0px; ">
                                                            <option value="normal">Обычный</option>
                                                            <option value="bold" selected="">Жирный</option>
                                                            <option value="italic">Курсив</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <p><span class="red">15.</span> Форматирование кнопки:</p>
                                        <table border="0" cellspacing="0" cellpadding="0" style="margin-top: 10px; margin-left: 20px;">
                                            <tbody>
                                                <tr>
                                                    <td>Граница:&nbsp;</td>
                                                    <td>
                                                        <select id="border_weight" name="unique_subscribe_border_weight" style="border-top-left-radius: 0px; border-top-right-radius: 0px; border-bottom-right-radius: 0px; border-bottom-left-radius: 0px; ">
                                                            <option value="0">0</option>
                                                            <option value="1" selected="">1</option>
                                                            <option value="2">2</option>
                                                            <option value="3">3</option>
                                                            <option value="4">4</option>
                                                            <option value="5">5</option>
                                                            <option value="6">6</option>
                                                            <option value="7">7</option>
                                                        </select>
                                                    </td>
                                                    <td style="width: 120px; ">&nbsp;
                                                        <span class="minicolors minicolors-theme-default minicolors-swatch-position-left minicolors-swatch-left minicolors-position-default">
                                                            <input class="minicolors minicolors-input" id="minicolor9" type="text" value="#638112" size="7" maxlength="7">
                                                            <span class="minicolors-panel minicolors-slider-hue" style="display: none;">
                                                                <span class="minicolors-slider">
                                                                    <span class="minicolors-picker" style="top: 67.88461538461539px;"></span>
                                                                </span>
                                                                <span class="minicolors-opacity-slider">
                                                                    <span class="minicolors-picker"></span>
                                                                </span>
                                                                <span class="minicolors-grid" style="background-color: rgb(0, 183, 255);">
                                                                    <span class="minicolors-grid-inner"></span>
                                                                    <span class="minicolors-picker" style="top: 38px; left: 104px;">
                                                                        <span></span>
                                                                    </span>
                                                                </span>
                                                            </span>
                                                        </span>
                                                    </td>
                                                    <td>Фон:</td>
                                                    <td width="115px">&nbsp;
                                                        <span class="minicolors minicolors-theme-default minicolors-swatch-position-left minicolors-swatch-left minicolors-position-default">
                                                            <input class="minicolors minicolors-input" id="minicolor10" type="text" value="#99C030" size="7" maxlength="7">
                                                            <span class="minicolors-panel minicolors-slider-hue" style="display: none;">
                                                                <span class="minicolors-slider">
                                                                    <span class="minicolors-picker" style="top: 67.88461538461539px;"></span>
                                                                </span>
                                                                <span class="minicolors-opacity-slider">
                                                                    <span class="minicolors-picker"></span>
                                                                </span>
                                                                <span class="minicolors-grid" style="background-color: rgb(0, 183, 255);">
                                                                    <span class="minicolors-grid-inner"></span>
                                                                    <span class="minicolors-picker" style="top: 38px; left: 104px;">
                                                                        <span></span>
                                                                    </span>
                                                                </span>
                                                            </span>
                                                        </span>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </article>
                                </div>
                                <div>
                                    <input id="ac-6" name="accordion-1" type="radio" />
                                    <label for="ac-6">Настройки счетчика формы</label>
                                    <article class="ac-large">
                                        <p><span class="red">16.</span> Элемент формы:</p>
                                        <table border="0" cellspacing="0" cellpadding="0">
                                            <tbody>
                                                <tr>
                                                    <td id="form_elements" style="white-space: nowrap;">
                                                        <input type="checkbox" name="element_counter" style="display: inline;">&nbsp;&nbsp;Счетчик 
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <p><span class="red">17.</span> Форматирование текста счетчика:</p>
                                        <table border="0" cellspacing="0" cellpadding="0" style="">
                                            <tbody>
                                                <tr>
                                                    <td colspan="3">
                                                        Шрифт:
                                                        <select id="font" name="unique_element_counter_font" style="border-top-left-radius: 0px; border-top-right-radius: 0px; border-bottom-right-radius: 0px; border-bottom-left-radius: 0px;">
                                                            <option value="arial">Arial</option>
                                                            <option value="courier">Courier</option>
                                                            <option value="times new roman">Times New Roman</option>
                                                            <option value="verdana">Verdana</option>
                                                        </select>
                                                    </td>
                                                    <td align="right" colspan="2">&nbsp;&nbsp;Цвет:</td>                        
                                                    <td>&nbsp;
                                                        <span class="minicolors minicolors-theme-default minicolors-swatch-position-left minicolors-swatch-left minicolors-position-default">
                                                            <input class="minicolors minicolors-input" id="minicolor11" type="text" value="#bdbdbd" size="7" maxlength="7">
                                                            <span class="minicolors-panel minicolors-slider-hue" style="display: none;">
                                                                <span class="minicolors-slider">
                                                                    <span class="minicolors-picker" style="top: 67.88461538461539px;"></span>
                                                                </span>
                                                                <span class="minicolors-opacity-slider">
                                                                    <span class="minicolors-picker"></span>
                                                                </span>
                                                                <span class="minicolors-grid" style="background-color: rgb(0, 183, 255);">
                                                                    <span class="minicolors-grid-inner"></span>
                                                                    <span class="minicolors-picker" style="top: 38px; left: 104px;">
                                                                        <span></span>
                                                                    </span>
                                                                </span>
                                                            </span>
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="3">&nbsp;</td>
                                                </tr>
                                                <tr style="display: table-row;">
                                                    <td colspan="6">
                                                        Размер:
                                                        <select id="size" name="unique_element_counter_size" style="border-top-left-radius: 0px; border-top-right-radius: 0px; border-bottom-right-radius: 0px; border-bottom-left-radius: 0px;">
                                                            <option value="8px">8</option>
                                                            <option value="9px">9</option>
                                                            <option value="10px">10</option>
                                                            <option value="11px">11</option>
                                                            <option value="12px">12</option>
                                                            <option value="13px" selected>13</option>
                                                            <option value="14px">14</option>
                                                            <option value="15px">15</option>
                                                            <option value="16px">16</option>
                                                            <option value="17px">17</option>
                                                            <option value="18px">18</option>
                                                            <option value="19px">19</option>
                                                            <option value="20px">20</option>
                                                            <option value="21px">21</option>
                                                            <option value="22px">22</option>
                                                            <option value="23px">23</option>
                                                            <option value="24px">24</option>
                                                        </select>
                                                        &nbsp;&nbsp;
                                                        Тип:
                                                        <select id="type" name="unique_element_counter_type" style="border-top-left-radius: 0px; border-top-right-radius: 0px; border-bottom-right-radius: 0px; border-bottom-left-radius: 0px;">
                                                            <option value="normal">Обычный</option>
                                                            <option value="bold" selected>Жирный</option>
                                                            <option value="italic">Курсив</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <p><span class="red">18.</span> Счетчик подписчиков:</p>
                                        <table border="0" cellspacing="0" cellpadding="0" style="">
                                            <tbody>
                                                <tr>
                                                    <td colspan="3">
                                                        Шрифт:
                                                        <select id="number_font" style="border-top-left-radius: 0px; border-top-right-radius: 0px; border-bottom-right-radius: 0px; border-bottom-left-radius: 0px;">
                                                            <option value="arial">Arial</option>
                                                            <option value="courier">Courier</option>
                                                            <option value="timesnewroman">Times New Roman</option>
                                                            <option value="verdana" selected>Verdana</option>
                                                        </select>
                                                    </td>
                                                    <td align="right" colspan="2">&nbsp;&nbsp;Цвет:</td>                        
                                                    <td>&nbsp;
                                                        <span class="minicolors minicolors-theme-default minicolors-swatch-position-left minicolors-swatch-left minicolors-position-default">
                                                            <input class="minicolors minicolors-input" id="minicolor12" type="text" value="#ada6ad" size="7" maxlength="7">
                                                            <span class="minicolors-panel minicolors-slider-hue" style="display: none;">
                                                                <span class="minicolors-slider">
                                                                    <span class="minicolors-picker" style="top: 67.88461538461539px;"></span>
                                                                </span>
                                                                <span class="minicolors-opacity-slider">
                                                                    <span class="minicolors-picker"></span>
                                                                </span>
                                                                <span class="minicolors-grid" style="background-color: rgb(0, 183, 255);">
                                                                    <span class="minicolors-grid-inner"></span>
                                                                    <span class="minicolors-picker" style="top: 38px; left: 104px;">
                                                                        <span></span>
                                                                    </span>
                                                                </span>
                                                            </span>
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="3">&nbsp;</td>
                                                </tr>
                                                <tr style="display: table-row;">
                                                    <td colspan="6">
                                                        Размер:
                                                        <select id="number_size" style="border-top-left-radius: 0px; border-top-right-radius: 0px; border-bottom-right-radius: 0px; border-bottom-left-radius: 0px;">
                                                            <option value="8px">8</option>
                                                            <option value="9px">9</option>
                                                            <option value="10px" selected>10</option>
                                                            <option value="11px">11</option>
                                                            <option value="12px">12</option>
                                                            <option value="13px">13</option>
                                                            <option value="14px">14</option>
                                                            <option value="15px">15</option>
                                                            <option value="16px">16</option>
                                                            <option value="17px">17</option>
                                                            <option value="18px">18</option>
                                                            <option value="19px">19</option>
                                                            <option value="20px">20</option>
                                                            <option value="21px">21</option>
                                                            <option value="22px">22</option>
                                                            <option value="23px">23</option>
                                                            <option value="24px">24</option>
                                                        </select>
                                                        &nbsp;&nbsp;
                                                        От надписи:
                                                        <select id="number_alignment" name="" class="listbox" style="border-top-left-radius: 0px; border-top-right-radius: 0px; border-bottom-right-radius: 0px; border-bottom-left-radius: 0px; ">
                                                            <option value="top">Cверху</option>
                                                            <option value="right" selected="">Cправа</option>
                                                            <option value="bottom">Cнизу</option>
                                                            <option value="left">Cлева</option> 
                                                        </select>
                                                        <br /><br />
                                                        Фон:
                                                        <input type="checkbox" name="number_bg_color" id="number_bg_color" style="display: inline;">&nbsp;&nbsp;
                                                        <span class="minicolors minicolors-theme-default minicolors-swatch-position-left minicolors-swatch-left minicolors-position-default minicolor13" style="display: none; ">
                                                            <input class="minicolors minicolors-input" id="minicolor13" type="text" value="#ffffff" size="7" maxlength="7">
                                                            <span class="minicolors-panel minicolors-slider-hue" style="display: none;">
                                                                <span class="minicolors-slider">
                                                                    <span class="minicolors-picker" style="top: 67.88461538461539px;"></span>
                                                                </span>
                                                                <span class="minicolors-opacity-slider">
                                                                    <span class="minicolors-picker"></span>
                                                                </span>
                                                                <span class="minicolors-grid" style="background-color: rgb(0, 183, 255);">
                                                                    <span class="minicolors-grid-inner"></span>
                                                                    <span class="minicolors-picker" style="top: 38px; left: 104px;">
                                                                        <span></span>
                                                                    </span>
                                                                </span>
                                                            </span>
                                                        </span>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </article>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>
                <!-- /Form Generator -->
                <div class="export">
                    <br />
                    <div class="users_result">
                        <!-- Users Filter -->
                        <div id="users_filter">
                            <form>
                                <fieldset>
                                    <form class="form-inline">
                                        Выводить пользователей:&nbsp;
                                        <select name="search[date_mode]">
                                            <option value="">За весь период</option>
                                            <option value="TODAY">За сегодня</option>
                                            <option value="YESTERDAY">За вчера</option>
                                            <option value="WEEK">За последнюю неделю</option>
                                        </select>
                                        <input type="text" class="input-small" name="email_filter" placeholder="Фильтр по емайлу">
                                        <input type="button" class="btn" name="users_filter_btn" value="Сделать выборку">
                                    </form>
                                </fieldset>
                            </form>
                        </div>
                        <a href="#myModal2" id="export_btn" data-toggle="modal" class="sr-btn sr-btn-default">Экспортировать</a>
                        <!-- Modal -->
                        <div id="myModal2" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                <h3 id="myModalLabel">Экспорт зарегистрированных пользователей</h3>
                            </div>
                            <div class="modal-body">
                                <table width="100%">
                                    <tbody>
                                        <tr>
                                            <td class="import-request-options">
                                                <input type="radio" class="get_deliveries" id="get_deliveries" />&nbsp;Выберите рассылку:
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">
                                                <div class="get_deliveries_select" style="display: none; ">
                                                    <select name="rDestinationId" id="rDestinationId_d" style="width:350px; padding-left:10px; margin-left:1px">
                                                        <option value="0" class="chose">Выбрать ></option>
                                                    </select>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="import-request-options">
                                                <input type="radio" class="get_groups" id="get_groups" />&nbsp;Выберите группу:
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">
                                                <div class="get_groups_select" style="display: none; ">
                                                    <select name="rDestinationId" id="rDestinationId_g" style="width:350px; padding-left:10px; margin-left:1px">
                                                        <option value="0" class="chose">Выбрать ></option>
                                                    </select>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="modal-footer">
                                <button class="btn" id="export_sr">Экспортировать</button>
                                <button class="btn" data-dismiss="modal" aria-hidden="true">Закрыть</button>
                                <span style="display: none;text-align: center; margin-top: 8px;">Подождите пожалуйста...</span>
                            </div>
                        </div>
                        <!-- Users table -->
                        <table class="table table-hover" id="users_table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Пользователь</th>
                                    <th>Email</th>
                                    <th>Дата регистрации</th>
                                    <th><input type="checkbox" name="check_all" /></th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                        <span class="records_on_page">
                            Выводить по:&nbsp;
                            <select name="records_on_page" class="listbox">
                                <option>10</option>
                                <option>20</option>
                                <option>30</option>
                                <option>50</option>
                                <option selected="">100</option>
                            </select>
                        </span>
                        <div class="pager">
                            <a href="#" alt="First" class="firstPage">Первая</a>&nbsp;
                            <a href=""'#" alt="Previous" class="prevPage">Предыдущая</a>&nbsp;
                            <span class="currentPage"></span> of 
                            <span class="totalPages"></span>&nbsp;
                            <a href="#" alt="Next" class="nextPage">Следующая</a>&nbsp;
                            <a href="#" alt="Last" class="lastPage">Последняя</a>&nbsp;&nbsp;&nbsp;&nbsp;
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
